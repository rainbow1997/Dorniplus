<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Request as RequestFacade;
use App\Models\User;
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected array $searchParams = ['title','created_at','updated_at'];
    public function __construct(Request $request)
    {

        $this->middleware('permission:category-list|category-edit|category-create|category-delete',['only' => ['index','show']]);
        $this->middleware('permission:category-create',['only' =>['create','store']]);
        $this->middleware('permission:category-edit',['only' => ['edit','update'] ]);
        $this->middleware('permission:category-delete',['only' => ['destroy'] ]);
    }

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

        $categories = $categories->withCount(['posts']);
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

        return Inertia::render('Post/Category/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function validateCreation(Request $request)
    {
        return $request->validate([
            'title' => ['required', 'string']
        ]);

    }
    public function store(Request $request)
    {
        //
        Category::create($this->validateCreation($request));

        return redirect()->route('categories.index')
            ->with('message', 'موضوع مورد نظر با موفقیت افزوده شد.');
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
        return Inertia::render('Post/Category/Edit', [
            'category' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    protected function validateUpdate(Request $request)
    {
        return $request->validate([
            'title' => ['required', 'string']
        ]);

    }
    public function update(Request $request, Category $category)
    {
        //
        $category->update($this->validateUpdate($request));

        return redirect()->route('categories.index')
            ->with('message', 'موضوع مورد نظر با موفقیت ویرایش گردید.');
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
        $category->delete();
        return redirect()->route('categories.index')
            ->with('message', 'موضوع مورد نظر حذف گردید.');
    }
}
