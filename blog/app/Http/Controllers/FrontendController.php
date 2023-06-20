<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index()
    {
        $categories = Category::withCount([
            'blogs as blogs_count' => function (Builder $query) {
                $query->published();
            }
        ])->limit('10')->get();
        $tags = Tag::limit(10)->get();
        $blogs = Blog::with('author')->search()->published()->visible()->orderBy('published_at', 'desc')->simplePaginate(3);

        return view('frontend.index', compact(['categories', 'tags', 'blogs']));
    }

    public function category(Category $category)
    {
        $blogs = $category->blogs()->search()->published()->visible()->simplePaginate(3);
        $categories = Category::withCount('blogs')->limit('10')->get();

        $blogs = $category->blogs()->search()->published()->simplePaginate(3);
        $categories = Category::withCount([
            'blogs as blogs_count' => function (Builder $query) {
                $query->published();
            }
        ])->limit('10')->get();

        $tags = Tag::limit(10)->get();
        return view('frontend.index', compact(['categories', 'tags', 'blogs']));
    }

    public function tag(Tag $tag)
    {

        $blogs = $tag->blogs()->search()->published()->visible()->simplePaginate(3);
        $categories = Category::withCount('blogs')->limit('10')->get();

        $blogs = $tag->blogs()->search()->published()->simplePaginate(3);
        $categories = Category::withCount([
            'blogs as blogs_count' => function (Builder $query) {
                $query->published();
            }
        ])->limit('10')->get();

        $tags = Tag::limit(10)->get();

        return view('frontend.index', compact(['categories', 'tags', 'blogs']));
    }

    public function show(Blog $blog)
    {
        $blogTags = $blog->tags;
        $categories = Category::withCount([
            'blogs as blogs_count' => function (Builder $query) {
                $query->published();
            }
        ])->limit('10')->get();
        $tags = Tag::limit(10)->get();
        $comments = $blog->comments()->visible()->whereNull('reply_id')->with(['author', 'reply.comment.author', 'reply.author'])->limit('5')->get();
        return view('frontend.blog', compact(['categories', 'tags', 'blog', 'blogTags', 'comments']));
    }
}
