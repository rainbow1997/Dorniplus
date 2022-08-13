<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Request as RequestFacade;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected array $searchParams = ['title','created_at','updated_at'];

    public function index()
    {
        //
        $request = collect(RequestFacade::all());
        $search = apartSearchParameters($request,$this->searchParams);

        $categories = Category::query();
        if($search->isNotEmpty())
        {

            $categories->when($search['title'], function ($query, $search) {// $search['title] become $search

                return $query->title($search);
            })
            ->when($search['updated_at'], function ($query, $search) {
                    return $query->updatedat(convertDateForDB($search));
            })
            ->when($search['created_at'], function ($query, $search) {
                    return $query->createdat(convertDateForDB($search));
            });

        }

        $categories = Category::withCount(['posts']);
        $categories = $categories->orderBy('created_at', 'ASC')->paginate(5);

        return Inertia::render('Post/Category/Index',['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
    }
}
