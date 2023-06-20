@extends('frontend.layouts.app')

@section('styles')
<style>
    .button.button-pasific.disabled {
        background: #333!important;
    }

    /* .blogs {
        display: flex;
        justify-content: start;
        flex-direction: row;
        flex-wrap: wrap;
        box-sizing: content-box
    } */
</style>

@endsection

@section('main-content')
<div id="blog" class="pt20 pb50">
    <div class="container">

        <div class="row">
            <div class="col-md-9 mt25">
                <div class="row">
                    @foreach ($blogs as $blog)
                        <div class="col-md-4 col-sm-6 col-xs-12 mb50">
                            <h4 class="blog-title"><a href="{{ route('frontend.blogs.show', $blog->id) }}">{{ $blog->title }}</a></h4>
                            <div class="blog-three-attrib">
                                <span class="icon-calendar"></span>{{ $blog->published_at->diffForHumans() }} |
                                <span class=" icon-pencil"></span><a href="#">{{ $blog->author->name }}</a>
                            </div>
                            <img src="{{ asset($blog->image_path) }}" class="img-responsive" alt="image blog">
                            <p class="mt25">
                                {{ $blog->excerpt }}
                            </p>
                            <a href="{{ route('frontend.blogs.show', $blog->id) }}" class="button button-gray button-xs">Read More <i class="fa fa-long-arrow-right"></i></a>

                        </div>
                    @endforeach
                </div>

                <!-- Blog Paging
                ===================================== -->
                {{ $blogs->appends(['search' => request()->search])->links('pagination::simple-bootstrap-5') }}



            </div>


            <!-- Blog Sidebar
            ===================================== -->
            @include('frontend.layouts._sidebar')

        </div>

    </div>
</div>

@endsection
