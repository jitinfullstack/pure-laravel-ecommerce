@extends('frontend.layouts')
@section('page_title', 'Daily Shop | Cart')
@section('container')

<!-- catg header banner section -->
<section id="aa-catg-head-banner">
    <img src="{{ asset('frontend_assets/img/fashion/fashion-header-bg-8.jpg') }}" alt="fashion img">
    <div class="aa-catg-head-banner-area">
      <div class="container">
       <div class="aa-catg-head-banner-content">
         <h2>Cart Page</h2>
         <ol class="breadcrumb">
           <li><a href="index.html">Home</a></li>
           <li class="active">Cart</li>
         </ol>
       </div>
      </div>
    </div>
   </section>
   <!-- / catg header banner section -->

  <!-- Cart view section -->
  <section id="cart-view">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="cart-view-area">
            <div class="cart-view-table">
              <form action="">
                  @php

                   $totalPrice = 0;
                   $subtotal = 0;
                   $total = 0;

                  @endphp

                @if (isset($list[0]))

                <div class="table-responsive">
                   <table class="table">
                     <thead>
                       <tr>
                         <th></th>
                         <th></th>
                         <th>Product</th>
                         <th>Price</th>
                         <th>Quantity</th>
                         <th>Total</th>
                       </tr>
                     </thead>
                     <tbody>
                       @foreach ($list as $data)

                       @php
                            $totalPrice = $totalPrice + ($data->price * $data->quantity)
                        @endphp

                        <tr id="cart_box{{ $data->attr_id }}">
                            <td><a class="remove" href="javascript:void(0)" onclick="deleteCartProduct('{{ $data->pid }}', '{{ $data->size }}', '{{ $data->color }}', '{{ $data->attr_id }}')"><i class="fa fa-close"></i></a></td>
                            <td><a href="{{ url('product') }}/{{ $data->slug }}"><img src="{{ asset('storage/media') }}/{{ $data->image }}" alt="img"></a></td>
                            <td><a class="aa-cart-title" href="{{ url('product') }}/{{ $data->slug }}">{{ $data->name }}</a>
                            @if ($data->size != '')
                                <br><p class="size_cart">Size: {{ $data->size }}</p>
                            @endif

                            @if ($data->color != '')
                                <p class="color_cart">Color: {{ $data->color }}</p>
                            @endif
                            </td>
                            <td>Rs. {{ $data->price }}</td>
                            <td><input class="aa-cart-quantity" type="number" id="qty{{ $data->attr_id }}" value="{{ $data->quantity }}" onchange="updateQty('{{ $data->pid }}', '{{ $data->size }}', '{{ $data->color }}', '{{ $data->attr_id }}', '{{ $data->price }}')"></td>
                            <td id="total_price_{{ $data->attr_id }}">Rs. {{ $data->price * $data->quantity }}</td>
                        </tr>
                       @endforeach

                        <tr>
                            <td colspan="6" class="aa-cart-view-bottom">
                            {{-- <div class="aa-cart-coupon">
                                <input class="aa-coupon-code" type="text" placeholder="Coupon">
                                <input class="aa-cart-view-btn" type="submit" value="Apply Coupon">
                            </div> --}}
                            <a class="aa-cart-view-btn" value="Checkout" href="{{ route('checkout') }}">Checkout</a>
                            </td>
                        </tr>

                       </tbody>
                   </table>
                 </div>
                 @else
                    <h3 style="text-align: center;margin-top:50px;margin-bottom:50px; text-decoration:underline;"><a class="aa-cart-title" href="javascript:void(0)">No Item Found in Cart!</a></h3>
                 @endif
              </form>
              <!-- Cart Total view -->
              <div class="cart-view-total">
                <h4>Cart Totals</h4>
                <table class="aa-totals-table">
                  <tbody>
                    <tr>
                      <th>Subtotal</th>

                      @php
                        //   $totalPrice = $totalPrice  + ((count()->id) * ($data->quantity * $data->price))
                        //   $subtotal = $totalPrice + $subtotal
                        // $subtotal = ($data->price * $data->quantity)
                        // $total = $subtotal + ($data->price)
                      @endphp

                      <td>Rs. {{ $subtotal }}</td>
                    </tr>
                    <tr>
                      <th>Total</th>
                      <td>Rs. {{ $totalPrice }}</td>
                    </tr>
                  </tbody>
                </table>
                <a class="aa-cart-view-btn" href="{{ route('checkout') }}">Proced to Checkout</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- / Cart view section -->


   <!-- Subscribe section -->
   <section id="aa-subscribe">
     <div class="container">
       <div class="row">
         <div class="col-md-12">
           <div class="aa-subscribe-area">
             <h3>Subscribe our newsletter </h3>
             <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ex, velit!</p>
             <form action="" class="aa-subscribe-form">
               <input type="email" name="" id="" placeholder="Enter your Email">
               <input type="submit" value="Subscribe">
             </form>
           </div>
         </div>
       </div>
     </div>
   </section>
   <!-- / Subscribe section -->

   <input type="hidden" id="qty" value="1" />
  <form id="formAddToCart">
    <input type="hidden" id="size_id" name="size_id"/>
    <input type="hidden" id="color_id" name="color_id"/>
    <input type="hidden" id="pqty" name="pqty"/>
    <input type="hidden" id="product_id" name="product_id"/>
    @csrf
</form>

@endsection
