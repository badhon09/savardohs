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
        td,th{
            vertical-align: top;
            border: 1px solid black;
            max-width:100%;
            padding: 5px;
            text-align: center;
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
<div class="row">
    @foreach($result as $item)
        <div class="row">
            <div style="float: left; width: 33.33%">
                <img style="width: 80px; height: auto;" src="https://zit-bd.com/zit_assets/logo.png" alt="Logo">
            </div>
            <div style="float: left; width: 33.33%; text-align: center; font-size: 14px;">
                <p style="line-height: 1.5;"><b>SAVAR CANTT BOARD</b> <br>
                    {{$item['billing_dept_name']}} <br>
                    {{$item['revenue_head_name']}}</p>
            </div>
        </div>
        <div class="row">
            <p> <b>Billing Cycle:</b> {{$item['bill_cycle_name']}}</p>
        </div>
        <div class="row">
            <table width="100%" cellspacing="0">
                <tr>
                    <th style="text-align: center; width: 15%">Shop No</th>
                    <th style="text-align: center; width: 15%">Shop Area</th>
                    <th style="text-align: center; width: 15%">Meter No</th>
                    <th style="text-align: center; width: 15%">Meter Reading Date</th>
                    <th style="text-align: center; width: 15%">Meter Reading</th>
                    <th style="text-align: center; width: 15%">Updated at</th>
                </tr>
                @foreach($item['row_item'] as $row)
                    <tr>
                        <td>{{$row['shop_new_num']}}</td>
                        <td>@if($row['area_in_sft'] !=''){{$row['area_in_sft']}} sq. ft @endif</td>
                        <td>{{$row['meter_number']}}</td>
                        <td>@if($row['meter_reading_date'] != ''){{ date('d-m-Y',strtotime($row['meter_reading_date']))}} @endif</td>
                        <td>{{$row['current_reading']}}</td>
                        <td>@if($row['updated_at'] != ''){{ date('d-m-Y',strtotime($row['updated_at']))}} {{date('h:i A',strtotime($row['updated_at']))}} @endif</td>
                    </tr>
                @endforeach
            </table>
        </div>
    @endforeach
</div>

    <htmlpagefooter name="page-footer">
        <div style="float: left; width: 50%">
            <p style="text-align: left; font-size: 10px;">
                Developed By- Ainigma Technologies Limited <br>
                <span style="font-size: 8px;">Report No.: 006</span>
            </p>
        </div>
        <div style="float: left; width: 50%">
            <p style="text-align: right;">{PAGENO} of {nbpg} pages</p>
        </div>
    </htmlpagefooter>
</body>
</html>
