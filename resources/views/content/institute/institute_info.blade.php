@extends('layouts.contentLayoutMaster')
@section('content')
    @if($action == 'new')
        @livewire("institute.institute-create")
    @elseif($action == 'edit')
        @livewire("institute.institute-edit",['editID' => $editID])
    @elseif($action == 'delete')
      @livewire("institute.institute-delete",['deleteID' => $deleteID])
    @else
        @livewire("institute.institute-list")
    @endif
@endsection
