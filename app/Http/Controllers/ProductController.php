<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(){
    return view('products.index');
    }
    public function create(){
    return view('products.create');
    }
    public function store(Request $request){
        $request->validate([
            'name' =>'required',
            'description' =>'required',
            'image' =>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $imagename =time().'.'.$request->image->extension();
        $request->image->move(public_path('products'), $imagename);
        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->image = $imagename;
        $product->save();
        return back();
    }
}
