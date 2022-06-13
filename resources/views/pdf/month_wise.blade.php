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
                Dept. of Engineering <br>
                Electric Bill</p>
        </div>
</div>
    <div class="row">
        <p>বিলের মাসঃ {{$data[0]->bill_cycle_name_bn}}</p>
        <table width="100%" cellspacing="0">
            <tr>
                <th colspan="9">সাভার ক্যান্টনমেন্ট বোর্ড সুপার মার্কেট এর বৈদ্যুতিক মিটার রিডিং বহি (নিচতলা)</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            <tr>
                <td>গ্রা/নং</td>
                <td>দোকান নং</td>
                <td>আবেদনকারী নাম ও ঠিকানা</td>
                <td>রেভিনিউ হেড</td>
                <td>মিটার নং</td>
                <td>পূর্ববর্তী মাসের ইউনিট</td>
                <td>পরবর্তী মাসের ইউনিট</td>
                <td>বিদ্যুৎ খরচের পরিমাণ</td>
                <td>প্রতি ইউনিটের মূল্য</td>
                <td>ডিমান্ড চার্জ</td>
                <td>প্রকৃত বিলের পরিমাণ</td>
                <td>ভ্যাট(৫%)</td>
                <td>সর্বমোট টাকা</td>
                <td>পূর্ববর্তী মাসের বকেয়া</td>
                <td>বিলম্ব মাশুল(৫%)</td>
                <td>সর্বমোট পাওনা</td>
                <td>আদায়কৃত টাকার পরিমাণ</td>
                <td>তারিখ ও রশিদ নম্বর</td>
                <td>বকেয়ার পরিমাণ</td>
            </tr>
            @php
            $n=1;
            @endphp
            @foreach($data as $row)
                <tr>
                    <td>{{$n++}}</td>
                    <td style="text-align: center;">{{$row->shop_new_num_bn}}</td>
                    <td>
                        {{$row->user_name_bn}}
                        {{$row->address}}
                    </td>
                    <td>{{$row->revenue_head_name_bn}}</td>
                    <td>{{$row->meter_number}}</td>
                    <td style="text-align: right">{{$NumBangla->bnNum($row->previous_meter_reading)}}</td>
                    <td style="text-align: right;">{{$NumBangla->bnNum($row->current_meter_reading)}}</td>
                    <td style="text-align: right">{{$NumBangla->bnNum($row->used_unit)}}</td>
                    <td style="text-align: right">{{$NumBangla->bnNum($row->billing_rate)}}</td>
                    <td style="text-align: right">{{$NumBangla->bnNum($row->demand_note_amt)}}</td>
                    <td style="text-align: right">{{$NumBangla->bnNum($row->bill_amount)}}</td>
                    <td style="text-align: right">{{$NumBangla->bnNum($row->vat_amount)}}</td>
                    <td style="text-align: right">{{$NumBangla->bnNum($row->total_bill)}}</td>
                    <td style="text-align: right">{{$NumBangla->bnNum(0)}}</td>
                    <td style="text-align: right">{{$NumBangla->bnNum($row->penalty)}}</td>
                    <td style="text-align: right">{{$NumBangla->bnNum($row->total_bill_after_penalty)}}</td>
                    <td style="text-align: right">{{$NumBangla->bnNum(0)}}</td>
                    <td style="text-align: right">{{$NumBangla->bnNum(0)}}</td>
                    <td style="text-align: right">{{$NumBangla->bnNum(0)}}</td>
                </tr>
{{--                @break--}}
            @endforeach
        </table>
    </div>
<htmlpagefooter name="page-footer">
    <div class="col-md-6">
        <p style="text-align: left; font-size: 10px;">
            Developed By- Ainigma Technologies Limited <br>
            <span style="font-size: 8px;">Report No.: {{$reportno}}</span>
        </p>
    </div>
    <div class="col-md-6">
        <p style="text-align: right">{PAGENO} of {nbpg} pages</p>
    </div>
</htmlpagefooter>
</body>
</html>
