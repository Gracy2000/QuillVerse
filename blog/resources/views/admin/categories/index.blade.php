@extends('admin.layouts.app')

@section('main-content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Categories</h1>
        <a href="{{ route('admin.categories.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i>
            Create Category
        </a>
    </div>
    <!-- End Of Page Heading -->

    <!-- Category Table  -->
    <div class="row">
        <div class="col-sm-12">
            @include('admin.layouts._alert-messages')
            <table class="table table-bordered">
                <thead>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Post Count</th>
                    <th>Actions</th>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->name }}</td>
                            <td>{{ 0 }}</td>
                            <td>
                                <a class="btn btn-primary" href="{{ route('admin.categories.edit', $category->id) }}"><i class="fas fa-pen"></i></a>
                                <button class="btn btn-danger" href="#" data-toggle="modal" data-target="#deleteModal" onClick="deleteModalHelper(' {{ route('admin.categories.destroy', $category->id) }} ')"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- End of Category Table  -->

            <!-- Pagination  -->
            {{ $categories->links('pagination::bootstrap-5') }}
            <!-- End of Pagination  -->

        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="" method="POST" id="deleteForm">
            @csrf
            @method('DELETE')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete Category?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Are you sure you want to delete Category?</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-danger" type="submit">Delete</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection


@section('scripts')
<script>
    function deleteModalHelper(url) {
        document.getElementById('deleteForm').setAttribute('action', url);
    }
</script>
@endsection


