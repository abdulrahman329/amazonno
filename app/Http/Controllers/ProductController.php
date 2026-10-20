<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\Products\StoreProductRequest;
use App\Http\Requests\Products\UpdateProductRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Product::with('user', 'category', 'cover')
        ->when($request->filled('category'), fn ($q) => $q->where('category_id', $request->category))
        ->when($request->filled('search'), fn ($q) => $q->where('name', 'like', '%' . $request->search . '%'))
        ->latest()
        ->paginate(8);

        $categories = Category::orderBy('name')->get();
    
        return view('products.index', compact('products', 'categories'));
    
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Product::class); 

        $categories = Category::orderBy('name')->get();
        
        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        
        DB::transaction(function () use ($request) {
            $product = Product::create([
                ...$request->safe()->except('images'),
                'user_id' => $request->user()->id,
            ]);
    
            foreach ($request->file('images') as $index => $file) {
                $product->images()->create([
                    'path'       => storeImage($file, 'products'),
                    'sort_order' => $index,
                ]);
            }
        });
        
        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load('user', 'category','images');

        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $this->authorize('update', $product); 

        $categories = Category::orderBy('name')->get();

        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        // Only this product's images can be removed, even if someone sends other ids
        $toRemove = $product->images()
            ->whereIn('id', $request->input('remove_images', []))
            ->get();

        $newFiles = $request->file('images', []);

        $total = $product->images()->count() - $toRemove->count() + count($newFiles);

        if ($total < 1 || $total > 5) {
            return back()
                ->withInput()
                ->withErrors(['images' => 'A product must have between 1 and 5 images.']);
        }

        DB::transaction(function () use ($request, $product, $toRemove, $newFiles) {
            $product->update($request->safe()->except(['images', 'remove_images']));

            $next = ($product->images()->max('sort_order') ?? -1) + 1;

            foreach ($newFiles as $file) {
                $product->images()->create([
                    'path'       => storeImage($file, 'products'),
                    'sort_order' => $next++,
                ]);
            }

            $product->images()->whereIn('id', $toRemove->pluck('id'))->delete();
        });

        // Files are deleted only after the database work succeeded
        $toRemove->each(fn ($image) => deleteImage($image->path));

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);

        $paths = $product->images()->pluck('path');

        $product->delete();   // the database cascade removes the image rows

        $paths->each(fn ($path) => deleteImage($path));

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
