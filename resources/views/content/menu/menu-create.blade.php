@extends('layouts.contentLayoutMaster')
@section('title') Menu Create @endsection

@section('vendor-style')
  {{-- vendor css files --}}
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
@endsection

@section('page-style')
{{-- Page Css files --}}
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
<link rel="stylesheet" type="text/css" href="{{asset('css/base/plugins/forms/pickers/form-flat-pickr.css')}}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
<style media="screen">
.col-12 .col-md-6{
  margin-top:10px;
}
.icon-list{
  height: auto;
  width: 100%;
  padding: 8px;
}
.input-label{
  height: auto;
  width: 100%;
}
.card-input-element {
    display: none;
}
.card-input:hover {
    cursor: pointer;
}
.card-input-element:checked + .card-input {
    box-shadow: 0 0 1px 1px #2ecc71;
}
.hover-body:hover{
    background: #f9f9f9;
}
</style>
@endsection

@section('content')
<section>
  <div class="row">
    <div class="col-12">
        <form action="{{url('menu-create')}}" method="POST">
          @csrf
          <div class="card border-primary">
            <div class="card-header border-bottom">
              <h4 class="card-title">Create Menu</h4>
              <button type="submit" class="btn btn-primary waves-effect waves-float waves-light"><i class="fa fa-save"></i> Save</button>
            </div>
            <div class="card-body">
                <div class="row">
                  <div class="col-12 col-md-6">
                      <label class="form-label" for="menu_type">Menu Type</label>
                      <select id="menu_type" name="menu_type" class="form-control" required>
                        <option value="">Select Type</option>                        
                        <option value="1">Parent Menu</option>                        
                        <option value="2">Sub Menu</option>                        
                        <option value="3">Child Menu</option>                        
                      </select>
                      @error('menu_type') <span class="error">{{ $message }}</span> @enderror
                  </div>
                  <div class="col-12 col-md-6 text-center" style="padding-top:30px;">
                      <input type="checkbox" id="is_newtab" name="is_newtab" class="form-check-input" value="1"/>
                      <label class="form-label" for="is_newtab"> Open in New-tab</label>
                      @error('is_newtab') <span class="error">{{ $message }}</span> @enderror                      
                  </div>
                  <div class="col-12 col-md-6">
                      <label class="form-label" for="menu_name">Menu Name</label>
                      <input type="text"  id="menu_name" name="menu_name" class="form-control"  required/>
                      @error('menu_name') <span class="error">{{ $message }}</span> @enderror
                  </div>
                  <div class="col-12 col-md-6">
                      <label class="form-label" for="menu_name_bn">Menu Name (bn)</label>
                      <input type="text"  id="menu_name_bn" name="menu_name_bn" class="form-control"  required/>
                      @error('menu_name_bn') <span class="error">{{ $message }}</span> @enderror
                  </div>
                  <div class="col-12 col-md-6 parent_menu">
                      <label class="form-label" for="menu_parent_id">Parent Menu</label>
                      <select id="menu_parent_id" name="menu_parent_id" class="form-control">
                        <option value="">Select</option>
                        @foreach($parent_menu as $item)
                        <option value="{{$item->id}}">{{$item->menu_name}}</option>
                        @endforeach
                      </select>
                      @error('menu_parent_id') <span class="error">{{ $message }}</span> @enderror
                  </div>
                  <div class="col-12 col-md-6 sub_menu">
                      <label class="form-label" for="sub_menu_id">Sub Menu</label>
                      <select id="sub_menu_id" name="sub_menu_id" class="form-control">
                        <option value="">Select</option>
                        @foreach($sub_menu as $row)
                        <option value="{{$row->id}}">{{$row->menu_name}}</option>
                        @endforeach
                      </select>
                      @error('sub_menu_id') <span class="error">{{ $message }}</span> @enderror
                  </div>
                  <div class="col-12 col-md-6">
                      <label class="form-label" for="route_id">Url</label>
                      <input type="text"  id="route_id" name="route_id" class="form-control"  required/>
                      @error('route_id') <span class="error">{{ $message }}</span> @enderror
                  </div>
                  <div class="col-12 col-md-6">
                      <label class="form-label" for="seq_number">Seq</label>
                      <input type="number" id="seq_number" name="seq_number" class="form-control"  required/>
                      @error('seq_number') <span class="error">{{ $message }}</span> @enderror
                  </div>
                  <div class="col-12 col-md-6">
                      <label class="form-label" for="icon_name">Icon Name</label>
                      <div class="input-group">
                        <input type="text" id="icon_name" name="icon_name" class="form-control"  required aria-label="icon_name" aria-describedby="basic-addon2">                        
                        <button type="button" class="btn btn-outline-secondary waves-effect" data-bs-toggle="modal" data-bs-target="#secondary">
                          icon
                        </button>
                      </div>
                      @error('icon_name') <span class="error">{{ $message }}</span> @enderror
                      <!-- Button trigger modal -->
                      <div class="modal fade modal-secondary text-start show" id="secondary" tabindex="-1" aria-labelledby="myModalLabel1660" style="display: block;" aria-modal="true" role="dialog">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="myModalLabel1660">Icon List</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <div class="row">
                              <div class="col-md-2">
                                <label class="input-label">
                                    <input type="radio" name="product" class="card-input-element" value="home" />
                                        <div class="hover-body card-input">
                                          <i data-feather="home" class="icon-list"></i>                                                                      
                                      </div>
                                </label>
                              </div>
                              <div class="col-md-2">
                                <label class="input-label">
                                    <input type="radio" name="product" class="card-input-element" value="archive" />
                                        <div class="hover-body card-input">
                                          <i data-feather="archive" class="icon-list"></i>                                                                      
                                      </div>
                                </label>
                              </div>
                              <div class="col-md-2">
                                <label class="input-label">
                                    <input type="radio" name="product" class="card-input-element" value="award" />
                                        <div class="hover-body card-input">
                                          <i data-feather="award" class="icon-list"></i>                                                                      
                                      </div>
                                </label>
                              </div>
                            </div>
                          </div>
                          <!-- <div class="modal-footer">
                            <button type="button" class="btn btn-secondary waves-effect waves-float waves-light" data-bs-dismiss="modal">Accept</button>
                          </div> -->
                        </div>
                      </div>
                    </div>
                  </div>                 
                </div>
            </div>
          </div>
        </form>
    </div>
  </div>
</section>
@endsection
@section('vendor-script')
{{-- vendor files --}}
   <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
@endsection

@section('page-script')
<script>
$('.modal').hide()
$("input[type='radio']").click(function() {
    if($("input[type='radio'].card-input-element").is(':checked')) {
        var icon_name = $("input[type='radio'].card-input-element:checked").val()  
        $("#icon_name").val(icon_name)
        $(".modal").modal('hide');
    }    
});
$('#menu_type').on('change',function(){
  let val = $(this).val();
  if(val == 1){
    $('.parent_menu').hide();
    $('.sub_menu').hide();
  }else if(val == 2){
    $('.parent_menu').show();
    $('.sub_menu').hide();
  }else if(val == 3){
    $('.parent_menu').show();
    $('.sub_menu').show();
  }else {
    $('.parent_menu').show();
    $('.sub_menu').show();
  }
})
</script>
@endsection
@section('page-script')
    @if(session()->has('server_message'))
        <script>
            toastr.success("{{ session('server_message') }}", 'Success!', {
                closeButton: true,
                tapToDismiss: false
            });
        </script>
    @endif
    @if(session()->has('server_error'))
        <script>
            toastr.error("{{ session('server_error') }}", 'Failed!', {
                closeButton: true,
                tapToDismiss: false
            });
            // location.reload();
        </script>
    @endif
  {{-- Page js files --}}
@endsection
