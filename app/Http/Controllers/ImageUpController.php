<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageUpController extends Controller
{
    public function index()
    {
        $maintitle = 'イメージアップロード';
        $image = request()->input('image');
        return view('imageup.index', compact('image'));
    }
    public function create()
    {
        $main_title = "組み込み用イメージアップロード";
        return view('imageup.create', compact('main_title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $image_file = $request->file('image_file');
        if ($image_file) {
            $path =  $image_file->store('images', 'public');
            $image = ltrim($path, 'images/');
        }
        return redirect()->route('imageup.index', ['image' => $image]);
    }
}
