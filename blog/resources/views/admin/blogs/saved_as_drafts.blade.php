@extends('admin.layouts.app')

@section('main-content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Blogs</h1>
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
                    <th>Visibility</th>
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
                            <td>
                                @if ($blog->visible)
                                    {{ "Visible" }}
                                @else
                                    {{ "Invisible" }}
                                @endif
                            </td>
                            <td>
                                <a class="btn btn-primary" href="{{ route('admin.blogs.edit', $blog->id) }}"><i class="fas fa-pen"></i></a>
                                <button class="btn btn-danger" href="#" data-toggle="modal" data-target="#deleteModal" onClick="deleteModalHelper(' {{ route('admin.blogs.trash', $blog->id) }} ')"><i class="fa fa-trash"></i></button>
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

<!-- Make Invisible Modal -->
<div class="modal fade" id="makeInvisibleModal" tabindex="-1" role="dialog" aria-labelledby="makeInvisibleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="" method="POST" id="makeInvisibleForm">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="makeInvisibleModalLabel">Make Invisible Blog?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Are you sure you want to make invisible this blog to the users?</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-danger" type="submit">Make Invisible</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Make Visible Modal -->
<div class="modal fade" id="makeVisibleModal" tabindex="-1" role="dialog" aria-labelledby="makeVisibleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="" method="POST" id="makeVisibleForm">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="makeVisibleModalLabel">Make Visible Blog?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Are you sure you want to make visible this blog to the users?</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-danger" type="submit">Make Visible</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection


@section('scripts')
<script>
    function makeInvisibleModalHelper(url) {
        document.getElementById('makeInvisibleForm').setAttribute('action', url);
    }
    function makeVisibleModalHelper(url) {
        document.getElementById('makeVisibleForm').setAttribute('action', url);
    }
</script>
@endsection


