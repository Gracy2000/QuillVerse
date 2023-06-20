<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Comment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['validateAdmin'])->only(['aprrove', 'disapprove']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comments = Comment::latest()->paginate(10);

        return view('admin.blogs.comments.index', compact('comments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Blog $blog)
    {
        Comment::create([
            'body' => $request->body,
            'blog_id' => $blog->id,
            'user_id' => auth()->id(),
        ]);

        // session()->flash('success', 'Blog created successfully');
        return redirect(route('frontend.blogs.show', $blog->id));
    }

    public function reply(Request $request, Blog $blog, Comment $comment)
    {
        Comment::create([
            'body' => $request->body,
            'blog_id' => $blog->id,
            'user_id' => auth()->id(),
            'reply_id' => $comment->id
        ]);

        // session()->flash('success', 'Blog created successfully');
        return redirect(route('frontend.blogs.show', $blog->id));
    }

    public function approve(Request $request, Comment $comment)
    {
        if($comment->reply_id) {
            $commentObject = Comment::findOrFail($comment->reply_id);
            if(!$commentObject->visibility) {
                session()->flash('error', 'Comment cannot be approved');
                return redirect(route('admin.blogs.comments.index'));;
            }
        }
        $comment->visibility = Carbon::now();
        $comment->save();

        session()->flash('success', 'Comment has been approved');
        return redirect(route('admin.blogs.comments.index'));;
    }

    public function disapprove(Request $request, Comment $comment)
    {

        $comment->visibility = null;
        $comment->save();

        $repliedComments = Comment::where('reply_id', $comment->id)->get()->map(function (Comment $reply) {
            $reply->visibility = null;
            $reply->save();
        });

        session()->flash('success', 'Comment has been approved');
        return redirect(route('admin.blogs.comments.index'));;
    }

}
