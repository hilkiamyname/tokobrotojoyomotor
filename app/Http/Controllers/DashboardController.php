<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CheckOut;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $checkouts = CheckOut::latest()->get(); // Or use your desired query to fetch data
        return view('dashboard', compact('checkouts'));
    }
}
