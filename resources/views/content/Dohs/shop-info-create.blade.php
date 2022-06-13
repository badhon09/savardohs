@section('title')
{{Config('revenue.label')}} Info
@endsection

@section('vendor-style')
  {{-- vendor css files --}}
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
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
</style>
@endsection

<section>
  <div class="row">
    <div class="col-12">
        <form wire:submit.prevent="Store">
            <div class="card border-primary">
        <div class="card-header border-bottom">
          <h4 class="card-title">Create {{Config('revenue.label')}} Info</h4>
          <button type="submit" class="btn btn-primary waves-effect waves-float waves-light"><i class="fa fa-save"></i> Save</button>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-6">
                    <label class="form-label" for="shopType">Plot Type</label>
                    <select  wire:model="shopType" class="form-select" id="shopType"  name="shopType" >
                        <option value="">-- Select --</option>
                        @foreach($shopTypeList as $item)
                            <option value="{{ $item->id }}">{{ $item->shop_type_name }}</option>
                        @endforeach
                    </select>
                    @error('shopType') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-check m-2">
                        <label class="form-label" for="shutterType">For Common Bill</label>
                        <input type="checkbox" wire:model="shutterType" id="shutterType" name="shutterType" class="form-check-input" disabled/>
                        @error('shutterType') <span class="error">{{ $message }}</span> @enderror
                    </div>                    
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label" for="shopNewNum">Plot Number</label>
                    <input type="text" wire:model="shopNewNum" wire:change="copytoFloor" wire:keydown="copytoFloor" id="shopNewNum" name="shopNewNum" class="form-control"  />
                    @error('shopNewNum') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div class="col-12 col-md-6">
                    <label class="form-label" for="shopNewNumBn">Plot Number (bn)</label>
                    <input type="text" wire:model="shopNewNumBn" id="shopNewNumBn" name="shopNewNumBn" class="form-control"  />
                    @error('shopNewNumBn') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div class="col-12 col-md-6">
                    <label class="form-label" for="modalEditUserLastName">Road Number</label>
                    <input type="text" wire:model="shopName" id="shopName" name="shopName" class="form-control"  />
                    @error('shopName') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div class="col-12 col-md-6">
                    <label class="form-label" for="shopNameBn">Road Number (bn)</label>
                    <input type="text" wire:model="shopNameBn" id="shopNameBn" name="shopName" class="form-control"  />
                    @error('shopNameBn') <span class="error">{{ $message }}</span> @enderror
                </div>   
                                             
                <div class="col-12 col-md-6">
                    <label class="form-label" for="floorNo">Plot Number</label>
                    <input type="text" wire:model="floorNo" id="floorNo" name="floorNo" class="form-control"  disabled/>
                    @error('floorNo') <span class="error">{{ $message }}</span> @enderror
                </div>                
                <div class="col-12 col-md-6">
                    <label class="form-label" for="meterNumber">Sector/Block Number</label>
                    <input type="text" wire:model="meterNumber" id="meterNumber" name="meterNumber" class="form-control"  />
                    @error('meterNumber') <span class="error">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>
      </div>
        </form>

    </div>
  </div>
</section>
@section('vendor-script')
{{-- vendor files --}}
   <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
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
