@extends('layouts.contentLayoutMaster')
@section('content')
    @if($action == 'new')
        @livewire("shop.mapping.mapping-create")
    @elseif($action == 'edit')
        @livewire("shop.mapping.mapping-edit")
    @else
        @php
        @endphp
        @livewire("shop.mapping.mapping-list")
    @endif
@endsection
