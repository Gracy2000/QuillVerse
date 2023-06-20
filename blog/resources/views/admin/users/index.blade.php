@extends('admin.layouts.app')

@section('main-content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Users</h1>
    </div>
    <!-- End Of Page Heading -->

    <!-- User Table  -->
    <div class="row">
        <div class="col-sm-12">
            @include('admin.layouts._alert-messages')
            <table class="table table-bordered">
                <thead>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>About</th>
                    <th>Actions</th>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td><img src="{{ asset($user->image_path) }}" alt="" width="80px"></td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->about }}</td>
                            <td>{{ $user->about }}</td>
                            <td>
                                {{-- <a class="btn btn-primary" href="{{ route('admin.users.edit', $user->id) }}"><i class="fas fa-pen"></i></a> --}}
                                {{-- <button class="btn btn-danger" href="#" data-toggle="modal" data-target="#deleteModal" onClick="deleteModalHelper(' {{ route('admin.users.trash', $user->id) }} ')"><i class="fa fa-trash"></i></button> --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- End of user Table  -->

            <!-- Pagination  -->
            {{ $users->links('pagination::bootstrap-5') }}
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


