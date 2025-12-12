<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class KeranjangController extends Controller
{
    public function index(Request $request)
    {
        $kategoriDipilih = $request->kategori ?? 'Semua';

        $produkList = DB::table('penjualan')
            ->leftJoin('rating_produk', 'penjualan.id', '=', 'rating_produk.id_penjualan')
            ->select('penjualan.*', DB::raw('AVG(rating_produk.rating) as rating'))
            ->groupBy('penjualan.id')
            ->orderByDesc('penjualan.id')
            ->get();

        $produkFiltered = ($kategoriDipilih === 'Semua')
            ? $produkList
            : $produkList->where('kategori', $kategoriDipilih);

        $kategoriList = $produkList->pluck('kategori')->unique()->sort()->values();

        $dibeli = Session::get('pembelian_sukses', []);

        return view('Belanja', compact('produkFiltered', 'kategoriList', 'kategoriDipilih', 'dibeli'));
    }

    public function add($id)
    {
        $produk = DB::table('penjualan')->where('id', $id)->first();
        $keranjang = Session::get('keranjang', []);
        $keranjang[] = [
            'id' => $produk->id,
            'nama' => $produk->produk,
            'harga' => $produk->harga,
            'qty' => 1
        ];
        Session::put('keranjang', $keranjang);
        return redirect()->route('keranjang.view');
    }

    public function buyNow($id)
    {
        $produk = DB::table('penjualan')->where('id', $id)->first();
        $keranjang = [[
            'id' => $produk->id,
            'nama' => $produk->produk,
            'harga' => $produk->harga,
            'qty' => 1
        ]];
        Session::put('keranjang', $keranjang);
        return redirect()->route('checkout');
    }

    public function view()
    {
        $keranjang = Session::get('keranjang', []);
        $total = collect($keranjang)->sum(fn($item) => $item['harga'] * $item['qty']);
        return view('KeranjangView', compact('keranjang', 'total'));
    }

    public function remove($key)
    {
        $keranjang = Session::get('keranjang', []);
        if (isset($keranjang[$key])) {
            unset($keranjang[$key]);
            Session::put('keranjang', array_values($keranjang));
        }
        return redirect()->route('keranjang.view');
    }

    public function checkout()
    {
        $keranjang = Session::get('keranjang', []);
        $total = collect($keranjang)->sum(fn($item) => $item['harga'] * $item['qty']);
        return view('Pembayaran', compact('keranjang','total'));
    }

    public function processPayment(Request $request)
    {
        $keranjang = Session::get('keranjang', []);
        if (empty($keranjang)) return redirect()->route('keranjang.view');

        Session::put('pembelian_sukses', collect($keranjang)->pluck('id')->toArray());
        Session::forget('keranjang');

        return view('ProsesPembayaran', [
            'pembelian_sukses' => Session::get('pembelian_sukses')
        ]);
    }

    public function showRating($id)
    {
        $dibeli = Session::get('pembelian_sukses', []);

        if (!in_array($id, $dibeli)) abort(403, 'Produk belum dibeli.');

        $produk = DB::table('penjualan')->where('id', $id)->first();

        return view('Rating', compact('produk'));
    }

    public function processRating(Request $request)
    {
        $request->validate([
            'id_penjualan' => 'required',
            'rating' => 'required|integer|min:1|max:5'
        ]);

        DB::table('rating_produk')->insert([
            'id_penjualan' => $request->id_penjualan,
            'rating' => $request->rating,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->route('belanja')->with('success', 'Rating berhasil dikirim!');
    }
}
