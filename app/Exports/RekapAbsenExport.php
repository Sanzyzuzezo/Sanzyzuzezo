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

class RekapAbsenExport implements FromView, ShouldAutoSize, WithColumnWidths, WithStyles, WithEvents
{
    use Exportable;

    protected $search;
    protected $filter_bulan;
    protected $filter_tahun;

    public function __construct($search, $bulan, $tahun)
    {
        $this->search = $search;
        $this->filter_bulan = $bulan;
        $this->filter_tahun = $tahun;
    }

    public function columnWidths(): array
    {
        return [
            'A' => 10,
            'B' => 30,
            'C' => 10,
            'D' => 10,
            'E' => 10,
            'F' => 10,
            'G' => 10
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
            3    => ['font' => ['bold' => true]],
            5    => ['font' => ['bold' => true]],
        ];
    }

    public function view(): View
    {
        $log = Setting::where('name', 'info')->first();
        $data = json_decode($log->value);

        $min_date = Carbon::parse($data->tanggal_tutup_buku . '-' . $this->filter_bulan . '-' . $this->filter_tahun)->subMonth()->addDay()->format('Y-m-d');
        $max_date = Carbon::parse($data->tanggal_tutup_buku . '-' . $this->filter_bulan . '-' . $this->filter_tahun)->format('Y-m-d');

        $data = User::where('employee', 1)->whereHas('log_absen')
            ->withCount([
                'log_absen as absen_hadir' => function ($query) use ($min_date, $max_date) {
                    $query->where('status_kehadiran', 1)->where('status_approval', '!=', 99)->whereDate('jam_masuk', '>', $min_date)
                        ->whereDate('jam_masuk', '<=', $max_date);
                },
                'log_absen as absen_sakit' => function ($query) use ($min_date, $max_date) {
                    $query->where('status_kehadiran', 2)->where('status_approval', '!=', 99)->whereDate('jam_masuk', '>', $min_date)
                        ->whereDate('jam_masuk', '<=', $max_date);
                },
                'log_absen as absen_izin' => function ($query) use ($min_date, $max_date) {
                    $query->where('status_kehadiran', 3)->where('status_approval', '!=', 99)->whereDate('jam_masuk', '>', $min_date)
                        ->whereDate('jam_masuk', '<=', $max_date);
                },
                'log_absen as absen_alpha' => function ($query) use ($min_date, $max_date) {
                    $query->where('status_kehadiran', 4)->where('status_approval', '!=', 99)->whereDate('jam_masuk', '>', $min_date)
                        ->whereDate('jam_masuk', '<=', $max_date);
                },
                'log_absen as absen_mangkir' => function ($query) use ($min_date, $max_date) {
                    $query->where('status_approval', 99)->whereDate('jam_masuk', '>', $min_date)->whereDate('jam_masuk', '<=', $max_date);
                }
            ]);

        if ($this->search) {
            $data = $data->where('name', 'LIKE', "%{$this->search}%");
        }

        $data = $data->get();

        $periode = Carbon::parse($this->filter_tahun . '-' . $this->filter_bulan . '-' . '01')->format('F Y');

        return view('administrator.human_resource.export.index', compact('data', 'periode'));
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
                $event->sheet->getDelegate()->getStyle('A2:G2')
                    ->applyFromArray($styleArray2);
                $event->sheet->getDelegate()->getStyle('A1:G1')
                    ->applyFromArray($styleArray2);
                $event->sheet->getDelegate()->getStyle('A3:G3')
                    ->applyFromArray($styleArray2);
                $event->sheet->getDelegate()->getStyle('A4:G4')
                    ->applyFromArray($styleArray2);
            },
        ];
    }
}
