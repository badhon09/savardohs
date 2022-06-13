@extends('layouts.contentLayoutMaster')
@section('content')
    @if($action == 'new')
        @livewire("billmonth.bill-month-create")
    @elseif($action == 'edit')
        @livewire("billmonth.bill-month-edit",['editID' => $editID])
    @elseif($action == 'delete')
      @livewire("billmonth.bill-month-delete",['deleteID' => $deleteID])
    @else
        @livewire("billmonth.bill-month-list")
    @endif
@endsection
