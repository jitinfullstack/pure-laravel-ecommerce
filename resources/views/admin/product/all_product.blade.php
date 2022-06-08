@extends('admin.layouts')
@section('page_title', 'Product')
@section('product_select', 'active')
@section('container')

<h1>Product</h1>
<a href="{{ route('admin.manage_product') }}">
    <button type="button" class="btn btn-success mt-2 mb-3">
        Add Product
    </button>
</a>
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
                        <th>prodoct name</th>
                        <th>product slug</th>
                        <th>product image</th>
                        <th>created at</th>
                        <th>action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->slug }}</td>
                            <td>
                                @if ($product->image!='')
                                    <img src="{{ asset('storage/media') }}/{{ $product->image }}" alt="{{ $product->name }}" width="100px">
                                @endif
                            </td>
                            <td>{{ $product->created_at }}</td>
                            <td>
                                @if ($product->status == 1)
                                    <a href="{{ url('admin/product/status/0') }}/{{ $product->id }}" class="mr-2 btn btn-sm btn-info">Active</a>
                                @elseif ($product->status == 0)
                                    <a href="{{ url('admin/product/status/1') }}/{{ $product->id }}" class="mr-2 btn btn-sm btn-danger">Deactive</a>
                                @endif
                                <a href="{{ route('admin.edit_manage_product', ['product_id' => $product->id]) }}" class="mr-2"><i class="fa fa-edit fa-2x text-info"></i></a>
                                <a href="{{ route('product.delete_product', ['product_id'=> $product->id ]) }}" class="mr-2"><i class="fa fa-times fa-2x text-danger"></i></a>
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
