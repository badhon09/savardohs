@extends('layouts.contentLayoutMaster')
@section('content')
    @if($action == 'new')
        @livewire("user.usertype.user-type-create")
    @elseif($action == 'edit')
        @livewire("user.usertype.user-type-edit",['editID' => $editID])
    @elseif($action == 'delete')
      @livewire("user.usertype.user-type-delete",['deleteID' => $deleteID])
    @else
        @livewire("user.usertype.user-type-list")
    @endif
@endsection
