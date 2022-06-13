@extends('layouts.contentLayoutMaster')
@section('content')
    @if($action == 'new')
        @livewire("bill.billmaster.bill-master-create")
    @elseif($action == 'edit')
        @livewire("bill.billmaster.bill-master-edit")
    @elseif($action == 'delete')
      @livewire("bill.billmaster.bill-master-delete")
    @else
        @livewire("bill.billmaster.bill-master-list")
    @endif
@endsection
