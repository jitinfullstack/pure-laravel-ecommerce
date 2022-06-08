@extends('admin.layouts')
@section('page_title', 'Order Details')
@section('order_select', 'active')
@section('container')

<h1>Order Details - {{ $order_details[0]->id }}</h1>

<a href="{{ route('admin.order') }}">
    <button type="button" class="btn btn-success btn-block mt-2">
        Back
    </button>
</a>

<div class="row m-t-30 m-b-20">
    <div class="col-md-12">
        <div class="cart-view-area">
            <div class="cart-view-table">
                <div class="table-responsive m-b-40">
                    <table class="table table-borderless table-data3">
                        <thead>
                            <tr>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <strong>Update Order Status: </strong>
                                    <p>
                                        <select class="form-control" id="order_status" onchange="update_order_status({{ $order_details[0]->id }})">
                                            <?php
                                              foreach ($order_status as $list) {
                                                  if($order_details[0]->order_status == $list->id){
                                                    echo '<option  value="'.$list->id.'">'.$list->order_status.'</option>';                                                  }
                                                  else{
                                                    echo '<option value="'.$list->id.'">'.$list->order_status.'</option>';
                                                  }
                                                }
                                            ?>
                                        </select>
                                    </p>
                                    <br>
                                </td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="cart-view-area">
            <div class="cart-view-table">
                <div class="table-responsive m-b-40">
                    <table class="table table-borderless table-data3">
                        <thead>
                            <tr>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <strong>Update Payment Status: </strong>
                                    <p>
                                        <select class="form-control" id="payment_status" onchange="update_payment_status({{ $order_details[0]->id }})">
                                            <?php
                                              foreach ($payment_status as $list) {
                                                  if($order_details[0]->payment_status == $list){
                                                    echo '<option selected value="'.$list.'">'.$list.'</option>';
                                                  }
                                                  else{
                                                    echo '<option value="'.$list.'">'.$list.'</option>';
                                                  }
                                                }
                                            ?>
                                        </select>
                                    </p>
                                    <br>
                                </td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="cart-view-area">
            <div class="cart-view-table">
                <div class="table-responsive m-b-40">
                    <table class="table table-borderless table-data3">
                        <thead>
                            <tr>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <strong>Track Details: </strong><br>
                                    <form method="post">
                                        <textarea class="form-control" name="track_details" required>{{ $order_details[0]->track_details }}</textarea>
                                        <button type="submit" class="btn btn-sm btn-success m-t-10">Update</button>
                                        @csrf
                                    </form>
                                    <br>
                                </td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row m-b-20">
<div class="col-md-6">
    <div class="cart-view-area">

        <div class="cart-view-table">
        <form action="">

            <h3 class="m-b-10">Details Address</h3>
            <div class="table-responsive m-b-40">
                <table class="table table-borderless table-data3">
                <thead>
                    <tr>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Name: </strong> <p>{{ $order_details[0]->name }}</p><br>
                            <strong>Phone: </strong> <p>({{ $order_details[0]->mobile }})</p><br>
                            <strong>Email: </strong> <p>{{ $order_details[0]->email }}</p><br>
                            <strong>Address: </strong> <p>{{ $order_details[0]->address }}, {{ $order_details[0]->city }}, {{ $order_details[0]->state }}, {{ $order_details[0]->zipcode }}</p>
                        </td>
                        <td></td>
                    </tr>
                </tbody>
                </table>
            </div>
        </form>
        </div>
    </div>

</div>



<div class="col-md-6">
    <div class="cart-view-area">

        <div class="cart-view-table">
        <form action="">

            <h3 class="m-b-10">Order Details</h3>
            <div class="table-responsive m-b-40">
                <table class="table table-borderless table-data3">
                    <thead>
                        <tr>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Order Status: </strong> <p>{{ $order_details[0]->order_status }}</p><br>
                                <strong>Payment Status: </strong> <p>{{ $order_details[0]->payment_status }}</p><br>
                                <strong>Payment Type: </strong> <p>{{ $order_details[0]->payment_type }}</p><br>
                                <?php
                                    if($order_details[0]->payment_id != ''){
                                        echo '<strong>Address: </strong> <p> '.$order_details[0]->payment_id .'</p>';
                                    }
                                ?>

                            </td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </form>
        </div>
    </div>

</div>

</div>


<div class="row">

    <div class="col-md-12">
    <div class="cart-view-area">

        <div class="cart-view-table">
        <form action="">

            <div class="table-responsive m-b-40">
                <table class="table table-borderless table-data3">
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
                        <td><img src="{{ asset('storage/media/'.$order_detail->attr_image) }}" alt="{{ $order_detail->name }}" width="60px"></td>
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


@endsection
