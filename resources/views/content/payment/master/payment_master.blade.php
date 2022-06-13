@extends('layouts.contentLayoutMaster')
@section('content')
    @if($action == 'new')
        @livewire("payment.paymentmaster.payment-master-create")
    @elseif($action == 'edit')
        @livewire("payment.paymentmaster.payment-master-edit")
    @elseif($action == 'delete')
      @livewire("payment.paymentmaster.payment-master-delete")
    @else
        @livewire("payment.paymentmaster.payment-master-list")
    @endif
@endsection
