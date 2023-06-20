@extends('admin.layouts.app')

@section('main-content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Add New Category</h1>
    </div>
    <!-- End Of Page Heading -->

    <!-- Add Category Form  -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.categories.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name" class="form-label"></label>
                            <input
                            type="text"
                            value="{{ old('name') }}"
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
                            <button type="submit" class="btn btn-primary" name="addCategory">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Add Category Form  -->
</div>

@endsection
