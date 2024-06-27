<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <link  href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
</head>
<style>
    .pending-paid{
        font-size: 1.5em;
    }
    @media print {
        table{
            font-size: 11px;
            max-width: 100%;
        }

        td {
            max-width: 20%;
        }

        .pending-paid{
            font-size: 12px;
        }

        .payment-method {
            font-size: 12px;
        }

        .grand-total {
            font-size: 14px
        }
        .card-title {
            font-size: 14px;
        }
        .toko-brotojoyo-motor {
            margin-top: 10px;
            text-align: center;
            font-size: 12px
        }

        .no-print { display: none; }
            @page {
            margin: 0;  /* Adjust margins for better control */
        }


    }
</style>
<body>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        {{-- <h4 class="mb-sm-0">Detail Transaksi</h4> --}}

                        {{-- <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Transaksi</a></li>
                                <li class="breadcrumb-item active">Detail Transaksi</li>
                            </ol>
                        </div> --}}

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="toko-brotojoyo-motor" style="">
                                <h5>TOKO BROTOJOYO MOTOR</h5>
                                Jl. Brotojoyo Timur II No. 2A
                                <p>No telp: 024 3584402</p>
                            </div>
                            <div class="card-title">
                                <h4 class="card-title">{{ $transaction->no_transaction }}</h4>
                                {{-- Customer Name : <strong>{{ $transaction->customer_name }}</strong> --}}
                                <p class="card-title-desc">Transaction Date : {{ date('d-m-Y', strtotime($transaction->created_at)) }}</p>

                            </div>

                            <div class="table-responsive">
                                <table class="table mb-0">

                                    <thead class="table-light">
                                        <tr>
                                            <th>Nama Barang</th>
                                            <th>Jumlah Barang</th>
                                            <th class="text-end">Harga</th>
                                            <th class="text-end">Jumlah Harga</th>
                                        </tr>
                                    </thead>

                                    @php
                                        $total = 0;
                                    @endphp

                                    <tbody>
                                        {{-- {{ $transaction->products }} --}}
                                        @foreach ($transaction->products as $key => $product)
                                            <tr>
                                                <td>{{ $product->namaproduct }}</td>
                                                <td>{{ $product->count }} </td>
                                                <td class="text-end">Rp{{ number_format($product->price, 0, ',', '.') }}</td>
                                                <td class="text-end">Rp{{ number_format($product->total_price, 0, ',', '.') }}</td>
                                            </tr>

                                            @php
                                                $total += $product->total_price
                                            @endphp
                                        @endforeach
                                        <tr>
                                            <td colspan="3" class="text-center">Total Harga</td>
                                            <td class="text-end">Rp{{ number_format($total, 0, ',', '.') }}</td>
                                        </tr>
                                        <tr class="table-light">
                                            <td colspan="3" class="text-center">Total Bayar</td>
                                            <td class="text-end"><h4 class="grand-total">Rp{{ number_format($total + $transaction->shipping_costs, 0, ',', '.') }}</h4></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <p class="text-center" id="terima-kasih" style="display:none; font-size:8px">~ TERIMA KASIH ~</p>
                            <div class="d-print-none">
                                <a href="{{ route('transaction.history_transaction') }}" class="btn btn-md btn-danger waves-effect waves-light mt-2">Back</a>
                                <div class="float-end">
                                    <a href="javascript:window.print()" class="btn btn-primary waves-effect waves-light mt-2" id="print"><i class="fa fa-print"></i>Print</a>
                                </div>
                            </div>

                        </div>

                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->
    </div>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>

<script>
    $(document).ready(function(){
        $("#print").on("click", function(){
            $("#terima-kasih").show();
        })
    })
</script>

<script>

    window.html2canvas = html2canvas;
    window.jsPDF = window.jspdf.jsPDF;

    function makePDF(){
        html2canvas(document.querySelector(".card-body"),{
            allowTaint:true,
            useCORS: true,
            scale: 1
        }).then(canvas =>{
            var img = canvas.toDataURL("image/png");

            var doc = new jsPDF();
            doc.save("htmltopdf");
        })
    }

</script>
</html>
