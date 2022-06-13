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
@endphp
<div class="row">
    <div style="float: left; width: 33.33%">
        <img style="width: 80px; height: auto;" src="https://zit-bd.com/zit_assets/logo.png" alt="Logo">
    </div>
    <div style="float: left; width: 33.33%; text-align: center; font-size: 14px;">
        <p style="line-height: 1.5;"> <b>SAVAR CANTT BOARD</b> <br>
            Sena Market Savar <br>
            List of Shops without owner-not sold
        </p>
    </div>
</div>
    <div class="row">
        <table width="100%" cellspacing="0">
            <tr>
                <th>Sl No.</th>
                <th>Shop Name</th>
                <th>Revenue Source</th>
                <th>Shop No.</th>
                <th>Area (Sq. ft)</th>
                <th>Meter No.</th>
                <th>Pay Master</th>
                <th>Tenant</th>
                <th>Tenant Phone</th>
            </tr>
            @php
            $n=1;
            @endphp
            @foreach($data as $row)
                <tr>
                    <td>{{$n++}}</td>
                    <td>{{$row->shop_name_bn}}</td>
                    <td>{{$row->revenue_source_name}}</td>
                    <td>{{$row->shop_new_num}}</td>
                    <td>{{$row->area_in_sft}}</td>
                    <td>{{$row->meter_number}}</td>
                    <td>{{$row->pay_master}}</td>
                    <td>{{$row->tenant_name}}</td>
                    <td>{{$row->tenant_mob_no}}</td>
                </tr>
            @endforeach
        </table>
    </div>
<htmlpagefooter name="page-footer">
    <div class="col-md-6">
        <p style="text-align: left; font-size: 10px;">
            Developed By- Ainigma Technologies Limited <br>
            <span style="font-size: 8px;">Report No.: 002</span>
        </p>
    </div>
    <div class="col-md-6">
        <p style="text-align: right">{PAGENO} of {nbpg} pages</p>
    </div>
</htmlpagefooter>
</body>
</html>
