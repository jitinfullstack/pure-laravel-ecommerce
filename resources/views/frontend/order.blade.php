@extends('frontend.layouts')
@section('page_title', 'Daily Shop | Order')
@section('container')

<!-- catg header banner section -->
<section id="aa-catg-head-banner">
    <img src="{{ asset('frontend_assets/img/fashion/fashion-header-bg-8.jpg') }}" alt="fashion img">
    <div class="aa-catg-head-banner-area">
      <div class="container">
       <div class="aa-catg-head-banner-content">
         <h2>Order Page</h2>
         <ol class="breadcrumb">
           <li><a href="index.html">Home</a></li>
           <li class="active">Order</li>
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

                <div class="table-responsive">
                   <table class="table">
                     <thead>
                       <tr>
                         <th>Order Id</th>
                         <th>Order Status</th>
                         <th>Payment Status</th>
                         <th>Payment Type</th>
                         <th>Payment Id</th>
                         <th>Total Amount</th>
                         <th>Order Placed On</th>
                       </tr>
                     </thead>
                     <tbody>
                        @foreach ($orders as $order)
                        <tr>
                            <td class="order_id_btn"><a href="{{ route('order_details', ['id' => $order->id]) }}">{{ $order->id }}</a></td>
                            <td>{{ $order->order_status }}</td>
                            <td>{{ $order->payment_status }}</td>
                            <td>{{ $order->payment_type }}</td>
                            <td>{{ $order->payment_id }}</td>
                            <td>{{ $order->total_amount }}</td>
                            <td>{{ $order->added_on }}</td>

                        </tr>
                        @endforeach

                       </tbody>
                   </table>
                 </div>

              </form>

            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- / Cart view section -->

@endsection
