<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(){
    return view('products.index',['products'=>Product::get()]);
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
        return back()->withSuccess('Product Created Successfully');
    }

    public function edit($id){
        $product = Product::where('id',$id)->first();
        return view('products.edit',['product'=>$product]);
    }
    public function update(Request $request, $id){
        $request->validate([
            'name' =>'required',
            'description' =>'required',
            'image' =>'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $product = Product::where('id',$id)->first();
        if(isset($request->image)){
            $imagename =time().'.'.$request->image->extension();
            $request->image->move(public_path('products'), $imagename);
            $product->image = $imagename;
        }
        $product->name = $request->name;
        $product->description = $request->description;
        $product->save();
        return back()->withSuccess('Product Updated Successfully');
    }
    public function destroy($id){
        $product = Product::where('id',$id)->first();
        $product->delete();
        return back()->withSuccess('Product Deleted Successfully');
    }
}
