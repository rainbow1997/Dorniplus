<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request as RequestFacade;
use Inertia\Inertia;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    protected array $searchParams = ['title', 'created_at', 'updated_at'];

    public function __construct(Request $request)
    {

        $this->middleware('permission:category-list|category-edit|category-create|category-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:category-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:category-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:category-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        //
        $request = collect(RequestFacade::all());
        $search = apartSearchParameters($request, $this->searchParams);

        $categories = Category::query();
        if ($search->isNotEmpty()) {

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

        return Inertia::render('Post/Category/Index', ['categories' => $categories]);
    }

    public function store(Request $request)
    {
        //

        $category = Category::create($this->validateCreation($request));
        activity()->performedOn($category)
            ->causedBy(Auth::user())
            ->log("موضوع  با نام $category->title ساخته شده است .");
        return redirect()->route(getLocaleName().'.categories.index')
            ->with('message', 'موضوع مورد نظر با موفقیت افزوده شد.');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //

        return Inertia::render('Post/Category/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    protected function validateCreation(Request $request)
    {
        return $request->validate([
            'title' => ['required', 'string']
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param Category $category
     * @return Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Category $category
     * @return Response
     */
    public function edit(Category $category)
    {
        //
        return Inertia::render('Post/Category/Edit', [
            'category' => $category
        ]);
    }

    public function update(Request $request, Category $category)
    {
        //
        $category->update($this->validateUpdate($request));
        activity()->performedOn($category)
            ->causedBy(Auth::user())
            ->log("موضوع  با نام $category->title ویرایش شده است .");
        return redirect()->route(getLocaleName().'.categories.index')
            ->with('message', 'موضوع مورد نظر با موفقیت ویرایش گردید.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Category $category
     * @return Response
     */
    protected function validateUpdate(Request $request)
    {
        return $request->validate([
            'title' => ['required', 'string']
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @return Response
     */
    public function destroy(Category $category)
    {
        //
        activity()->performedOn($category)
            ->causedBy(Auth::user())
            ->log("موضوع  با نام $category->title حذف شده است .");
        $category->delete();
        return redirect()->route(getLocaleName().'.categories.index')
            ->with('message', 'موضوع مورد نظر حذف گردید.');
    }
}
