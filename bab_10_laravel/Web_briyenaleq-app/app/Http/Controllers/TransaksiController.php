<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class TransaksiController extends Controller
{
    public function index()
    {
        return view('transaksi', ['transaksi' => Transaksi::all()]);
    }

    public function list()
    {
        return response()->json(Transaksi::all());
    }

    public function store(Request $request)
    {
        $data = $request->all();

        if ($request->hasFile('bukti')) {
            $data['bukti'] = $request->file('bukti')->store('bukti_transaksi', 'public');
        }

        $transaksi = Transaksi::create($data);

        return response()->json([
            'id' => $transaksi->id,
            'tanggal' => $transaksi->tanggal,
            'nama' => $transaksi->nama,
            'produk' => $transaksi->produk,
            'kategori' => $transaksi->kategori,
            'harga' => $transaksi->harga,
            'status' => $transaksi->status,
            'bukti' => $transaksi->bukti ? $transaksi->bukti : null
        ]);
    }

    public function show($id)
    {
        $transaksi = Transaksi::findOrFail($id);

        return response()->json([
            'id' => $transaksi->id,
            'tanggal' => $transaksi->tanggal,
            'nama' => $transaksi->nama,
            'produk' => $transaksi->produk,
            'kategori' => $transaksi->kategori,
            'harga' => $transaksi->harga,
            'status' => $transaksi->status,
            'bukti' => $transaksi->bukti ? $transaksi->bukti : null
        ]);
    }

    public function update(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('bukti')) {
            if ($transaksi->bukti) Storage::disk('public')->delete($transaksi->bukti);
            $data['bukti'] = $request->file('bukti')->store('bukti_transaksi', 'public');
        }

        $transaksi->update($data);

        return response()->json([
            'id' => $transaksi->id,
            'tanggal' => $transaksi->tanggal,
            'nama' => $transaksi->nama,
            'produk' => $transaksi->produk,
            'kategori' => $transaksi->kategori,
            'harga' => $transaksi->harga,
            'status' => $transaksi->status,
            'bukti' => $transaksi->bukti ? $transaksi->bukti : null
        ]);
    }

    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);

        if ($transaksi->bukti) {
            Storage::disk('public')->delete($transaksi->bukti);
        }

        $transaksi->delete();

        return response()->json(['message' => 'Data berhasil dihapus']);
    }

    public function pdf()
    {
        $transaksi = Transaksi::all();
        $pdf = Pdf::loadView('pdf.transaksi_pdf', compact('transaksi'));
        return $pdf->download('data_transaksi.pdf');
    }
}
