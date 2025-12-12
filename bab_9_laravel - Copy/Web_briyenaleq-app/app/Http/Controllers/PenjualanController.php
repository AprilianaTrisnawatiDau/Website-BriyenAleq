<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class PenjualanController extends Controller
{
    public function index()
    {
        $penjualData = Penjualan::orderBy('id', 'desc')->get();
        return view('penjualan', compact('penjualData'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tanggal' => 'required|date',
            'nama' => 'required|string|max:100',
            'produk' => 'required|string|max:100',
            'alamat' => 'required|string',
            'kategori' => 'required|string|in:Ternak,Tani',
            'harga' => 'required|numeric|min:0',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('penjualan', 'public');
        }

        $penjualan = Penjualan::create($data);

        return response()->json([
            'success' => true,
            'data' => $penjualan,
            'foto_url' => $penjualan->foto ? asset('storage/'.$penjualan->foto) : null
        ]);
    }

    public function edit($id)
    {
        $penjualan = Penjualan::findOrFail($id);
        return response()->json($penjualan);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'tanggal' => 'required|date',
            'nama' => 'required|string|max:100',
            'produk' => 'required|string|max:100',
            'alamat' => 'required|string',
            'kategori' => 'required|string|in:Ternak,Tani',
            'harga' => 'required|numeric|min:0',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $penjualan = Penjualan::findOrFail($id);

        if ($request->hasFile('foto')) {
            if ($penjualan->foto && Storage::exists('public/'.$penjualan->foto)) {
                Storage::delete('public/'.$penjualan->foto);
            }
            $data['foto'] = $request->file('foto')->store('penjualan', 'public');
        }

        $penjualan->update($data);

        return response()->json([
            'success' => true,
            'data' => $penjualan,
            'foto_url' => $penjualan->foto ? asset('storage/'.$penjualan->foto) : null
        ]);
    }

    public function destroy($id)
    {
        $penjualan = Penjualan::findOrFail($id);
        if ($penjualan->foto && Storage::exists('public/'.$penjualan->foto)) {
            Storage::delete('public/'.$penjualan->foto);
        }
        $penjualan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }

    public function generatePDF()
    {
        $data = Penjualan::orderBy('id', 'desc')->get();
        $pdf = Pdf::loadView('penjualan.report', compact('data'));
        return $pdf->download('laporan_penjualan_' . date('Y-m-d') . '.pdf');
    }
}
