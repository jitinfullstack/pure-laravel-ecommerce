@extends('admin.layouts')
@section('page_title', 'Manage Tax')
@section('tax_select', 'active')
@section('container')

<h1>Manage Tax</h1>
<a href="{{ route('admin.tax') }}">
    <button type="button" class="btn btn-success btn-block mt-2">
        Back
    </button>
</a>
<div class="row m-t-30">
    <div class="col-md-12">

        <div class="card">
            <div class="card-body">

                <form action="{{ route('tax.manage_tax_process') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="tax_value" class="control-label mb-1">Tax Value</label>
                        <input id="tax_value" name="tax_value" type="text" class="form-control" value="{{ $tax_value }}" aria-required="true" aria-invalid="false" required>
                        @error('tax_value')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="tax_description" class="control-label mb-1">Tax Description</label>
                        <input id="tax_description" name="tax_description" type="text" class="form-control" value="{{ $tax_description }}" aria-required="true" aria-invalid="false" required>
                        @error('tax_description')
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
