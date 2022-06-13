@extends('layouts.contentLayoutMaster')
@section('content')
    @if($action == 'new')
        @livewire("settlement.settlement-create")
    @elseif($action == 'edit')
        @livewire("settlement.settlement-edit",['editID' => $editID])
    @else
        @livewire("settlement.settlement-list")
    @endif
@endsection
