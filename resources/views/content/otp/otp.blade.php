@extends('layouts.contentLayoutMaster')
@section('content')
    @if($action == 'new')
        @livewire("otp.otp-create")        
    @else
        @livewire("otp.otp-list")
    @endif
@endsection