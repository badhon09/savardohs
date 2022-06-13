@extends('layouts.contentLayoutMaster')
@section('title')
 Opening-balance-by-Flat 
@endsection

@section('vendor-style')
  {{-- vendor css files --}}
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
@endsection

@section('page-style')
{{-- Page Css files --}}
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
<link rel="stylesheet" type="text/css" href="{{asset('css/base/plugins/forms/pickers/form-flat-pickr.css')}}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
<style media="screen">
.col-12 .col-md-6{
  margin-top:10px;
}
.form-control-80{  
  width:100px;  
}
table tr td,table tr th{
    padding: 5px !important;
}
.card-header{
    padding: 3px;
}
.text-table tr th,.text-table tr td{
    font-size: 10px !important;
}
</style>
@endsection

@section('content')
<section>
    <div class="card card-body border-danger">
        @if(isset($isBillGenerated))
        <div class="alert alert-danger p-2">
        <h4 class="text-danger">Bill already generated! You are no longer allowed to update the opening balance.</h4>
        </div>
        @else
        @if(Session::has('server_message'))
        <div class="alert alert-success p-2">
        {{ Session::get('server_message')}}
        </div>
        @endif
        <div class="row">
            <div class="col-md-4 py-2">
                <label for="shopName">Flat Name</label>
                <select id="shopName" class="form-control" name="shopName">
                    <option value="">select</option>
                    @foreach($shoplist as $item)
                    <option value="{{$item->id}}" {{(request()->shop_id == $item->id)?'selected':null}}>{{$item->shop_new_num}}</option>
                    @endforeach                    
                </select>
            </div>
            <div class="col-md-8"></div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card border-primary">
                    <div class="card-header border-bottom bg-light">
                    <h4 class="card-title">Flat Details</h4>
                    </div>
                    <div class="card-body" style="padding:5px">
                    @if(!empty($shopDetails))
                    <span>Flat Name : {{$shopDetails->shop_new_num}}</span><br>
                    <span>Type : {{$shopDetails->shop_type_name}}</span><br>
                    <span>Area : {{$shopDetails->area_in_sft}}</span><br>
                    @else
                    <p>No Data Found</p>
                    @endif
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card border-primary">
                    <div class="card-header border-bottom bg-light">
                    <h4 class="card-title">Owner Details</h4>
                    </div>
                    <div class="card-body" style="padding:5px">
                    @if(count($shopOwnerDetails)>0)
                        <table class="table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Name</th>
                                    <th>Number</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Owner</td>
                                    <td>{{$shopOwnerDetails[0]->ownerName}}</td>
                                    <td>{{$shopOwnerDetails[0]->ownerMobile}}</td>
                                </tr>
                                <tr>
                                    <td>Tenant</td>
                                    <td>{{$shopOwnerDetails[0]->tenantName}}</td>
                                    <td>{{$shopOwnerDetails[0]->tenantMobile}}</td>
                                </tr>
                                <tr>
                                    <td>Paymaster</td>
                                    <td>{{$shopOwnerDetails[0]->paymasterName}}</td>
                                    <td>{{$shopOwnerDetails[0]->paymasterMobile}}</td>
                                </tr>
                            </tbody>
                        </table>
                    @else
                    <p>No Data Found</p>
                    @endif
                    </div>
                </div>
            </div>            
        </div>
        <div class="row">   
            <form action="{{url('/single-shop-data-store')}}" method="POST">    
                @csrf     
                <div class="col-md-12 table-responsive">                    
                    <table class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <th>Rev Head</th>
                                <th>Bill Amount</th>
                                <th>VAT (%)</th>
                                <th>Total Amount</th>
                                <th>Penalty Amount</th>
                                <th>After Penalty</th>
                                <th>Waived Amount</th>
                                <th>Total Payable</th>
                            </tr>
                        </thead>
                        <tbody>
                            <input type="hidden" class="shop_id" name="shop_id" value="{{request()->shop_id}}">                                                                                
                            @if(count($rate)>0)
                                @foreach($rate as $item)                                  
                                <tr>                                    
                                    <td>{{$item['revenue_head_name']}}</td>
                                    <td><input type="text" class="form-control amount_count" required name="shop_rate_amount[{{$item['revenue_head_id']}}]" value="{{$item['shop_rate_amount']}}"></td>
                                    <td><input type="text" class="form-control amount_count" value="{{$item['vat_amount']}}"></td>
                                    <td><input type="text" class="form-control" disabled value="{{$totalAmount = (($item['vat_amount'] / 100) * $item['shop_rate_amount'])+$item['shop_rate_amount']}}"></td>
                                    <td><input type="text" class="form-control amount_count" value="{{$item['penalty_amount']}}"></td>
                                    <td><input type="text" class="form-control" disabled value="{{$totalAmount+$item['penalty_amount']}}"></td>
                                    <td><input type="text" class="form-control" disabled value="0"></td>
                                    <td><input type="text" class="form-control" disabled value="{{$totalAmount+$item['penalty_amount']}}"></td>
                                    <td class="hidden"><input type="text" class="form-control data{{$loop->iteration}}" value="{{$item['revenue_head_id']}}"></td>
                                </tr>
                                @endforeach                            
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="text-end py-2">
                    @if(Session::has('server_message'))
                    <button class="btn btn-info mt-1 generate_bill" type="button">Generate Bill</button>
                    @else 
                    <button class="btn btn-primary" type="submit" >Save</button><br>
                    @endif 
                </div>
            </form>
        </div>
        <form action="{{url('opening-balance-bill-generate')}}" method="POST">
            @csrf
            <input type="hidden" class="revenue_head_count" name="revenue_head_count" value="{{count($rate)}}">
            <div class="row hidden_div">
                <div class="col-md-12 table-responsive">
                    <table class="table text-center table-bordered mt-2 card-body text-table">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Bill Month</th>
                                <th>Discounted Date</th>
                                <th>Due Date</th>
                                <th>Rev Head</th>
                                <th>Bill Amount</th>
                                <th>VAT Amount</th>
                                <th>Total Amount</th>
                                <th>Penalty Amount</th>
                                <th>After Penalty</th>
                                <th>Waived Amount</th>
                                <th>Total Payable</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        @if(count($billcycleNotExist)>0)
                                    @php $rowCunt = 0;$isRowCunt = false;$sl = 0;$i=1 @endphp              
                                    @foreach($billcycleNotExist as $row)
                                        @php
                                            if($rowCunt == 0){
                                                $rowCunt = $cycleCount = collect($billcycleNotExist)->where('bill_cycle_id',$row['bill_cycle_id'])->count();
                                                $isRowCunt = true;
                                                $sl++;
                                                $i=1;
                                            }else{
                                                $isRowCunt = false;
                                                $i++;
                                            }
                                            $rowCunt--;
                                        @endphp                                       
                                        <tr>
                                            @if($isRowCunt)
                                            <td  rowspan="{{$cycleCount}}">{{$i}}</td>
                                            <td  rowspan="{{$cycleCount}}">{{$row['bill_cycle_name']}}</td>
                                            @endif
                                            <td>
                                                <input type="date" class="form-control" name="discounted_date[]" value="{{date('Y-m-d')}}" required>
                                            </td>
                                            <td>
                                                <input type="date" class="form-control" name="due_date[]" value="{{date('Y-m-d')}}" required>
                                            </td>
                                            <td>
                                                <span class="small">{{$row['revenue_head_name']}}</span>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control {{'total_bill_amount'.$sl}}" name="bill_rate[]" value="0" required>
                                                <input type="hidden" name="grand_total_bill_amount[]" id="total_amount_bill_cal{{$sl}}">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control {{'total_vat_amount'.$sl}}" name="vat_rate[]" value="0" required>
                                                <input type="hidden" name="grand_total_vat_amount[]" id="total_amount_vat_cal{{$sl}}">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control {{'total_amount'.$sl}}" name="total_amount[]" value="0" required>
                                                <input type="hidden" name="grand_total_amount[]" id="total_amount_cal{{$sl}}">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control {{'total_penalty_amount'.$sl}}" name="penalty_amount[]" value="0" required>
                                                <input type="hidden" name="grand_total_penalty_amount[]" id="total_penalty_amount_cal{{$sl}}">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control {{'total_after_penalty_amount'.$sl}}" name="after_penalty[]" value="0" required>
                                                <input type="hidden" name="grand_total_after_penalty_amount[]" id="total_after_penalty_amount_cal{{$sl}}">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control {{'total_waived_amount'.$sl}}" name="waived_amount[]" value="0" required>
                                                <input type="hidden" name="grand_total_waived_amount[]" id="total_waived_amount_cal{{$sl}}">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control {{'total_payable_amount'.$sl}}" name="payable_amount[]" value="0" required>
                                                <input type="hidden" name="grand_total_payable_amount[]" id="total_payable_amount_cal{{$sl}}">
                                            </td>
                                            <td class="hidden">
                                                <input type="text" class="inpdt{{$sl}}{{$i}}" name="revenue_head_id[]" value="{{$row['revenue_head_id']}}">
                                            </td>
                                            <td class="hidden">
                                                <input type="text" class="" name="bill_cycle_id[]" value="{{$row['bill_cycle_id']}}">
                                            </td>
                                            <td class="hidden">
                                                <input type="hidden" class="shop_id" name="shop_id_val[]" value="{{request()->shop_id}}">
                                            </td>
                                            <!-- <td class="">
                                                <input type="text" class="total_bill_rate" name="total_bill_rate" value="0">
                                            </td> -->
                                            @if($isRowCunt)
                                                <td  rowspan="{{$cycleCount}}"><input type="checkbox" class="form-check-input" name="check{{$sl}}" value="{{$sl}}"></td>
                                            @endif
                                        </tr>

                                    @endforeach
                                @endif 
                        </tbody>
                    </table>
                
                </div>
                <div class="col-md-12 text-end py-2">
                    <button class="btn btn-primary disabled last-btn" type="submit">Add</button>
                    <button class="btn btn-warning disabled last-btn" type="submit">Update</button>
                </div>
            </div>
        </form>
        @endif
    </div>
</section>
@endsection
@section('vendor-script')
{{-- vendor files --}}
   <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
@endsection

@section('page-script')
<script>
$('.hidden_div').hide();
$(document).ready(function(){
    $('.generate_bill').click(function(){
        $('.hidden_div').show();
    });
    $('#shopName').on('change', function(){
        window.location = 'opening-balance-by-shop?shop_id='+$(this).val();
    });
    $('.amount_count').on('keyup', function(){   
        let bill_rate = $(this).parent().parent().children().eq(1).children().val();
        let vat_rate = $(this).parent().parent().children().eq(2).children().val();
        let penalty_rate = $(this).parent().parent().children().eq(4).children().val();
        let total = Math.floor((vat_rate / 100) * bill_rate)
        
        $(this).parent().parent().children().eq(3).children().val(parseFloat(total)+parseFloat(bill_rate))
        let rate_after_penalty= parseFloat(total)+parseFloat(bill_rate)+parseFloat(penalty_rate);
        $(this).parent().parent().children().eq(5).children().val(rate_after_penalty)
        $(this).parent().parent().children().eq(7).children().val(rate_after_penalty)  
        
        sessionStorage.setItem("vat_rate", vat_rate);
        sessionStorage.setItem("penalty_rate", penalty_rate);
    });

    $('input[type="checkbox"]').change(function() {
        if($(this).is(':checked')){   
            let chkbx_value= this.value;             
            let revenue_head_count = $('.revenue_head_count').val();   
            let total_bill_rate = parseInt(0);         
            for (let i = 1; i <= revenue_head_count; i++) {       
                $('.inpdt'+chkbx_value+i).parent().prev().prev().prev().prev().prev().prev().prev().children().val($('.data'+i).parent().parent().children().eq(1).children().val());                                    
                $('.inpdt'+chkbx_value+i).parent().prev().prev().prev().prev().prev().prev().children().val($('.data'+i).parent().parent().children().eq(2).children().val());                                    
                $('.inpdt'+chkbx_value+i).parent().prev().prev().prev().prev().prev().children().val($('.data'+i).parent().parent().children().eq(3).children().val());                                    
                $('.inpdt'+chkbx_value+i).parent().prev().prev().prev().prev().children().val($('.data'+i).parent().parent().children().eq(4).children().val());                                    
                $('.inpdt'+chkbx_value+i).parent().prev().prev().prev().children().val($('.data'+i).parent().parent().children().eq(5).children().val());                                    
                $('.inpdt'+chkbx_value+i).parent().prev().prev().children().val($('.data'+i).parent().parent().children().eq(6).children().val());                                    
                $('.inpdt'+chkbx_value+i).parent().prev().children().val($('.data'+i).parent().parent().children().eq(7).children().val());                                    
                $('.inpdt'+chkbx_value+i).val($('.data'+i).parent().parent().children().eq(8).children().val()); 
                
            }

            var total_bill_amount = 0;
            $('.total_bill_amount'+chkbx_value).each(function(){
                total_bill_amount = parseInt(total_bill_amount)+parseInt(this.value);
            });
            $('#total_amount_bill_cal'+chkbx_value).val(total_bill_amount);

            var total_vat_amount = 0;
            $('.total_vat_amount'+chkbx_value).each(function(){
                total_vat_amount = parseInt(total_vat_amount)+parseInt(this.value);
            });
            $('#total_amount_vat_cal'+chkbx_value).val(total_vat_amount);
            
            var total_amount = 0;
            $('.total_amount'+chkbx_value).each(function(){
                total_amount = parseInt(total_amount)+parseInt(this.value);
            });
            $('#total_amount_cal'+chkbx_value).val(total_amount);
            
            var total_penalty_amount = 0;
            $('.total_penalty_amount'+chkbx_value).each(function(){
                total_penalty_amount = parseInt(total_penalty_amount)+parseInt(this.value);
            });
            $('#total_penalty_amount_cal'+chkbx_value).val(total_penalty_amount);

            var total_after_penalty_amount = 0;
            $('.total_after_penalty_amount'+chkbx_value).each(function(){
                total_after_penalty_amount = parseInt(total_after_penalty_amount)+parseInt(this.value);
            });
            $('#total_after_penalty_amount_cal'+chkbx_value).val(total_after_penalty_amount);

            var total_waived_amount = 0;
            $('.total_waived_amount'+chkbx_value).each(function(){
                total_waived_amount = parseInt(total_waived_amount)+parseInt(this.value);
            });
            $('#total_waived_amount_cal'+chkbx_value).val(total_waived_amount);

            var total_payable_amount = 0;
            $('.total_payable_amount'+chkbx_value).each(function(){
                total_payable_amount = parseInt(total_payable_amount)+parseInt(this.value);
            });
            $('#total_payable_amount_cal'+chkbx_value).val(total_payable_amount);

        }else{
            let chkbx_value= this.value;          
            let revenue_head_count = $('.revenue_head_count').val();   
            let total_bill_rate = parseInt(0);         
            for (let i = 1; i <= revenue_head_count; i++) {       
                $('.inpdt'+chkbx_value+i).parent().prev().prev().prev().prev().prev().prev().prev().children().val(0);                                    
                $('.inpdt'+chkbx_value+i).parent().prev().prev().prev().prev().prev().prev().children().val(0);                                    
                $('.inpdt'+chkbx_value+i).parent().prev().prev().prev().prev().prev().children().val(0);                                    
                $('.inpdt'+chkbx_value+i).parent().prev().prev().prev().prev().children().val(0);                                    
                $('.inpdt'+chkbx_value+i).parent().prev().prev().prev().children().val(0);                                    
                $('.inpdt'+chkbx_value+i).parent().prev().prev().children().val(0);                                    
                $('.inpdt'+chkbx_value+i).parent().prev().children().val(0);                                    
                $('.inpdt'+chkbx_value+i).val(0); 
                
            }
        }
        $('.last-btn').removeClass('disabled');
    });

});
</script>
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
  {{-- Page js files --}}
@endsection
