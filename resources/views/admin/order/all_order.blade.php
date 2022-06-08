@extends('admin.layouts')
@section('page_title', 'Order')
@section('order_select', 'active')
@section('container')

<h1>Order</h1>

<div class="row m-t-20">
    <div class="col-md-12">
        <!-- DATA TABLE-->
        <div class="table-responsive m-b-40">
            <table class="table table-borderless table-data3">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer Details</th>
                        <th>Amount</th>
                        <th>Order Status</th>
                        <th>Payment Status</th>
                        <th>Payment Type</th>
                        <th>Placed On</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td class="order_id_btn"><a href="{{ route('admin.order_details', ['id' => $order->id]) }}">{{ $order->id }}</a></td>
                            <td>
                                {{ $order->name }}<br>
                                {{ $order->email }}<br>
                                {{ $order->mobile }}<br>
                                {{ $order->address }}, {{ $order->city }}, {{ $order->state }}, {{ $order->zipcode }}
                            </td>
                            <td>{{ $order->total_amount }}</td>
                            <td>{{ $order->order_status }}</td>
                            <td>{{ $order->payment_status }}</td>
                            <td>{{ $order->payment_type }}</td>
                            <td>{{ $order->added_on }}</td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- END DATA TABLE-->
    </div>

</div>
@endsection
