<?php

namespace App\Http\Controllers;
use App\Models\Image;
use Illuminate\Http\Request;
class ImageController extends Controller
{
public function index(Request $request) {
$itemuser = $request->user();
$itemgambar = Image::where('user_id', $itemuser->id)->paginate(20);
$data = array('title' => 'Data Image',
'itemgambar' => $itemgambar);
return view('image.index', $data)->with('no', ($request->input('page', 1) - 1) * 20);
 }
public function store(Request $request)
 {
$this->validate($request, [
'image' =>
'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
 ]);
$itemuser = $request->user();
$fileupload = $request->file('image');
$folder = $request->file('image')->store('public/images');
$itemgambar = $this->upload($fileupload, $itemuser, $folder);
// $inputan = $request->all();
// $inputan['user_id'] = $itemuser->id;
// Image::create($inputan);
return back()->with('success', 'Image berhasil diupload');
 }
public function destroy(Request $request, $id) {
$itemuser = $request->user();
$itemgambar = Image::where('user_id', $itemuser->id)
->where('id', $id)
->first();
if ($itemgambar) {
\Storage::delete($itemgambar->url);
$itemgambar->delete();
return back()->with('success', 'Data berhasil dihapus');
 } else {
return back()->with('error', 'Data tidak ditemukan');
 }
 }
public function upload($fileupload, $itemuser, $folder) {
$folder = 'assets/images';
$path = $fileupload->store('images');
$inputangambar['url'] = $path;
$inputangambar['user_id'] = $itemuser->id;
return Image::create($inputangambar);
 }
}
