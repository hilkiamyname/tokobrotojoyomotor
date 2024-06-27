<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <x-app-layout>
    <div class="container mt-4">
        <a href="{{ route('products.index') }}" class="btn btn-md btn-danger me-3 mb-4">Back</a>
        <table class="table table-bordered pt-2" id="tabel-data">
            <thead class="table-primary">
                <tr>
                    <th scope="col">User Input</th>
                    <th scope="col">Nama Product</th>
                    <th scope="col">Kode Product</th>
                    <th scope="col">Jumlah</th>
                    <th scope="col">Harga Masuk</th>
                    <th scope="col">Harga Jual</th>
                    <th scope="col">Waktu</th>
                    <th scope="col" style="width: 12%">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr>
                        {{-- perlu ganti jumlah nya sesuai dengan kurang tambahnya --}}
                        <td>{{ $product->user->name }}</td>
                        <td>{{ $product->namaproduct }}</td>
                        <td>{{ $product->kodeproduct }}</td>
                        <td>{{ $product->jumlah }}</td>
                        <td>{{ "Rp " . number_format($product->hargamasuk,2,',','.') }}</td>
                        <td>{{ "Rp " . number_format($product->hargajual,2,',','.') }}</td>
                        <td>{{ $product->created_at }}</td>
                        <td class="text-center">
                            {{ $product->action }}
                            {{-- <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('products.destroy', $product->id) }}" method="POST">
                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form> --}}
                        </td>
                    </tr>
                @empty
                    <div class="alert alert-danger">
                        Data Products belum Tersedia.
                    </div>
                @endforelse
            </tbody>
        </table>
    </div>
    </x-app-layout>
</body>
</html>
