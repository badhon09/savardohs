@extends('layouts.contentLayoutMaster')
@section('content')
    @if($action == 'new')
        @livewire("shop.shopinfo.shop-info-create")
    @elseif($action == 'edit')
        @livewire("shop.shopinfo.shop-info-edit",['editID'=>$editID])
    @elseif($action == 'delete')
      @livewire("shop.shopinfo.shop-info-delete")
    @else
        @livewire("shop.shopinfo.shop-info-list")
    @endif
@endsection
