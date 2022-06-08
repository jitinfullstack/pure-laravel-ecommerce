@extends('admin.layouts')
@section('page_title', 'Manage Color')
@section('color_select', 'active')
@section('container')

<h1>Manage Color</h1>
<a href="{{ route('admin.color') }}">
    <button type="button" class="btn btn-success btn-block mt-2">
        Back
    </button>
</a>
<div class="row m-t-30">
    <div class="col-md-12">

        <div class="card">
            <div class="card-body">

                <form action="{{ route('color.manage_color_process') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="color" class="control-label mb-1">Color</label>
                        <input id="color" name="color" type="text" class="form-control" value="{{ $color }}" aria-required="true" aria-invalid="false" required>
                        @error('color')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
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
