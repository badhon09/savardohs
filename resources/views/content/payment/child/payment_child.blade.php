@extends('layouts.contentLayoutMaster')
@section('content')
    @if($action == 'new')
        @livewire("payment.paymentchild.payment-child-create")
    @elseif($action == 'edit')
        @livewire("payment.paymentchild.payment-child-edit")
    @elseif($action == 'delete')
      @livewire("payment.paymentchild.payment-child-delete")
    @else
        @livewire("payment.paymentchild.payment-child-list")
    @endif
@endsection
