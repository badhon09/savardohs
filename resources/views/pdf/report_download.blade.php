@extends('layouts/contentLayoutMaster')

@section('title', 'Electric Bill Report Generate')
@section('content')
    <section>
        <div class="row">
            <div class="col-12">
                <form action="" enctype="multipart/form-data">
                    <div class="card border-primary">
                        <div class="row card-body">
                            <div class="col-12 col-md-3">
                                <label for="bc_id">Billing Cycle:</label>
                                <select onchange="bill_cycle_val()" name="bc_id" id="bc_id" class="form-control" required="required">
                                    <option value="">Select Billing Cycle</option>
                                    @foreach($bill_cycle_data as $row)
                                        <option value="{{$row->bill_cycle_id}}">{{$row->bill_cycle_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 my-auto">
                                <button onclick="ajaxReq()" class="btn btn-primary" id="submit" type="submit" disabled  style="margin-top: 18px;">Submit</button>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div id="message" style="margin-top: 18px; display: none;">

                                        </div>
                                    </div>
                                    <div class="col-md-5" id="download" style="margin-top: 18px; display: none;">

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <script>
        function bill_cycle_val()
        {
            var bc_id = $('#bc_id').val();
            if(bc_id == '')
            {
                $('#submit').attr('disabled',true);
            }
            else
            {
                $('#submit').removeAttr('disabled');
            }
        }
        function ajaxReq()
        {
            event.preventDefault();
            var dep_id = '2';
            var rev_id ='6';
            var bc_id = $('#bc_id').val();
            $.ajax({
                method:"GET",
                url:"{{URL::to('get-data-by-bcID')}}",
                data: {revId: rev_id, bcId: bc_id, dep_id:dep_id},
                success:function(res){
                    var i = 0;
                    var data = res.data;
                    var length = res.data.length;
                    setInterval(function ()
                    {
                        if(i<length)
                        {
                            pdfReq(data[i].pc_id,i,length,bc_id);
                            i = i+1;
                        }

                    },3000)
                },
                error:function(err){
                    console.log(err);
                }
            });
        }
        function pdfReq(pc_id,i,length,bc_id)
        {
            $.ajax({
                method:"GET",
                url:"{{URL::to('electric_bill_report?pc_id=')}}"+pc_id,
                success:function (newres) {
                    var j=i+1;
                    if(j == length)
                    {
                        var status = true;
                    }
                    $('#message').show();
                    if(status)
                    {
                        var url="{{URL::to('download-zip?bc_id=')}}"+bc_id;
                        $('#download').show();
                        $('#download').html('<a href="'+url+'" class="btn btn-danger">Download Zip</a>')
                        $('#message').html('<a class="btn btn-success">Genarate Complete ' +j+ ' of ' + length +'</a>');
                    }
                    else
                    {
                        // $('#download').show();
                        // $('#download').html('<button onclick="cancelReq('+bc_id+')" class="btn btn-danger" id="cancel">Cancel</button>')
                        $('#message').html('<a class="btn btn-success">Generated ' +j+ ' of ' + length +'</a>');
                    }
                },
                error:function (err)
                {
                    console.log(err)
                }
            });
        }
    </script>
@endsection
