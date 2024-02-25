<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Bahan Baku</title>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th align="center">No</th>
                <th align="center">Nama</th>
                <th align="center">Deskripsi</th>
                <th align="center">Stok</th>
                <th align="center">Satuan</th>
                <th align="center">Harga</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp @forelse ($data as $d)
            <tr>
                <td align="center">{{ $no }}</td>
                <td>{{ $d->nama }}</td>
                <td>{{ $d->deskripsi }}</td>
                <td align="center">{!! stokCheck($d->stok) !!}</td>
                <td align="center">{{ $d->satuan }}</td>
                <td>{{ intval($d->harga) }}</td>
            </tr>
            @php $no++; @endphp
            @endforeach
        </tbody>
    </table>
</body>
</html>
