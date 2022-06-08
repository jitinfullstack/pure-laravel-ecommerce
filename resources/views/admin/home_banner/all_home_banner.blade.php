@extends('admin.layouts')
@section('page_title', 'Home Banner')
@section('home_banner_select', 'active')
@section('container')

<h1>Home Banner</h1>
<a href="{{ route('admin.manage_home_banner') }}">
    <button type="button" class="btn btn-success mt-2 mb-3">
        Add Home Banner
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
                        <th>image</th>
                        <th>text</th>
                        <th>link</th>
                        <th>action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($home_banners as $home_banner)
                        <tr>
                            <td>{{ $home_banner->id }}</td>
                            <td>
                                <img src="{{ asset('storage/media/banner') }}/{{ $home_banner->image }}" width="100px">
                            </td>
                            <td>{{ $home_banner->btn_text }}</td>
                            <td>{{ $home_banner->btn_link }}</td>
                            <td>
                                @if ($home_banner->status == 1)
                                    <a href="{{ url('admin/home_banner/status/0') }}/{{ $home_banner->id }}" class="mr-2 btn btn-sm btn-info">Active</a>
                                @elseif ($home_banner->status == 0)
                                    <a href="{{ url('admin/home_banner/status/1') }}/{{ $home_banner->id }}" class="mr-2 btn btn-sm btn-danger">Deactive</a>
                                @endif
                                <a href="{{ route('admin.edit_manage_home_banner', ['home_banner_id' => $home_banner->id]) }}" class="mr-2"><i class="fa fa-edit fa-2x text-info"></i></a>
                                <a href="{{ route('home_banner.delete_home_banner', ['home_banner_id'=> $home_banner->id ]) }}" class="mr-2"><i class="fa fa-times fa-2x text-danger"></i></a>
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
