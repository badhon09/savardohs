@extends('layouts.contentLayoutMaster')
@section('content')
    @if($action == 'new')
        @livewire("shop.shoptype.shop-type-create")
    @elseif($action == 'edit')
        @livewire("shop.shoptype.shop-type-edit",['editID' => $editID])
    @elseif($action == 'delete')
      @livewire("shop.shoptype.shop-type-delete",['deleteID' => $deleteID])
    @else
        @livewire("shop.shoptype.shop-type-list")
    @endif
@endsection
