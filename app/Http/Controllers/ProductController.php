<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Product::all();
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "name"=> "required|string|max:255",
            "price"=> "required",
            "slug"=> "required"
            ]);

        return Product::create($request->all());
      
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // sekgoas e podobro da se koristi findOR Fail poso ako
        // ne go najde toj record ke frli error deka ne postoi Not Found 
        return Product::findOrFail($id);
    }

  
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // poso sakam prvo da go zemam produktot potoa da go updejtiram 
        $product = Product::findOrFail($id); // go imam tekovniot produkt preku id-to 
        $product->update($request->all());
        return $product;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return Product::destroy($id);
    }

    public function search(string $name) {
        return Product::where("name","like","%". $name ."%")->get();

    }
}
