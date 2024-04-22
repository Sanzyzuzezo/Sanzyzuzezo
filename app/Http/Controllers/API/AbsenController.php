<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LogAbsen;
use DataTables;
use DateTime;
use DB;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Setting;

class AbsenController extends Controller
{
    public function absen_masuk(Request $request)
    {
        $setting = Setting::where('name', 'info')->first();
        $info = json_decode($setting->value);
        $user = auth()->user();
        $date = now()->format('Y-m-d') . ' ' . $info->jam_masuk;
        $timeRange = '';
        // $waktu_masuk = Carbon::createFromFormat('d-m-Y H:i:s', $request->date);
        // $waktu_server = Carbon::createFromFormat('Y-m-d H:i:s', $date);
        $waktu_masuk = Carbon::parse($request->date)->format('Y-m-d H:i:s');
        $waktu_server = Carbon::now()->format('Y-m-d H:i:s');
        $tgl_masuk = Carbon::parse($waktu_masuk)->format('Y-m-d');
        $tgl_server = Carbon::parse($waktu_server)->format('Y-m-d');
        $jam_masuk = Carbon::parse($waktu_masuk)->format('H:i:s');
        $time = Carbon::parse('08:00:00')->format('H:i:s');

        if ($tgl_masuk != $tgl_server) {
            return response()->json([
                'status' => 'error',
                'message' => "message aja ini"
            ]);
            return false;
        }

        // Pengecekan apakah objek DateTime valid
        if ($waktu_masuk && $waktu_server) {
            $thisUser = LogAbsen::where('id_karyawan', $user->id)->whereDate('jam_masuk', Carbon::parse($waktu_masuk)->format('Y-m-d'))->first();

            // Check if user has already recorded attendance for today
            if (!empty($thisUser)) {
                return response()->json([
                    'status' => 200,
                    'absen' => true,
                    'message' => 'Anda sudah absen'
                ]);

                return false;
            }

            // radius
            // request latitude and request longitude

            // $radius = $this->distance($info->master_lat, $info->master_long, $info->maks_lat, $info->maks_long);
            // $lokasi_absen = $this->distance($info->master_lat, $info->master_long, $request->lat, $request->long);

            // if($lokasi_absen > $radius) {
            //     return response()->json([
            //         'status' => 200,
            //         'message' => "Diluar jangkauan untuk absen"
            //     ]);

            //     return false;
            // }

            $diff = strtotime($jam_masuk) - strtotime($time);

            if ($diff != 0) {
                // Hitung selisih waktu jika user telat
                $timeDifference = Carbon::parse($diff)->format('H:i:s');
                $timeRange = $timeDifference;
            }

            $imageName = $request->file('img_absen_masuk')->getClientOriginalName();
            $request->file('img_absen_masuk')->move(public_path('log_absen'), $imageName);
            // Rekam absensi user ke dalam database
            LogAbsen::create([
                'id_karyawan' => $user->id,
                'jam_masuk' => $waktu_masuk,
                'telat' => $timeRange,
                'nama_file_masuk' => $imageName,
                'status' => 0,
                'status_kehadiran' => 1,
                'status_approval' => 1
                // 'lat' => $request->lat,
                // 'long' => $request->long,
                // 'lokasi' => $request->lokasi
            ]);

            // Kembalikan respons JSON sesuai dengan hasil absensi
            return response()->json([
                'status' => 200,
                'message' => 'Absensi Anda pada tgl ' . $date . ' telah direkap',
                'jam_masuk' => $request->date,
                'telat' => $diff == 0 ? 'Tidak Telat' : $timeRange
            ]);
        } else {
            // Objek DateTime tidak valid, kembalikan respons error
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid DateTime objects'
            ]);
        }
    }
    public function absen_keluar(Request $request)
    {
        $setting = Setting::where('name', 'info')->first();
        $info = json_decode($setting->value);
        $user = auth()->user();
        $date = now()->format('Y-m-d') . ' ' . $info->jam_masuk;
        // $waktu_keluar = DateTime::createFromFormat('d-m-Y H:i:s', $request->date);
        $waktu_keluar = Carbon::parse($request->date)->format('d-m-Y H:i:s');
        // $thisUser = LogAbsen::where('id_karyawan',$user->id)->whereDate('jam_keluar','0000-00-00 00:00:00')->first();
        $thisUser = LogAbsen::where('id_karyawan', $user->id)->whereDate('jam_masuk', Carbon::parse($request->date)->format('Y-m-d'))->first();

        // $radius = $this->distance($info->master_lat, $info->master_long, $info->maks_lat, $info->maks_long);
        // $lokasi_absen = $this->distance($info->master_lat, $info->master_long, $request->lat, $request->long);

        // if($lokasi_absen > $radius) {
        //     return response()->json([
        //         'status' => 200,
        //         'message' => "Diluar jangkauan untuk absen"
        //     ]);

        //     return false;
        // }

        $imageName = $request->file('img_absen_keluar')->getClientOriginalName();
        $request->file('img_absen_keluar')->move(public_path('log_absen'), $imageName);

        // kalo lupa absen
        if (!isset($thisUser)) {
            $tgl_masuk = Carbon::parse($request->date)->format('Y-m-d');
            $jam_masuk = "09:00:00";
            $absen_masuk = Carbon::parse($tgl_masuk . ' ' . $jam_masuk)->format('Y-m-d H:i:s');

            LogAbsen::create([
                'id_karyawan' => $user->id,
                'jam_masuk' => $absen_masuk,
                'jam_keluar' => Carbon::parse($request->date)->format('Y-m-d H:i:s'),
                'telat' => "01:00:00",
                'nama_file_keluar' => $imageName,
                'status' => 1,
                'status_kehadiran' => 1
                // 'lat' => $request->lat,
                // 'long' => $request->long
            ]);

            return response()->json([
                'status' => 200,
                'message' => "Anda lupa absen masuk hari ini, Berhasil Absen Keluar",
                'jam_keluar' => $request->date
            ]);

            return false;
        }

        // chek if had updated row cause out from absen
        if (!empty($thisUser) && $thisUser->status != 1) {
            // LogAbsen::where('id',$thisUser->id)->update([
            //     'jam_keluar' => $waktu_keluar
            // ]);

            $thisUser->update([
                'jam_keluar' => Carbon::parse($request->date)->format('Y-m-d H:i:s'),
                'nama_file_keluar' => $imageName,
                'status' => 1
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Absensi keluar sudah direkap',
                'jam_keluar' => $request->date,
            ]);
        } else {
            return response()->json([
                'status' => 200,
                'message' => 'Anda udah absen keluar'
            ]);
        }
    }
    public function getLog(Request $request)
    {
        // $data = DB::table('log_absen')
        //         ->leftJoin('users','log_absen.id_karyawan','=','users.id')
        //         ->get();
        // dd($data);
        // return DataTables::of($data)->addIndexColumn()->make(true);
        // return $log;  
        $data = LogAbsen::with('users');

        if ($request->karyawan) {
            $data = $data->where('id_karyawan', $request->karyawan);
        }

        if ($request->status_kehadiran) {
            $data = $data->where('status_kehadiran', $request->status_kehadiran);
        }

        if ($request->tanggal) {
            $tanggal = explode("-", $request->tanggal);
            $data = $data->whereDate('jam_masuk', '>=', Carbon::parse($tanggal[0])->format('Y-m-d'))
                ->whereDate('jam_masuk', '<=', Carbon::parse($tanggal[1])->format('Y-m-d'));
        }

        $data = $data->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('tanggal', function ($row) {
                $tanggal = Carbon::parse($row->jam_masuk)->format('d-m-Y');

                return $tanggal;
            })
            ->editColumn('jam_masuk', function ($row) {
                if ($row->status_kehadiran != 1) {
                    $jam_masuk = "-";
                } else {
                    $jam_masuk = Carbon::parse($row->jam_masuk)->format('H:i:s');
                }
                return $jam_masuk;
            })
            ->editColumn('jam_keluar', function ($row) {
                if ($row->status_kehadiran != 1) {
                    $jam_keluar = "-";
                } else {
                    $jam_keluar = Carbon::parse($row->jam_keluar)->format('H:i:s');
                }
                return $jam_keluar;
            })
            ->editColumn('telat', function ($row) {
                if ($row->telat) {
                    $time = explode(':', $row->telat);
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

                    if ($row->status_kehadiran != 1) {
                        return "-";
                    } else {
                        return $jam . ' ' . $menit . ' ' . $detik;
                    }
                }
            })
            ->editColumn('status_kehadiran', function ($row) {
                if ($row->status_kehadiran == 1) {
                    $status_kehadiran = "Hadir";
                } else if ($row->status_kehadiran == 2) {
                    $status_kehadiran = "Sakit";
                } else if ($row->status_kehadiran == 3) {
                    $status_kehadiran = "Izin";
                } else if ($row->status_kehadiran == 4) {
                    $status_kehadiran = "Alfa";
                }

                return $status_kehadiran;
            })
            ->make(true);
    }

    public function listAbsen(Request $request)
    {
        $user = auth()->user();
        $absen = LogAbsen::where('id_karyawan', $user->id)
            ->whereMonth('jam_masuk', Carbon::now()->format('m'))->get();
        // $telat = 0;
        $telat = [];

        foreach ($absen as $a) {
            // $telat += strtotime($a->telat);
            array_push($telat, $a->telat);
        }

        $jumlah_telat = Carbon::parse($this->sumTime($telat))->format('H:i:s');

        if ($absen) {
            return response()->json([
                'status' => 200,
                'message' => "success",
                'data' => $absen,
                'jumlah_telat' => $jumlah_telat
            ]);
        } else {
            return response()->json([
                'status' => 500,
                'message' => "error"
            ]);
        }
    }

    function sumTime($entitiy)
    {
        $time = (array)$entitiy;
        $time = array_filter($time, function ($item) {
            return !in_array($item, ['00:00:00', '0:00:00']);
        });
        $begin = Carbon::createFromFormat('H:i:s', '00:00:00');
        $end = clone $begin;

        foreach ($time as $element) {
            $dateTime = Carbon::createFromFormat('H:i:s', $element);
            $end->addHours($dateTime->format('H'))
                ->addMinutes($dateTime->format('i'))
                ->addSeconds($dateTime->format('s'));
        }

        return sprintf(
            '%s:%s:%s',
            $end->diffInHours($begin),
            $end->format('i'),
            $end->format('s')
        );
    }

    function distance($lat_from, $long_from, $lat_to, $long_to)
    {
        $earth_radius = 6371000;
        $latFrom = deg2rad($lat_from);
        $longFrom = deg2rad($long_from);
        $latTo = deg2rad($lat_to);
        $longTo = deg2rad($long_to);

        $latDelta = $latTo - $latFrom;
        $longDelta = $longTo - $longFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) + cos($latFrom) * cos($latTo) * pow(sin($longDelta / 2), 2)));

        return $angle * $earth_radius;
    }

    public function pengajuanAbsen(Request $request)
    {
        try {
            $user = auth()->user();
            $tgl_masuk = Carbon::parse($request->date)->format('Y-m-d');
            $jam_masuk = "00:00:00";
            $absen_masuk = Carbon::parse($tgl_masuk . ' ' . $jam_masuk)->format('Y-m-d H:i:s');

            if ($request->type == "sakit") {
                $type = 2;
            } else if ($request->type == "izin") {
                $type = 3;
            }

            $log = new LogAbsen;
            $log->id_karyawan = $user->id;
            $log->jam_masuk = $absen_masuk;
            $log->jam_keluar = $absen_masuk;
            $log->status = 2;
            $log->status_kehadiran = $type;
            $log->status_approval = 0;
            $log->save();

            return response()->json([
                'status' => 200,
                'message' => "Pengajuan anda berhasil dikirim!"
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'message' => $th->getMessage()
            ]);
        }
    }
}
