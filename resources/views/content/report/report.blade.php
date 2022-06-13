@extends('layouts.contentLayoutMaster')
@section('content')
    @if($action == 'user')
        @livewire("report.user-payment-report")
    @elseif($action == 'settlement')
        @livewire("report.online-settlement-report")
    @elseif($action == 'meterBill')
      @livewire("report.meter-bill-view")
    @elseif($action == 'variousRateInfo')
        @livewire("report.various-rate-info")
    @elseif($action == 'realization')
      @livewire("report.payment-realization-report")
    @endif
@endsection
