<?php

namespace App\Http\Controllers;

use App\Models\Washing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class WashingController extends Controller
{
    public function index()
    {
        $washings = Washing::all();
        return view('admin.washings.index', compact('washings'));
    }

    public function store(Request $req)
    {
        $washing = new Washing();

        $washing->washing_name = $req->washing_name;
        $washing->owner_name = $req->owner_name;
        $washing->owner_tel = $req->owner_tel;
        $washing->address = $req->address;
        $washing->status = $req->status;

        if($req->hasFile('image')){
            $ext = $req->image->extension();
            $fileName = rand(1,100).time().'.'.$ext;
            $fileNameWithUpload = 'storage/uploads/' . $fileName;
            $req->image->storeAs('public/uploads', $fileName);

            $washing->image = $fileNameWithUpload;

        }

        $washing->save();
        return redirect()->route('washing');
    }

    public function edit($id)
    {
        $washing = Washing::where('id',$id)->firstOrFail();
        return view('admin.washings.edit', compact('washing'));
    }

    public function update(Request $req, $id)
    {

        $washing = Washing::where('id',$id)->firstOrFail();


        $washing->washing_name = $req->washing_name;
        $washing->owner_name = $req->owner_name;
        $washing->owner_tel = $req->owner_tel;
        $washing->address = $req->address;
        $washing->status = $req->status;

        if($req->hasFile('image')){
            $ext = $req->image->extension();
            $fileName = rand(1,100).time().'.'.$ext;
            $fileNameWithUpload = 'storage/uploads/' . $fileName;
            $req->image->storeAs('public/uploads', $fileName);

            $washing->image = $fileNameWithUpload;

        }

        $washing->save();

//        return redirect()->route('washing');
        return redirect()->back();
    }

    public function delete($id)
    {
        $washing = Washing::findOrFail($id);

        if( File::exists($washing->image)){
            File::delete($washing->image);
        }
        $washing->delete();

        return redirect()->route('washing');
    }
}
