<?php

namespace App\Http\Controllers;

use App\Http\Requests\Tags\CreateTagRequest;
use App\Http\Requests\Tags\UpdateTagRequest;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['validateAdmin'])->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = Tag::paginate(2);
        return view('admin.tags.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.tags.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateTagRequest $request)
    {
        request()->validate([
            'name' => 'required | min:3 | max:255'
        ]);

        Tag::create([
            'name' => $request->name
        ]);

        session()->flash('success', 'Tag created successfully');

        return redirect(route('admin.tags.index'));
    }

    /**
     * Route model binding in Laravel is a feature that simplifies the process of retrieving model instances based on route parameters. It provides a convenient way to automatically inject model instances into your route closures or controller methods, eliminating the need for manual retrieval and reducing boilerplate code.
     * By defining explicit route parameters that match the primary key of your models, Laravel's route model binding mechanism automatically resolves the appropriate model instance and passes it as an argument.
     */

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tag $tag) // Here Route Model Binding concept is being applied to implement Dependency Injection
    {
        return view('admin.tags.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTagRequest $request, Tag $tag) // Here also Route Model Binding concept is being applied
    {
        $tag->name = $request->name;
        $tag->save();

        session()->flash('success', 'Tag updated successfully');
        return redirect(route('admin.tags.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        // TODO: Validate whether the tag has posts associated with it. if not then only proceed
        $tag->delete();

        session()->flash('success', 'Tag deleted successfully');
        return redirect(route('admin.tags.index'));
    }
}
