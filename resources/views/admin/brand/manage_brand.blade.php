@extends('admin.layouts')
@section('page_title', 'Manage Brand')
@section('brand_select', 'active')
@section('container')

@if($id>0)
    @php
        $image_required=""
    @endphp
@else
    @php
        $image_required="required"
    @endphp
@endif

<h1>Manage Brand</h1>
<a href="{{ route('admin.brand') }}">
    <button type="button" class="btn btn-success btn-block mt-2">
        Back
    </button>
</a>
@error('image')
    <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
        <span class="badge badge-pill badge-danger">Warning</span>
        {{ $message }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
@enderror
<div class="row m-t-30">
    <div class="col-md-12">

        <div class="card">
            <div class="card-body">

                <form action="{{ route('brand.manage_brand_process') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <div class="row align-items-top">
                            <div class="col-md-4">
                                <label for="name" class="control-label mb-1">Brand Name</label>
                                <input id="name" name="name" type="text" class="form-control" value="{{ $name }}" aria-required="true" aria-invalid="false" required>
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="image" class="control-label mb-1">Brand Image</label>
                                <input id="image" name="image" type="file" class="form-control" aria-required="true" aria-invalid="false">
                                @if ($image)
                                    <img src="{{ asset('storage/media/brand') }}/{{ $image }}" width="100px" class="mt-2">
                                @endif
                                @error('image')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mt-4">
                                <label for="is_home" class="control-label mb-1">Show in Home Page</label>
                                <input id="is_home" name="is_home" type="checkbox" class="mr-2 mt-2 float-left" {{ $is_home_selected }}>

                            </div>
                        </div>
                    </div>
                    <div>
                        <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                            <span id="payment-button-amount">Submit</span>
                            <span id="payment-button-sending" style="display:none;">Sending…</span>
                        </button>
                    </div>
                    <input type="hidden" name="id" value="{{ $id }}"/>
                </form>
            </div>

        </div>

    </div>

</div>
@endsection
