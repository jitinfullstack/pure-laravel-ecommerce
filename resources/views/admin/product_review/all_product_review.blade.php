@extends('admin.layouts')
@section('page_title', 'Product Review')
@section('product_review_select', 'active')
@section('container')

<h1>Product Review</h1>

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
                        <th>User</th>
                        <th>Product</th>
                        <th>Rating</th>
                        <th>Review</th>
                        <th>Added On</th>
                        <th>action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($product_review as $review)
                        <tr>
                            <td>{{ $review->id }}</td>
                            <td>{{ $review->name }}</td>
                            <td>{{ $review->pname }}</td>
                            <td>{{ $review->rating }}</td>
                            <td>{{ $review->review }}</td>
                            <td>{{ $review->added_on }}</td>
                            <td>
                                @if ($review->status == 1)
                                    <a href="{{ url('admin/update_product_review/status/0') }}/{{ $review->id }}" class="mr-2 btn btn-sm btn-info">Active</a>
                                @elseif ($review->status == 0)
                                    <a href="{{ url('admin/update_product_review/status/1') }}/{{ $review->id }}" class="mr-2 btn btn-sm btn-danger">Deactive</a>
                                @endif

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
