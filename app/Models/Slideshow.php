<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Slideshow extends Model
{
protected $table = "slideshow";
protected $fillable = [
'foto',
'caption_title',
'caption_content',
'user_id',
 ];
public function user()
 {
return $this->belongsTo(User::class, 'user_id');
 }
}
