<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Enum\CommentStatus;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as RequestFacade;
use Inertia\Inertia;
class CommentManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected array $searchParams = ['fullname', 'email', 'phone', 'content', 'created_at'];

    public function index()
    {
        //
        $request = collect(RequestFacade::all());
        $search = apartSearchParameters($request, $this->searchParams);
        $comments = Comment::query();
        if ($search->isNotEmpty()) {

            $comments->when($search['fullname'], function ($query, $search) {// $search['title] become $search

                return $query->fullname($search);
            })
                ->when($search['email'], function ($query, $search) {

                    return $query->email($search);
                })
                ->when($search['phone'], function ($query, $search) {
                    return $query->phone($search);
                })
                ->when($search['content'], function ($query, $search) {
                    return $query->content($search);
                })
//                ->when($search['roles'], function ($query, $search) {
//
//                    return $query->role($search);
//                 })
                ->when($search['created_at'], function ($query, $search) {
                    return $query->startDate(convertDateForDB($search));
                });

        }

        $comments = $comments->with(['user','commentable']);
        $comments = $comments->orderBy('id', 'DESC')->paginate(10);
        return Inertia::render('Post/Comment/Comments',['comments' => $comments]);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Comment $comment)
    {
        //
        activity()->performedOn($comment)
            ->causedBy(\Auth::user())
            ->log(" نظر ارسالی  با نام $comment->fullname تایید شده است .");
        $comment->status=CommentStatus::PUBLIC;
        $comment->save();
        return redirect()->route('comments.index')
            ->with('message', 'نظر مورد نظر تایید گردید.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        //
        //
        activity()->performedOn($comment)
            ->causedBy(\Auth::user())
            ->log(" نظر ارسالی  با نام $comment->fullname حذف شده است .");
        $comment->delete();

        return redirect()->route('comments.index')
            ->with('message', 'نظر مورد نظر حذف گردید.');
    }
}
