<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Haha</title>
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <link  href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
</head>
<body>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Transaction') }}
        </h2>
    </x-slot>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <div class="dropdown mb-3">
                        {{-- <a href="{{ route('transaction.create') }}" class="btn btn-md btn-success">Add Transaction</a> --}}
                        <a href="{{ route('transaction.history_transaction') }}" class="btn btn-md btn-success">History Transaction</a>
                        </div>
                        {{-- Searching --}}
                        {{-- <form id="search" action="{{ route('products') }}" method="GET"> --}}
                            {{-- @csrf --}}
                            {{-- <div class="input-group mb-3">
                                <input type="text" class="form-control" name="search" value="" placeholder="Masukkan kata kunci">
                                <button class="btn btn-secondary" type="submit">
                                    Cari
                                </button>
                            </div> --}}
                        {{-- </form> --}}
                        {{-- <form action="" method="POST">
                            @csrf --}}
                            <div class="col-2">
                                <label class="form-label" for="transaction_number">Nomor Transaksi :</label>
                                @if (!isset($transactions))
                                    <input readonly type="number" class="form-control form-control-sm mb-3" value="1" name="transaction_number" id="transaction_number" disabled>
                                @else
                                    <input readonly type="number" class="form-control form-control-sm mb-3" value="{{ $transactions->id + 1 }}" name="transaction_number" id="transaction_number" disabled>
                                @endif
                            </div>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">Nama Product</th>
                                        <th scope="col">Kode Product</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Harga Satuan</th>
                                        <th scope="col">Harga Total</th>
                                        <th scope="col" style="width: 8% ; text-align: center;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($checkouts as $checkout)
                                        <tr>
                                            <td>{{ $checkout->namaproduct }}</td>
                                            <td>{{ $checkout->kodeproduct }}</td>
                                            <td>{{ $checkout->count }}</td>
                                            <td>{{ "Rp " . number_format($checkout->price,2,',','.') }}</td>
                                            <td>{{ "Rp " . number_format($checkout->total_price,2,',','.') }}</td>
                                            <td class="text-center">
                                                <input name="kodeproduct" type="hidden" value="{{ $checkout->kodeproduct }}">
                                                <form action="{{ route('transaction.update', $checkout->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="kodeproduct" value="{{ $checkout->kodeproduct }}">
                                                    <button type="submit" class="btn btn-sm btn-danger">Cancel</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <div class="alert alert-danger">
                                            Data Products belum Tersedia.
                                        </div>
                                    @endforelse
                                        <tr>
                                            <td colspan="4"></td>
                                            <td>{{ "Rp " . number_format($checkouts->sum('total_price'),2,',','.')}}</td>
                                            <form action="{{ route('make.transaction') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="total_price" value="{{ $checkouts->sum('total_price') }}">
                                                <input type="hidden" name="checkouts" value="{{ $checkouts }}">
                                                {{-- <input type="hidden" name="no_transaction" value="{{ $transactions->id + 1 }}"> --}}
                                                @if (isset($transactions))
                                                <input type="hidden" name="no_transaction" value="{{ $transactions->id + 1 }}">
                                                @else
                                                <input type="hidden" name="no_transaction" value="1">
                                                @endif
                                                <td class="text-center"><button type="submit" class="btn btn-sm btn-primary">Buat Nota</button></td>
                                            </form>
                                        </tr>
                                </tbody>
                            </table>
                        {{-- </form> --}}

                        <div class="card-body">
                        <table class="table table-bordered pt-2" id="tabel-data">
                            <thead>
                                <tr>
                                    <th scope="col">Nama Product</th>
                                    <th scope="col">Kode Product</th>
                                    <th scope="col">Jumlah</th>
                                    <th scope="col">Harga Jual</th>
                                    <th scope="col" style="width: 10%">Quantity</th>
                                    <th scope="col" style="width: 12%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($products as $product)
                                    <tr>
                                        <td>{{ $product->namaproduct }}</td>
                                        <td>{{ $product->kodeproduct }}</td>
                                        <td>{{ $product->jumlah }}</td>
                                        <td>{{ "Rp " . number_format($product->hargajual,2,',','.') }}</td>
                                        {{-- <td>{{ "Rp " . number_format($product->hargajual,2,',','.') }}</td> --}}
                                        <form action="{{ route('transaction.store')}}" method="POST">
                                            @csrf
                                            <td>
                                                <input style="width: 100% ;" type="number" value="0" name="product_count" min="1" max="{{ $product->jumlah }}">
                                            </td>
                                            @error('product_count')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                            <td class="text-center">
                                                <input type="hidden" name="kodeproduct" value="{{ $product->kodeproduct }}">
                                                @method('POST')
                                                <button type="submit" class="btn btn-sm btn-primary">Tambah</button>
                                            </td>
                                        </form>
                                    </tr>
                                @empty
                                    <div class="alert alert-danger">
                                        Data Products belum Tersedia.
                                    </div>
                                @endforelse
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        //message with sweetalert
        @if(session('success'))
            Swal.fire({
                icon: "success",
                title: "BERHASIL",
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2000
            });
        @elseif(session('error'))
            Swal.fire({
                icon: "error",
                title: "GAGAL!",
                text: "{{ session('error') }}",
                showConfirmButton: false,
                timer: 2000
            });
        @endif
    </script>

<script>
    $(document).ready(function(){
        $('#tabel-data').DataTable();
    });
</script>
</body>
</html>
