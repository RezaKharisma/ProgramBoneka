<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Pengeluaran Bahan Baku</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style type="text/css">
		table tr td,
		table tr th{
			font-size: 9pt;
		}
	</style>
</head>
<body>
    <center class="mb-5">
		<h5>Data Pengeluaran Bahan Baku {{ \Carbon\Carbon::now()->format('Y') }}</h4>
	</center>
    <table class="table table-bordered" border="1">
        <thead>
            <tr>
                <th align="center">No</th>
                <th align="center">Nama Bahan Baku</th>
                <th align="center">Penambahan Stok</th>
                <th align="center">Tanggal</th>
                <th align="center">Harga</th>
                <th align="center">Harga Total</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp @forelse ($data as $d)
            <tr>
                <td align="center">{{ $no }}</td>
                <td>
                    {{ $d->bahan_baku->nama }}
                    @if ($d->deleted_at != null)
                        <span style="color: red">(deleted)</span>
                    @endif
                </td>
                <td align="center">{{ $d->jumlah }}</td>
                <td>{{ Carbon\Carbon::parse($d->created_at)->translatedFormat('d F Y') }}</td>
                <td>Rp. {{ currency_IDR(intval($d->harga)) }}</td>
                <td>Rp. {{ currency_IDR(intval($d->harga) * $d->jumlah)}}</td>
            </tr>
            @php $no++; @endphp
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5" align="center">Total</td>
                <td>Rp. {{ currency_IDR($total) }}</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
