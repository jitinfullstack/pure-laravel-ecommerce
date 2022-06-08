@extends('frontend.layouts')
{{-- @section('page_title', 'Daily Shop | '.$product->name ) --}}
@section('page_title', 'Daily Shop | Checkout')
@section('container')


<!-- catg header banner section -->
<section id="aa-catg-head-banner">
    <img src="{{ asset('frontend_assets/img/fashion/fashion-header-bg-8.jpg') }}" alt="fashion img">
    {{-- <img src="{{ asset('frontend') }}" alt="fashion img"> --}}
    <div class="aa-catg-head-banner-area">
     <div class="container">
      <div class="aa-catg-head-banner-content">
        <h2>Checkout Page</h2>
        <ol class="breadcrumb">
          <li><a href="index.html">Home</a></li>
          <li class="active">Checkout</li>
        </ol>
      </div>
     </div>
   </div>
  </section>
  <!-- / catg header banner section -->

 <!-- Cart view section -->
 <section id="checkout">
   <div class="container">
     <div class="row">
       <div class="col-md-12">
        <div class="checkout-area">
          <form id="frmPlaceOrder">
            <div class="row">
              <div class="col-md-8">
                <div class="checkout-left">
                  <div class="panel-group" id="accordion">

                    @if (session()->has('FRONT_USER_LOGIN') == null)

                    <input type="button" value="Login" class="aa-browse-btn" data-toggle="modal" data-target="#login-modal">

                    <br><br>
                    OR
                    <br><br>

                    @endif

                    <!-- Billing Details -->
                    <div class="panel panel-default aa-checkout-billaddress">
                      <div class="panel-heading">
                        <h4 class="panel-title">
                          <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                            Billing Details
                          </a>
                        </h4>
                      </div>
                      <div id="collapseTwo" class="panel-collapse collapse in">

                        <div class="panel-body">
                          <div class="row">
                            <div class="col-md-12">
                              <div class="aa-checkout-single-bill">
                                <input type="text" placeholder="Full Name*" value="{{ $customers['name'] }}" name="name" required>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="aa-checkout-single-bill">
                                <input type="email" placeholder="Email Address*" value="{{ $customers['email'] }}" name="email" required>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="aa-checkout-single-bill">
                                <input type="tel" placeholder="Phone*" value="{{ $customers['mobile'] }}" name="mobile" required>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-12">
                              <div class="aa-checkout-single-bill">
                                <textarea cols="8" rows="3" name="address" required>{{ $customers['address'] }}</textarea>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-4">
                              <div class="aa-checkout-single-bill">
                                <input type="text" placeholder="City / Town*" value="{{ $customers['city'] }}" name="city" required>
                              </div>
                            </div>

                            <div class="col-md-4">
                              <div class="aa-checkout-single-bill">
                                <input type="text" placeholder="State*" value="{{ $customers['state'] }}" name="state" required>
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="aa-checkout-single-bill">
                                <input type="text" placeholder="Postcode / ZIP*" value="{{ $customers['zipcode'] }}" name="zipcode" required>
                              </div>
                            </div>
                          </div>
                        </div>

                      </div>
                    </div>

                    <!-- Shipping Address -->
                    <div class="panel panel-default aa-checkout-billaddress">
                      <div class="panel-heading">
                        <h4 class="panel-title">
                          <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                            Shippping Address
                          </a>
                        </h4>
                      </div>
                      <div id="collapseThree" class="panel-collapse collapse">
                        <div class="panel-body">
                         <div class="row">
                            <div class="col-md-6">
                              <div class="aa-checkout-single-bill">
                                <input type="text" placeholder="First Name*">
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="aa-checkout-single-bill">
                                <input type="text" placeholder="Last Name*">
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-12">
                              <div class="aa-checkout-single-bill">
                                <input type="text" placeholder="Company name">
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="aa-checkout-single-bill">
                                <input type="email" placeholder="Email Address*">
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="aa-checkout-single-bill">
                                <input type="tel" placeholder="Phone*">
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-12">
                              <div class="aa-checkout-single-bill">
                                <textarea cols="8" rows="3">Address*</textarea>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-12">
                              <div class="aa-checkout-single-bill">
                                <select>
                                  <option value="0">Select Your Country</option>
                                  <option value="1">Australia</option>
                                  <option value="2">Afganistan</option>
                                  <option value="3">Bangladesh</option>
                                  <option value="4">Belgium</option>
                                  <option value="5">Brazil</option>
                                  <option value="6">Canada</option>
                                  <option value="7">China</option>
                                  <option value="8">Denmark</option>
                                  <option value="9">Egypt</option>
                                  <option value="10">India</option>
                                  <option value="11">Iran</option>
                                  <option value="12">Israel</option>
                                  <option value="13">Mexico</option>
                                  <option value="14">UAE</option>
                                  <option value="15">UK</option>
                                  <option value="16">USA</option>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="aa-checkout-single-bill">
                                <input type="text" placeholder="Appartment, Suite etc.">
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="aa-checkout-single-bill">
                                <input type="text" placeholder="City / Town*">
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="aa-checkout-single-bill">
                                <input type="text" placeholder="District*">
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="aa-checkout-single-bill">
                                <input type="text" placeholder="Postcode / ZIP*">
                              </div>
                            </div>
                          </div>
                           <div class="row">
                            <div class="col-md-12">
                              <div class="aa-checkout-single-bill">
                                <textarea cols="8" rows="3">Special Notes</textarea>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- Coupon section -->
                    {{-- <div class="panel panel-default aa-checkout-coupon">
                        <div class="panel-heading">
                          <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour">
                              Have a Coupon?
                            </a>
                          </h4>
                        </div>
                        <div id="collapseFour" class="panel-collapse collapse">
                          <div class="panel-body">
                            <input type="text" placeholder="Coupon Code" class="aa-coupon-code">
                            <input type="submit" value="Apply Coupon" class="aa-browse-btn">
                          </div>
                        </div>
                      </div> --}}

                  </div>

                </div>
              </div>
              <div class="col-md-4">
                <div class="checkout-right">
                  <h4>Order Summary</h4>
                  <div class="aa-order-summary-area">
                    <table class="table table-responsive">
                      <thead>
                        <tr>
                          <th>Product</th>
                          <th>Total</th>
                        </tr>
                      </thead>
                      <tbody>
                        @php
                            $totalPrice = 0;
                        @endphp
                        @foreach ($cart_data as $product)
                        @php
                            $totalPrice = $totalPrice + ($product->price * $product->quantity)
                        @endphp
                        <tr>
                          <td style="color:#FF6666">{{ $product->name }} <strong> x  {{ $product->quantity }}</strong>
                            @if ($product->color != '')
                                <p class="color_cart" style="margin-top: 2px;">{{ $product->color }}</p>
                            @endif
                          </td>
                          <td>Rs. {{ $product->price * $product->quantity}}</td>
                        </tr>

                        @endforeach
                      </tbody>
                      <tfoot>
                        <tr class="hide show_coupon_box">
                          <th>Coupon Code <a href="javascript:void(0)" onclick="remove_coupon_code()" class="ml-2"><i class="fa fa-times text-danger"></i></a></th>
                          <td id="coupon_code_str"></td>
                        </tr>
                         {{-- <tr class="hide show_coupon_box">
                          <th>Coupon Code Value</th>
                          <td id="coupon_code_value"></td>
                        </tr> --}}
                         <tr>
                          <th>Total</th>
                          <td id="total_price">Rs. {{ $totalPrice }}</td>
                        </tr>
                      </tfoot>
                    </table>
                  </div>

                  <h4>Coupon Code</h4>
                  <div class="aa-payment-method">
                    <input type="text" placeholder="Coupon Code" class="aa-coupon-code apply_coupon_code_box" name="coupon_code" id="coupon_code">
                    <input type="button" onclick="applyCouponCode()" value="Apply Coupon" class="aa-coupon-btn apply_coupon_code_box">
                    <div id="coupon_code_msg"></div>
                  </div>

                  <br><br>

                  <h4>Payment Method</h4>
                  <div class="aa-payment-method">
                    <label for="cod"><input type="radio" id="cod" name="payment_type" value="COD" checked> Cash on Delivery </label>
                    <label for="instamojo"><input type="radio" id="instamojo" name="payment_type" value="Online"> Via Instamojo </label>
                    <img src="https://www.paypalobjects.com/webstatic/mktg/logo/AM_mc_vs_dc_ae.jpg" border="0" alt="PayPal Acceptance Mark">
                    <input type="submit" value="Place Order" class="aa-browse-btn" id="btnPlaceOrder">
                  </div>

                  <div id="order_place_msg"></div>

                </div>
              </div>
            </div>
            @csrf
          </form>
         </div>
       </div>
     </div>
   </div>
 </section>
 <!-- / Cart view section -->

@endsection
