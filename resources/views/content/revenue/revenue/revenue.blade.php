@extends('layouts.contentLayoutMaster')
@section('content')
    @if($action == 'new')
        @livewire("revenue.revenue.revenue-create")
    @elseif($action == 'edit')
        @livewire("revenue.revenue.revenue-edit",['editID'=>$editID])
    @elseif($action == 'delete')
      @livewire("revenue.revenue.revenue-delete")
    @else
        @livewire("revenue.revenue.revenue-list")
    @endif
@endsection
