<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;  // Tambah ini
use Illuminate\Support\Facades\Validator;  // Tambah ini
use Barryvdh\DomPDF\Facade\Pdf;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksi = Transaksi::orderBy('created_at', 'desc')->get();
        return view('transaksi', ['transaksi' => $transaksi]);
    }

    public function list()
    {
        $transaksi = Transaksi::orderBy('created_at', 'desc')->get();
        return response()->json($transaksi);
    }

    public function store(Request $request)
    {
        try {
            // Validasi input
            $validator = Validator::make($request->all(), [
                'tanggal' => 'required|date',
                'nama' => 'required|string|max:255',
                'produk' => 'required|string|max:255',
                'kategori' => 'required|in:Tani,Ternak',
                'harga' => 'required|numeric|min:0',
                'status' => 'required|in:Pending,Success',
                'bukti' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            $data = $request->all();

            if ($request->hasFile('bukti')) {
                $data['bukti'] = $request->file('bukti')->store('bukti_transaksi', 'public');
            }

            $transaksi = Transaksi::create($data);

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil ditambahkan',
                'id' => $transaksi->id,
                'tanggal' => $transaksi->tanggal,
                'nama' => $transaksi->nama,
                'produk' => $transaksi->produk,
                'kategori' => $transaksi->kategori,
                'harga' => $transaksi->harga,
                'status' => $transaksi->status,
                'bukti' => $transaksi->bukti ? $transaksi->bukti : null,
                'created_at' => $transaksi->created_at->format('Y-m-d H:i:s')
            ]);

        } catch (\Exception $e) {
            Log::error('Store Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $transaksi = Transaksi::findOrFail($id);

            return response()->json([
                'success' => true,
                'id' => $transaksi->id,
                'tanggal' => $transaksi->tanggal,
                'nama' => $transaksi->nama,
                'produk' => $transaksi->produk,
                'kategori' => $transaksi->kategori,
                'harga' => $transaksi->harga,
                'status' => $transaksi->status,
                'bukti' => $transaksi->bukti ? $transaksi->bukti : null
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $transaksi = Transaksi::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'tanggal' => 'required|date',
                'nama' => 'required|string|max:255',
                'produk' => 'required|string|max:255',
                'kategori' => 'required|in:Tani,Ternak',
                'harga' => 'required|numeric|min:0',
                'status' => 'required|in:Pending,Success',
                'bukti' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            $data = $request->all();

            if ($request->hasFile('bukti')) {
                if ($transaksi->bukti) {
                    Storage::disk('public')->delete($transaksi->bukti);
                }
                $data['bukti'] = $request->file('bukti')->store('bukti_transaksi', 'public');
            }

            $transaksi->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diupdate',
                'id' => $transaksi->id,
                'tanggal' => $transaksi->tanggal,
                'nama' => $transaksi->nama,
                'produk' => $transaksi->produk,
                'kategori' => $transaksi->kategori,
                'harga' => $transaksi->harga,
                'status' => $transaksi->status,
                'bukti' => $transaksi->bukti ? $transaksi->bukti : null
            ]);

        } catch (\Exception $e) {
            Log::error('Update Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $transaksi = Transaksi::findOrFail($id);

            if ($transaksi->bukti) {
                Storage::disk('public')->delete($transaksi->bukti);
            }

            $transaksi->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            Log::error('Delete Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function pdf()
    {
        $transaksi = Transaksi::orderBy('tanggal', 'desc')->get();
        $pdf = Pdf::loadView('pdf.transaksi_pdf', compact('transaksi'));
        return $pdf->download('data_transaksi_' . date('Y-m-d_H-i-s') . '.pdf');
    }
}
