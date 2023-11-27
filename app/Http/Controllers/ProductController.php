<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products=Product::with("category")->get();
        return response()->json(["data"=>$products]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->merge(["slug"=>Str::slug($request->title)]);
        $validator= Validator::make($request->all(),[
          "title"=>"required",
          "slug"=>"required|unique:products,slug",
          "description"=>"required",
          "image"=>"nullable",
          "price"=>"required|regex:/^\d+(\.\d{1,2})?$/",
          "discount"=>"nullable",
          "status"=>"nullable",
          "category_id"=>"required|exists:categories,id"
        ]);
        if($validator->fails()){
            return response()->json(["errors"=>$validator->errors()], 422);
        }
        $fileName=null;
        // dd($request->hasFile("image"));
       
        if ($request->hasFile("image")){
            
            $fileName = time().'.'.$request->image->extension();
           
            $request->image->move(public_path("images"),$fileName);
        }
        $product = Product::create([
            "title"=>$request->title,
            "slug"=>$request->slug,
            "description"=>$request->description,
            "image"=>$fileName,
            "price"=>$request->price,
            "discount"=>$request->discount ?? 0,
            "status"=>$request->status,
            "category_id"=>$request->category_id
        ]);
        return response()->json(["status"=>"created"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product=Product::find($id);
        return response()->json(["data"=>$product]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Log::debug($request->all());
    $product=Product::find($id);
    $request->merge(["slug"=>Str::slug($request->title)]);
        $validator= Validator::make($request->all(),[
          "title"=>"required",
          "slug"=>"required|unique:products,slug,". $product->id,
          "description"=>"required",
          "image"=>"nullable",
          "price"=>"required|regex:/^\d+(\.\d{1,2})?$/",
          "discount"=>"nullable",
          "status"=>"nullable",
          "category_id"=>"required|exists:categories,id"
        ]);
        if($validator->fails()){
            return response()->json(["errors"=>$validator->errors()], 422);
        }
        $fileName= $product->image;
       if($request->hasFile("image")){
        $fileName= time().".".$request->image->extension();
        $request->image->move(public_path("images"),$fileName);
       }
    $product->title=$request->title;
    $product->slug=$request->slug;
    $product->description=$request->description;
    $product->image=$fileName;
    $product->price=$request->price;
    $product->discount=$request->discount;
    $product->category_id=$request->category_id;
    $product->status=$request->status ? true: false;
    $product->save();
        return response()->json(["status"=>"updated"]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product=Product::find($id);
    $product->delete();
    return response()->json(["status"=>"deleted"]);
    }
}
