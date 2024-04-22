<?php

namespace App\Http\Controllers\Administrator;

use App\Exports\RekapAbsenDetailExport;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use DataTables;
use App\Models\User;
use App\Models\Setting;
use App\Models\LogAbsen;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Str;
use Image;
use File;
use DB;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Carbon\Carbon;
use App\Exports\RekapAbsenExport;
use Maatwebsite\Excel\Facades\Excel;

class HumanResourceController extends Controller
{

    private static $module = "human_resource";

    public function index()
    {
        if (!isAllowed(static::$module, "view")) {
            abort(403);
        }
        return view('administrator.human_resource.index');
    }

    public function getData(Request $request)
    {
        if ($request->status != "") {
            $status = $request->status == "active" ? 1 : 0;
            $data = User::where([
                ['status', $status],
                ['employee', 1]
            ])->get();
        } else {
            $data = User::where('employee', 1);
        }
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = "";
                if (isAllowed(static::$module, "edit")) : //Check permission
                    $btn .= '<a href="' . route('admin.users.edit', $row->id) . '" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                    <span class="svg-icon svg-icon-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="black" />
                            <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="black" />
                        </svg>
                    </span>
                </a>';
                endif;
                if (isAllowed(static::$module, "delete")) : //Check permission
                    $btn .= '<a href="#" data-ix="' . $row->id . '" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm delete">
                    <span class="svg-icon svg-icon-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="black" />
                            <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="black" />
                            <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="black" />
                        </svg>
                    </span>
                </a>';
                endif;
                return $btn;
            })
            ->addColumn('status', function ($row) {
                if ($row->status) {
                    $status = '<div class="badge badge-light-success mb-5">Active</div>';
                } else {
                    $status = '<div class="badge badge-light-danger mb-5">Inactive</div>';
                }
                return $status;
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function log()
    {
        if (!isAllowed(static::$module, "log")) {
            abort(403);
        }
        $data['karyawans'] = User::where('employee', 1)->get();
        return view('administrator.human_resource.log', $data);
    }

    public function setting()
    {
        if (!isAllowed(static::$module, "setting")) {
            abort(403);
        }
        $setting = Setting::where('name', 'info')->first();
        $data['setting'] = json_decode($setting['value']);

        return view('administrator.human_resource.setting', $data);
    }

    public function updateSetting(Request $request)
    {
        if (!isAllowed(static::$module, "setting")) {
            abort(403);
        }

        $this->validate($request, [
            'jam_masuk' => 'required',
            'jam_keluar' => 'required',
            'tanggal_tutup_buku' => 'required'
        ]);

        $value = [
            'jam_masuk' => $request->jam_masuk,
            'jam_keluar' => $request->jam_keluar,
            'tanggal_tutup_buku' => $request->tanggal_tutup_buku
            // 'master_lat' => $request->master_lat,
            // 'master_long' => $request->master_long,
            // 'maks_lat' => $request->maks_lat,
            // 'maks_long' => $request->maks_long,
            // 'radius' => $request->radius
        ];

        $setting = Setting::where('name', 'info')->first();
        $setting->value = json_encode($value);
        $setting->save();

        return redirect()->back()->with(['success' => 'Your data updated successfully.']);
    }

    public function exportExcel(Request $request)
    {
        if (!isAllowed(static::$module, "export")) {
            abort(403);
        }
        // $params = [];
        $whereNama = [];
        $status = "";
        $karyawan = "";
        $periode = "";

        // dd($request->search);
        $query = LogAbsen::select(DB::raw('log_absen.*,users.name AS karyawan_name'))
            ->leftJoin(DB::raw('users'), 'users.id', '=', 'log_absen.id_karyawan');

        if ($request->search != null) {
            $search = explode("|", $request->search);
            foreach ($search as $value) {
                $nilai = explode(":", $value);

                if ($nilai[0] == "filterSearch" && $nilai[1]) {
                    $query = $query->where(DB::raw("LOWER(users.name)"), "LIKE", '%' . $nilai[1] . '%');
                }

                if ($nilai[0] == "filterStatus" && $nilai[1]) {
                    $filter_status = $nilai[1];
                    if ($filter_status == 1) {
                        $status = "Hadir";
                    } else if ($filter_status == 2) {
                        $status = "Sakit";
                    } else if ($filter_status == 3) {
                        $status = "Izin";
                    } else if ($filter_status == 4) {
                        $status = "Alfa";
                    }
                    $query = $query->where('status_kehadiran', $nilai[1]);
                }

                if ($nilai[0] == "filterKaryawan" && $nilai[1]) {
                    $user = User::find($nilai[1]);
                    $karyawan = $user->name;

                    $query = $query->where('id_karyawan', $nilai[1]);
                }

                if ($nilai[0] == "filterDate") {
                    $periode = $nilai[1];
                    $tanggal = explode("-", $nilai[1]);

                    $query = $query->whereDate('jam_masuk', '>=', Carbon::parse($tanggal[0])->format('Y-m-d'))
                        ->whereDate('jam_masuk', '<=', Carbon::parse($tanggal[1])->format('Y-m-d'));
                }
            }
        }

        $log_absen = $query->get();


        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $spreadsheet->getActiveSheet()->getStyle('G')->getNumberFormat()
            ->setFormatCode('#,##0');

        $textCenter = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ];

        $textLeft = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            ],
        ];

        $sheet->mergeCells('A1:G1')->getStyle('A1:G1')->getFont()->setBold(true)->setSize(16);
        $sheet->mergeCells('A1:G1')->getStyle('A1:G1')->applyFromArray($textCenter);
        $sheet->mergeCells('A2:G2')->getStyle('A2:G2')->getFont()->setBold(true)->setSize(12);
        $sheet->mergeCells('A3:B3')->getStyle('A3:B3')->getFont()->setBold(true)->setSize(12);
        $sheet->mergeCells('C3:D3')->getStyle('C3:D3')->getFont()->setBold(true)->setSize(12);
        $sheet->mergeCells('A4:B4')->getStyle('A4:B4')->getFont()->setBold(true)->setSize(12);
        $sheet->mergeCells('C4:D4')->getStyle('C4:D4')->getFont()->setBold(true)->setSize(12);
        $sheet->getStyle('E3')->getFont()->setBold(true)->setSize(12);
        $sheet->mergeCells('F3:G3')->getStyle('F3:G3')->getFont()->setBold(true)->setSize(12);


        $sheet->setCellValue('A3', 'Periode: ');
        $sheet->setCellValue('A4', 'Nama Karyawan: ');
        $sheet->setCellValue('E3', 'Status Kehadiran: ');

        $sheet->setCellValue('C3', $periode)->getStyle('C3')->getFont()->setBold(true);
        $sheet->setCellValue('C4', $karyawan)->getStyle('C4')->getFont()->setBold(true);
        $sheet->setCellValue('F3', $status)->getStyle('F3')->getFont()->setBold(true);

        $sheet->setCellValue('A1', 'Absensi');
        $sheet->setCellValue('A6', 'No')->getStyle('A6')->getFont()->setBold(true);
        $sheet->setCellValue('B6', 'Nama')->getStyle('B6')->getFont()->setBold(true);
        $sheet->setCellValue('C6', 'Tanggal')->getStyle('C6')->getFont()->setBold(true);
        $sheet->setCellValue('D6', 'Jam Masuk')->getStyle('D6')->getFont()->setBold(true);
        $sheet->setCellValue('E6', 'Jam Pulang')->getStyle('E6')->getFont()->setBold(true);
        $sheet->setCellValue('F6', 'Telat')->getStyle('F6')->getFont()->setBold(true);
        $sheet->setCellValue('G6', 'Status Kehadiran')->getStyle('G6')->getFont()->setBold(true);


        $rows = 7;
        $no = 1;

        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        $textTopLeft = [
            'alignment' => array(
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT
            ),
        ];

        $textCenter = [
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ];

        $sheet->getStyle('A6:G' . (count($log_absen) + 6))->applyFromArray($styleArray);

        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(40);
        $sheet->getColumnDimension('C')->setWidth(40);
        $sheet->getColumnDimension('D')->setWidth(40);
        $sheet->getColumnDimension('E')->setWidth(40);
        $sheet->getColumnDimension('F')->setWidth(40);
        $sheet->getColumnDimension('G')->setWidth(40);

        foreach ($log_absen as $data) {
            $sheet->setCellValue('A' . $rows, $no)->getStyle('A')->getAlignment();
            $sheet->setCellValue('B' . $rows, $data['karyawan_name'])->getStyle('B')->getAlignment();
            $dateAndTime = Carbon::parse($data['jam_masuk'])->format('d F Y');
            $sheet->setCellValue('C' . $rows, $dateAndTime)->getStyle('C')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $dateAndTime1 = date('H:i:s', strtotime($data['jam_masuk']));
            $sheet->setCellValue('D' . $rows, $dateAndTime1)->getStyle('D')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $dateAndTime2 = date('H:i:s', strtotime($data['jam_keluar']));
            $sheet->setCellValue('E' . $rows, $dateAndTime2)->getStyle('E')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $telat = $data['telat'];
            $formattedTime = $this->formatWaktu($telat);
            $sheet->setCellValue('F' . $rows, $formattedTime)->getStyle('F')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            if ($data['status_kehadiran'] == 1) {
                $status = "Hadir";
            } else if ($data['status_kehadiran'] == 2) {
                $status = "Sakit";
            } else if ($data['status_kehadiran'] == 3) {
                $status = "Izin";
            } else if ($data['status_kehadiran'] == 4) {
                $status = "Alfa";
            }
            $sheet->setCellValue('G' . $rows, $status)->getStyle('G')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $rows++;
            $no++;
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Absensi.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }
    function formatWaktu($waktu)
    {
        if ($waktu) {
            $time = explode(':', $waktu);
            if ($time[0] == "00") {
                $jam = "";
            } else {
                $jam = $time[0] . " Jam";
            }

            if ($time[1] == "00") {
                $menit = "";
            } else {
                $menit = $time[1] . " Menit";
            }

            if ($time[2] == "00") {
                $detik = "";
            } else {
                $detik = $time[2] . " Detik";
            }

            return $jam . ' ' . $menit . ' ' . $detik;
        }
    }

    public function pengajuanAbsensi(Request $request)
    {
        $data['karyawans'] = User::where('employee', 1)->get();

        return view('administrator.human_resource.pengajuan_absensi', $data);
    }

    public function getPengajuanAbsensi(Request $request)
    {
        $data = LogAbsen::with('users')
            ->where('status', 2)
            ->whereIn('status_kehadiran', [2, 3])
            ->where('status_approval', 0);

        if ($request->type) {
            $data = $data->where('status_kehadiran', $request->type);
        }

        if ($request->karyawan) {
            $data = $data->where('id_karyawan', $request->karyawan);
        }

        $data = $data->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('tanggal', function ($row) {
                $tanggal = Carbon::parse($row->jam_masuk)->format('d-m-Y');

                return $tanggal;
            })
            ->editColumn('type', function ($row) {
                if ($row->status_kehadiran == 2) {
                    $type = "Sakit";
                } else if ($row->status_kehadiran == 3) {
                    $type = "Izin";
                }

                return $type;
            })
            ->addColumn('action', function ($row) {
                $action = '
                        <a href="#" data-ix="' . $row->id . '" data-approval="1" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm act_absen">
                            <span class="svg-icon svg-icon-3 text-success">
                                <svg viewBox="0 0 24 24" width="24" height="24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M4 12.6111L8.92308 17.5L20 6.5" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g>
                                </svg>
                            </span>
                        </a>
                        <a href="#" data-ix="' . $row->id . '" data-approval="99" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm act_absen">
                            <span class="svg-icon svg-icon-3 text-danger">
                            <svg viewBox="0 0 24 24"  width="24" height="24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M20.7457 3.32851C20.3552 2.93798 19.722 2.93798 19.3315 3.32851L12.0371 10.6229L4.74275 3.32851C4.35223 2.93798 3.71906 2.93798 3.32854 3.32851C2.93801 3.71903 2.93801 4.3522 3.32854 4.74272L10.6229 12.0371L3.32856 19.3314C2.93803 19.722 2.93803 20.3551 3.32856 20.7457C3.71908 21.1362 4.35225 21.1362 4.74277 20.7457L12.0371 13.4513L19.3315 20.7457C19.722 21.1362 20.3552 21.1362 20.7457 20.7457C21.1362 20.3551 21.1362 19.722 20.7457 19.3315L13.4513 12.0371L20.7457 4.74272C21.1362 4.3522 21.1362 3.71903 20.7457 3.32851Z" fill="#0F0F0F"></path> </g></svg>
                            </span>
                        </a>
                    ';

                return $action;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function actPengajuanAbsensi(Request $request)
    {
        if (!isAllowed(static::$module, "approval")) {
            abort(403);
        }
        try {
            $log_absen = LogAbsen::find($request->ix);
            $log_absen->status = 1;
            $log_absen->status_approval = $request->approval;
            $log_absen->save();

            return response()->json([
                'status' => 200,
                'message' => 'success'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function rekapAbsensiPerBulan()
    {
        if (!isAllowed(static::$module, "view")) {
            abort(403);
        }
        $data['karyawans'] = User::where('employee', 1)->get();

        return view('administrator.human_resource.rekap_absensi_per_bulan', $data);
    }

    public function getDataRekapAbsensiPerBulan(Request $request)
    {
        $log = Setting::where('name', 'info')->first();
        $data = json_decode($log->value);

        $min_date = Carbon::parse($data->tanggal_tutup_buku . '-' . $request->filter_bulan . '-' . $request->filter_tahun)->subMonth()->addDay()->format('Y-m-d');
        $max_date = Carbon::parse($data->tanggal_tutup_buku . '-' . $request->filter_bulan . '-' . $request->filter_tahun)->format('Y-m-d');

        $data = User::where('employee', 1)->whereHas('log_absen')
            ->withCount([
                'log_absen as absen_hadir' => function ($query) use ($min_date, $max_date) {
                    $query->where('status', '!=', 2)->where('status_approval', '!=', 99)->where('status_kehadiran', 1)->whereDate('jam_masuk', '>', $min_date)
                        ->whereDate('jam_masuk', '<=', $max_date);
                },
                'log_absen as absen_sakit' => function ($query) use ($min_date, $max_date) {
                    $query->where('status', '!=', 2)->where('status_approval', '!=', 99)->where('status_kehadiran', 2)->whereDate('jam_masuk', '>', $min_date)
                        ->whereDate('jam_masuk', '<=', $max_date);
                },
                'log_absen as absen_izin' => function ($query) use ($min_date, $max_date) {
                    $query->where('status', '!=', 2)->where('status_approval', '!=', 99)->where('status_kehadiran', 3)->whereDate('jam_masuk', '>', $min_date)
                        ->whereDate('jam_masuk', '<=', $max_date);
                },
                'log_absen as absen_alpha' => function ($query) use ($min_date, $max_date) {
                    $query->where('status', '!=', 2)->where('status_approval', '!=', 99)->where('status_kehadiran', 4)->whereDate('jam_masuk', '>', $min_date)
                        ->whereDate('jam_masuk', '<=', $max_date);
                }
            ]);

        if ($request->search) {
            $data = $data->where('name', 'LIKE', "%{$request->search}%");
        }

        $data = $data->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) use ($request) {
                $action = '
                    <a href="' . route('admin.human_resource.rekap_absensi_per_bulan.detail', ['id' => $row->id, 'bulan' => $request->filter_bulan, 'tahun' => $request->filter_tahun]) . '" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                        <span class="svg-icon svg-icon-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M21.7 18.9L18.6 15.8C17.9 16.9 16.9 17.9 15.8 18.6L18.9 21.7C19.3 22.1 19.9 22.1 20.3 21.7L21.7 20.3C22.1 19.9 22.1 19.3 21.7 18.9Z" fill="black"/><path opacity="0.3" d="M11 20C6 20 2 16 2 11C2 6 6 2 11 2C16 2 20 6 20 11C20 16 16 20 11 20ZM11 4C7.1 4 4 7.1 4 11C4 14.9 7.1 18 11 18C14.9 18 18 14.9 18 11C18 7.1 14.9 4 11 4ZM8 11C8 9.3 9.3 8 11 8C11.6 8 12 7.6 12 7C12 6.4 11.6 6 11 6C8.2 6 6 8.2 6 11C6 11.6 6.4 12 7 12C7.6 12 8 11.6 8 11Z" fill="black"/></svg>
                        </span>
                    </a>
                    ';

                return $action;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function getRekapAbsensiPerBulanDetail($id, $bulan, $tahun)
    {
        if (!isAllowed(static::$module, "view")) {
            abort(403);
        }
        $log = Setting::where('name', 'info')->first();
        $data = json_decode($log->value);

        $min_date = Carbon::parse($data->tanggal_tutup_buku . '-' . $bulan . '-' . $tahun)->subMonth()->addDay()->format('Y-m-d');
        $max_date = Carbon::parse($data->tanggal_tutup_buku . '-' . $bulan . '-' . $tahun)->format('Y-m-d');

        $karyawan = User::with([
            'log_absen' => function ($query) use ($min_date, $max_date) {
                // $query->whereDate('jam_masuk', '>', $min_date)
                //     ->whereDate('jam_masuk', '<=', $max_date)
                //     ->orWhere('status_approval', NULL)->orWhere('status_approval', 1)
                //     ->orWhere('status_approval', 99);
                $query->where('status', '!=', 2)
                    ->whereDate('jam_masuk', '>', $min_date)
                    ->whereDate('jam_masuk', '<=', $max_date);
            }
        ])->find($id);

        $events = [];

        foreach ($karyawan->log_absen as $log) {
            if ($log->status_kehadiran == 1 && ($log->status_approval == NULL || $log->status_approval == 1)) {
                $title = "Hadir";
                $class = "stat-1 col-white";
            } else if ($log->status_kehadiran == 2 && ($log->status_approval == NULL || $log->status_approval == 1)) {
                $title = "Sakit";
                $class = "stat-2 col-white";
            } else if ($log->status_kehadiran == 3 && ($log->status_approval == NULL || $log->status_approval == 1)) {
                $title = "Izin";
                $class = "stat-3 col-white";
            } else if ($log->status_kehadiran ==  4 && ($log->status_approval == NULL || $log->status_approval == 1)) {
                $title = "Alpha";
                $class = "stat-4 col-white";
            } else if ($log->status_approval == 99) {
                $title = "Mangkir";
                $class = "stat-99 col-white";
            }

            $events[] = [
                'title' => $title,
                'start' => $log->jam_masuk,
                'backgroundColor' => '#fff',
                'className' => $class
            ];
        }

        $data = [
            'bulan' => $bulan,
            'tahun' => $tahun
        ];

        return view('administrator.human_resource.rekap_absensi_per_bulan_detail', compact('karyawan', 'events', 'max_date', 'data'));
    }

    public function exportRekapAbsensiPerBulan(Request $request)
    {
        if (!isAllowed(static::$module, "export")) {
            abort(403);
        }
        return Excel::download(new RekapAbsenExport($request->search, $request->filter_bulan, $request->filter_tahun), 'Rekap Absensi Per Bulan.xlsx');
    }



    public function rekapAbsensiPerTahun()
    {
        if (!isAllowed(static::$module, "view")) {
            abort(403);
        }
        $data['karyawans'] = User::where('employee', 1)->get();

        return view('administrator.human_resource.rekap_absensi_per_tahun', $data);
    }

    public function getDataRekapAbsensiPerTahun(Request $request)
    {
        if (!isAllowed(static::$module, "view")) {
            abort(403);
        }
        $log = Setting::where('name', 'info')->first();
        $data = json_decode($log->value);

        $year_start = Carbon::createFromDate($request->tahun, 1, 1)->startOfYear()->format('m-Y');
        $year_end = Carbon::createFromDate($request->tahun, 12, 31)->endOfYear()->format('m-Y');

        $min_date = Carbon::parse($data->tanggal_tutup_buku . '-' . $year_start)->format('Y-m-d');
        $max_date = Carbon::parse($data->tanggal_tutup_buku . '-' . $year_end)->format('Y-m-d');

        $data = User::where('employee', 1)->whereHas('log_absen')
            ->withCount([
                'log_absen as absen_hadir' => function ($query) use ($min_date, $max_date) {
                    $query->where('status', '!=', 2)->where('status_approval', '!=', 99)->where('status_kehadiran', 1)->whereDate('jam_masuk', '>', $min_date)
                        ->whereDate('jam_masuk', '<=', $max_date);
                },
                'log_absen as absen_sakit' => function ($query) use ($min_date, $max_date) {
                    $query->where('status', '!=', 2)->where('status_approval', '!=', 99)->where('status_kehadiran', 2)->whereDate('jam_masuk', '>', $min_date)
                        ->whereDate('jam_masuk', '<=', $max_date);
                },
                'log_absen as absen_izin' => function ($query) use ($min_date, $max_date) {
                    $query->where('status', '!=', 2)->where('status_approval', '!=', 99)->where('status_kehadiran', 3)->whereDate('jam_masuk', '>', $min_date)
                        ->whereDate('jam_masuk', '<=', $max_date);
                },
                'log_absen as absen_alpha' => function ($query) use ($min_date, $max_date) {
                    $query->where('status', '!=', 2)->where('status_approval', '!=', 99)->where('status_kehadiran', 4)->whereDate('jam_masuk', '>', $min_date)
                        ->whereDate('jam_masuk', '<=', $max_date);
                }
            ]);

        $data = $data->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) use ($request) {
                $action = '
                    <a href="' . route('admin.human_resource.rekap_absensi_per_tahun.detail', ['id' => $row->id, 'tahun' => ($request->tahun != null) ? $request->tahun : date('Y')]) . '" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">                  
                            <span class="svg-icon svg-icon-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M21.7 18.9L18.6 15.8C17.9 16.9 16.9 17.9 15.8 18.6L18.9 21.7C19.3 22.1 19.9 22.1 20.3 21.7L21.7 20.3C22.1 19.9 22.1 19.3 21.7 18.9Z" fill="black"/>
                                    <path opacity="0.3" d="M11 20C6 20 2 16 2 11C2 6 6 2 11 2C16 2 20 6 20 11C20 16 16 20 11 20ZM11 4C7.1 4 4 7.1 4 11C4 14.9 7.1 18 11 18C14.9 18 18 14.9 18 11C18 7.1 14.9 4 11 4ZM8 11C8 9.3 9.3 8 11 8C11.6 8 12 7.6 12 7C12 6.4 11.6 6 11 6C8.2 6 6 8.2 6 11C6 11.6 6.4 12 7 12C7.6 12 8 11.6 8 11Z" fill="black"/>
                                </svg>
                            </span>
                        </a>
                    ';

                return $action;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function getRekapAbsensiPerTahunDetail(Request $request, $id)
    {
        $karyawan = User::select('users.*')
            ->leftJoin('log_absen', 'users.id', '=', 'log_absen.id_karyawan')
            ->where('log_absen.status', '!=', 2)->where('log_absen.status_approval', '!=', 99)
            ->with('log_absen')->find($id);
        $events = [];

        $tahunIni = $request->tahun;
        $bulanTahunIni = [];
        for ($i = 1; $i <= 12; $i++) {
            $bulanTahunIni[$i] = [
                'Hadir' => 0,
                'Sakit' => 0,
                'Izin' => 0,
                'Alpha' => 0,
            ];
        }

        foreach ($karyawan->log_absen as $log) {
            if (Carbon::parse($log->jam_masuk)->year == $tahunIni) {
                if ($log->status_kehadiran == 1) {
                    $title = "Hadir";
                } else if ($log->status_kehadiran == 2) {
                    $title = "Sakit";
                } else if ($log->status_kehadiran == 3) {
                    $title = "Izin";
                } else if ($log->status_kehadiran == 4) {
                    $title = "Alpha";
                }

                $bulan = Carbon::parse($log->jam_masuk)->format('n');
                $bulanTahunIni[$bulan][$title] = ($bulanTahunIni[$bulan][$title] ?? 0) + 1;
            }

            foreach ($karyawan->log_absen as $log) {
                if (Carbon::parse($log->jam_masuk)->year == $tahunIni) {
                    if ($log->status_kehadiran == 1) {
                        $title = "Hadir";
                    } else if ($log->status_kehadiran == 2) {
                        $title = "Sakit";
                    } else if ($log->status_kehadiran == 3) {
                        $title = "Izin";
                    } else if ($log->status_kehadiran == 4) {
                        $title = "Alpha";
                    }

                    $bulan = Carbon::parse($log->jam_masuk)->format('n');
                    $bulanTahunIni[$bulan][$title] = ($bulanTahunIni[$bulan][$title] ?? 0) + 1;
                }
            }

            $chartData = [];

            foreach ($bulanTahunIni as $bulan => $data) {
                $chartData[] = [
                    'start' => $bulan,
                    'presence' => $data['Hadir'] ?? 0,
                    'sick' => $data['Sakit'] ?? 0,
                    'leave' => $data['Izin'] ?? 0,
                    'alpha' => $data['Alpha'] ?? 0,
                ];
            }

            return view('administrator.human_resource.rekap_absensi_per_tahun_detail', compact('karyawan', 'events', 'chartData', 'tahunIni'));
        }
    }

    public function exportRekapAbsensiDetailPerBulan(Request $request)
    {
        if (!isAllowed(static::$module, "export")) {
            abort(403);
        }
        return Excel::download(new RekapAbsenDetailExport($request->id_karyawan, $request->bulan, $request->tahun), 'Rekap Detail Absensi Per Bulan.xlsx');
    }

    public function exportExcelTahun(Request $request)
    {
        if (!isAllowed(static::$module, "export")) {
            abort(403);
        }
        $reqTahun = null;

        if ($request->search != null) {
            $search = explode("|", $request->search);
            foreach ($search as $value) {
                $nilai = explode(":", $value);

                if ($nilai[0] == "filterTahun" && $nilai[1]) {
                    $reqTahun = $nilai[1];
                }
            }
        }

        $whereNama = [];
        $periode = "";

        $log = Setting::where('name', 'info')->first();
        $data = json_decode($log->value);

        $year_start = Carbon::createFromDate($reqTahun, 1, 1)->startOfYear()->format('m-Y');
        $year_end = Carbon::createFromDate($reqTahun, 12, 31)->endOfYear()->format('m-Y');

        $min_date = Carbon::parse($data->tanggal_tutup_buku . '-' . $year_start)->format('Y-m-d');
        $max_date = Carbon::parse($data->tanggal_tutup_buku . '-' . $year_end)->format('Y-m-d');

        $query = User::where('employee', 1)
            ->whereHas('log_absen')
            ->withCount([
                'log_absen as absen_hadir' => function ($query) use ($min_date, $max_date, $reqTahun) {
                    $query->where('status', '!=', 2)->where('status_approval', '!=', 99)->where('status_kehadiran', 1)
                        ->whereDate('jam_masuk', '>', $min_date)
                        ->whereDate('jam_masuk', '<=', $max_date);
                },
                'log_absen as absen_sakit' => function ($query) use ($min_date, $max_date, $reqTahun) {
                    $query->where('status', '!=', 2)->where('status_approval', '!=', 99)->where('status_kehadiran', 2)
                        ->whereDate('jam_masuk', '>', $min_date)
                        ->whereDate('jam_masuk', '<=', $max_date);
                },
                'log_absen as absen_izin' => function ($query) use ($min_date, $max_date, $reqTahun) {
                    $query->where('status', '!=', 2)->where('status_approval', '!=', 99)->where('status_kehadiran', 3)
                        ->whereDate('jam_masuk', '>', $min_date)
                        ->whereDate('jam_masuk', '<=', $max_date);
                },
                'log_absen as absen_alpha' => function ($query) use ($min_date, $max_date, $reqTahun) {
                    $query->where('status', '!=', 2)->where('status_approval', '!=', 99)->where('status_kehadiran', 4)
                        ->whereDate('jam_masuk', '>', $min_date)
                        ->whereDate('jam_masuk', '<=', $max_date);
                },
            ]);

        if ($request->search != null) {
            $search = explode("|", $request->search);

            foreach ($search as $value) {
                $nilai = explode(":", $value);

                if ($nilai[0] == "filterSearch" && $nilai[1]) {
                    $query = $query->where(DB::raw("LOWER(users.name)"), "LIKE", '%' . $nilai[1] . '%');
                }
            }
        }

        $log_absen = $query->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $spreadsheet->getActiveSheet()->getStyle('F')->getNumberFormat()
            ->setFormatCode('#,##0');

        $textCenter = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ];

        $textLeft = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            ],
        ];

        $sheet->mergeCells('A1:F1')->getStyle('A1:F1')->getFont()->setBold(true)->setSize(16);
        $sheet->mergeCells('A1:F1')->getStyle('A1:F1')->applyFromArray($textCenter);
        $sheet->mergeCells('A2:F2')->getStyle('A2:F2')->getFont()->setBold(true)->setSize(12);
        $sheet->mergeCells('A3:B3')->getStyle('A3:B3')->getFont()->setBold(true)->setSize(12);
        $sheet->mergeCells('C3')->getStyle('C3')->getFont()->setBold(true)->setSize(12);
        $sheet->mergeCells('A4:B4')->getStyle('A4:B4')->getFont()->setBold(true)->setSize(12);
        $sheet->mergeCells('C4')->getStyle('C4')->getFont()->setBold(true)->setSize(12);
        $sheet->getStyle('E3')->getFont()->setBold(true)->setSize(12);

        $sheet->setCellValue('A3', 'Periode: ');
        $sheet->setCellValue('C3', ($reqTahun != null) ? $reqTahun : date('Y'))->getStyle('C3')->getFont()->setBold(true);

        $sheet->setCellValue('A1', 'Rekap Absensi Per Tahun');
        $sheet->setCellValue('A5', 'No')->getStyle('A5')->getFont()->setBold(true);
        $sheet->setCellValue('B5', 'Nama')->getStyle('B5')->getFont()->setBold(true);
        $sheet->setCellValue('C5', 'Hadir')->getStyle('C5')->getFont()->setBold(true);
        $sheet->setCellValue('D5', 'Sakit')->getStyle('D5')->getFont()->setBold(true);
        $sheet->setCellValue('E5', 'Izin')->getStyle('E5')->getFont()->setBold(true);
        $sheet->setCellValue('F5', 'Alpha')->getStyle('F5')->getFont()->setBold(true);


        $rows = 6;
        $no = 1;

        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        $textTopLeft = [
            'alignment' => array(
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT
            ),
        ];

        $textCenter = [
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ];

        $sheet->getStyle('A5:F' . (count($log_absen) + 5))->applyFromArray($styleArray);

        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(10);
        $sheet->getColumnDimension('D')->setWidth(10);
        $sheet->getColumnDimension('E')->setWidth(10);
        $sheet->getColumnDimension('F')->setWidth(10);

        foreach ($log_absen as $data) {
            $sheet->setCellValue('A' . $rows, $no)->getStyle('A')->getAlignment();
            $sheet->setCellValue('B' . $rows, $data['name'])->getStyle('B')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->setCellValue('C' . $rows, $data['absen_hadir'])->getStyle('C')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->setCellValue('D' . $rows, $data['absen_sakit'])->getStyle('D')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->setCellValue('E' . $rows, $data['absen_izin'])->getStyle('E')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->setCellValue('F' . $rows, $data['absen_alpha'])->getStyle('F')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $rows++;
            $no++;
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Rekap Absensi Per Tahun.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }
}
