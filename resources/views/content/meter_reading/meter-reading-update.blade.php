@extends('layouts.contentLayoutMaster')
@section('vendor-style')
    {{-- vendor css files --}}
    {{--    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">--}}
    {{--    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">--}}
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">

@endsection
@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    {{--    <link rel="stylesheet" type="text/css" href="{{asset('css/base/plugins/forms/pickers/form-flat-pickr.css')}}">--}}
    <style>
        .invalid-data{
            background: red;
            color: #fff;
        }
    </style>
@endsection
@section('title', 'Meter Reading - List')
@section('content')
<div class="row" >
    <div class="col-12">
        <div class="card border-primary">
            <form action="{{ URL::to('meter-reading/meter-reading-update') }}">
                <div class="row" style="margin-left:10px;margin-top:10px" >
                    <div class="col-md-4">
                        <label for="cycle_id">Bill Cycle</label>
                        <select name="cycle_id" class="form-control " id="cycle_id" required>
                            <option value="">-- select item --</option>
                            @foreach($cycleList as $i=>$data)
                                <option value="{{$data['cycle_id']}}" @if(@$_GET['cycle_id'] == $data['cycle_id']) selected @endif >{{$data['bill_cycle_name']}}</option>
                            @endforeach
                        </select>

                    </div>
                    <div class="col-md-2">
                        <br>
                        <input type="submit" name="Search" class="btn btn-primary pull-right" value="Search">
                    </div>
                    <div class="col-md-2">
                        <br>
                        <input type="date" value="{{ Date('Y-m-d') }}" name="meter_reading_date" class="btn btn-info"  required>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </div>

                </div>
            </form>
            @if(count($cycleList) > 0)
            <form action="{{ URL::to('meter-reading/meter-reading-update') }}" method="POST"  enctype="multipart/form-data">
                @csrf
                <div class="card-datatable">
                    <br>
                <table id="table_id" class="datatables-ajax table table-responsive">
                    <thead>
                    <tr class="text-white">
{{--                        <th class="bg-primary" >Sl</th>--}}
                        <th class="bg-primary" >Bill Cycle</th>
                        <th class="bg-primary" >{{Config('revenue.label')}} Number</th>
                        <th class="bg-primary" >Revenue Head</th>
                        <th class="bg-primary">Prev Meter Reading</th>
                        <th class="bg-primary">Meter Reading</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($shopList as $i=>$bmItem)
                        <tr>
{{--                            <td @if($bmItem['is_update'] == 1) style="background:#e2ffe2;"  @endif>{{$loop->iteration}}</td>--}}
                            <td @if($bmItem['is_update'] == 1) style="background:#e2ffe2;"  @endif>{{$bmItem['bill_cycle_name']}}</td>
                            <td @if($bmItem['is_update'] == 1) style="background:#e2ffe2;"  @endif>{{$bmItem['shop_new_num']}}</td>
                            <td @if($bmItem['is_update'] == 1) style="background:#e2ffe2;"  @endif>{{$bmItem['revenue_head_name']}}</td>
                            <td @if($bmItem['is_update'] == 1) style="background:#e2ffe2;"  @endif>
                                <input style="width:150px" id="{{'reading_val_id'.$bmItem['id']}}" value="{{$bmItem['prev_meter_reading']}}" class="form-control" disabled type="text" >
                                <input id="{{'prev_meter_reading'.$i}}" name="prev_meter_reading[]" id="{{'reading_val_id'.$bmItem['id']}}" value="{{$bmItem['prev_meter_reading']}}" type="hidden" >
                                <input  name="prev_meter_reading_date[]" value="{{$bmItem['prev_meter_reading_date']}}" class="form-control"  type="hidden" >
                            </td>
                            <td @if($bmItem['is_update'] == 1) style="background:#e2ffe2;"  @endif>
                                <input id="{{'meter_reading'.$i}}" onClick="this.select();"  name="meter_reading[]" style="width:150px"  onblur="validateMeterReading({{$i}})" data-id="{{$i}}" class="form-control" value="{{$bmItem['meter_reading']}}" min="{{$bmItem['prev_meter_reading']}}" type="number" required>
                                <input  name="reading_child_id[]" style="width:150px"  class="form-control" value="{{$bmItem['reading_child_id']}}" type="hidden" >
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                </table>
            </div>
                @if(count($shopList) > 0)
                <div class="col-md-12 pull-right" >
                    <div class="row" style="margin-top:20px;">
                        <div class="col-md-2"></div>
                        <div class="col-md-12" style="float:right;text-align: right">
                            <input  class="btn btn-primary pull-right" style="float:right;" type="submit" name="update"  value="Save">

                            <a href="{{ url('meter-reading/meter-reading-update') }}" style="float:right;text-align: right" class="btn btn-danger pull-right" type="submit" name="update">Cancel</a>
                            @if(@$_GET['cycle_id'])
                                <a href="{{ url('electric_bill_check?billing_cycle='.@$_GET['cycle_id']) }}" style="float:right;margin-right:5px;margin-left:5px;" class="btn btn-warning pull-right" type="button" name="update" target="_blank">Check</a>
                            @else
                                <input class="btn btn-warning pull-right" style="float:right;" type="button" name="update" disabled  value="Check">
                            @endif
                            {{--                         @else   <input wire:click.prevent="updateMeterReadingCheck" class="btn btn-primary pull-right" type="submit" name="update" value="Check">--}}
                            <input  class="btn btn-success pull-right" style="float:right;margin-right:5px; " type="submit" name="update" value="Publish">
                            <br>
                            <br>

                            <input type="hidden" name="cycle_id" style="float:right;" value="{{@$_GET['cycle_id']}}">
                            <input type="hidden" name="page" style="float:right;" value="{{@$_GET['page']}}">
                            <input type="hidden" name="qty" style="float:right;" value="{{@$_GET['qty']}}">
                            &nbsp;&nbsp;&nbsp;&nbsp;

                        </div>
                    </div>
                </div>
                @endif
            </form>
                @if(count($shopList) > 0)
                <div class="row">
                    <div class="col-md-2">
                        <div class="d-flex justify-content-center">
{{--                            <br>--}}
                            &nbsp;&nbsp;<span style="margin-top:10px;">Lentgh</span>
                            <select name=""  onchange="chnagePageDataQty(this)" class="add-button btn form-control" id="" style="border-color: #52844f !important;">
                                <option value="{{ url()->current().'?page='.@$_GET['page'].'&qty=10'.'&cycle_id='.@$_GET['cycle_id']}}" @if(@$_GET['qty'] == 10) selected @endif>10</option>
                                <option value="{{ url()->current().'?page='.@$_GET['page'].'&qty=20'.'&cycle_id='.@$_GET['cycle_id']}}" @if(@$_GET['qty'] == 20) selected @endif>20</option>
                                <option value="{{ url()->current().'?page='.@$_GET['page'].'&qty=30'.'&cycle_id='.@$_GET['cycle_id']}}" @if(@$_GET['qty'] == 30) selected @endif>30</option>
                                <option value="{{ url()->current().'?page='.@$_GET['page'].'&qty=50'.'&cycle_id='.@$_GET['cycle_id']}}" @if(@$_GET['qty'] == 50) selected @endif>50</option>
                                <option value="{{ url()->current().'?page='.@$_GET['page'].'&qty=100'.'&cycle_id='.@$_GET['cycle_id']}}" @if(@$_GET['qty'] == 100) selected @endif>100</option>
                                <option value="{{ url()->current().'?page='.@$_GET['page'].'&qty=200'.'&cycle_id='.@$_GET['cycle_id']}}" @if(@$_GET['qty'] == 200) selected @endif>200</option>
                                <option value="{{ url()->current().'?page='.@$_GET['page'].'&qty=300'.'&cycle_id='.@$_GET['cycle_id']}}" @if(@$_GET['qty'] == 300) selected @endif>300</option>
                                <option value="{{ url()->current().'?page='.@$_GET['page'].'&qty=500'.'&cycle_id='.@$_GET['cycle_id']}}" @if(@$_GET['qty'] == 500) selected @endif>500</option>
                                <option value="{{ url()->current().'?page='.@$_GET['page'].'&qty=1000'.'&cycle_id='.@$_GET['cycle_id']}}" @if(@$_GET['qty'] == 1000) selected @endif>1000</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-10" >
                        <br>
                        <div class="d-flex justify-content-left dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate" style="float:right;margin-right:10px">
                            <ul class="pagination" >
                                @foreach($links as $index=>$link)
                                    <li class="paginate_button page-item @if($link['active']) active @endif">
                                        <a href="{{ $link['url'].'&cycle_id='.@$_GET['cycle_id'].'&qty='.@$_GET['qty'] }}" aria-controls="DataTables_Table_0" data-dt-idx="{{$link['label']}}" tabindex="0" class="page-link">{!! $link['label'] !!} </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                </div>
                @endif
            @else
                <br>
                <br>
                <br>
            @endif
        </div>
    </div>
</div>
@endsection
@section('vendor-script')
    {{-- vendor files --}}
        <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>

{{--        <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>--}}
{{--        <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.js')) }}"></script>--}}
{{--    <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>--}}
@endsection

@section('page-script')
    <script type="text/javascript">
        function MeterReadingClickFunc(){
            console.log('d');
        }
        function chnagePageDataQty(e){
            location.replace(e.value);
        }
        function validateMeterReading(id){
            var prevMR = $('#prev_meter_reading'+id).val();
            var curMR =  $('#meter_reading'+id).val();
            if(parseFloat(curMR) < parseFloat(prevMR)){
                // $('#meter_reading'+id).removeClass('invalid-data')
                // $('#meter_reading'+id).removeClass('invalid-data')
                $('#meter_reading'+id).addClass('invalid-data')
            }else{
                $('#meter_reading'+id).removeClass('invalid-data')
                // $('#meter_reading'+id).addClass('invalid-data')
                // $('#meter_reading'+id).addClass('invalid-data')
            }
        }
    </script>
    @if(session()->has('server_message'))
        <script>
            toastr.success("{{ session('server_message') }}", 'Success!', {
                closeButton: true,
                tapToDismiss: false
            });
        </script>
    @endif
    @if(session()->has('server_error'))
        <script>
            toastr.error("{{ session('server_error') }}", 'Failed!', {
                closeButton: true,
                tapToDismiss: false
            });
            // location.reload();
        </script>
    @endif
    {{-- Page js files --}}
@endsection
