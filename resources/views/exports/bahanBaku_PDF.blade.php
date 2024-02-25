<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Bahan Baku</title>
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
		<h5>Data Bahan Baku {{ \Carbon\Carbon::now()->format('Y') }}</h4>
	</center>

    <table class="table table-bordered" border="1">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Deskripsi</th>
                <th>Stok</th>
                <th>Satuan</th>
                <th>Harga</th>
                {{-- <th>Tanggal Input</th> --}}
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp @forelse ($data as $d)
            <tr>
                <td>{{ $no }}</td>
                <td>{{ $d->nama }}</td>
                <td>{{ $d->deskripsi }}</td>
                <td>{{ $d->stok }}</td>
                <td>{{ $d->satuan }}</td>
                <td>Rp. {{ currency_IDR($d->harga) }}</td>
                {{-- <td>{{ \Carbon\Carbon::parse($d->created_at)->format('d/m/Y h:i A') }}</td> --}}
            </tr>
            @php $no++; @endphp
            @endforeach
        </tbody>
    </table>
</body>
</html>
