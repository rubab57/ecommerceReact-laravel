<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Log::debug("hitting");
        $categories= Category::all();
        return response()->json(["data"=>$categories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       //to show create form
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->merge(["slug"=>Str::slug($request->title)]);
       
        $validator= Validator::make($request->all(), [
            "title"=>"required", 
            "slug"=>"required|unique:categories,slug",
            "status"=>"nullable"
        ]);
        if($validator->fails()){
            return response()->json(["errors"=>$validator->errors()], 422);
        }
        $category= Category::create($request->all());
        return response()->json(["status"=>"created"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
      $category=Category::find($id);
    // $category=Category::where("slug",$id)->first();
      return response()->json(["data"=>$category]);
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
     $category= Category::find($id);
     $request->merge(["slug"=>Str::slug($request->title)]);
      $validator= Validator::make($request->all(), [
        "title"=>"required", 
        "slug"=>"required|unique:categories,slug,".$category->id,
        "status"=>"nullable"
    ]);
    if($validator->fails()){
        return response()->json(["errors"=>$validator->errors()], 422);
    }
    $category->title=$request->title;
    $category->slug=$request->slug;
    $category->status=$request->status ? true: false;
    $category->save();
    return response()->json(["status"=>"updated"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    $category=Category::find($id);
    $category->delete();
    return response()->json(["status"=>"deleted"]);
    }
}
