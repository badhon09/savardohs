@extends('layouts.contentLayoutMaster')
@section('title', 'Bill Generate')
@section('content')
    @if($action == 'new')
        @livewire("shop.bill-generate.month-wise-bill-create")
    @elseif($action == 'edit')
        @livewire("shop.bill-generate.month-wise-bill-edit")
    @else
        @livewire("shop.bill-generate.month-wise-bill-list")
    @endif
@endsection



