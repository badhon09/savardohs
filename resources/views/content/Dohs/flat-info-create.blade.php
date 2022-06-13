@extends('layouts.contentLayoutMaster')
@section('title') Flat Info Create @endsection

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
        <form wire:submit.prevent="Store">
            <div class="card border-primary">
        <div class="card-header border-bottom">
          <h4 class="card-title">Add Flat</h4>
          <button type="submit" class="btn btn-primary waves-effect waves-float waves-light"><i class="fa fa-save"></i> Save</button>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-6">
                    <label class="form-label" for="shopType">Select Flat</label>
                    <select  wire:model="shopType" class="form-select" id="shopType"  name="shopType" >
                        <option value="">-- Select --</option>
                    </select>
                    @error('shopType') <span class="error">{{ $message }}</span> @enderror
                </div>
                <!-- <div class="col-12 col-md-6">
                    <div class="form-check m-2">
                        <label class="form-label" for="shutterType">For Common Bill</label>
                        <input type="checkbox" wire:model="shutterType" id="shutterType" name="shutterType" class="form-check-input" disabled/>
                        @error('shutterType') <span class="error">{{ $message }}</span> @enderror
                    </div>                    
                </div> -->
                <!-- <div class="col-12 col-md-6">
                    <label class="form-label" for="shopType">Flat Type</label>
                    <select  wire:model="shopType" class="form-select" id="shopType"  name="shopType" disabled >
                        <option value="">-- Select --</option>
                    </select>
                    @error('shopType') <span class="error">{{ $message }}</span> @enderror
                </div>                 -->
                <div class="col-12 col-md-6">
                    <label class="form-label" for="shopNewNum">Flat Number</label>
                    <input type="text" wire:model="shopNewNum" wire:change="copytoFloor" wire:keydown="copytoFloor" id="shopNewNum" name="shopNewNum" class="form-control"  disabled/>
                    @error('shopNewNum') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div class="col-12 col-md-6">
                    <label class="form-label" for="shopNewNumBn">Flat Number (bn)</label>
                    <input type="text" wire:model="shopNewNumBn" id="shopNewNumBn" name="shopNewNumBn" class="form-control"  disabled/>
                    @error('shopNewNumBn') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div class="col-12 col-md-6">
                    <label class="form-label" for="floorNo">Plot Number</label>
                    <!-- <input type="text" wire:model="floorNo" id="floorNo" name="floorNo" class="form-control"  disabled/>
                    @error('floorNo') <span class="error">{{ $message }}</span> @enderror -->
                    <select  wire:model="shopType" class="form-select" id="shopType"  name="shopType" disabled>
                        <option value="">-- Select --</option>
                    </select>
                </div>
                <div class="col-12 col-md-6">
                    <label class="form-label" for="modalEditUserLastName">Road Number</label>
                    <input type="text" wire:model="shopName" id="shopName" name="shopName" class="form-control" disabled />
                    @error('shopName') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div class="col-12 col-md-6">
                    <label class="form-label" for="shopNameBn">Road Number (bn)</label>
                    <input type="text" wire:model="shopNameBn" id="shopNameBn" name="shopName" class="form-control" disabled />
                    @error('shopNameBn') <span class="error">{{ $message }}</span> @enderror
                </div>   
                                                                             
                <div class="col-12 col-md-6">
                    <label class="form-label" for="meterNumber">Sector/Block Number</label>
                    <input type="text" wire:model="meterNumber" id="meterNumber" name="meterNumber" class="form-control"  disabled/>
                    @error('meterNumber') <span class="error">{{ $message }}</span> @enderror
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
