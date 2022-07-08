<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
class LatihanController extends Controller
{
public function index()
 {
return "oke, ini dari controller";
 }
public function blog($id)
 {
return "Ini blog dengan id " . $id;
 }
 public function komentar($idblog, $idkomentar)
 {
echo 'Id blognya : ' . $idblog;
echo '<br />';
echo 'Id komentarnya : ' . $idkomentar;
 }
 public function beranda()
 {
$data = array('nama' => 'Toko Klowor');
return view('beranda', $data);
 }
}
