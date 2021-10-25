<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    public function index()
    {
        $company = Company::first();
        return view('admin.company.index', compact('company'));
    }

    public function update(Request $request, $id)
    {
        $company = Company::find($id);
        $logo = $request->file('logo');
        // dd($logo);

        if ($logo == '') {
            $this->validate($request, [
                'name' => 'required',
                'address' => 'required',
                'detail' => 'required',
                'long' => 'required',
                'lat' => 'required',
                'day_operational' => 'required',
                'time_operational' => 'required',
            ]);
            $company->update([
                'name' => $request->name,
                'address' => $request->address,
                'detail' => $request->detail,
                'long' => $request->long,
                'lat' => $request->lat,
                'day_operational' => $request->day_operational,
                'time_operational' => $request->time_operational,
            ]);
        } else {
            // $this->validate($request, [
            //     'name' => 'required',
            //     'address' => 'required',
            //     'about' => 'required',
            //     'logo' => 'required|image|mimes:jpeg,jpg,png|max:2000',
            //     'long' => 'required',
            //     'lat' => 'required',
            //     'day_operational' => 'required',
            //     'time_operational' => 'required',
            // ]);

            Storage::disk('local')->delete('public/Company/' . basename($company->logo));

            $logo->storeAs('public/Company', $logo->hashName());

            $company->update([
                'name' => $request->name,
                'address' => $request->address,
                'logo' => $logo->hashName(),
                'about' => $request->detail,
                'long' => $request->long,
                'lat' => $request->lat,
                'day_operational' => $request->day_operational,
                'time_operational' => $request->time_operational,
            ]);
        }
        if ($company) {
            return redirect()->route('company.index')->with('success', "Data Company Successfully Updated");
        } else {
            return redirect()->route('company.index')->with('error', "Data Company Failed To Updated");
        }
    }
}
