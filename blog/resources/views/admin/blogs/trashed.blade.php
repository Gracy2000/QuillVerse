@extends('admin.layouts.app')

@section('main-content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Trashed Blogs</h1>
    </div>
    <!-- End Of Page Heading -->

    <!-- Blog Table  -->
    <div class="row">
        <div class="col-sm-12">
            @include('admin.layouts._alert-messages')
            <table class="table table-bordered">
                <thead>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Excerpt</th>
                    <th>Category</th>
                    <th>Trashed At</th>
                    <th>Actions</th>
                </thead>
                <tbody>
                    @foreach ($blogs as $blog)
                        <tr>
                            <td>{{ $blog->id }}</td>
                            <td><img src="{{ asset($blog->image_path) }}" alt="" width="80px"></td>
                            <td>{{ $blog->title }}</td>
                            <td>{{ $blog->excerpt }}</td>
                            <td>{{ $blog->category->name }}</td>
                            <td>{{ $blog->deleted_at }}</td>
                            <td>
                                <button class="btn btn-warning" href="#" data-toggle="modal" data-target="#restoreModal" onClick="restoreModalHelper(' {{ route('admin.blogs.restore', $blog->id) }} ')"><i class="fa fa-recycle"></i></button>
                                <button class="btn btn-danger" href="#" data-toggle="modal" data-target="#deleteModal" onClick="deleteModalHelper(' {{ route('admin.blogs.destroy', $blog->id) }} ')"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- End of blog Table  -->

            @if ($blogs->count() == 0)
                <p>no BLogs Found</p>
            @endif

            <!-- Pagination  -->
            {{ $blogs->links('pagination::bootstrap-5') }}
            <!-- End of Pagination  -->

        </div>
    </div>
</div>

<!-- Restore Modal -->
<div class="modal fade" id="restoreModal" tabindex="-1" role="dialog" aria-labelledby="restoreModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="" method="POST" id="restoreForm">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="restoreModalLabel">Restore Category?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Are you sure you want to Restore Category?</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-warning" type="submit">Restore</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- End of Restore Modal -->

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
<!-- End of Delete Modal -->

@endsection


@section('scripts')
<script>
    function deleteModalHelper(url) {
        document.getElementById('deleteForm').setAttribute('action', url);
    }
    function restoreModalHelper(url) {
        document.getElementById('restoreForm').setAttribute('action', url);
    }
</script>
@endsection


