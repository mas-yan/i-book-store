<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::latest()->get();
        return view('admin.slider.index', compact('sliders'));
    }
    public function create()
    {
        return view('admin.slider.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'link' => 'required',
            'image' => 'required|image|mimes:jpeg,jpg,png|max:2000'
        ]);

        $image = $request->file('image');
        $image->storeAs('public/slider', $image->hashName());

        $slider = Slider::create([
            'link' => $request->link,
            'image' => $image->hashName(),
        ]);

        if ($slider) {
            return redirect()->route('slider.index')->with('success', "Slider Successfully Added");
        } else {
            return redirect()->route('slider.index')->with('error', "Slider Failed To Added");
        }
    }

    public function destroy($id)
    {
        $slider = Slider::findOrFail($id);
        Storage::disk('local')->delete('public/slider/' . basename($slider->image));
        $slider->delete();

        if ($slider) {
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
