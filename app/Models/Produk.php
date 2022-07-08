<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Produk extends Model
{
use HasFactory;
protected $table = 'produk';
protected $fillable = [
'kategori_id',
'user_id',
'kode_produk',
'nama_produk',
'slug_produk',
'deskripsi_produk',
'foto',
'qty',
'satuan',
'harga',
'status',
 ];
public function kategori()
 {
return $this->belongsTo(Kategori::class, 'kategori_id');
 }
public function user()
 {
return $this->belongsTo(User::class, 'user_id');
 }
public function images()
 {
return $this->hasMany(ProdukImage::class, 'produk_id');
 }
 // function untuk menampilkan list produk promo
public function promo() {
    return $this->hasOne(ProdukPromo::class, 'produk_id');
 }
}
