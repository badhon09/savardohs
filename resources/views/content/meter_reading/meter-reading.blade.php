@extends('layouts.contentLayoutMaster')
@section('title', 'Meter Reading')
@section('content')
    @if($action == 'new')
        @livewire("meter-reading.meter-reading-create")
    @elseif($action == 'edit')
        @php $cycleId = @$_GET['cycle_id'] @endphp
        @livewire("meter-reading.meter-reading-update",['cycleId'=>$cycleId])
    @elseif($action == 'publish')
        @php $cycleId = @$_GET['cycle_id'] @endphp
        @livewire("meter-reading.meter-reading-public",['cycleId'=>$cycleId])
    @elseif($action == 'publishCommonArea')
        @php $cycleId = @$_GET['cycle_id'] @endphp
        @livewire("meter-reading.mater-reading-publish-common-area",['cycleId'=>$cycleId])
    @elseif($action == 'meterCommon')
        @livewire("meter-reading.meter-reading-common-master")
    @else
        @livewire("meter-reading.meter-reading-list")
    @endif
@endsection



