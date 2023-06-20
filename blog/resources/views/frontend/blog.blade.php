@extends('frontend.layouts.app')

@section('styles')

    <style>
        .active {
            display: block;
        }
        .inactive {
            display: none;
        }
    </style>
@endsection

@section('scripts')
    <script>
        //
        $('.reply-btn').click(function(e) {
            // Removing any previous replyform
            $('.reply-form').each(function(i, obj){
                obj.classList.remove('active');
                obj.classList.add('inactive');
            })

            // Displaying current replyform
            let id = e.target.dataset.id;
            let replyForm = $(`#${id}`)[0]
            replyForm.classList.remove('inactive');
            replyForm.classList.add('active');

        })


    </script>

@endsection

@section('main-content')
<section id="blog" class="pt75 pb50">
    <div class="container">

        <div class="row">
            <div class="col-md-9">

                <div class="blog-three-mini">
                    <h2 class="color-dark"><a href="#">{{ $blog->title }}</a></h2>
                    <div class="blog-three-attrib">
                        <div><i class="fa fa-calendar"></i>{{ $blog->published_at->diffForHumans() }}</div> |
                        <div><i class="fa fa-pencil"></i><a href="#">{{ $blog->author->name }}</a></div> |
                        <div><i class="fa fa-comment-o"></i><a href="#">{{ $comments->count() }} Comments</a></div> |
                        {{-- <div><a href="#"><i class="fa fa-thumbs-o-up"></i></a>150 Likes</div> | --}}
                        <div>
                            Share:  <a href="#"><i class="fa fa-facebook-official"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-linkedin"></i></a>
                            <a href="#"><i class="fa fa-google-plus"></i></a>
                            <a href="#"><i class="fa fa-pinterest"></i></a>
                        </div>
                    </div>

                    <img src="{{ asset($blog->image_path) }}" alt="Blog Image" class="img-responsive">

                    <div class="blog-body my-3">
                        {{-- MAIN BODY --}}
                        {!! $blog->body !!}
                    </div>

                    <div class="blog-post-read-tag mt50">
                        <i class="fa fa-tags"></i> Tags:
                        @foreach ($blogTags as $tag)
                            <a href="{{ route('frontend.tag', $tag->id) }}">{{ $tag->name }}</a>,
                        @endforeach
                    </div>

                </div>


                <div class="blog-post-author mb50 pt30 bt-solid-1">
                    <img src="{{ asset($blog->author->image_path) }}" class="img-circle" width="110px" alt="image">
                    <span class="blog-post-author-name">{{ $blog->author->name }}</span> <a href="https://twitter.com/booisme"><i class="fa fa-twitter"></i></a>
                    <p>
                        {{ $blog->author->about }}
                    </p>
                </div>


                <div class="blog-post-comment-container">
                    <h5><i class="fa fa-comments-o mb25"></i> {{ $comments->count() }} Comments</h5>

                    <div class="blog-post-comment">
                        <img src="assets/img/other/photo-4.jpg" class="img-circle" alt="image">
                        <span class="blog-post-comment-name">John Boo</span> Jan. 20 2016, 10:00 PM
                        <a href="#" class="pull-right text-gray"><i class="fa fa-comment"></i> Reply</a>
                        <p>
                            Adipisci velit sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam.
                        </p>

                        <div class="blog-post-comment-reply">
                            <img src="assets/img/other/photo-2.jpg" class="img-circle" alt="image">
                            <span class="blog-post-comment-name">John Boo</span> Jan. 20 2016, 10:00 PM
                            <a href="#" class="pull-right text-gray"><i class="fa fa-comment"></i> Reply</a>
                            <p>
                                Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur.
                            </p>
                        </div>

                    </div>

                    @foreach ($comments as $comment)
                        @if(is_null($comment->reply_id))
                            <div class="blog-post-comment">
                                <img src="{{ asset($comment->author->image_path) }}" class="img-circle" width="54px" alt="image">
                                <span class="blog-post-comment-name">{{ $comment->author->name }}</span> {{ $comment->created_at->diffForHumans() }}
                                <p>
                                    {{ $comment->body }}
                                </p>
                                <div class="reply d-flex" id="comment" style="display: flex; justify-content: flex-end">
                                    <div>
                                        <button class="btn btn-primary reply-btn mb15" type="button" aria-haspopup="true" aria-expanded="true" data-id="{{ $comment->id }}">
                                            <i class="fa fa-comment"></i> Reply
                                            {{-- <span class="caret"></span> --}}
                                        </button>
                                    </div>
                                </div>

                                <!-- Reply Form -->
                                <div class="blog-post-comment-reply reply-form mb15 inactive" id="{{ $comment->id }}">
                                    <img src="{{ asset(auth()->user()->image_path) }}" class="img-circle" width="36px" alt="image">
                                    <span class="blog-post-comment-name">{{ auth()->user()->name }}</span>
                                    <h5>Reply to: {{'@'. $comment->author->name }}</h5>
                                    <form action="{{ route('admin.blogs.comments.reply', [$blog->id, $comment->id]) }}" method="POST">
                                        <p>
                                            @csrf
                                            <textarea name="body" id="" cols="80" rows="5" class="p5" style="border-radius: 8px"></textarea>
                                            <div class="reply d-flex" style="display: flex; justify-content: flex-end">
                                                <button class="button btn btn-primary" type="submit">Send</button>
                                            </div>
                                        </p>
                                    </form>
                                </div>

                                <!-- Replies Form -->
                                @foreach ($comment->reply as $reply)
                                    <div class="blog-post-comment-reply">
                                        <img src="{{ asset($reply->author->image_path) }}" class="img-circle" width="36px" alt="image">
                                        <span class="blog-post-comment-name">{{ $reply->author->name }}</span> {{ $reply->created_at->diffForHumans() }}
                                        <h5>Replied to: {{'@'. $reply->comment->author->name }}</h5>
                                        <p>
                                            {{ $reply->body }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @endforeach

                    <button class="button button-default button-sm center-block button-block mt25 mb25">Load More Comments</button>


                </div>

                <div class="blog-post-leave-comment">
                    <h5><i class="fa fa-comment mt25 mb25"></i> Leave Comment</h5>

                    <form action="{{ route('admin.blogs.comments.store', $blog->id) }}" method="POST">
                        @csrf
                        <textarea name="body" class="blog-leave-comment-textarea"></textarea>
                        <button class="button button-pasific button-sm center-block mb25" type="submit">Leave Comment</button>
                    </form>

                </div>

            </div>
            <!-- Blog Sidebar
                        ===================================== -->
            @include('frontend.layouts._sidebar')

        </div>

        <div class="row mt35 animated" data-animation="fadeInUp" data-animation-delay="800">
            <div class="col-md-6">
                <a href="#" class="button button-dark button-sm pull-right">Prev</a>
            </div>
            <div class="col-md-6">
                <a href="#" class="button button-dark button-sm pull-left">Next</a>
            </div>
        </div>

    </div>
</section>
@endsection
