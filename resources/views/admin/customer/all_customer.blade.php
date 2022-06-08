@extends('admin.layouts')
@section('page_title', 'Customers')
@section('customer_select', 'active')
@section('container')

<h1>Customers</h1>
{{-- <a href="{{ route('admin.manage_customer') }}">
    <button type="button" class="btn btn-success mt-2 mb-3">
        Add Customer
    </button>
</a> --}}
@if (Session::has('message'))
    <div class="sufee-alert alert with-close alert-dark alert-dismissible fade show">
        <span class="badge badge-pill badge-dark">Success</span>
        {{ Session::get('message') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
@endif
<div class="row m-t-20">
    <div class="col-md-12">
        <!-- DATA TABLE-->
        <div class="table-responsive m-b-40">
            <table class="table table-borderless table-data3">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>name</th>
                        <th>email</th>
                        <th>mobile</th>
                        {{-- <th>city</th> --}}
                        <th>created at</th>
                        <th>action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($customers as $customer)
                        <tr>
                            <td>{{ $customer->id }}</td>
                            <td>{{ $customer->name }}</td>
                            <td>{{ $customer->email }}</td>
                            <td>{{ $customer->mobile }}</td>
                            {{-- <td>{{ $customer->city }}</td> --}}
                            <td>{{ $customer->created_at }}</td>
                            <td>
                                @if ($customer->status == 1)
                                    <a href="{{ url('admin/customer/status/0') }}/{{ $customer->id }}" class="mr-2 btn btn-sm btn-info">Active</a>
                                @elseif ($customer->status == 0)
                                    <a href="{{ url('admin/customer/status/1') }}/{{ $customer->id }}" class="mr-2 btn btn-sm btn-danger">Deactive</a>
                                @endif
                                <a href="{{ route('admin.show_customer', ['customer_id' => $customer->id]) }}"><i class="fa fa-edit fa-2x text-info"></i></a>
                                {{-- <a href="{{ route('coupon.delete_coupon', ['coupon_id'=> $coupon->id ]) }}" style="margin-left: 10px"><i class="fa fa-times fa-2x text-danger"></i></a> --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- END DATA TABLE-->
    </div>

</div>
@endsection
