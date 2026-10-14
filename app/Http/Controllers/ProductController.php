<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\Products\StoreProductRequest;
use App\Http\Requests\Products\UpdateProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('user', 'category')
        ->latest()
        ->paginate(8);
    
        return view('products.index', compact('products'));
    
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        
        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $validatedData = $request->validated();
        
        if ($request->hasFile('image')) {
            $validatedData['image'] = storeImage($request->file('image'));
        }

        $validatedData['user_id'] = auth()->id();
        
        Product::create($validatedData);
        
        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load('user', 'category');

        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();

        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $validatedData = $request->validated();

        if ($request->hasFile('image')) {
        
            // Store the new image and get the path
            $oldImage = $product->getRawOriginal('image');
            
            // Store the new image and update the validated data with the new image path
            $validatedData['image'] = storeImage($request->file('image'));
            
            $product->update($validatedData);  // if this throws, we stop here —
                // old file is still intact, nothing broken
                deleteImage($oldImage); // only reached if the update succeeded
            } else {
                $product->update($validatedData);
            }
        
        return redirect()->route('products.index')->with('success', 'Product Updateed successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
