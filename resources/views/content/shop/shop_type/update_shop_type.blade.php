@extends('layouts/contentLayoutMaster')

@section('title', 'Update Shop Type')

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

<section>
  <div class="row">
    <div class="col-12">
      <div class="card border-primary">
        <div class="card-header border-bottom">
          <h4 class="card-title">Update Shop Type</h4>
          <button type="button" class="btn btn-primary waves-effect waves-float waves-light" data-bs-toggle="modal" data-bs-target="#editUser"><i class="ficon" data-feather="arrow-right"></i> Update</button>
        </div>
        <div class="card-body">
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
            <!-- <div class="col-12 text-center mt-2 pt-50">
              <button type="submit" class="btn btn-primary me-1">Submit</button>
              <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">
                Discard
              </button>
            </div> -->
          </form>
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
