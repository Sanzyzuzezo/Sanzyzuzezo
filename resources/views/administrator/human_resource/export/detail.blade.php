<table>
    <tbody>
        <tr>
            <th colspan="2" style="font-weight: 700; text-align: center;">REKAP DETAIL ABSENSI</th>
        </tr>
        <tr>
            <th></th>
            <th></th>
        </tr>
        <tr>
            <th>Nama Karyawan</th>
            <th>{{ $karyawans->name }}</th>
        </tr>
        <tr>
            <th>Periode</th>
            <th>{{ $periode }}</th>
        </tr>
    </tbody>
</table>

<table class="table">
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Status Kehadiran</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($final_arr as $item)
            <tr>
                <td>{{\Carbon\Carbon::parse($item['tanggal'])->format('d F Y')}}</td>
                <td>
                    @if ($item['status_kehadiran'] == 1)
                        Hadir
                    @elseif($item['status_kehadiran'] == 2)
                        Sakit
                    @elseif($item['status_kehadiran'] == 3)
                        Izin
                    @elseif($item['status_kehadiran'] == 4)
                        Alpha
                    @else
                        Mangkir
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>