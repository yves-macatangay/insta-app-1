@extends('layouts.app')

@section('title', 'Suggested Users')

@section('content')

    @if($suggested_users)
        <div class="row justify-content-center">
            <div class="col-4">
                <h3 class="h4 mb-4">Suggested</h3>
                @foreach($suggested_users as $user)
                    <div class="row mb-3 align-items-center">
                        {{-- icon/avatar --}}
                        <div class="col-auto">
                            <a href="{{ route('profile.show', $user->id)}}">
                                @if($user->avatar)
                                    <img src="{{ $user->avatar }}" alt="" class="rounded-circle avatar-md">
                                @else 
                                    <i class="fa-solid fa-circle-user text-secondary icon-md"></i>
                                @endif 
                            </a>
                        </div>
                        {{-- user info --}}
                        <div class="col ps-0 text-truncate">
                            <a href="{{ route('profile.show', $user->id)}}" class="text-decoration-none text-dark fw-bold">{{ $user->name }}</a>
                            <p class="mb-0 text-secondary small">{{ $user->email }}</p>
                            <span class="small text-secondary">
                                @if($user->followsYou())
                                    Follows you
                                @else
                                    @if($user->followers->count() == 0)
                                        No followers yet
                                    @elseif($user->followers->count() ==1)
                                        1 follower
                                    @else 
                                        {{ $user->followers->count() }} followers
                                    @endif
                                @endif 
                            </span>
                        </div>
                        {{-- follow --}}
                        <div class="col-auto">
                            <form action="{{ route('follow.store', $user->id)}}" method="post">
                                @csrf 
                                <button type="submit" class="btn text-primary p-0">Follow</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else 
        <h3 class="h5 text-center text-muted">No suggested users found.</h3>
    @endif

@endsection