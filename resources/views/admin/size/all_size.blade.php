@extends('admin.layouts')
@section('page_title', 'Size')
@section('size_select', 'active')
@section('container')

<h1>Size</h1>
<a href="{{ route('admin.manage_size') }}">
    <button type="button" class="btn btn-success mt-2 mb-3">
        Add Size
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
                        <th>Size</th>
                        <th>created at</th>
                        <th>action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sizes as $size)
                        <tr>
                            <td>{{ $size->id }}</td>
                            <td>{{ $size->size }}</td>
                            <td>{{ $size->created_at }}</td>
                            <td>
                                @if ($size->status == 1)
                                    <a href="{{ url('admin/size/status/0') }}/{{ $size->id }}" class="mr-2 btn btn-sm btn-info">Active</a>
                                @elseif ($size->status == 0)
                                    <a href="{{ url('admin/size/status/1') }}/{{ $size->id }}" class="mr-2 btn btn-sm btn-danger">Deactive</a>
                                @endif
                                <a href="{{ route('admin.edit_manage_size', ['size_id' => $size->id]) }}" class="mr-2"><i class="fa fa-edit fa-2x text-info"></i></a>
                                <a href="{{ route('size.delete_size', ['size_id'=> $size->id ]) }}" class="mr-2"><i class="fa fa-times fa-2x text-danger"></i></a>
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
