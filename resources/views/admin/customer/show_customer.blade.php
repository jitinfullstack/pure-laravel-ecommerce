@extends('admin.layouts')
@section('page_title', 'Show Customer Details')
@section('customer_select', 'active')
@section('container')

<h1>Customers Details</h1>
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
                        <th>Fields</th>
                        <th></th>
                        <th>Value</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><b>ID</b></td>
                        <td></td>
                        <td>{{ $customer_list->id }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><b>Name</b></td>
                        <td></td>
                        <td>{{ $customer_list->name }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><b>Email</b></td>
                        <td></td>
                        <td>{{ $customer_list->email }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><b>Mobile</b></td>
                        <td></td>
                        <td>{{ $customer_list->mobile }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><b>Address</b></td>
                        <td></td>
                        <td>{{ $customer_list->address }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><b>City</b></td>
                        <td></td>
                        <td>{{ $customer_list->city }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><b>State</b></td>
                        <td></td>
                        <td>{{ $customer_list->state }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><b>Zipcode</b></td>
                        <td></td>
                        <td>{{ $customer_list->zipcode }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><b>Company</b></td>
                        <td></td>
                        <td>{{ $customer_list->company }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><b>GST Number</b></td>
                        <td></td>
                        <td>{{ $customer_list->gstin }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><b>Created At</b></td>
                        <td></td>
                        <td>
                            {{ \Carbon\Carbon::parse($customer_list->created_at)->isoFormat('LLLL'); }}
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><b>Updated At</td>
                        <td></td>
                        <td>
                            {{ \Carbon\Carbon::parse($customer_list->updated_at)->isoFormat('LLLL'); }}
                        </td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- END DATA TABLE-->
    </div>

</div>
@endsection
