@if(!$user->trashed())
<div class="modal fade" id="deactivate-user{{ $user->id }}">
    <div class="modal-dialog">
        <div class="modal-content border-danger">
            <div class="modal-header border-danger">
                <h3 class="h4 text-danger"><i class="fa-solid fa-user-slash"></i> Deactivate User</h3>
            </div>
            <div class="modal-body">
                Are you sure you want to deactivate &nbsp;
                @if($user->avatar)
                    <img src="{{ $user->avatar }}" alt="" class="rounded-circle avatar-sm d-inline">
                @else 
                    <i class="fa-solid fa-circle-user text-secondary icon-sm align-middle"></i>
                @endif 
                <span class="fw-bold">{{ $user->name }}</span>?
            </div>
            <div class="modal-footer border-0">
                <form action="{{ route('admin.users.deactivate', $user->id)}}" method="post">
                    @csrf 
                    @method('DELETE')
                    <button type="button" data-bs-dismiss="modal" class="btn btn-sm btn-outline-danger">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-danger">Deactivate</button>
                </form>
            </div>
        </div>
    </div>
</div>

@else 
{{-- activate --}}
<div class="modal fade" id="activate-user{{ $user->id }}">
    <div class="modal-dialog">
        <div class="modal-content border-success">
            <div class="modal-header border-success">
                <h3 class="h4 text-success"><i class="fa-solid fa-user-check"></i> Activate User</h3>
            </div>
            <div class="modal-body">
                Are you sure you want to activate &nbsp;
                @if($user->avatar)
                    <img src="{{ $user->avatar }}" alt="" class="rounded-circle avatar-sm d-inline">
                @else 
                    <i class="fa-solid fa-circle-user text-secondary icon-sm align-middle"></i>
                @endif 
                <span class="fw-bold">{{ $user->name }}</span>?
            </div>
            <div class="modal-footer border-0">
                <form action="{{ route('admin.users.activate', $user->id)}}" method="post">
                    @csrf 
                    @method('PATCH')
                    <button type="button" data-bs-dismiss="modal" class="btn btn-sm btn-outline-success">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-success">Activate</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endif 