@extends('layouts.contentLayoutMaster')
@section('content')
    @if($action == 'new')
        @livewire("billing.billing-create")
    @elseif($action == 'edit')
        @livewire("billing.billing-edit",['editID' => $editID])    
    @else
        @livewire("billing.billing-list")
    @endif
@endsection
