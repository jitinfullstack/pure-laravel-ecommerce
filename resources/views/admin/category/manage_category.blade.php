@extends('admin.layouts')
@section('page_title', 'Manage Category')
@section('category_select', 'active')
@section('container')

@if($id>0)
    @php
        $image_required=""
    @endphp
@else
    @php
        $image_required="required"
    @endphp
@endif

<h1>Manage Category</h1>
<a href="{{ route('admin.category') }}">
    <button type="button" class="btn btn-success btn-block mt-2">
        Back
    </button>
</a>
<div class="row m-t-30">
    <div class="col-md-12">

        <div class="card">
            <div class="card-body">

                <form action="{{ route('category.manage_category_process') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <div class="row">

                            <div class="col-md-6">
                                <label for="category_name" class="control-label mb-1">Category Name</label>
                                <input id="category_name" name="category_name" type="text" class="form-control" value="{{ $category_name }}" aria-required="true" aria-invalid="false" required>
                                @error('category_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="category_slug" class="control-label mb-1">Category Slug</label>
                                <input id="category_slug" name="category_slug" type="text" class="form-control" value="{{ $category_slug }}" aria-required="true" aria-invalid="false" required>
                                @error('category_slug')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row align-items-center">

                            <div class="col-md-4">
                                <label for="is_home" class="control-label mb-1">Show in Home Page</label>
                                <input id="is_home" name="is_home" type="checkbox" class="mr-2 mt-2 float-left" {{ $is_home_selected }}>

                            </div>

                            <div class="col-md-4">
                                <label for="parent_category_id" class="control-label mb-1">Parent Category</label>

                                <select id="parent_category_id" name="parent_category_id" class="form-control" required>
                                    <option value="0">Select Parent Category</option>
                                    @foreach($category as $list)
                                        @if($parent_category_id==$list->id)
                                            <option selected value="{{$list->id}}">
                                        @else
                                            <option value="{{$list->id}}">
                                        @endif
                                        {{$list->category_name}}</option>
                                    @endforeach
                                </select>

                            </div>

                            <div class="col-md-4">
                                <label for="category_image" class="control-label mb-1">Category Image</label>
                                <input id="category_image" name="category_image" type="file" class="form-control" aria-required="true" aria-invalid="false">
                                @if ($category_image)
                                    <img src="{{ asset('storage/media/category') }}/{{ $category_image }}" width="100px" class="mt-2">
                                @endif
                                @error('category_image')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </div>

                    <div>
                        <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                            <span id="payment-button-amount">Submit</span>
                            <span id="payment-button-sending" style="display:none;">Sending…</span>
                        </button>
                    </div>
                    <input type="hidden" name="id" value="{{ $id }}"/>
                </form>
            </div>

        </div>

    </div>

</div>
@endsection
