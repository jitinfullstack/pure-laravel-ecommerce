@extends('admin.layouts')
@section('page_title', 'Manage Home Banner')
@section('home_banner_select', 'active')
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

<h1>Manage Home Banner</h1>
<a href="{{ route('admin.home_banner') }}">
    <button type="button" class="btn btn-success btn-block mt-2">
        Back
    </button>
</a>
<div class="row m-t-30">
    <div class="col-md-12">

        <div class="card">
            <div class="card-body">

                <form action="{{ route('home_banner.manage_home_banner_process') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <div class="row">

                            <div class="col-md-6">
                                <label for="btn_text" class="control-label mb-1">Button Text</label>
                                <input id="btn_text" name="btn_text" type="text" class="form-control" value="{{ $btn_text }}" aria-required="true" aria-invalid="false">
                                @error('btn_text')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="btn_link" class="control-label mb-1">Button Link</label>
                                <input id="btn_link" name="btn_link" type="text" class="form-control" value="{{ $btn_link }}" aria-required="true" aria-invalid="false">
                                @error('btn_link')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <label for="image" class="control-label mb-1">Image</label>
                                <input id="image" name="image" type="file" class="form-control" aria-required="true" aria-invalid="false" {{$image_required}}>
                                @if ($image)
                                    <img src="{{ asset('storage/media/banner') }}/{{ $image }}" width="100px" class="mt-2">
                                @endif
                                @error('image')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
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
