<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Carbon\Carbon;
use App\Models\LogAbsen;

class CheckAbsenEmployee extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:check_absen_employee';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Schedule Absen Employee';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $weekend = Carbon::now();
            if ($weekend->format('l') != "Saturday" || $weekend->format('l') != "Sunday") {
                $arr_user = [];
                $users = User::where('employee', 1)->get();
                foreach ($users as $u) {
                    array_push($arr_user, $u->id);
                }

                $arr_log = [];
                $logs = LogAbsen::whereDate('jam_masuk', Carbon::now()->format('Y-m-d'))->get();
                foreach ($logs as $log) {
                    array_push($arr_log, $log->id_karyawan);
                }

                $diff_absen = array_diff($arr_user, $arr_log);
                $tgl_masuk = Carbon::now()->format('Y-m-d');
                $jam_masuk = "00:00:00";
                $absen_masuk = Carbon::parse($tgl_masuk . ' ' . $jam_masuk)->format('Y-m-d H:i:s');

                foreach ($diff_absen as $diff) {
                    $log = new LogAbsen;
                    $log->id_karyawan = $diff;
                    $log->jam_masuk = $absen_masuk;
                    $log->jam_keluar = $absen_masuk;
                    $log->status = 1;
                    $log->status_kehadiran = 4;
                    $log->status_approval = 1;
                    $log->save();
                }

                \Log::info("Success checking absensi");
            } else {
                \Log::info("This is Weekend!");
            }
        } catch (\Throwable $th) {
            \Log::info($th->getMessage());
        }
    }
}
