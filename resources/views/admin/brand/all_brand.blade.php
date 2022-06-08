@extends('admin.layouts')
@section('page_title', 'Brand')
@section('brand_select', 'active')
@section('container')

<h1>Brand</h1>
<a href="{{ route('admin.manage_brand') }}">
    <button type="button" class="btn btn-success mt-2 mb-3">
        Add Brand
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
                        <th>name</th>
                        <th>image</th>
                        <th>created at</th>
                        <th>action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($brands as $brand)
                        <tr>
                            <td>{{ $brand->id }}</td>
                            <td>{{ $brand->name }}</td>
                            <td>
                                @if ($brand->image)
                                    <img src="{{ asset('storage/media/brand') }}/{{ $brand->image }}" width="100px">
                                @else
                                    &nbsp;
                                @endif
                            </td>
                            <td>{{ $brand->created_at }}</td>
                            <td>
                                @if ($brand->status == 1)
                                    <a href="{{ url('admin/brand/status/0') }}/{{ $brand->id }}" class="mr-2 btn btn-sm btn-info">Active</a>
                                @elseif ($brand->status == 0)
                                    <a href="{{ url('admin/brand/status/1') }}/{{ $brand->id }}" class="mr-2 btn btn-sm btn-danger">Deactive</a>
                                @endif
                                <a href="{{ route('admin.edit_manage_brand', ['brand_id' => $brand->id]) }}" class="mr-2"><i class="fa fa-edit fa-2x text-info"></i></a>
                                <a href="{{ route('brand.delete_brand', ['brand_id'=> $brand->id ]) }}" class="mr-2"><i class="fa fa-times fa-2x text-danger"></i></a>
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
