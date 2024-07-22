@extends('layouts.app')

@section('title', $user->name)

@section('content')
    @include('user.profiles.header')

    {{-- posts --}}
    <div class="row">
        @forelse($user->posts as $post)
            <div class="col-lg-4 col-md-6 mb-4">
                <a href="{{ route('post.show', $post->id)}}">
                    <img src="{{ $post->image }}" alt="" class="grid-img">
                </a>
            </div>
        @empty
            <p class="h4 text-center text-muted">No posts yet.</p>
        @endforelse
    </div>
@endsection