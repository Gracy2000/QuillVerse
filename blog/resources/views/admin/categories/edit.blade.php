@extends('admin.layouts.app')

@section('main-content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Category</h1>
    </div>
    <!-- End Of Page Heading -->

    <!-- Add Category Form  -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name" class="form-label"></label>
                            <input
                            type="text"
                            value="{{ old('name', $category->name) }}"
                            class="form-control @error('name') border-danger @enderror"
                            placeholder="Enter Category Name"
                            id="name"
                            name="name">
                            @error('name')
                                <span class="text-danger">
                                    {{-- {{ $errors->has('name') ? 'ERROR' : 'NO ERROR' }} --}}
                                    {{ $errors->first('name') }}
                                </span>
                            @enderror

                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" name="updateCategory">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Add Category Form  -->
</div>

@endsection


@section('scripts')
    <script src="{{asset('admin/js/custom.js')}}"></script>
@endsection
