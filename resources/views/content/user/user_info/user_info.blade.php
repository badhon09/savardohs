@extends('layouts.contentLayoutMaster')
@section('content')
    @if($action == 'new')
        @livewire("user.userinfo.user-info-create")
    @elseif($action == 'edit')
        @livewire("user.userinfo.user-info-edit",['editID' => $editID])
    @elseif($action == 'delete')
      @livewire("user.userinfo.user-info-delete",['deleteID' => $deleteID])
    @else
        @livewire("user.userinfo.user-info-list")
    @endif
@endsection
