<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Kategori extends Model
{
use HasFactory;
protected $table = 'kategori';
protected $fillable = [
'kode_kategori',
'nama_kategori',
'slug_kategori',
'deskripsi_kategori',
'status',
'foto',
'user_id',
 ];
public function user()
 { //user yang menginput data kategori
return $this->belongsTo(User::class, 'user_id');
}
public function produk()
 {
return $this->belongsTo(Produk::class, 'id', 'kategori_id');
 }
}
