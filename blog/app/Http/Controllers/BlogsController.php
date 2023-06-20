<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Tag;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;

class BlogsController extends Controller
{

    public function __construct() {
        $this->middleware(['validateAuthor'])->only(['edit', 'update', 'destroy', 'trash']);
        $this->middleware(['validateAdmin'])->only(['makeInvisible', 'makeVisible']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // $blogs = Blog::latest()->paginate(10); // Here By default, lazy loading is used which can lead to N+1 query problem i.e it fires n+1 query to retrieve data from database. 1 is for retrieving all primary data like blogs and n queries is for retrieving relationship table data in this case category
        /**
         * To solve this problem Eager Loading can be used
         * Eager loading resolves this problem by fetching all the required related models in a single query upfront. This way, you can retrieve the necessary data in a more efficient manner, reducing the overall number of queries executed and improving the response time of your application.
         * In this It retrieves data of relationship tables all together with data of primary queries
         * To eager load relationships in Laravel, you can use the with() method on your Eloquent queries. This method accepts the names of the relationships you want to load and fetches them along with the main model.
         */

        $authUser = auth()->user();
        if($authUser->isAdmin()) {
            $blogs = Blog::with('category')->whereNotNull('published_at')->latest()->paginate(10);
        } else {
            $blogs = Blog::with('category')->where('user_id', $authUser->id)->whereNotNull('published_at')->latest()->paginate(10);
        }
        return view('admin.blogs.index', compact('blogs'));
    }

    public function drafts()
    {
        $authUser = auth()->user();
        if($authUser->isAdmin()) {
            $blogs = Blog::with('category')->whereNull('published_at')->latest()->paginate(10);
        } else {
            $blogs = Blog::with('category')->where('user_id', $authUser->id)->whereNull('published_at')->latest()->paginate(10);
        }
        return view('admin.blogs.saved_as_drafts', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();

        return view('admin.blogs.create', compact(['categories', 'tags']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateBlogRequest $request)
    {
        // Image upload and return the name of the file which will be created
        $image_path = $request->file('image')->store('blogs');
        if($request->has('saveAsDraft'))
        {
            dd($request);
            $data = $request->only(['title', 'excerpt', 'body', 'category_id']); // We didnt mentioned tags because we have attach tags with blogs
        } else {
            $data = $request->only(['title', 'excerpt', 'body', 'category_id', 'published_at']); // We didnt mentioned tags because we have attach tags with blogs
        }

        $data = array_merge($data, [
            'image_path' => $image_path,
            'user_id' => auth()->user()->id
        ]);

        $blog = Blog::create($data);
        $blog->tags()->attach($request->tags);

        session()->flash('success', 'Blog created successfully');
        return redirect(route('admin.blogs.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        $categories = Category::all();
        $tags = Tag::all();

        return view('admin.blogs.edit', compact(['categories', 'tags', 'blog']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBlogRequest $request, Blog $blog)
    {
        $data = $request->only(['title', 'excerpt', 'body', 'category_id', 'published_at']); // We didnt mentioned tags because we have attach tags with blogs

        if($request->hasFile('image')) {
            //If updated image is uploaded and return the name of the file which will be created
            $image_path = $request->file('image')->store('blogs');
            $blog->deleteImage(); // Previous orphaned image(that image will not be referred again) should be deleted if updated image is uploaded
            $data = array_merge($data, [
                'image_path' => $image_path, // Here we will not give user id since the user created the blog will be able to update it
            ]);
        }

        $blog->update($data);
        $blog->tags()->sync($request->tags);

        session()->flash('success', 'Blog Updated successfully');
        return redirect(route('admin.blogs.index'));
    }

    /**
     * Remove the specified resource permanently from storage.
     */
    public function destroy(int $blogId)
    {
        $blog = Blog::onlyTrashed()->find($blogId);
        $blog->deleteImage();
        $blog->forceDelete();

        session()->flash('success', 'Blog Destroyed successfully');
        return redirect(route('admin.blogs.trashed'));
    }

    /**
     * Remove the specified resource temporarily from storage.
     */
    public function trash(Blog $blog)
    {
        $blog->delete();

        session()->flash('success', 'Blog Deleted successfully');
        return redirect(route('admin.blogs.index'));
    }

    /**
     * Display the temporarily removed resources from storage.
     */
    public function trashed()
    {
        $blogs = Blog::with('category')
                    ->where('user_id', auth()->id())
                    ->onlyTrashed()
                    ->latest()
                    ->paginate(10);

        return view('admin.blogs.trashed', compact('blogs'));
    }

    /**
     * Restore the temporarily removed resources from storage.
     */
    public function restore(int $blogId)
    {
        $blog = Blog::withTrashed()->find($blogId);
        $blog->restore();

        session()->flash('success', 'Blog Restored successfully');
        return redirect(route('admin.blogs.index'));
    }

    public function makeInvisible(Blog $blog) {
        $blog->visible = false;
        $blog->save();

        session()->flash('success', "$blog->title is now invisible to users");
        return redirect(route('admin.blogs.index'));
    }

    public function makeVisible(Blog $blog) {
        $blog->visible = true;
        $blog->save();

        session()->flash('success', "$blog->title is now visible to users");
        return redirect(route('admin.blogs.index'));
    }


}
