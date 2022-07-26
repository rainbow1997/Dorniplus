<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use \App\Models\Province;
use \App\Models\City;
class RegionController extends Controller
{
    //
    public function index(){
        $provinces = Province::with('cities')->latest()->paginate(10);
        return Inertia::render('Auth/Regions/Index',['provinces' => $provinces]);
    }
    public function createProvince(){
        return Inertia::render('Auth/Regions/CreateProvince');
    }
    public function createCity(Province $province)
    {
        return Inertia::render('Auth/Regions/AddCityToProvince',['province' => $province]);
    }
    public function storeProvince(Request $request)
    {
        
        Province::create($this->validateProvince($request));
        return redirect()->route('regions.index')
        ->with('message','استان جدید با موفقیت افزوده شد.');
    }
    public function validateProvince(Request $request)
    {
        return $request->validate([
            'title' => ['required','string']
        ]);


    }
    public function storeCity(Request $request,Province $province)
    {
        
        $province->cities()->create($this->validateCity($request));
        return redirect()->route('regions.index')
        ->with('message','شهر جدید با موفقیت افزوده شد.');

    }
    public function validateCity(Request $request)
    {
        return $request->validate([
            'title' => ['required','string'],
        ]);


    }
    public function showProvince(Province $province){
        dd($province);
    }
    public function editProvince(Province $province)
    {
        return Inertia::render('Auth/Regions/EditProvince',[
            'province' => $province
            ]);
    }
    public function updateProvince(Request $request,Province $province)
    {
        $province->update($this->validateProvince($request));
        
        return redirect()->route('regions.index')
        ->with('message','استان مورد نظر با موفقیت ویرایش گردید.');
    }
    public function destroyProvince(Province $province)
    {
        $province->delete();
        return redirect()->route('regions.index')
        ->with('message','استان مورد نظر حذف گردید.');
    }

    public function showCity(City $city){

    }
    public function editCity(City $city)
    {
        return Inertia::render('Province/Edit',[
            'city' => [
                'id' => $city->id,
                'title' => $city->title
            ]
            ]);
    }
    public function updateCity(Request $request,City $city)
    {
        $city->update($this->validateCity($request));
        
        return redirect()->route('regions.index')
        ->with('message','شهر مورد نظر با موفقیت ویرایش گردید.');
    }
    public function destroyCity(City $city)
    {
        $city->delete();
        return redirect()->route('regions.index')
        ->with('message','شهر مورد نظر حذف گردید.');
    }
}
