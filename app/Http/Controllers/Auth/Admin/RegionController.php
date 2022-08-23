<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Province;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class RegionController extends Controller
{
    //
    public function __construct(){
        $this->middleware('permission:region-list|region-create|region-edit|region-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:region-create', ['only' => ['createProvince','CreateCity', 'storeProvince','storeCity']]);
        $this->middleware('permission:region-edit', ['only' => ['editProvince','editCity', 'updateProvince','updateCity']]);
        $this->middleware('permission:region-delete', ['only' => ['destroyCity','destroyProvince']]);
    }
    public function index()
    {
        $provinces = Province::with('cities')->latest()->paginate(10);
        return Inertia::render('Auth/Regions/Index', ['provinces' => $provinces]);
    }

    public function createProvince()
    {
        return Inertia::render('Auth/Regions/CreateProvince');
    }

    public function createCity(Province $province)
    {
        return Inertia::render('Auth/Regions/AddCityToProvince', ['province' => $province]);
    }

    public function storeProvince(Request $request)
    {

        $province = Province::create($this->validateProvince($request));
        activity()->performedOn($province)
            ->causedBy(Auth::user())
            ->log("استان جدید با نام $province->title ساخته شده است. ");
        return redirect()->route('regions.index')
            ->with('message', 'استان جدید با موفقیت افزوده شد.');
    }

    public function validateProvince(Request $request)
    {
        return $request->validate([
            'title' => ['required', 'string']
        ]);


    }

    public function storeCity(Request $request, Province $province)
    {

        $city = $province->cities()->create($this->validateCity($request));
        activity()->performedOn($province)
            ->causedBy(Auth::user())
            ->log("شهر جدید با نام $city->title ساخته شده است. ");
        return redirect()->route('regions.index')
            ->with('message', 'شهر جدید با موفقیت افزوده شد.');

    }

    public function validateCity(Request $request)
    {
        return $request->validate([
            'title' => ['required', 'string'],
        ]);


    }

    public function showProvince(Province $province)
    {
        dd($province);
    }

    public function editProvince(Province $province)
    {
        return Inertia::render('Auth/Regions/EditProvince', [
            'province' => $province
        ]);
    }

    public function updateProvince(Request $request, Province $province)
    {
        $province->update($this->validateProvince($request));
        activity()->performedOn($province)
            ->causedBy(Auth::user())
            ->log("استان با نام $province->title ویرایش شده است. ");
        return redirect()->route('regions.index')
            ->with('message', 'استان مورد نظر با موفقیت ویرایش گردید.');
    }

    public function destroyProvince(Province $province)
    {
        $province->delete();
        activity()->performedOn($province)
            ->causedBy(Auth::user())
            ->log("استان با نام $province->title حذف شده است. ");
        return redirect()->route('regions.index')
            ->with('message', 'استان مورد نظر حذف گردید.');
    }

    public function showCity(City $city)
    {

    }

    public function editCity(City $city)
    {
        return Inertia::render('Province/Edit', [
            'city' => [
                'id' => $city->id,
                'title' => $city->title
            ]
        ]);
    }

    public function updateCity(Request $request, City $city)
    {
        $city->update($this->validateCity($request));
        activity()->performedOn($city)
            ->causedBy(Auth::user())
            ->log("شهر با نام $city->title ویرایش شده است. ");
        return redirect()->route('regions.index')
            ->with('message', 'شهر مورد نظر با موفقیت ویرایش گردید.');
    }

    public function destroyCity(City $city)
    {
        activity()->performedOn($city)
            ->causedBy(Auth::user())
            ->log("شهر با نام $city->title حذف شده است. ");
        $city->delete();
        return redirect()->route('regions.index')
            ->with('message', 'شهر مورد نظر حذف گردید.');
    }
}
