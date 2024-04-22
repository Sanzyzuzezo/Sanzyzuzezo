<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

use Carbon\Carbon;
use App\Models\Setting;
use App\Models\User;

class RekapAbsenDetailExport implements FromView, ShouldAutoSize, WithColumnWidths, WithStyles, WithEvents
{
    use Exportable;

    protected $id_karyawan;
    protected $bulan;
    protected $tahun;

    public function __construct($id_karyawan, $bulan, $tahun)
    {
        $this->id_karyawan = $id_karyawan;
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20,
            'B' => 30
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
            3    => ['font' => ['bold' => true]],
            4    => ['font' => ['bold' => true]],
            6    => ['font' => ['bold' => true]]
        ];
    }

    public function view(): View
    {
        $log = Setting::where('name', 'info')->first();
        $data = json_decode($log->value);
        $tanggal_awal = $data->tanggal_tutup_buku;
        $periode = Carbon::parse('01' . '-' . $this->bulan . '-' . $this->tahun)->format('F Y');

        $min_date = Carbon::parse($tanggal_awal . '-' . $this->bulan . '-' . $this->tahun)->subMonth()->addDay()->format('Y-m-d');
        $max_date = Carbon::parse($tanggal_awal . '-' . $this->bulan . '-' . $this->tahun)->format('Y-m-d');

        $end_month = Carbon::parse($tanggal_awal . '-' . $this->bulan . '-' . $this->tahun)->subMonth()->endOfMonth()->format('Y-m-d');
        $start_month = Carbon::parse($tanggal_awal . '-' . $this->bulan . '-' . $this->tahun)->startOfMonth()->format('Y-m-d');

        $karyawans = User::with([
            'log_absen' => function ($query) use ($min_date, $max_date) {
                $query->where('status', '!=', 2)
                    ->whereDate('jam_masuk', '>', $min_date)
                    ->whereDate('jam_masuk', '<=', $max_date);
            }
        ])->find($this->id_karyawan);

        $new_arr = [];
        for ($min_date; $min_date <= $end_month; $min_date++) {
            $data = [
                'tanggal' => $min_date,
                'status_kehadiran' => 4
            ];
            array_push($new_arr, $data);
        }


        $new_arr2 = [];
        for ($start_month; $start_month <= $max_date; $start_month++) {
            $data = [
                'tanggal' => $start_month,
                'status_kehadiran' => 4
            ];
            array_push($new_arr2, $data);
        }

        $final_arr = array_merge($new_arr, $new_arr2);

        $arr_log_absen = [];
        foreach ($karyawans->log_absen as $log_absen) {
            $data = [
                'tanggal' => Carbon::parse($log_absen->jam_masuk)->format('Y-m-d'),
                'status_kehadiran' => $log_absen->status_kehadiran
            ];
            array_push($arr_log_absen, $data);
        }

        foreach ($arr_log_absen as $absen) {
            $found = false;

            foreach ($final_arr as &$item) {

                if ($item['tanggal'] == $absen['tanggal']) {
                    $item['status_kehadiran'] = $absen['status_kehadiran'];
                    $found = true;
                    break;
                }
            }

            if (!$found) {
                $final_arr[] = $item;
            }
        }

        return view('administrator.human_resource.export.detail', compact('final_arr', 'karyawans', 'periode'));
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function (AfterSheet $event) {
                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ]
                    ],
                ];

                $styleArray2 = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_NONE,
                            // 'color' => ['argb' => '000000'],
                        ]
                    ],
                ];

                $event->sheet->getDelegate()->getStyle($event->sheet->calculateWorksheetDimension())
                    ->applyFromArray($styleArray);
                $event->sheet->getDelegate()->getStyle('A2:B2')
                    ->applyFromArray($styleArray2);
                $event->sheet->getDelegate()->getStyle('A1:B1')
                    ->applyFromArray($styleArray2);
                $event->sheet->getDelegate()->getStyle('A3:B3')
                    ->applyFromArray($styleArray2);
                $event->sheet->getDelegate()->getStyle('A4:B4')
                    ->applyFromArray($styleArray2);
                $event->sheet->getDelegate()->getStyle('A5:B5')
                    ->applyFromArray($styleArray2);
            },
        ];
    }
}
