@extends('layouts.app')

@section('title', $user->name)

@section('content')
    @include('user.profiles.header')

    @if($user->follows->isNotEmpty())
        <div class="row justify-content-center">
            <div class="col-4">
            <h4 class="h4 text-center text-muted">Following</h4>
            
            @foreach($user->follows as $follow)
                <div class="row align-items-center mb-3">
                    <div class="col-auto">
                        <a href="{{ route('profile.show', $follow->followed->id)}}">
                            @if($follow->followed->avatar)
                                <img src="{{ $follow->followed->avatar }}" alt="" class="rounded-circle avatar-sm">
                            @else 
                                <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                            @endif 
                        </a>
                    </div>
                    <div class="col ps-0 text-truncate">
                        <a href="{{ route('profile.show', $follow->followed->id)}}" class="text-decoration-none text-dark fw-bold">{{ $follow->followed->name }}</a>
                    </div>
                    <div class="col-auto">
                        @if($follow->followed->id != Auth::user()->id)
                            @if($follow->followed->isFollowing())
                                {{-- unfollow --}}
                                <form action="{{ route('follow.destroy', $follow->followed->id)}}" method="post">
                                    @csrf 
                                    @method('DELETE')
                                    <button type="submit" class="btn p-0 text-secondary">Following</button>
                                </form>
                            @else 
                                {{-- follow --}}
                                <form action="{{ route('follow.store', $follow->followed->id)}}" method="post">
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
        <h4 class="h4 text-center text-muted">Not following anyone yet.</h4>
    @endif 
@endsection 