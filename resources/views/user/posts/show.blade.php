@extends('layouts.app')

@section('title', 'Show Post')

@section('content')

<style>
    .col-4 {
        overflow-y:scroll;
    }
    .card-body {
        position:absolute;
        top:65px;
    }
</style>

    <div class="row shadow border">
        <div class="col border-end p-0">
            <img src="{{ $post->image }}" alt="" class="w-100">
        </div>
        <div class="col-4 bg-white px-0">
            <div class="card border-0">
                @include('user.posts.contents.title')
                <div class="card-body w-100">
                    @include('user.posts.contents.body')

                    {{-- comments --}}
                    <div class="mt-3">
                        @include('user.posts.contents.comments.create')

                        @foreach($post->comments as $comment)
                            @include('user.posts.contents.comments.list-item')
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection