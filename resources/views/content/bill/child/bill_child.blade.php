@extends('layouts.contentLayoutMaster')
@section('content')
    @if($action == 'new')
        @livewire("bill.billchild.bill-child-create")
    @elseif($action == 'edit')
        @livewire("bill.billchild.bill-child-edit")
    @elseif($action == 'delete')
      @livewire("bill.billchild.bill-child-delete")
    @else
        @livewire("bill.billchild.bill-child-list")
    @endif
@endsection
