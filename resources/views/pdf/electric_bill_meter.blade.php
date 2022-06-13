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
            font-size: 14px;
        }
        table {
            border-collapse: collapse;
            font-size: 14px;
            width: 100%;
        }
        td{
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
@foreach($data as $item)
<div class="row">
    <div class="col-md-6" >
        <p style="text-align: left;">বিলের মাসঃ {{$item->bill_cycle_name_bn}}, বিল পরিশোধের সর্বশেষ তারিখঃ
            {{$NumBangla->bnNum(number_format(date('d',strtotime($item->due_date))))}}-{{$NumBangla->bnNum(number_format(date('m',strtotime($item->due_date))))}}-{{$NumBangla->bnNum(date('Y',strtotime($item->due_date)))}} ইং</p>
        <div class="row">
            <table width="100%" cellspacing="0" style="table-layout: fixed; padding: 10px;">
                <tr>
                    <td colspan="4" style="font-size: 18px; text-align: center;">সাভার ক্যান্টনমেন্ট বোর্ড সুপার মার্কেট এর বৈদ্যুতিক বিল</td>
                </tr>
                <tr>
                    <td colspan="4">
                        বিদ্যুৎ ব্যবহারকারীর নামঃ {{$item->shop_name_bn}} <br>
                        দোকান নম্বরঃ {{$item->shop_new_num}} <br>
                        ঠিকানাঃ সাভার ক্যান্টনমেন্ট বোর্ড সুপার মার্কেট, সাভার, ঢাকা। <br>
                        দোকানের এরিয়াঃ    @if(!empty($item->meter_number)){{$NumBangla->bnNum(number_format($item->area_in_sft))}} বর্গফুট @else  @endif <br>
                        বিদ্যুতিক মিটার নংঃ @if($item->meter_number !=''){{$NumBangla->bnNum($item->meter_number)}}@else  @endif <br>
                        গ্রাহক নংঃ {{$NumBangla->bnNum($item->id)}}
                    </td>
                </tr>
                <tr></tr>
                <tr>
                    <td>তারিখ</td>
                    <td>বিদ্যুৎ খরচের পরিমাণ (ইউনিট)</td>
                    <td>প্রতি ইউনিটের মূল্য</td>
                    <td>টাকার পরিমাণ</td>
                </tr>
                <tr>
                    <td>বর্তমান একক</td>
                    <td>{{$NumBangla->bnNum($item->current_meter_reading)}}</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>পূর্ববর্তী একক</td>
                    <td>{{$NumBangla->bnNum($item->previous_meter_reading)}}</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>ব্যবহৃত ইউনিট</td>
                    <td>{{$NumBangla->bnNum($item->used_unit)}}</td>
                    <td>{{$NumBangla->bnNum($item->billing_rate)}}</td>
                    <td style="text-align: right">{{$NumBangla->bnNum($item->bill_amount)}}</td>
                </tr>
                <tr>
                    <td colspan="3">ডিমান্ড চার্জ (কিলোওয়াট ৫০ টাকা)</td>
                    <td style="text-align: right">{{$NumBangla->bnNum($item->demand_note_amt)}}</td>
                </tr>
                <tr>
                    <td>কমন এরিয়ার ইউনিট</td>
                    <td>{{$NumBangla->bnNum(0)}}</td>
                    <td>{{$NumBangla->bnNum(0)}}</td>
                    <td style="text-align: right">{{$NumBangla->bnNum(0)}}</td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: right;">মোট টাকা</td>
                    <td style="text-align: right">{{$NumBangla->bnNum(($item->demand_note_amt+$item->bill_amount))}}</td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: right;">মূল্য সংযোজন কর মোট টাকার উপর ({{$NumBangla->bnNum($item->vat_rate)}}%)</td>
                    <td style="text-align: right">{{$NumBangla->bnNum($item->vat_amount)}}</td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: right;">পূর্ববর্তী মাসের বকেয়া টাকার পরিমাণ</td>
                    <td style="text-align: right">০</td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: right;">বিলম্ব মাশুল ({{$NumBangla->bnNum($item->penalty_rate)}}%)</td>
                    <td style="text-align: right">{{$NumBangla->bnNum($item->penalty)}}</td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: right;">সর্বমোট টাকা</td>
                    <td style="text-align: right">{{$NumBangla->bnNum($item->total_bill_after_penalty)}}</td>
                </tr>
            </table>
        </div>
        <div class="row">
            <p>বিঃদ্রঃ নির্ধারিত সময়ের পরে বিল পরিশোধ করা হলে ৫% বিলম্ব মাশুল বিলের সাথে পরিশোধ করতে হবে।</p>
        </div>
    </div>
    <div class="col-md-6" >
        <p style="text-align: left;">বিলের মাসঃ {{$item->bill_cycle_name_bn}}, বিল পরিশোধের সর্বশেষ তারিখঃ
            {{$NumBangla->bnNum(number_format(date('d',strtotime($item->due_date))))}}-{{$NumBangla->bnNum(number_format(date('m',strtotime($item->due_date))))}}-{{$NumBangla->bnNum(date('Y',strtotime($item->due_date)))}} ইং</p>
        <div class="row">
            <table width="100%" cellspacing="0" style="table-layout: fixed; padding: 10px;">
                <tr>
                    <td colspan="4" style="font-size: 18px; text-align: center;">সাভার ক্যান্টনমেন্ট বোর্ড সুপার মার্কেট এর বৈদ্যুতিক বিল</td>
                </tr>
                <tr>
                    <td colspan="4">
                        বিদ্যুৎ ব্যবহারকারীর নামঃ {{$item->shop_name_bn}} <br>
                        দোকান নম্বরঃ {{$item->shop_new_num}} <br>
                        ঠিকানাঃ সাভার ক্যান্টনমেন্ট বোর্ড সুপার মার্কেট, সাভার, ঢাকা। <br>
                        দোকানের এরিয়াঃ    @if(!empty($item->meter_number)){{$NumBangla->bnNum(number_format($item->area_in_sft))}} বর্গফুট @else  @endif <br>
                        বিদ্যুতিক মিটার নংঃ @if($item->meter_number !=''){{$NumBangla->bnNum($item->meter_number)}}@else  @endif <br>
                        গ্রাহক নংঃ {{$NumBangla->bnNum($item->id)}}
                    </td>
                </tr>
                <tr></tr>
                <tr>
                    <td>তারিখ</td>
                    <td>বিদ্যুৎ খরচের পরিমাণ (ইউনিট)</td>
                    <td>প্রতি ইউনিটের মূল্য</td>
                    <td>টাকার পরিমাণ</td>
                </tr>
                <tr>
                    <td>বর্তমান একক</td>
                    <td>{{$NumBangla->bnNum($item->current_meter_reading)}}</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>পূর্ববর্তী একক</td>
                    <td>{{$NumBangla->bnNum($item->previous_meter_reading)}}</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>ব্যবহৃত ইউনিট</td>
                    <td>{{$NumBangla->bnNum($item->used_unit)}}</td>
                    <td>{{$NumBangla->bnNum($item->billing_rate)}}</td>
                    <td style="text-align: right">{{$NumBangla->bnNum($item->bill_amount)}}</td>
                </tr>
                <tr>
                    <td colspan="3">ডিমান্ড চার্জ (কিলোওয়াট ৫০ টাকা)</td>
                    <td style="text-align: right">{{$NumBangla->bnNum($item->demand_note_amt)}}</td>
                </tr>
                <tr>
                    <td>কমন এরিয়ার ইউনিট</td>
                    <td>{{$NumBangla->bnNum(0)}}</td>
                    <td>{{$NumBangla->bnNum(0)}}</td>
                    <td style="text-align: right">{{$NumBangla->bnNum(0)}}</td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: right;">মোট টাকা</td>
                    <td style="text-align: right">{{$NumBangla->bnNum(($item->demand_note_amt+$item->bill_amount))}}</td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: right;">মূল্য সংযোজন কর মোট টাকার উপর ({{$NumBangla->bnNum($item->vat_rate)}}%)</td>
                    <td style="text-align: right">{{$NumBangla->bnNum($item->vat_amount)}}</td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: right;">পূর্ববর্তী মাসের বকেয়া টাকার পরিমাণ</td>
                    <td style="text-align: right">০</td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: right;">বিলম্ব মাশুল ({{$NumBangla->bnNum($item->penalty_rate)}}%)</td>
                    <td style="text-align: right">{{$NumBangla->bnNum($item->penalty)}}</td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: right;">সর্বমোট টাকা</td>
                    <td style="text-align: right">{{$NumBangla->bnNum($item->total_bill_after_penalty)}}</td>
                </tr>
            </table>
        </div>
        <div class="row">
            <p>বিঃদ্রঃ নির্ধারিত সময়ের পরে বিল পরিশোধ করা হলে ৫% বিলম্ব মাশুল বিলের সাথে পরিশোধ করতে হবে।</p>
        </div>
    </div>
<div class="row" style="margin-top: 30px;">
    <div class="col-md-6">
        বিল করনিকের  সাক্ষর
    </div>
    <div class="col-md-6">
        উপ-সহকারী প্রকৌশলী <br>
        (পানি ও বিদ্যুৎ) <br>
        সাভার ক্যান্টনমেন্ট বোর্ড।
    </div>
</div>
@endforeach
</body>
</html>
