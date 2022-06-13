@extends('layouts/contentLayoutMaster')

@section('title', 'Electric Bill Report Monthly')
@section('content')
    <section>
        <div class="row">
            <div class="col-12">
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div>{{$error}}</div>
                    @endforeach
                @endif
                <form action="{{URL::to('month_wise_sena_market_revenue_pdf')}}" enctype="multipart/form-data" target="_blank">
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
                                <label for="billing_cycle">Shop No:</label>
                                <select name="shop_no" id="shop_no" class="form-control">
                                    <option value="">Select Shop No</option>
                                    @foreach($shop as $row)
                                        <option value="{{$row->shop_id}}">{{$row->shop_new_num}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-md-3">
                                <label for="limit">Limit</label>
                                <select name="limit" id="limit" class="form-control">
                                    <option value="">Select Report Limit</option>
                                    <option value="100">100</option>
                                    <option value="200">200</option>
                                    <option value="500">500</option>
                                    <option value="1000">1000</option>
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
