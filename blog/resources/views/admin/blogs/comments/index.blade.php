@extends('admin.layouts.app')

@section('main-content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Comments</h1>
    </div>
    <!-- End Of Page Heading -->

    <!-- Comment Table  -->
    <div class="row">
        <div class="col-sm-12">
            @include('admin.layouts._alert-messages')
            <table class="table table-bordered">
                <thead>
                    <th>ID</th>
                    <th>Body</th>
                    <th>Blog Id</th>
                    <th>User Id</th>
                    <th>Reply Id</th>
                    @if (auth()->user()->isAdmin())
                        <th>Action</th>
                    @endif
                </thead>
                <tbody>
                    @foreach ($comments as $comment)
                        <tr>
                            <td>{{ $comment->id }}</td>
                            <td>{{ $comment->body }}</td>
                            <td>{{ $comment->blog_id }}</td>
                            <td>{{ $comment->user_id }}</td>
                            <td>{{ $comment->reply_id }}</td>
                            @if (auth()->user()->isAdmin())
                                @if ($comment->visibility)
                                    <td>
                                        <button class="btn btn-danger" href="#" data-toggle="modal" data-target="#disApproveModal" onClick="disApproveModalHelper(' {{ route('admin.blogs.comments.disapprove', $comment->id) }} ')">Disapprove</i></button>
                                    </td>
                                @else
                                    <td>
                                        <button class="btn btn-primary" href="#" data-toggle="modal" data-target="#approveModal" onClick="approveModalHelper(' {{ route('admin.blogs.comments.approve', $comment->id) }} ')">Approve</i></button>
                                    </td>
                                @endif
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- End of Comment Table  -->

            @if ($comments->count() == 0)
                <p>no comments Found</p>
            @endif

            <!-- Pagination  -->
            {{ $comments->links('pagination::bootstrap-5') }}
            <!-- End of Pagination  -->

        </div>
    </div>
</div>

<!-- Approve Modal -->
<div class="modal fade" id="approveModal" tabindex="-1" role="dialog" aria-labelledby="approveModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="" method="POST" id="approveForm">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="approveModalLabel">Approve Comment?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Are you sure you want to approve this comment?</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" type="submit">Approve</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Disapprove Modal -->
<div class="modal fade" id="disApproveModal" tabindex="-1" role="dialog" aria-labelledby="disApproveModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="" method="POST" id="disApproveForm">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="disApproveModalLabel">Disapprove Comment?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Are you sure you want to disapprove this comment?</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-danger" type="submit">Disapprove</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection


@section('scripts')
<script>
    function disApproveModalHelper(url) {
        document.getElementById('disApproveForm').setAttribute('action', url);
    }
    function approveModalHelper(url) {
        document.getElementById('approveForm').setAttribute('action', url);
    }
</script>
@endsection


