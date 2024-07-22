@extends('layouts.app')

@section('title', $user->name)

@section('content')
    @include('user.profiles.header')

    @if($user->followers->isNotEmpty())
        <div class="row justify-content-center">
            <div class="col-4">
            <h4 class="h4 text-center text-muted">Followers</h4>
            
            @foreach($user->followers as $follow)
                <div class="row align-items-center mb-3">
                    <div class="col-auto">
                        <a href="{{ route('profile.show', $follow->follower->id)}}">
                            @if($follow->follower->avatar)
                                <img src="{{ $follow->follower->avatar }}" alt="" class="rounded-circle avatar-sm">
                            @else 
                                <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                            @endif 
                        </a>
                    </div>
                    <div class="col ps-0 text-truncate">
                        <a href="{{ route('profile.show', $follow->follower->id)}}" class="text-decoration-none text-dark fw-bold">{{ $follow->follower->name }}</a>
                    </div>
                    <div class="col-auto">
                        @if($follow->follower->id != Auth::user()->id)
                            @if($follow->follower->isFollowing())
                                {{-- unfollow --}}
                                <form action="{{ route('follow.destroy', $follow->follower->id)}}" method="post">
                                    @csrf 
                                    @method('DELETE')
                                    <button type="submit" class="btn p-0 text-secondary">Following</button>
                                </form>
                            @else 
                                {{-- follow --}}
                                <form action="{{ route('follow.store', $follow->follower->id)}}" method="post">
                                    @csrf 
                                    <button type="submit" class="btn p-0 text-primary">Follow</button>
                                </form>
                            @endif 
                        @endif 
                    </div>
                </div>
            @endforeach 
            </div>
        </div>
    @else 
        <h4 class="h4 text-center text-muted">No followers yet.</h4>
    @endif 
@endsection 