<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\CheckOut;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class TransactionController extends Controller
{
    public function index()
    {
        $transaction_date = Carbon::today()->toDateString();
        $checkouts = CheckOut::where('no_transaction', "TBM" . $transaction_date)->get();
        $transactions = Transaction::orderBy('id', 'desc')->first();
        $products = Product::latest()->get();
        //render view with products
        return view('transaction.transaction', compact('checkouts', 'products', 'transactions'));
    }

    // public function show($id){
    //     dd($id);
    // }

    // tambah barang ke checkout
    public function store(Request $request)
    {
        // dd("hore");
        $transaction_number = $request->transaction_number;
        $kodeproduct = $request->kodeproduct;

        $request->validate([
            'product_count' => 'required|min:1'
        ], [
            'product_count.required' => 'Item count must more than 0!'
        ]);

        $product_count = $request->product_count;

        $product = Product::where('kodeproduct', $kodeproduct)->first();

        $product_left = $product->jumlah;
        $product_left_updated = $product_left - $product_count;

        $total_price = $product_count * $product->hargajual;

        $item_sold = $product->jumlah_terjual + $product_count;

        $product->update([
            'jumlah' => $product_left_updated,
            'jumlah_terjual' => $item_sold,
        ]);

        $transaction_date = Carbon::today()->toDateString();

        // $current_time = Carbon::now()->timestamp;
        $id = $request->input('transaction_number');

        $checkout = CheckOut::where('kodeproduct', $kodeproduct)->where('no_transaction', "TBM" . $transaction_date)->first();

        if ($checkout) {
            $product_count = $checkout->count + $product_count;
            $total_price_1 = $product_count * $product->hargajual;

            // dd($total_price_1);
            $checkout->update([
                'count' => $product_count,
                'total_price' => $total_price_1,
            ]);
            // dd($checkout);
            // $checkout->save();
        } else {
            CheckOut::insert([
                // 'transaction_number'=> $transaction_number_fix,
                // 'transaction_date'  => $request->transaction_date,
                'kodeproduct'       => $kodeproduct,
                'no_transaction'    => "TBM" . $transaction_date,
                'namaproduct'       => $product->namaproduct,
                'count'             => $product_count,
                'price'             => $product->hargajual,
                'total_price'       => $total_price,
                // 'created_at'        => Carbon::today()->toDateString(),
            ]);
        }

        $checkout = CheckOut::all();

        return redirect()->back()->with([
            'product' => $product,
            'checkout' => $checkout
        ]);
    }

    public function update(Request $request, $id)
    {
        // dd($checkout);
        $kodeproduct = $request->kodeproduct;
        $checkout = Checkout::find($id);

        $product = Product::where('kodeproduct', $kodeproduct)->first();

        $product_left = $product->jumlah;
        $checkout_count = $checkout->count;
        $product_left_updated = $product_left + $checkout_count;

        // Update jumlah produk yang tersisa
        $product->update([
            'jumlah' => $product_left_updated
        ]);

        // Update jumlah checkout
        $checkout->delete();

        return redirect()->back()->with([
            'product' => $product,
            'checkout' => $checkout
        ]);
    }

    public function makeTransaction(Request $request)
    {
        // $transaction = $request;
        $transaction_number = $request->no_transaction;
        $checkout = json_decode($request->checkouts)[0];

        // $checkout = CheckOut::where('no_transaction', $transaction_number);

        // $today = Carbon::today()->toDateString()
        // $transaction_id = $checkout->no_transaction;

        $user = Auth::user()->id;

        Transaction::insert([
            'id_user'           => $user,
            'no_transaction'    => $checkout->no_transaction . $request->no_transaction,
            'total_price'       => $request->total_price,
            'created_at'        => Carbon::today()->toDateString()
        ]);

        $checkouts = Checkout::where('no_transaction', $checkout->no_transaction)->update([
            'no_transaction' => $checkout->no_transaction . $transaction_number,
        ]);

        return redirect()->route('transaction.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function historypage()
    {
        $transactions = Transaction::orderBy('id', 'desc')->get();
        return view('transaction.history_transaction', compact('transactions'));
    }

    public function printpage($id)
    {
        $transaction = Transaction::findOrFail($id);
        return view('transaction.print_transaction', compact('transaction'));
    }

    public function filterdate(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $transactions = Transaction::whereDate('created_at', '>=', $start_date)
            ->whereDate('created_at', '<=', $end_date)
            ->get();
        // dd($start_date);
        // $transactions = Transaction::whereDate('created_at','>=', $start_date)
        //                             ->whereDate('created_at','<=', $end_date)
        //                             ->get();

        return view('transaction.history_transaction', compact('transactions'));
    }

    public function showDetailTransaction()
    {
    }

    public function dashboardcheckout() {
        $checkouts = CheckOut::all();
        // dd($checkouts);
        return view('dashboard', compact('checkouts'));
    }

    public function filterdatedashboard(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        // dd($start_date);

        if ($start_date & $end_date) {
            $all_transactions = Transaction::whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date);
            $all_product = Product::whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date);
            $all_transactions_count = $all_transactions->count();
            $transactions_total_price = $all_transactions->sum('total_price');
            $product_outcome = $all_product->sum('hargamasuk');
            $checkouts = CheckOut::whereDate('updated_at', '>=', $start_date)->whereDate('updated_at', '<=', $end_date);
            $total_checkouts_date = 0;
            $total_checkouts_date += $checkouts->sum('count');
            // dd($checkouts_detail);
        } else {
            $all_transactions = Transaction::all();
            $all_product = Product::all();
            $all_transactions_count = $all_transactions->count();
            $transactions_total_price = $all_transactions->sum('total_price');
            $product_outcome = $all_product->sum('hargamasuk');
            $checkouts = CheckOut::all();
            // $checkouts = CheckOut::all();
            $total_checkouts_date = 0;
            $total_checkouts_date += $checkouts->sum('count');
            // dd($checkouts);
        }

        $checkouts_detail = CheckOut::whereDate('updated_at', '>=', $start_date)->whereDate('updated_at', '<=', $end_date)->get();
        // dd($checkouts_detail);
        // $transactions = Transaction::whereDate('created_at', '>=', $start_date)
        //     ->whereDate('created_at', '<=', $end_date)
        //     ->get();

        // dd($all_transactions);

        return view('dashboard', compact('all_transactions_count','transactions_total_price','total_checkouts_date','checkouts_detail'));
    }

    public function destroy($id): RedirectResponse
    {
        $checkouts = CheckOut::findOrFail($id);
        $checkouts->delete();
        return redirect()->route('transaction.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
