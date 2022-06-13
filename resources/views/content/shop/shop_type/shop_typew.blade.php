@extends('layouts/contentLayoutMaster')

@section('title', 'Shop Type')

@section('vendor-style')
  {{-- vendor css files --}}
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
@endsection

@section('page-style')
{{-- Page Css files --}}
<link rel="stylesheet" type="text/css" href="{{asset('css/base/plugins/forms/pickers/form-flat-pickr.css')}}">
@endsection


@section('content')
<!-- Ajax Sourced Server-side -->

<section id="ajax-datatable">
  <div class="row">
    <div class="col-12">
      <div class="card border-primary">
        <div class="card-header border-bottom">
          <h4 class="card-title">Ajax Sourced Server-side</h4>
          <button type="button" class="btn btn-primary btn-sm waves-effect waves-float waves-light" data-bs-toggle="modal" data-bs-target="#editUser"><i class="ficon" data-feather="plus"></i> Add New</button>
          <!-- Edit User Modal -->
          <div class="modal fade" id="editUser" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
              <div class="modal-content">
                <div class="modal-header bg-transparent">
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-5 px-sm-5 pt-50">
                  <div class="text-center mb-2">
                    <h1 class="mb-1">Edit User Information</h1>
                    <p>Updating user details will receive a privacy audit.</p>
                  </div>
                  <form id="editUserForm" class="row gy-1 pt-75" onsubmit="return false">
                    <div class="col-12 col-md-6">
                      <label class="form-label" for="modalEditUserFirstName">Type name</label>
                      <input
                        type="text"
                        id="modalEditUserFirstName"
                        name="modalEditUserFirstName"
                        class="form-control"
                        placeholder=""
                        value=""
                        data-msg="Please enter your first name"
                      />
                    </div>
                    <div class="col-12 col-md-6">
                      <label class="form-label" for="modalEditUserLastName">Type name (bn)</label>
                      <input
                        type="text"
                        id="modalEditUserLastName"
                        name="modalEditUserLastName"
                        class="form-control"
                        placeholder=""
                        value=""
                        data-msg="Please enter your last name"
                      />
                    </div>
                    <div class="col-12 text-center mt-2 pt-50">
                      <button type="submit" class="btn btn-primary me-1">Submit</button>
                      <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">
                        Discard
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <!--/ Edit User Modal -->
        </div>
        <div class="card-datatable">
          <table class="datatables-ajax table table-responsive">
            <thead>
              <tr class="text-white">
                <th class="bg-primary">Type name</th>
                <th class="bg-primary">Type name(bn)</th>
                <th class="bg-primary">Created By</th>
                <th class="bg-primary">Updated By</th>
                <th class="bg-primary">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>demo</td>
                <td>demo</td>
                <td>demo</td>
                <td>demo</td>
                <td>
                  <div class="dropdown">
                      <button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0 waves-effect waves-float waves-light" data-bs-toggle="dropdown" aria-expanded="false">
                          <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                      </button>
                      <div class="dropdown-menu dropdown-menu-end" style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(-92px, 16px);" data-popper-placement="bottom-end">
                          <a class="dropdown-item" href="{{url('update_shop_type/1')}}">
                              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 me-50"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                              <span>Edit</span>
                          </a>
                          <a class="dropdown-item" href="#">
                              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash me-50"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                              <span>Delete</span>
                          </a>
                      </div>
                    </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>

<!--/ Ajax Sourced Server-side -->

@endsection


@section('vendor-script')
{{-- vendor files --}}
  <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
@endsection

@section('page-script')
  {{-- Page js files --}}
  <!-- <script src="{{ asset(mix('js/scripts/tables/table-datatables-advanced.js')) }}"></script> -->
@endsection
