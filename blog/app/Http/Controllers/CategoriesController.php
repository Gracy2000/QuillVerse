<?php

namespace App\Http\Controllers;

use App\Http\Requests\Categories\CreateCategoryRequest;
use App\Http\Requests\Categories\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
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
        // $categories = Category::paginate(2);
        // $categories = Category::orderBy('id', 'desc')->paginate(2);
        $categories = Category::latest()->paginate(2);

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCategoryRequest $request)
    {
        // dd($request);
        //$data = request()->all();
        // request()->validate([
        //     'name' => 'required | min:3 | max:255'
        // ]);
        // Instead of this, Using Category request to validate the data

        Category::create([
            'name' => $request->name
        ]);

        return redirect(route('admin.categories.index'));
    }



    /**
     * Route model binding in Laravel is a feature that simplifies the process of retrieving model instances based on route parameters. It provides a convenient way to automatically inject model instances into your route closures or controller methods, eliminating the need for manual retrieval and reducing boilerplate code.
     * By defining explicit route parameters that match the primary key of your models, Laravel's route model binding mechanism automatically resolves the appropriate model instance and passes it as an argument.
     */
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category) // Here Route Model Binding concept is being applied to implement Dependency Injection
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category) // Here also Route Model Binding concept is being applied
    {
        $category->name = $request->name;
        $category->save();

        session()->flash('success', 'Category updated successfully');
        return redirect(route('admin.categories.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        // TODO: Validate whether the category has posts associated with it. if not then only proceed
        $category->delete();

        session()->flash('success', 'Category deleted successfully');
        return redirect(route('admin.categories.index'));
    }
}
