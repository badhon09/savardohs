@extends('layouts/contentLayoutMaster')

@section('title', 'Electric Bill Report By Meter Number')
@section('content')
    <section>
        <div class="row">
            <div class="col-12">
                <form action="{{URL::to('electric_bill_report_by_meter')}}" enctype="multipart/form-data" target="_blank">
                    <div class="card border-primary">
                        <div class="row card-body">
                            <div class="col-12 col-md-3">
                                <label for="billing_cycle">Billing Cycle:</label>
                                <select name="billing_cycle" id="billing_cycle" class="form-control" required="required">
                                    <option value="">Select Billing Cycle</option>
                                    @foreach($bill_cycle as $row)
                                        <option value="{{$row->bill_cycle_id}}">{{$row->bill_cycle_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-md-3">
                                <label for="bc_id">Meter No.:</label>
                                <select name="meter_no" id="meter_no" class="form-control" required="required">
                                    <option value="">Select Meter No.</option>
                                    @foreach($meter as $row)
                                        <option value="{{$row->meter_number}}">{{$row->shop_name}} - {{$row->meter_number}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 my-auto">
                                <button class="btn btn-primary" id="submit" type="submit"  style="margin-top: 18px;">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
