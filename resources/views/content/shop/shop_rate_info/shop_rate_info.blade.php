@extends('layouts.contentLayoutMaster')
@section('content')
    @if($action == 'new')
        @livewire("shop.shoprateinfo.shop-rate-info-create")
    @elseif($action == 'edit')
        @livewire("shop.shoprateinfo.shop-rate-info-edit",['editID' => $editID])
    @elseif($action == 'delete')
      @livewire("shop.shoprateinfo.shop-rate-info-delete",['deleteID' => $deleteID])
    @else
        @livewire("shop.shoprateinfo.shop-rate-info-list")
    @endif
@endsection
