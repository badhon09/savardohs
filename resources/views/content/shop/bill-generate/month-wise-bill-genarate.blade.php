@extends('layouts.contentLayoutMaster')
@section('title', 'Bill Generate')
@section('content')
@section('vendor-style')
    {{-- Vendor Css files --}}
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
@endsection

@section('page-style')
    {{-- Page Css files --}}
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <style>
        .card {
            margin-bottom: 1rem !important;
        }
        .error_field{
            color:red !important;
        }
    </style>
@endsection
<section class="bs-validation">
    <div class="row">
        <div class="col-12">
            <div class="card border-primary">
                <div class="card-body">
                    <!-- jQuery Validation -->
                    @csrf
                    <div class="col-md-12 col-12">
                        <div class="card" style="margin-bottom:0px !important;">
                            <form name="generate" >
                                <div class="row">
                                    <div class="col-md-4 mb-1">
                                        <label class="form-label" for="select-market-shop">Bill Cycle</label>
                                        <select class="form-select" id="select-market-shop"  name="cycle_id" required>
                                            <option value="">-- Select Item --</option>
                                            @foreach($BillMonthList as $bmonth)
                                                <option value="{{ $bmonth->id }}" @if(@$_GET['cycle_id'] == $bmonth->id) selected @endif>{{ $bmonth->bill_cycle_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('billMonthID') <span class="error">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label for="issue_date">Issue Date</label>
                                        @if(@$_GET['issue_date'])
                                            <input type="date" onChange="GetIssueDate(this)" class="form-control" value="{{ @$_GET['issue_date'] }}" name="issue_date" id="issue_date" required>
                                        @else
                                            <input type="date" onChange="GetIssueDate(this)" class="form-control" value="{{ Date('Y-m-d') }}" name="issue_date" id="issue_date" required>
                                        @endif
                                        <span id="error_msg" style="color:red;display: none;font-size: 12px">Issue Date cannot be greater than Due Date</span>

                                    </div>
                                    <div class="col-md-3">
                                        <label for="due_date">Due Date</label>
                                        @if(@$_GET['due_date'])
                                            <input type="date" onChange="GetDueDate(this)" class="form-control" value="{{ @$_GET['due_date'] }}" name="due_date" id="due_date" required>
                                        @else
                                            <input type="date" onChange="GetDueDate(this)" class="form-control" value="{{ Date('Y-m-d') }}" name="due_date" id="due_date" required>
                                        @endif
                                        <span id="error_msg2" style="color:red;display: none;font-size: 12px">Due Date cannot be less than Issue Date</span>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-4 mb-1">
                                        <label for="bill_name">Bill Name</label>
                                        <input type="text" class="form-control" name="bill_name" required>
                                    </div>
                                    <div class="col-md-2">
                                        <br>
{{--                                        <input type="submit" name="submit" class="btn btn-primary" value="Populate">--}}
                                        <input type="hidden" name="_cycle_id" value="{{ @$_GET['cycle_id'] }}">
                                        <button type="submit" class="btn btn-primary pull-right" style="float:left" name="submit" value="Generate">Publish Bill</button>
                                    </div>
                                </div>
                                    @if(count(@$ProcessDataList) > 0)
                                <div class="row" >
                                    <div class="col-md-12">
                                        <div class="card-datatable">
                                            <table class="datatables-ajax table table-responsive">
                                                <thead>
                                                <tr class="text-white">
                                                    {{--                                                        <th class="bg-primary">ID</th>--}}
                                                    <th class="bg-primary">Revenue Head</th>
                                                    <th class="bg-primary">{{Config('revenue.label')}} Number</th>
                                                    <th class="bg-primary">Amount</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @if(count(@$ProcessDataList) > 0)
                                                    @foreach(@$ProcessDataList as $item)
                                                        <tr>
                                                            {{--                                                            <td>{{ $item->id }}</td>--}}
                                                            {{--                                                            <td>{{ $billMonthID }}</td>--}}
                                                            <td>{{ $item->revenue_head_name }}</td>
                                                            <td>{{ $item->shop_new_num }}</td>
                                                            <td>{{ number_format($item->rate,2) }}</td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td rowspan="2" style="text-align: center;vertical-align: middle">No data found</td>
                                                    </tr>
                                                @endif

                                                </tbody>
                                            </table>
                                            <div class="col-md-12 pull-right" >
                                                <br>
                                                @if(count(@$ProcessDataList) > 0)
                                                        <input type="hidden" name="_cycle_id" value="{{ @$_GET['cycle_id'] }}">
                                                        <button type="submit" class="btn btn-primary pull-right" style="float:left" name="submit" value="Generate">Publish Bill</button>
                                                    <span class="btn-default " style="float:right">Total Rate Amount: <strong>{{ number_format($totalAmount,2) }}</strong></span>
                                                @endif
                                            </div>
                                        </div>
                                        <br>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <br>
                                        <br>
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
                                        <br>
                                        <div class="d-flex justify-content-left dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate" style="float:right;margin-right:0px">
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
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@section('vendor-script')
    <!-- vendor files -->
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
@endsection
@section('page-script')
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
        </script>
    @endif
    <script type="text/javascript">
        function chnagePageDataQty(e){
            location.replace(e.value);
        }

        function GetIssueDate(e){
            var DueDate = $('#due_date').val();
            var issueDateOld = new Date(e.value);
            var issueDate = new Date(e.value);
            var DueDate = new Date(DueDate);
            if(issueDate.getTime() > DueDate.getTime()){
                $('#issue_date').val(new Date(issueDateOld));
                $('#issue_date').addClass('error_field');
                $('#error_msg').show();
            }else{
                $('#issue_date').removeClass('error_field');
                $('#error_msg').hide();

            }
        }
        function GetDueDate(e){
            var issueDate = $('#issue_date').val();
            var DueDateOld = new Date(e.value);
            var DueDate = new Date(e.value);
            var issueDate = new Date(issueDate);
            if(issueDate.getTime() > DueDate.getTime()){
                $('#due_date').val(new Date(DueDateOld));
                $('#due_date').addClass('error_field');
                $('#error_msg2').show();
            }else{
                $('#due_date').removeClass('error_field');
                $('#error_msg2').hide();
            }

        }
    </script>
    <!-- Page js files -->
    <script src="{{ asset(mix('js/scripts/forms/form-validation.js')) }}"></script>
    <script src="{{asset('js/core/appscript.js')}}"></script>
@endsection

@endsection



