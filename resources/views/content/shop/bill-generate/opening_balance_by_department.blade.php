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
    </style>
@endsection
<section class="bs-validation">
    <div class="row">
        <div class="col-12">
            <div class="card border-primary">

                <div class="row card-body m-0 p-0">
                    <div class="col-12 col-md-12">
                            <div class="row">
                                <form action="{{ URL::to('opening-balance-by-department') }}" enctype="multipart/form-data" method="POST" >
                                    @csrf
                                    <table class="table table-border">
                                    <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Shop Number</th>
                                        @foreach($billChildList as $row)
                                        @foreach($row as $itm)
                                                <th>{{$itm->revenue_head_name}}</th>
                                            @endforeach
                                            @break
                                        @endforeach
                                        <th>Total Amount</th>
                                        <th>Penalty</th>
                                        <th>After Penalty</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbody">
                                    @php $sl = 0; @endphp
                                    @foreach($billChildList as $i=>$row)

                                        <tr>
                                            <td width="7%"><span class="badge badge-light-primary"> {{ $loop->iteration }}</span></td>
                                            @foreach($row as $itm)
                                                <td>
                                                    {{ $itm->shop_new_num }}
                                                    <input type="hidden" name="bc_id[]" value="{{ $itm->bc_id }}">
                                                    <input type="hidden" name="bcr_id[]" value="{{ $itm->bcr_id }}">
                                                </td>
                                                @break
                                            @endforeach
                                            @foreach($row as $itm)
                                                <td >
                                                    <input type="number" name="amount[]" value="{{ $itm->amount }}" class="form-control form-control-sm" required/>
                                                </td>
                                            @endforeach
                                            @foreach($row as $itm)
                                                <td>
                                                    <input type="number" name="total_amount[]" value="{{ $itm->total_amount }}" class="form-control form-control-sm" required/>
                                                </td>
                                                <td>
                                                    <input type="number" name="penalty[]"  value="{{ $itm->penalty }}" class="form-control form-control-sm" required/>
                                                </td>
                                                <td>
                                                    <input type="number" name="total_bill_after_penalty[]" value="{{ $itm->total_bill_after_penalty }}" class="form-control form-control-sm" required/>
                                                </td>
                                                @break
                                            @endforeach
                                        </tr>
                                        @php $sl++; @endphp
                                        @if($sl == 40)
                                            @break
                                        @endif
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th colspan="8">
                                            <button type="submit" class="btn btn-primary waves-effect waves-float waves-light" style="float:right"><i class="fa fa-save"></i> Update</button>
                                        </th>
                                    </tr>
                                    </tfoot>
                                </table>
                                <div>
                                    @php 
                                    $btn=1;
                                    if(isset($_GET['page'])){
                                        $pageActive = $_GET['page'];
                                    }else{
                                        $pageActive = 1;
                                    }
                                    $beforeItem = $pageActive-4; 
                                    $afterItem = $pageActive+4;
                                    $totalItem = $dataCount/10;
                                    $lastItem = $totalItem-2;
                                    $elementOne='';
                                    $elementTwo='';
                                    @endphp        
                                    @for($i=0;$i<=$dataCount;$i+=10)
                                    @if($beforeItem <= $btn && $afterItem >= $btn )                                    
                                        @if($pageActive == $btn)
                                        <a href="{{url('opening-balance-by-department?page='.$btn)}}" class="btn btn-primary btn-sm my-1">{{$btn}}</a>
                                        @else
                                        <a href="{{url('opening-balance-by-department?page='.$btn)}}" class="btn btn-light border-primary btn-sm my-1">{{$btn}}</a>
                                        @endif
                                    @endif                                    
                                    <!-- @if($lastItem <= $btn)                                         
                                        @if($pageActive == $btn)
                                        <a href="{{url('opening-balance-by-department?page='.$btn)}}" class="btn btn-primary btn-sm my-1">{{$btn}}</a>
                                        @else
                                        <a href="{{url('opening-balance-by-department?page='.$btn)}}" class="btn btn-light border-primary btn-sm my-1">{{$btn}}</a>
                                        @endif
                                    @endif                                                -->
                                    @php $btn++ @endphp
                                    @endfor                                
                                </div>
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
            // location.reload();
        </script>
    @endif
    <script type="text/javascript">
        function chnagePageDataQty(e){
            location.replace(e.value);
        }
    </script>
    <!-- Page js files -->
    <script src="{{ asset(mix('js/scripts/forms/form-validation.js')) }}"></script>
    <script src="{{asset('js/core/appscript.js')}}"></script>
@endsection

@endsection



