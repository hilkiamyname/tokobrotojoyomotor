<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\DetailProduct;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Carbon\Carbon;

class ProductController extends Controller
{
    public function index()
    {
        // $products = Product::with('user')->whereHas('user')->get();
        $products = Product::latest()->get();
        // $users = User::latest()->get();
        return view('products.products', compact('products'));
    }

    public function detailproductpage(){
        $products = DetailProduct::latest()->get();

        return view('products.detail_products', compact('products'));
    }

    public function create()
    {
        return view('products.add_products');
    }

    public function store(Request $request): RedirectResponse
    {
        // dd('haii');
        //validate form
        // $request->validate([
        //     'namaproduct'         => 'required|string|max:255',
        //     'kodeproduct'         => 'required|string|min:5|max:20',
        //     'jumlah'              => 'required|integer|min:10',
        //     'hargamasuk'          => 'required|numeric',
        //     'hargajual'           => 'requ$products_count = $products->count();ired|numeric'
        // ]);
        $request->validate([
            'namaproduct' => 'required|unique:products,namaproduct',
            'kodeproduct' => 'required|unique:products,kodeproduct',
            'jumlah' => 'required',
            'hargamasuk' => 'required',
            'hargajual' => 'required',
        ],[
            'namaproduct.unique' => 'Nama Product has already exist!',
            'kodeproduct.unique' => 'Kode Product has already exist!',
            'jumlah.required' => 'Jumlah is required!',
            'hargamasuk.required' => 'Harga Masuk is required!',
            'hargajual.required' => 'Harga Jual is required!'
        ]);

        //create product
        // $user = User::query()->id;
        $user = Auth::user()->id;
        // dd($user);

        Product::insert([
            'namaproduct'         => $request->namaproduct,
            'kodeproduct'         => $request->kodeproduct,
            'jumlah'              => $request->jumlah,
            'hargamasuk'          => $request->hargamasuk,
            'hargajual'           => $request->hargajual,
            'id_user'             => $user,
            'created_at'          => Carbon::now(),
            'updated_at'          => Carbon::now(),
            ]);

        DetailProduct::insert([
            'namaproduct'         => $request->namaproduct,
            'kodeproduct'         => $request->kodeproduct,
            'jumlah'              => $request->jumlah,
            'hargamasuk'          => $request->hargamasuk,
            'hargajual'           => $request->hargajual,
            'id_user'             => $user,
            'created_at'          => Carbon::now(),
            'updated_at'          => Carbon::now(),
            'action'              => 'add',
            ]);
        //redirect to index
        return redirect()->route('products.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function edit(string $id) : View
    {
        $products = Product::find($id);

        return view('products.edit_products')->with('products', $products);
    }

    public function update(Request $request, $id){

        // Validate the request data
        $request->validate([
            'namaproduct' => 'required|unique:products,namaproduct,' . $id,
            'kodeproduct' => 'required|unique:products,kodeproduct,' . $id,
            'jumlah' => 'required',
            'hargamasuk' => 'required',
            'hargajual' => 'required'
        ], [
            'namaproduct.unique' => 'Nama Product has already exist!',
            'kodeproduct.unique' => 'Kode Product has already exist!',
            'jumlah.required' => 'Jumlah is required!',
            'hargamasuk.required' => 'Harga Masuk is required!',
            'hargajual.required' => 'Harga Jual is required!'
        ]);

        $products = Product::findOrFail($id);

        // $current_time = Carbon::now()->timestamp;

        $products->update([
            'namaproduct'         => $request->namaproduct,
            'kodeproduct'         => $request->kodeproduct,
            'jumlah'              => $request->jumlah,
            'hargamasuk'          => $request->hargamasuk,
            'hargajual'           => $request->hargajual
        ]);

        $user = Auth::user()->id;

        DetailProduct::insert([
            'namaproduct'         => $request->namaproduct,
            'kodeproduct'         => $request->kodeproduct,
            'jumlah'              => $request->jumlah,
            'hargamasuk'          => $request->hargamasuk,
            'hargajual'           => $request->hargajual,
            'id_user'             => $user,
            'created_at'          => Carbon::now(),
            'updated_at'          => Carbon::now(),
            'action'              => 'edit',
            ]);

        return redirect()->route('products.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    public function destroy($id) : RedirectResponse
    {

        $products = Product::findOrFail($id);

        $products->delete();

        return redirect()->route('products.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
