<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use App\Models\ProdukPromo;
use App\Models\Slideshow;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomepageController extends Controller
{
    public function index()
    {
        $itemproduk = Produk::orderBy('created_at', 'desc')
            ->limit(6)
            ->get();
        $itempromo = ProdukPromo::orderBy('created_at', 'desc')
            ->limit(6)
            ->get();
        $itemkategori = Kategori::orderBy('nama_kategori', 'asc')
            ->limit(6)
            ->get();
        $itemslide = Slideshow::get();
        $data = [
            'title' => 'Homepage',
            'itemproduk' => $itemproduk,
            'itempromo' => $itempromo,
            'itemkategori' => $itemkategori,
            'itemslide' => $itemslide,
        ];
        return view('homepage.index', $data);
    }
    public function about()
    {
        $data = ['title' => 'Tentang Kami'];
        return view('homepage.about', $data);
    }
    public function kontak()
    {
        $data = ['title' => 'Kontak Kami'];
        return view('homepage.kontak', $data);
    }
    public function kategori()
    {
        $itemkategori = Kategori::orderBy('nama_kategori', 'asc')
            ->limit(6)
            ->get();
        $itemproduk = Produk::orderBy('created_at', 'desc')
            ->limit(6)
            ->get();
        $data = ['title' => 'Kategori Produk', 'itemkategori' =>
        $itemkategori, 'itemproduk' => $itemproduk];
        return view('homepage.kategori', $data);
    }
    public function kategoribyslug(Request $request, $slug)
    {
        $itemproduk = Produk::orderBy('nama_produk', 'desc')
            ->where('status', 'publish')
            ->whereHas('kategori', function ($q) use ($slug) {
                $q->where('slug_kategori', $slug);
            })
            ->paginate(18);
        $listkategori = Kategori::orderBy('nama_kategori', 'asc')
            ->where('status', 'publish')
            ->get();
        $itemkategori = Kategori::where('slug_kategori', $slug)
            ->where('status', 'publish')
            ->first();
        if ($itemkategori) {
            $data = [
                'title' => $itemkategori->nama_kategori,
                'itemproduk' => $itemproduk, 'listkategori' => $listkategori,
                'itemkategori' => $itemkategori
            ];
            return view('homepage.produk', $data)->with(
                'no',
                ($request->input('page') - 1) * 18
            );
        } else {
            return abort('404');
        }
    }
    public function produk(Request $request)
    {
        $itemproduk = Produk::orderBy('nama_produk', 'desc')
            ->where('status', 'publish')
            ->paginate(18);
        $listkategori = Kategori::orderBy('nama_kategori', 'asc')
            ->where('status', 'publish')
            ->get();
        $data = [
            'title' => 'Produk', 'itemproduk' => $itemproduk,
            'listkategori' => $listkategori
        ];
        return view('homepage.produk', $data)->with('no', ($request->input('page') - 1) * 18);
    }
    public function produkdetail($id)
    {
        $itemproduk = Produk::where('slug_produk', $id)
            ->where('status', 'publish')
            ->first();
        if ($itemproduk) {
            if (Auth::user()) { //cek kalo user login
                $itemuser = Auth::user();
                $itemwishlist = Wishlist::where(
                    'produk_id',
                    $itemproduk->id
                )->where('user_id', $itemuser->id)
                    ->first();
                $data = array(
                    'title' => $itemproduk->nama_produk,
                    'itemproduk' => $itemproduk,
                    'itemwishlist' => $itemwishlist
                );
            } else {
                $data = array(
                    'title' => $itemproduk->nama_produk,
                    'itemproduk' => $itemproduk
                );
            }
            return view('homepage.produkdetail', $data);
        } else {
            // kalo produk ga ada, jadinya tampil halaman tidakditemukan (error 404)
            return abort('404');
        }
    }
}
