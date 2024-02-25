<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Produk</title>
</head>
<body>
    <table border="1">
        <thead>
            <tr>
                <th align="center">No</th>
                <th align="center">Nama</th>
                <th align="center">Deskripsi</th>
                <th align="center">Bahan Baku</th>
                <th align="center">Harga Beli</th>
                <th align="center">Harga Jual</th>
                <th align="center">Stok</th>
                <th align="center">Status</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp @forelse ($data as $d)
            @php
                $bahanBaku = json_decode($d->bahan_baku, true);
                $bahanBakuCount = count($bahanBaku);
            @endphp
            <tr>
                <td align="center" rowspan="{{ $bahanBakuCount }}">{{ $no }}</td>
                <td rowspan="{{ $bahanBakuCount }}">{{ $d->nama }}</td>
                <td rowspan="{{ $bahanBakuCount }}">{{ $d->deskripsi }}</td>
                @foreach ($bahanBaku as $key => $bb)
                    @if ($key == 0)
                        <td>{{ $bb['nama'] }} | jumlah : {{ $bb['jumlah'] }} {{ $bb['satuan'] }} | Harga Pokok : {{ $bb['harga'] }}</td>
                    @endif
                @endforeach
                <td rowspan="{{ $bahanBakuCount }}">Rp. {{ currency_IDR($d->harga_beli) }}</td>
                <td rowspan="{{ $bahanBakuCount }}">Rp. {{ currency_IDR($d->harga_jual) }}</td>
                <td rowspan="{{ $bahanBakuCount }}" align="center">{{ $d->stok }}</td>
                <td rowspan="{{ $bahanBakuCount }}" align="center" >{{ $d->status }}</td>
            </tr>
            @if ($bahanBakuCount)
            @foreach ($bahanBaku as $key => $bb)
                @if ($key != 0)
                    <tr>
                        <td>{{ $bb['nama'] }} | jumlah : {{ $bb['jumlah'] }} {{ $bb['satuan'] }} | Harga Pokok : {{ $bb['harga'] }}</td>
                    </tr>
                @endif
            @endforeach
            @endif
            @php $no++; @endphp
            @endforeach
        </tbody>
    </table>
</body>
</html>
