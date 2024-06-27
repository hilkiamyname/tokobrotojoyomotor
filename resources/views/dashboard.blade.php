<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<body>
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard Toko Brotojoyo Motor') }}
            </h2>
        </x-slot>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        @php
                        $transactions = App\Models\Transaction::all()->count();
                        $transactions_total = App\Models\Transaction::all()->sum('total_price');
                        $product_total_outcome = App\Models\Product::all()->sum('hargamasuk');
                        // $latest_transactions = App\Models\Transaction::latest()->limit(10)->get();
                        // $total_income = 0;
                        // foreach($transactions_total as $transaction){
                        // $total_income += $transaction->total_price;
                        // }
                        @endphp
                        <div class="row">
                            <form action="{{ route('dashboard.filterdate') }}" method="GET">
                                @csrf
                                <div class="row mb-2 align-items-end">
                                    <div class="col">
                                        <label for="">Start Date</label>
                                        <input type="date" name="start_date" class="form-control" required>
                                    </div>
                                    <div class="col">
                                        <label for="">End Date</label>
                                        <input type="date" name="end_date" class="form-control" required>
                                    </div>
                                    <div class="col">
                                        <button class="btn btn-primary" type="submit">Filter</button>
                                    </div>
                                </div>
                            </form>

                            <div class="col-xl-4 col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-truncate font-size-14 mb-2">Jumlah Transaksi</p>
                                                <h4 class="mb-2">{{ $all_transactions_count ?? $transactions }}</h4>
                                                {{-- <p class="text-muted mb-0"><span class="text-success fw-bold font-size-12 me-2"><i class="ri-arrow-right-up-line me-1 align-middle"></i>9.23%</span>from previous period</p> --}}
                                            </div>
                                            <div class="avatar-sm">
                                                <span class="avatar-title bg-light text-primary rounded-3">
                                                    <i class="ri-shopping-cart-2-line font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div><!-- end cardbody -->
                                </div><!-- end card -->
                            </div><!-- end col -->
                            @php
                                $check_outs = App\Models\CheckOut::all();
                                $total_checkouts = 0;
                                foreach($check_outs as $checkout){
                                    $total_checkouts += $checkout->count;
                                }
                            @endphp

                            <div class="col-xl-4 col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-truncate font-size-14 mb-2">Total Barang Terjual</p>
                                                <h4 class="mb-2">{{ $total_checkouts_date ?? $total_checkouts }}</h4>
                                                {{-- <p class="text-muted mb-0"><span class="text-danger fw-bold font-size-12 me-2"><i class="ri-arrow-right-down-line me-1 align-middle"></i>1.09%</span>from previous period</p> --}}
                                            </div>
                                            <div class="avatar-sm">
                                                <span class="avatar-title bg-light text-warning rounded-3">
                                                    <i class="ri-shopping-bag-3-line font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div><!-- end cardbody -->
                                </div><!-- end card -->
                            </div><!-- end col -->
                            <div class="col-xl-4 col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-truncate font-size-14 mb-2">Total Pemasukan</p>
                                                <h4 class="mb-2">Rp{{ number_format($transactions_total_price ?? $transactions_total, 0, ',', '.') }}</h4>
                                                {{-- <p class="text-muted mb-0"><span class="text-success fw-bold font-size-12 me-2"><i class="ri-arrow-right-up-line me-1 align-middle"></i>16.2%</span>from previous period</p> --}}
                                            </div>
                                            <div class="avatar-sm">
                                                <span class="avatar-title bg-light text-success rounded-3">
                                                    <i class="mdi mdi-currency-usd font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div><!-- end cardbody -->
                                </div><!-- end card -->
                            </div><!-- end col -->
                            {{-- <div class="col-xl-4 col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-truncate font-size-14 mb-2">Total Pengeluaran</p>
                                                <h4 class="mb-2">Rp{{ number_format($product_outcome ?? $product_total_outcome, 0, ',', '.') }}</h4>
                                                {{-- <p class="text-muted mb-0"><span class="text-success fw-bold font-size-12 me-2"><i class="ri-arrow-right-up-line me-1 align-middle"></i>16.2%</span>from previous period</p> --}}
                                            {{-- </div>
                                            <div class="avatar-sm">
                                                <span class="avatar-title bg-light text-success rounded-3">
                                                    <i class="mdi mdi-currency-usd font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div><!-- end cardbody -->
                                </div><!-- end card -->
                            </div><!-- end col --> --}}
                            {{-- SHOW THE CHECKOUTS --}}
                        </div><!-- end row -->

                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
</body>
</html>

