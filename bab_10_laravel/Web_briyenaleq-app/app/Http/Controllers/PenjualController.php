<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;

class PenjualController extends Controller
{
    public function index()
    {
        // Ambil data penjualan, group by penjual
        $penjualData = Penjualan::selectRaw('nama, COUNT(*) as jumlah')
            ->groupBy('nama')
            ->get();

        $totalData = $penjualData->sum('jumlah');

        return view('Penjual', compact('penjualData', 'totalData'));
    }
}
