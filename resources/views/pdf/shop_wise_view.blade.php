@extends('layouts/contentLayoutMaster')

@section('title', 'Electric Bill Shop By Monthly')
@section('content')
    <section>
        <div class="row">
            <div class="col-12">
                <form action="{{URL::to('electric_bill_shop_wise')}}" enctype="multipart/form-data" target="_blank">
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
                                <select name="shop_no" id="shop_no" class="form-control" required="required">
                                    <option value="">Select Shop No</option>
                                    @foreach($shop as $row)
                                        <option value="{{$row->shop_id}}">{{$row->shop_new_num}}</option>
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
