@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <div class="row gx-5">
        <div class="col-8">
            @if($search)
                <h2 class="h5 text-muted mb-3">Search results for '<strong>{{ $search }}</strong>'</h2>
            @endif 
            {{-- POSTS --}}
            @forelse($all_posts as $post)
                <div class="card mb-4">
                    @include('user.posts.contents.title')
                    {{-- image --}}
                    <div class="container p-0">
                        <a href="{{ route('post.show', $post->id)}}">
                            <img src="{{ $post->image }}" alt="" class="w-100">
                        </a>
                    </div>
                    <div class="card-body">
                        @include('user.posts.contents.body')

                        {{-- comments --}}
                        <div class="mt-3">

                            @if($post->comments->isNotEmpty())
                                <hr class="mb-3">

                                <div class="mb-2">
                                    @foreach($post->comments->take(3) as $comment)
                                        @include('user.posts.contents.comments.list-item')
                                    @endforeach

                                    @if($post->comments->count() > 3)
                                        <a href="{{ route('post.show', $post->id)}}" class="text-decoration-none small mt-3">View all {{ $post->comments->count() }} comments</a>
                                    @endif
                                </div>
                            @endif


                            @include('user.posts.contents.comments.create')
                        </div>
                    </div>
                </div>
            @empty 
                <div class="text-center">
                    <h2>Share Photos</h2>
                    <p class="text-muted">When you share photos, they'll appear on your profile.</p>
                    <a href="{{ route('post.create')}}" class="text-decoration-none">Share your first photo</a>
                </div>
            @endforelse
        </div>
        <div class="col-4">
            {{-- USER INFO --}}
            <div class="row align-items-center bg-white py-3 rounded-3 shadow-sm mb-5">
                <div class="col-auto">
                    <a href="{{ route('profile.show', Auth::user()->id)}}">
                        @if(Auth::user()->avatar)
                            <img src="{{ Auth::user()->avatar }}" alt="" class="rounded-circle avatar-md">
                        @else 
                            <i class="fa-solid fa-circle-user icon-md text-secondary"></i>
                        @endif 
                    </a>
                </div>
                <div class="col ps-0">
                    <a href="{{ route('profile.show', Auth::user()->id )}}" class="text-decoration-none fw-bold text-dark">{{ Auth::user()->name }}</a>
                    <p class="mb-0 text-muted">{{ Auth::user()->email }}</p>
                </div>
            </div>

            {{-- SUGGESTED USERS --}}
            @if($suggested_users)
                <div class="row align-items-center mb-3">
                    <div class="col">
                        <span class="fw-bold text-secondary">Suggestions For You</span>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('suggested-users')}}" class="text-decoration-none text-dark fw-bold">See all</a>
                    </div>
                </div>

                @foreach($suggested_users as $user)
                    <div class="row align-items-center mb-3">
                        <div class="col-auto">
                            <a href="{{ route('profile.show', $user->id)}}">
                                @if($user->avatar)
                                    <img src="{{ $user->avatar }}" alt="" class="rounded-circle avatar-sm">
                                @else 
                                    <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                                @endif 
                            </a>
                        </div>
                        <div class="col ps-0 text-truncate">
                            <a href="{{ route('profile.show', $user->id)}}" class="text-decoration-none text-dark fw-bold">{{ $user->name }}</a>
                        </div>
                        <div class="col-auto">
                            <form action="{{ route('follow.store', $user->id )}}" method="post">
                                @csrf 
                                <button type="submit" class="bg-transparent border-0 shadow-none p-0 text-primary">Follow</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

@endsection