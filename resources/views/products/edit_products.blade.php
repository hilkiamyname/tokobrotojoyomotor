<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<x-app-layout>
    <div class="container mt-5 mb-5">
        <div class="row pb-5">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <form action="{{ route('products.update', $products) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group mb-3">
                                <label class="font-weight-bold">Nama Products</label>
                                <input type="text" class="form-control @error('namaproduct') is-invalid @enderror" name="namaproduct" value="{{ $products->namaproduct }}" placeholder="Masukkan Judul Product">

                                <!-- error message untuk namaproduct -->
                                @error('namaproduct')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="font-weight-bold">Kode Products</label>
                                <input type="text" class="form-control @error('kodeproduct') is-invalid @enderror" name="kodeproduct" value="{{ $products->kodeproduct}}" placeholder="Masukkan Kode Product">

                                <!-- error message untuk kodeproduct -->
                                @error('kodeproduct')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="font-weight-bold">Harga Masuk</label>
                                        <input type="number" class="form-control @error('price') is-invalid @enderror" name="hargamasuk" value="{{ $products->hargamasuk }}" placeholder="Masukkan Harga Product">

                                        <!-- error message untuk hargamasuk -->
                                        @error('hargamasuk')
                                            <div class="alert alert-danger mt-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="font-weight-bold">Harga Jual</label>
                                        <input type="number" class="form-control @error('hargajual') is-invalid @enderror" name="hargajual" value="{{ $products->hargajual }}" placeholder="Masukkan Harga Jual Product">

                                        <!-- error message untuk hargajual -->
                                        @error('hargajual')
                                            <div class="alert alert-danger mt-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                            </div>

                            <div class="form-group mb-3">
                                <label class="font-weight-bold">Jumlah</label>
                                <input type="text" class="form-control @error('jumlah') is-invalid @enderror" name="jumlah" value="{{$products->jumlah}}" placeholder="Masukkan Jumlah Product">

                                <!-- error message untuk jumlah -->
                                @error('jumlah')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-md btn-primary me-3">SAVE</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
</body>
</html>
