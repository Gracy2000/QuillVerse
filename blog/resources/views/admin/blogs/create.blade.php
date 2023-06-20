@extends('admin.layouts.app')

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.0/dist/trix.css">

@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.0/dist/trix.umd.min.js"></script>

    <script>
        $('.select2').select2({
            placeholder: "Select a Value",
            allowClear: true
        })

        let publishedAtDate = flatpickr('#published_at', {
            enableTime: true,
            altInput: true,
            altFormat: "F j, Y H:i",
            dateFormat: "Y-m-d H:i",
            minDate: "today",
            minTime: new Date(),
        })

        $('#published_at').change(function() {
            $("#saveAsDraft").attr("checked", false);
        })

        $('#saveAsDraft').change(function() {
            console.log("clicked");
            publishedAtDate.clear();
        })
    </script>
@endsection

@section('main-content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Add New Blog</h1>
    </div>
    <!-- End Of Page Heading -->

    <!-- Add Blog Form  -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Title -->
                        <div class="form-group">
                            <label for="title" class="form-label">Title</label>
                            <input
                            type="text"
                            value="{{ old('title') }}"
                            class="form-control @error('title') border-danger @enderror"
                            placeholder="Enter Title"
                            id="title"
                            name="title">
                            @error('title')
                                <span class="text-danger">
                                    {{-- {{ $errors->has('title') ? 'ERROR' : 'NO ERROR' }} --}}
                                    {{ $message }}
                                </span>
                            @enderror

                        </div>
                        <!-- End of Title -->

                        <!-- Excerpt -->
                        <div class="form-group">
                            <label for="excerpt" class="form-label">Excerpt</label>
                            <input
                            type="text"
                            value="{{ old('excerpt') }}"
                            class="form-control @error('excerpt') border-danger @enderror"
                            placeholder="Enter excerpt"
                            id="excerpt"
                            name="excerpt">
                            @error('excerpt')
                                <span class="text-danger">
                                    {{-- {{ $errors->has('excerpt') ? 'ERROR' : 'NO ERROR' }} --}}
                                    {{ $message }}
                                </span>
                            @enderror

                        </div>
                        <!-- End of Excerpt -->

                        <!-- Body -->
                        <div class="form-group">
                            <label for="body" class="form-label">Body</label>
                            <input
                            type="hidden"
                            value="{{ old('body') }}"
                            class="form-control @error('body') border-danger @enderror"
                            placeholder="Enter Body"
                            id="body"
                            name="body">
                            <trix-editor input="body"></trix-editor>
                            @error('body')
                                <span class="text-danger">
                                    {{-- {{ $errors->has('body') ? 'ERROR' : 'NO ERROR' }} --}}
                                    {{ $message }}
                                </span>
                            @enderror

                        </div>
                        <!-- End of Body -->

                        <!-- Category Id -->
                        <div class="form-group">
                            <label for="category_id" class="form-label">Category</label>
                            <select
                                name="category_id"
                                id="category_id"
                                class="form-control select2"
                                >
                                <option></option>
                                @foreach ($categories as $category)
                                    @if ($category->id == old('category_id'))
                                        <option value="{{$category->id}}" selected>{{$category->name}}</option>
                                    @else
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('category_id')
                                <span class="text-danger">
                                    {{-- {{ $errors->has('category_id') ? 'ERROR' : 'NO ERROR' }} --}}
                                    {{ $message }}
                                </span>
                            @enderror

                        </div>
                        <!-- End of Category Id -->

                        <!-- Tags -->
                        <div class="form-group">
                            <label for="tags" class="form-label">Tags</label>
                            <select
                                name="tags[]"
                                id="tags"
                                class="form-control select2"
                                multiple
                                >
                                <option></option>
                                @foreach ($tags as $tag)
                                        <option value="{{$tag->id}}"
                                            {{ old('tags') && in_array($tag->id, old('tags')) ? 'selected' : ''; }}>
                                            {{$tag->name}}
                                        </option>
                                @endforeach
                            </select>
                            @error('tags')
                                <span class="text-danger">
                                    {{-- {{ $errors->has('tags') ? 'ERROR' : 'NO ERROR' }} --}}
                                    {{ $message }}
                                </span>
                            @enderror

                        </div>
                        <!-- End of Tags -->

                        <!-- Published At -->
                            <div class="form-group">
                                <label for="published_at" class="form-label">Published At</label>
                                <input
                                type="date"
                                value="{{ old('published_at') }}"
                                class="form-control mb-1 @error('published_at') border-danger @enderror"
                                placeholder="Enter Published Date"
                                id="published_at"
                                name="published_at">
                                @error('published_at')
                                    <span class="text-danger">
                                        {{-- {{ $errors->has('published_at') ? 'ERROR' : 'NO ERROR' }} --}}
                                        {{ $message }}
                                    </span>
                                @enderror
                                <!-- Saved Draft Checkbox -->
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="saveAsDraft" id="saveAsDraft" checked>
                                    <label class="form-check-label" for="saveAsDraft">
                                        Save as Draft
                                    </label>
                                </div>
                                <!-- End of Saved Draft Checkbox -->
                            </div>
                        <!-- End of published_at -->





                        <!-- Image File -->
                        <div class="form-group mb-2">
                            <label for="image_path" class="form-label">Image</label>
                            <input
                            type="file" {{--  by watching type as file we should form enctype to multipart/form-data  --}}
                            class="form-control @error('image_path') border-danger @enderror"
                            placeholder="Select a image file"
                            id="image_path"
                            name="image">
                            @error('image_path')
                                <span class="text-danger">
                                    {{-- {{ $errors->has('image_path') ? 'ERROR' : 'NO ERROR' }} --}}
                                    {{ $message }}
                                </span>
                            @enderror

                        </div>
                        <!-- End of Image File -->

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" name="addBlog">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Add Category Form  -->
</div>

@endsection
