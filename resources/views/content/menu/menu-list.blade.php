@extends('layouts.contentLayoutMaster')
@section('title') Menu List @endsection

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
.dropstart .dropdown-menu {
    min-width: 18rem;
    inset:0px 0px auto auto !important;
    transform: translate(-20px, -30px)!important;
}
</style>
@endsection

@section('content')
<section id="ajax-datatable">
  <div class="row">
    <div class="col-12">
      <div class="card border-primary">
        <div class="card-header border-bottom">
          <a href="{{ URL::to('menu-create') }}" class="btn btn-primary btn-sm waves-effect waves-float waves-light">
            <i class="fa fa-plus"></i> Create Menu
          </a>
        </div>
        <div class="card-datatable table-responsive" style="overflow:auto;">
        <table class="datatables-ajax table table-hover text-nowrap">
              <thead>
                <tr class="text-white text-nowrap">
                  <th class="bg-primary">Sl</th>
                  <th class="bg-primary">Main Menu</th>
                  <th class="bg-primary">Sub Menu</th>
                  <th class="bg-primary">Child Menu</th>
                  <th class="bg-primary">Url</th>
                  <th class="bg-primary">Action</th>             
                </tr>
              </thead>
              <tbody>
                  @if($menuList)
                  @foreach($menuList as $item)
                  <tr>
                      <td><span class="badge badge-light-primary">{{$loop->iteration}}</span></td>
                      <td>{{($item->menu_parent_id == null)?$item->menu_name:null}}</td>
                      <td>{{($item->menu_parent_id !== null && $item->sub_menu_id == null)?$item->menu_name:null}}</td>
                      <td>{{($item->is_child == 1)?$item->menu_name:null}}</td>
                      <td>{{substr($item->route_id,0,40)}}</td>
                      <td>
                        <div class="d-flex justify-content-start">
                                <a  href="{{ URL::to('menu-edit/'.$item->id) }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 me-50"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                                </a>
                                <div class="dropstart">
                                    <a href="#" class="dropdown-toggle" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash me-50"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                    </a>
                                    <div class="dropdown-menu p-0" aria-labelledby="dropdownMenuButton">
                                        <div class="card mb-0">
                                            <div class="card-header bg-primary text-white" style="padding:8px;">
                                                Are you sure want to delete<span class="badge badge-light-primary bg-white"></span>?
                                            </div>
                                            <form action="{{url('menu-delete/'.$item->id)}}" method="POST">
                                              @csrf
                                                <div class="card-body p-1 d-flex justify-content-around border-primary rounded-bottom">
                                                    <button type="button" class="btn btn-flat-danger btn-sm border-danger px-2"><i class="fa fa-times"></i></button>
                                                    <button type="submit" class="btn btn-flat-success btn-sm border-success px-2"><i class="fa fa-check"></i></button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          </td>
                  </tr>
                  @endforeach
                  @else
                  @endif
              </tbody>
              <tfoot>
                <tr class="text-nowrap">
                  <th>Sl</th>
                  <th>Main Menu</th>
                  <th>Sub Menu</th>
                  <th>Child Menu</th>
                  <th>Url</th>
                  <th>Action</th>             
                </tr>
              </tfoot>
            </table>
        </div>
      </div>
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
