@extends('layouts.contentLayoutMaster')
@section('content')
    @if($action == 'new')
        @livewire("user.adminuser.admin-user-create")
    @elseif($action == 'edit')
        @livewire("user.adminuser.admin-user-edit",['editID' => $editID])
    @elseif($action == 'delete')
      @livewire("user.adminuser.admin-user-delete",['deleteID' => $deleteID])
    @else
        @livewire("user.adminuser.admin-user-list")
    @endif
@endsection
