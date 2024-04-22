<table>
    <tbody>
        <tr>
            <th colspan="6" style="font-weight: 700; text-align: center;">REKAP DATA ABSENSI</th>
        </tr>
        <tr>
            <th></th>
            <th></th>
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
            <th>No</th>
            <th>Nama Karyawan</th>
            <th>Hadir</th>
            <th>Sakit</th>
            <th>Izin</th>
            <th>Alpha</th>
            <th>Mangkir</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $i => $item)
            <tr>
                <td>{{ $i + 1; }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->absen_hadir }}</td>
                <td>{{ $item->absen_sakit }}</td>
                <td>{{ $item->absen_izin }}</td>
                <td>{{ $item->absen_alpha }}</td>
                <td>{{ $item->absen_mangkir }}</td>
            </tr>
        @endforeach
    </tbody>
</table>