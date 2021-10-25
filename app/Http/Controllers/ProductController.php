<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class ProductController extends Controller
{

    public function dataProducts()
    {
        $product = Product::leftJoin('categories', 'categories.id', '=', 'products.category_id')->select('title', 'price', 'products.slug', 'stok', 'products.image', 'products.id', 'categories.name')->orderBy('products.created_at', 'desc');

        // dd($product->categories->nam);
        return DataTables::of($product)
            ->addIndexColumn()
            ->addColumn('price', function ($price) {
                return moneyFormat($price->price);
            })
            ->addColumn('action', function ($data) {
                $action = '<div class="text-center"><a href="' . route("product.edit", $data->slug) . '" width="130" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> Edit</a> | <button onclick="destroy(this.id)" id="' . $data->id . '" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i> Delete</button> | <a href="' . route("product.show", $data->slug) . '" width="130" class="btn btn-sm btn-success"><i class="fas fa-eye"></i> Show</a></div>';
                return $action;
            })
            ->addColumn('category', function ($category) {
                return $category->name;
            })
            ->addColumn('image', function ($image) {
                $gambar = '<div class="text-center"><img src="' . $image->image . '" style="height:65px" class="rounded"></div>';
                return $gambar;
            })
            ->rawColumns(['price', 'image', 'category', 'action'])
            ->toJson();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.product.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::latest()->get();
        return view('admin.product.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|unique:products,title',
            'category' => 'required',
            'detail' => 'required',
            'stok' => 'required',
            'price' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,jpg,png|max:2000'
        ]);

        $image = $request->file('image');
        $image->storeAs('public/products', $image->hashName());

        $product = Product::create([
            'title' => $request->title,
            'category_id' => $request->category,
            'slug' => Str::slug($request->title),
            'image' => $image->hashName(),
            'price' => $request->price,
            'stok' => $request->stok,
            'detail_product' => $request->detail
        ]);

        if ($product) {
            return redirect()->route('product.index')->with('success', "Product Successfully Added");
        } else {
            return redirect()->route('product.index')->with('error', "Product Failed To Added");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('admin.product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $category = Category::get();
        return view('admin.product.edit', compact('product', 'category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $image = $request->file('image');
        $product = Product::where('slug', $product->slug)->first();

        if ($image == '') {
            $this->validate($request, [
                'title' => [
                    'required',
                    Rule::unique('products')->ignore($product->id),
                ],
                'category' => 'required',
                'detail' => 'required',
                'stok' => 'required',
                'price' => 'required|numeric',
            ]);

            $product->update([
                'name' => $request->title,
                'category_id' => $request->category,
                'price' => $request->price,
                'stok' => $request->stok,
                'detail_product' => $request->detail,
            ]);
        } else {
            $this->validate($request, [
                'title' => [
                    'required',
                    Rule::unique('products')->ignore($product->id),
                ],
                'category' => 'required',
                'detail' => 'required',
                'stok' => 'required',
                'price' => 'required|numeric',
                'image' => 'required|image|mimes:jpeg,jpg,png,svg|max:2000'
            ]);

            $image = $request->file('image');
            Storage::disk('local')->delete('public/products/' . basename($product->image));
            $image->storeAs('public/products', $image->hashName());

            $product->update([
                'title' => $request->title,
                'category_id' => $request->category,
                'slug' => Str::slug($request->title),
                'image' => $image->hashName(),
                'price' => $request->price,
                'stok' => $request->stok,
                'detail_product' => $request->detail
            ]);
        }

        if ($product) {
            return redirect()->route('product.index')->with('success', "Product Successfully Added");
        } else {
            return redirect()->route('product.index')->with('error', "Product Failed To Added");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        Storage::disk('local')->delete('public/products/' . basename($product->image));
        $product->delete();

        if ($product) {
            return response()->json([
                'status' => 'success'
            ]);
        } else {
            return response()->json([
                'status' => 'error'
            ]);
        }
    }
}
