@extends('layouts/contentLayoutMaster')

@section('title', 'Electric Bill Shop By Monthly')
@section('content')
    <section>
        <div class="row">
            <div class="col-12">
                <form action="{{URL::to('electric_bill_shop_wise_view_shop_pdf')}}" enctype="multipart/form-data" target="_blank">
                    <div class="card border-primary">
                        <div class="row card-body">
                            <div class="col-12 col-md-3">
                                <label for="billing_cycle">Billing Cycle:</label>
                                <select name="billing_cycle" id="billing_cycle" class="form-control" required="required">
                                    <option value="">Select Billing Cycle</option>
                                    @foreach($data as $row)
                                        <option value="{{$row->bill_cycle_id}}">{{$row->bill_cycle_name}}</option>
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
