@extends('frontend.layouts')
{{-- @section('page_title', 'Daily Shop | '.$product->name ) --}}
@section('page_title', 'Daily Shop | Failed')
@section('container')



<!-- product category -->
<section id="aa-product-category">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-8">
                <div>&nbsp;</div>
                <div>&nbsp;</div>
                <h2>Your order has been failed!</h2>
                <h3>Order Status: <strong style="color: #f66666">{{ session()->get('ORDER_STATUS') }}</strong></h3>
                <div>&nbsp;</div>
                <div>&nbsp;</div>
            </div>

        </div>
    </div>
</section>
<!-- / product category -->

@endsection
