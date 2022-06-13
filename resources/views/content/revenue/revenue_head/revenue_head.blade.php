@extends('layouts.contentLayoutMaster')
@section('content')
    @if($action == 'new')
        @livewire("revenue.revenuehead.revenue-head-create")
    @elseif($action == 'edit')
        @livewire("revenue.revenuehead.revenue-head-edit",['editID' => $editID])
    @elseif($action == 'delete')
      @livewire("revenue.revenuehead.revenue-head-delete",['deleteID' => $deleteID])
    @else
        @livewire("revenue.revenuehead.revenue-head-list")
    @endif
@endsection
