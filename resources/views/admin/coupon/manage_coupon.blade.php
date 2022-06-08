@extends('admin.layouts')
@section('page_title', 'Manage Coupon')
@section('coupon_select', 'active')
@section('container')

<h1>Manage Coupon</h1>
<a href="{{ route('admin.coupon') }}">
    <button type="button" class="btn btn-success btn-block mt-2">
        Back
    </button>
</a>
<div class="row m-t-30">
    <div class="col-md-12">

        <div class="card">
            <div class="card-body">

                <form action="{{ route('coupon.manage_coupon_process') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="title" class="control-label mb-1">Coupon Title</label>
                                <input id="title" name="title" type="text" class="form-control" value="{{ $title }}" aria-required="true" aria-invalid="false" required>
                                @error('title')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="code" class="control-label mb-1">Coupon Code</label>
                                <input id="code" name="code" type="text" class="form-control" value="{{ $code }}" aria-required="true" aria-invalid="false" required>
                                @error('code')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">

                            <div class="col-md-6">
                                <label for="value" class="control-label mb-1">Coupon Value</label>
                                <input id="value" name="value" type="text" class="form-control" value="{{ $value }}" aria-required="true" aria-invalid="false" required>
                                @error('value')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="type" class="control-label mb-1">Coupon Type</label>
                                <select id="type" name="type" class="form-control" required>
                                    @if ($type == 'percent')
                                        <option selected value="percent">Percentage</option>
                                        <option value="value">Value</option>
                                    @else
                                        <option value="percent">Percentage</option>
                                        <option selected value="value">Value</option>
                                    @endif
                                </select>
                            </div>

                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">

                            <div class="col-md-6">
                                <label for="min_order_amount" class="control-label mb-1">Min Order Amount</label>
                                <input id="min_order_amount" name="min_order_amount" type="text" class="form-control" value="{{ $min_order_amount }}" aria-required="true" aria-invalid="false" required>

                            </div>

                            <div class="col-md-6">
                                <label for="is_one_time" class="control-label mb-1">Is One Time</label>
                                <select id="is_one_time" name="is_one_time" class="form-control" required>
                                    @if ($is_one_time == '1')
                                        <option selected value="1">Yes</option>
                                        <option value="0">No</option>
                                    @else
                                        <option value="1">Yes</option>
                                        <option selected value="0">No</option>
                                    @endif
                                </select>
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
