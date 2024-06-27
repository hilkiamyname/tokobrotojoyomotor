<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <link  href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
</head>
<body>
<x-app-layout>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <div class="gap-2">
                            <a href="{{ route('transaction.index') }}" class="btn btn-md btn-success mb-2">Back</a>
                            <form action="{{ route('transaction.filterdate') }}" method="GET">
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
                        </div>
                        <form action=""></form>
                        {{-- @csrf --}}
                            <table class="table table-bordered pt-2" id="tabel-data">
                                <thead class="table-primary">
                                    <tr>
                                        <th scope="col">User Input</th>
                                        <th scope="col">No Transaction</th>
                                        <th scope="col">Harga Total</th>
                                        <th scope="col">Detail</th>
                                        <th scope="col" style="width: 8% ; text-align: center;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($transactions as $transaction)
                                        <tr>
                                            <td>{{ $transaction->user->name }}</td>
                                            <td>{{ $transaction->no_transaction }}</td>
                                            {{-- <td>{{ $transaction->total_price }}</td> --}}
                                            <td>{{ "Rp " . number_format($transaction->total_price,2,',','.') }}</td>
                                            {{-- <td></td> --}}
                                            <td>
                                                <table>
                                                    <thead>
                                                        <th>Nama</th>
                                                        <th>Jumlah</th>
                                                        <th>Harga</th>
                                                        {{-- <th>Total</th> --}}
                                                    </thead>
                                                    <tbody>
                                                        @forelse($transaction->products as $key => $product)
                                                        <tr>
                                                            <td>
                                                                {{ $product->namaproduct }}
                                                            </td>
                                                            <td>
                                                                {{ $product->count }}

                                                            </td>
                                                            <td>
                                                                Rp{{ number_format($product->price, 0, ',', '.') }}

                                                            </td>
                                                            {{-- <td>
                                                                Rp{{ number_format($product->total_price, 0, ',', '.') }}

                                                            </td> --}}
                                                        </tr>
                                                        @empty

                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('transaction.print_transaction', $transaction->id) }}" class="btn btn-sm btn-success">Print</a>
                                                {{-- <button>detail</button> --}}
                                            </td>
                                            {{-- </td> --}}
                                        </tr>

                                    @empty
                                        <div class="alert alert-danger">
                                            Data Transaction belum Tersedia.
                                        </div>
                                    @endforelse
                                </tbody>
                            </table>
                        </form>
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
<script type="text/javascript">
    $(function() {

        var start = moment().subtract(29, 'days');
        var end = moment();

        function cb(start, end) {
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }

        $('#reportrange').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
               'Today': [moment(), moment()],
               'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
               'Last 7 Days': [moment().subtract(6, 'days'), moment()],
               'Last 30 Days': [moment().subtract(29, 'days'), moment()],
               'This Month': [moment().startOf('month'), moment().endOf('month')],
               'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);

        cb(start, end);

    });
</script>

<script>
    $(document).ready(function(){
        $('#tabel-data').DataTable();
    });
</script>
</body>
</html>


