@extends('frontend.layouts')
@section('page_title', 'Daily Shop | Order Details')
@section('container')

<!-- catg header banner section -->
<section id="aa-catg-head-banner">
    <img src="{{ asset('frontend_assets/img/fashion/fashion-header-bg-8.jpg') }}" alt="fashion img">
    <div class="aa-catg-head-banner-area">
      <div class="container">
       <div class="aa-catg-head-banner-content">
         <h2>Details Page</h2>
         <ol class="breadcrumb">
           <li><a href="index.html">Home</a></li>
           <li class="active">Details</li>
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

        <div class="col-md-6">
            <div class="order_detail">
                <h3>Details Address</h3>
                {{ $order_details[0]->name }} ({{ $order_details[0]->mobile }})<br>
                {{ $order_details[0]->address }}<br>
                {{ $order_details[0]->city }}<br>
                {{ $order_details[0]->state }}<br>
                {{ $order_details[0]->zipcode }}
            </div>
        </div>

        <div class="col-md-6">
            <div class="order_detail">

                <h3>Order Details</h3>
                Order Status: {{ $order_details[0]->order_status }}<br>
                Payment Status: {{ $order_details[0]->payment_status }}<br>
                Payment Type: {{ $order_details[0]->payment_type }}<br>

                <?php
                    if($order_details[0]->payment_id != ''){
                        echo 'Payment Id: '.$order_details[0]->payment_id .'<br>';
                    }
                ?>

                <?php
                    if($order_details[0]->track_details != ''){
                        echo 'Track Details: '.$order_details[0]->track_details .'<br>';
                    }
                ?>

                {{-- Track Details: {{ $order_details[0]->track_details }}<br> --}}

            </div>
        </div>

      </div>

      <div class="row">

        <div class="col-md-12">
          <div class="cart-view-area">

            <div class="cart-view-table">
              <form action="">

                <div class="table-responsive">
                   <table class="table">
                     <thead>
                       <tr>
                         <th>Product</th>
                         <th>Image</th>
                         <th>Size</th>
                         <th>Color</th>
                         <th>Price</th>
                         <th>Qunatity</th>
                         <th>Total</th>
                       </tr>
                     </thead>
                     <tbody>
                         @php
                             $totalAmount = 0;
                         @endphp
                        @foreach ($order_details as $order_detail)
                        @php
                             $totalAmount = $totalAmount + ($order_detail->price * $order_detail->quantity);
                         @endphp
                        <tr>
                            <td>{{ $order_detail->pname }}</td>
                            <td><img src="{{ asset('storage/media/'.$order_detail->attr_image) }}" alt="{{ $order_detail->name }}"></td>
                            <td>{{ $order_detail->size }}</td>
                            <td>{{ $order_detail->color }}</td>
                            <td>Rs. {{ $order_detail->price }}</td>
                            <td>{{ $order_detail->quantity }}</td>
                            <td>Rs. {{ $order_detail->price * $order_detail->quantity }}</td>

                        </tr>
                        @endforeach

                        <tr>
                            <td colspan="5">&nbsp;</td>
                            <td><strong>Total </strong></td>
                            <td><strong>Rs. {{ $totalAmount }}</strong></td>
                        </tr>


                        <?php
                        if($order_details[0]->coupon_value>0){

                            echo '<tr>
                                    <td colspan="5">&nbsp;</td>
                                    <td><strong>Coupon <span class="coupon_apply_txt">('.$order_details[0]->coupon_code.')</span></strong></td>
                                    <td><strong>Rs. '.$order_details[0]->coupon_value. '</strong></td>
                                </tr>';

                            $totalAmount = $totalAmount - $order_details[0]->coupon_value;

                            echo '<tr>
                                    <td colspan="5">&nbsp;</td>
                                    <td><strong>Final Total </strong></td>
                                    <td><strong>Rs. '.$totalAmount. '</strong></td>
                                </tr>';
                        }
                        ?>

                       </tbody>
                   </table>
                 </div>

              </form>

            </div>
          </div>
        </div>
      </div>

      <div class="row">&nbsp;</div>
    </div>
  </section>
  <!-- / Cart view section -->

@endsection
