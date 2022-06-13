@php
    ini_set("pcre.backtrack_limit", "5000000000000000000");
    ini_set("memory_limit","4096M");
    ini_set('max_execution_time', 600);
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>বৈদ্যুতিক বিল</title>
    <style>
        @page {
            header: page-header;
            footer: page-footer;
        }
        body {
            font-family: 'nikosh',"Roboto Thin", sans-serif;
            width: 100%;
            font-size: 12px;
        }
        table {
            border-collapse: collapse;
            font-size: 12px;
            width: 100%;
        }
        td, tr, th{
            vertical-align: top;
            border: 1px solid black;
            max-width:100%;
            padding: 5px;
            /*white-space:nowrap;*/
        }
        .col-md-6
        {
            float: left;
            width: 48%;
            padding: 10px;
        }
        /* Clear floats after the columns */
        .row:after {
            content: "";
            display: table;
            clear: both;
        }
    </style>
</head>
<body>
@php
    $NumBangla = new lemonpatwari\BanglaNumber\NumberToBangla();
date_default_timezone_set('Asia/Dhaka');
@endphp
    <div class="row">
        <div style="float: left; width: 33.33%">
            <img style="width: 80px; height: auto;" src="https://zit-bd.com/zit_assets/logo.png" alt="Logo">
        </div>
        <div style="float: left; width: 33.33%; text-align: center; font-size: 14px;">
            <p style="line-height: 1.5;"><b>SAVAR CANTT BOARD</b> <br>
                Sena Market Savar <br>
                {{$data[0]->billing_dept_name}}<br>
                Month Wise Sena Market Revenue
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <p style="text-align: left">
                <b>Billing Cycle:</b> {{$data[0]->bill_cycle_name}} <br>
                <b>Issue Date: </b> {{date('d-m-y',strtotime($data[0]->issue_date))}} <br>
                <b>Due Date: </b> {{date('d-m-y',strtotime($data[0]->due_date))}}
            </p>
        </div>
        <div class="col-md-6">
            <p style="text-align: right"><b>Print Date:</b> {{ date('d-m-Y h:i A')}}</p>
        </div>
        <table width="100%" cellspacing="0">
            <tr>
                <th>Sl</th>
                <th>Shop Name</th>
                <th>Shop No.</th>
                <th>User Name</th>
                <th>Phone</th>
                <th>Service Charge</th>
                <th>Board Rent</th>
                <th>Monthly Rent</th>
                <th>Total Amount</th>
                <th>Penalty Amount</th>
                <th>Final Bill</th>
                <th>Paid Amount</th>
                <th>Payment Date</th>
                <th>Payment Status</th>
            </tr>
            @php
            $n=1;
            @endphp
            @foreach($data as $row)
                <tr>
                    <td>{{$n++}}</td>
                    <td>{{$row->shop_name_bn}}</td>
                    <td>{{$row->shop_num}}</td>
                    <td>{{$row->user_name_bn}}</td>
                    <td>{{$row->mobile_no}}</td>
                    <td style="text-align: right;">{{$row->service_charge}}/-</td>
                    <td style="text-align: right;">{{$row->board_rent}}/-</td>
                    <td style="text-align: right;">{{$row->monthly_rent}}/-</td>
                    <td style="text-align: right;">{{$row->total_amount}}/-</td>
                    <td style="text-align: right;">{{$row->penalty_amount}}/-</td>
                    <td style="text-align: right;">{{$row->final_bill}}/-</td>
                    <td style="text-align: center;">{{$row->paid_amount}}</td>
                    <td style="text-align: center;">@if(!empty($row->payment_date)){{date('d-m-y',strtotime($row->payment_date))}} @endif</td>
                    <td style="text-align: center;">{{ ($row->payment_status == 1) ? 'Paid' : 'Not Paid'}}</td>
                </tr>
            @endforeach
        </table>
    </div>

<htmlpagefooter name="page-footer">
    <div class="col-md-6">
        <p style="text-align: left; font-size: 10px;">
            Developed By- Ainigma Technologies Limited <br>
            <span style="font-size: 8px;">Report No.: 011B</span>
        </p>
    </div>
    <div class="col-md-6">
        <p style="text-align: right">{PAGENO} of {nbpg} pages</p>
    </div>
</htmlpagefooter>
</body>
</html>

