@extends('admin.layouts')
@section('page_title', 'Manage Size')
@section('size_select', 'active')
@section('container')

<h1>Manage Size</h1>
<a href="{{ route('admin.size') }}">
    <button type="button" class="btn btn-success btn-block mt-2">
        Back
    </button>
</a>
<div class="row m-t-30">
    <div class="col-md-12">

        <div class="card">
            <div class="card-body">

                <form action="{{ route('size.manage_size_process') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="size" class="control-label mb-1">Size</label>
                        <input id="size" name="size" type="text" class="form-control" value="{{ $size }}" aria-required="true" aria-invalid="false" required>
                        @error('size')
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
