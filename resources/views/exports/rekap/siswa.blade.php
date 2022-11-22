<div style="display: flex; width: 100%; margin-bottom: 2em;">
    <img src="{{ asset('storage/images/annahl.png') }}" alt="logo" style="float:left;">
    <div style="text-align: center;" id="top">
        <span>LAPORAN HASIL MEMBACA BUKU SISWA</span>
        <br>
        <span>SD AN NAHL ISLAMIC SCHOOL</span>
    </div>
</div>
<div style="font-size: small; width: 100%; display: flex;">
    <div style="width: 15%; float: left;">
        <div>Nama</div>
        <div>No Induk</div>
        <div>Kelas</div>
    </div>
    <div style="width: 85%;">
        <div>: {{ $siswa->nama }}</div>
        <div>: {{ $siswa->nis }}</div>
        <div>: {{ $siswa->grade->kelas }}</div>
    </div>
</div>

<br>
<table border="1" align="center" width="100%">
    <thead>
        <tr>
            <th rowspan="2">NO</th>
            <th colspan="2">WAKTU PEMINJAMAN</th>
            <th rowspan="2">JUDUL BUKU</th>
            <th rowspan="2">PENGARANG</th>
        </tr>
        <tr>
            <th>DARI</th>
            <th>SAMPAI</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($buku as $item)
        <tr>
            <th>{{ $loop->iteration }}</th>
            <td>{{ $item->dipinjam->format('d-m-Y') }}</td>
            <td>{{ $item->dikembalikan->format('d-m-Y') }}</td>
            <td>{{ $item->book->judul }}</td>
            <td>{{ $item->book->pengarang ?? '-' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<style>
    table,
    td,
    th {
        border: 2px solid black;
        padding: 6px;
        font-size: small;
    }

    table {
        border-collapse: collapse;
    }

    th {
        text-align: center;
    }

    #top span {
        font-size: large;
    }
</style>