<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $categories = Category::latest()->get();
        return view('admin.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.create');
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
            'title' => 'required|unique:categories,name',
            'image' => 'required|image|mimes:jpeg,jpg,png|max:2000'
        ]);

        $image = $request->file('image');
        $image->storeAs('public/categories', $image->hashName());

        $categories = Category::create([
            'slug' => Str::slug($request->title),
            'name' => $request->title,
            'image' => $image->hashName()
        ]);

        if ($categories) {
            return redirect()->route('categories.index')->with('success', "Category Successfully Added");
        } else {
            return redirect()->route('categories.index')->with('error', "Category Failed To Added");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function show(Category $categories)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('admin.category.edit', ['category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $image = $request->file('image');

        if ($image == '') {
            $this->validate($request, [
                'title' => [
                    'required',
                    Rule::unique('products')->ignore($category->id),
                ],
            ]);

            $category = Category::where('slug', $category->slug)->first();
            $category->update([
                'name' => $request->title,
            ]);
        } else {
            $this->validate($request, [
                'title' => [
                    'required',
                    Rule::unique('products')->ignore($category->id),
                ],
                'image' => 'required|image|mimes:jpeg,jpg,png|max:2000'
            ]);
            $category = Category::where('slug', $category->slug)->first();
            Storage::disk('local')->delete('public/categories/' . basename($category->image));


            $image->storeAs('public/categories', $image->hashName());

            $category->update([
                'name' => $request->title,
                'image' => $image->hashName(),
            ]);
        }

        if ($category) {
            return redirect()->route('categories.index')->with('success', "Category Successfully Added");
        } else {
            return redirect()->route('categories.index')->with('error', "Category Failed To Added");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        Storage::disk('local')->delete('public/categories/' . basename($category->image));
        $category->delete();

        if ($category) {
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
