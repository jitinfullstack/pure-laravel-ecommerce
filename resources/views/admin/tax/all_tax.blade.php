@extends('admin.layouts')
@section('page_title', 'Tax')
@section('tax_select', 'active')
@section('container')

<h1>Tax</h1>
<a href="{{ route('admin.manage_tax') }}">
    <button type="button" class="btn btn-success mt-2 mb-3">
        Add Tax
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
                        <th>Tax Value</th>
                        <th>Tax Description</th>
                        <th>created at</th>
                        <th>action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($taxes as $tax)
                        <tr>
                            <td>{{ $tax->id }}</td>
                            <td>{{ $tax->tax_value }}</td>
                            <td>{{ $tax->tax_description }}</td>
                            <td>{{ $tax->created_at }}</td>
                            <td>
                                @if ($tax->status == 1)
                                    <a href="{{ url('admin/tax/status/0') }}/{{ $tax->id }}" class="mr-2 btn btn-sm btn-info">Active</a>
                                @elseif ($tax->status == 0)
                                    <a href="{{ url('admin/tax/status/1') }}/{{ $tax->id }}" class="mr-2 btn btn-sm btn-danger">Deactive</a>
                                @endif
                                <a href="{{ route('admin.edit_manage_tax', ['tax_id' => $tax->id]) }}" class="mr-2"><i class="fa fa-edit fa-2x text-info"></i></a>
                                <a href="{{ route('tax.delete_tax', ['tax_id'=> $tax->id ]) }}" class="mr-2"><i class="fa fa-times fa-2x text-danger"></i></a>
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
