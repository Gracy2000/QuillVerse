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
                    <th>Role</th>
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
                            <td>{{ $user->role }}</td>
                            <td>
                                @if ($user->role != 'admin')
                                <button class="btn btn-primary" href="#" data-toggle="modal" data-target="#makeAdminModal" onClick="makeAdminModalHelper(' {{ route('admin.users.make-admin', $user->id) }} ')">Make Admin</button>
                                @else
                                    <button class="btn btn-danger" href="#" data-toggle="modal" data-target="#revokeAdminModal" onClick="revokeAdminModalHelper(' {{ route('admin.users.revoke-admin', $user->id) }} ')">Revoke Admin</button>
                                @endif
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

<!-- Make Admin Modal -->
<div class="modal fade" id="makeAdminModal" tabindex="-1" role="dialog" aria-labelledby="makeAdminModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="" method="POST" id="makeAdminForm">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="makeAdminModalLabel">Make Admin?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Are you sure you want to make this user as admin?</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" type="submit">Make Admin</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Revoke Admin Modal -->
<div class="modal fade" id="revokeAdminModal" tabindex="-1" role="dialog" aria-labelledby="revokeAdminModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="" method="POST" id="revokeAdminForm">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="revokeAdminModalLabel">Revoke Admin?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Are you sure you want to revoke this user as admin?</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-danger" type="submit">Revoke Admin</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection


@section('scripts')
<script>
    function makeAdminModalHelper(url) {
        document.getElementById('makeAdminForm').setAttribute('action', url);
    }
    function revokeAdminModalHelper(url) {
        document.getElementById('revokeAdminForm').setAttribute('action', url);
    }
</script>
@endsection


