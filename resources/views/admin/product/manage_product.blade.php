@extends('admin.layouts')
@section('page_title', 'Manage Product')
@section('product_select', 'active')
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

<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<h1>Manage Product</h1>
<a href="{{ route('admin.product') }}">
    <button type="button" class="btn btn-success btn-block mt-2 mb-3">
        Back
    </button>
</a>

@error('attr_image.*')
    <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
        <span class="badge badge-pill badge-danger">Warning</span>
        {{ $message }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
@enderror

@error('images.*')
    <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
        <span class="badge badge-pill badge-danger">Warning</span>
        {{ $message }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
@enderror

@if (Session::has('error_message'))
    <div class="sufee-alert alert with-close alert-warning alert-dismissible fade show">
        <span class="badge badge-pill badge-warning">Warning</span>
        {{ Session::get('error_message') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
@endif
<div class="row m-t-30 w-100 d-block">
    {{-- <div class="row"> --}}
        {{-- <div class="col-lg-12"> --}}
            <form action="{{ route('product.manage_product_process') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="col-lg-12">

                        <div class="card">
                            <div class="card-body">

                                    <div class="form-group">
                                        <label for="name" class="control-label mb-1">Product Name</label>
                                        <input id="name" name="name" type="text" class="form-control" value="{{ $name }}" aria-required="true" aria-invalid="false" required>
                                        @error('name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="slug" class="control-label mb-1">Product Slug</label>
                                        <input id="slug" name="slug" type="text" class="form-control" value="{{ $slug }}" aria-required="true" aria-invalid="false" required>
                                        @error('slug')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="image" class="control-label mb-1">Product Image</label>
                                        <input id="image" name="image" type="file" class="form-control" aria-required="true" aria-invalid="false" {{$image_required}}>
                                        @if ($image)
                                            <img src="{{ asset('storage/media') }}/{{ $image }}" width="100px" class="mt-2">
                                        @endif
                                        @error('image')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="category_id" class="control-label mb-1">Product Category</label>

                                                <select id="category_id" name="category_id" class="form-control" required>
                                                    <option value="">Select Categories</option>
                                                    @foreach($category as $list)
                                                        @if($category_id==$list->id)
                                                            <option selected value="{{$list->id}}">
                                                        @else
                                                            <option value="{{$list->id}}">
                                                        @endif
                                                        {{$list->category_name}}</option>
                                                    @endforeach
                                                </select>

                                            </div>

                                            <div class="col-md-4">
                                                <label for="brand" class="control-label mb-1">Product Brand</label>

                                                <select id="brand" name="brand" class="form-control" required>
                                                    <option value="">Select Brand</option>
                                                    @foreach($brands as $list)
                                                        @if($brand==$list->id)
                                                            <option selected value="{{$list->id}}">
                                                        @else
                                                            <option value="{{$list->id}}">
                                                        @endif
                                                        {{$list->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            {{-- <div class="col-md-4">
                                                <label for="brand" class="control-label mb-1">Product Brand</label>
                                                <input id="brand" name="brand" type="text" class="form-control" value="{{ $brand }}" aria-required="true" aria-invalid="false" required>

                                            </div> --}}

                                            <div class="col-md-4">
                                                <label for="model" class="control-label mb-1">Product Model</label>
                                                <input id="model" name="model" type="text" class="form-control" value="{{ $model }}" aria-required="true" aria-invalid="false" required>

                                            </div>
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label for="short_description" class="control-label mb-1">Short Description</label>
                                        <textarea id="short_description" name="short_description" class="form-control"required>
                                            {{ $short_description }}
                                        </textarea>

                                    </div>
                                    <div class="form-group">
                                        <label for="description" class="control-label mb-1">Description</label>
                                        <textarea id="description" name="description" class="form-control" required>
                                            {{ $description }}
                                        </textarea>

                                    </div>
                                    <div class="form-group">
                                        <label for="keywords" class="control-label mb-1">Keywords</label>
                                        <textarea id="keywords" name="keywords" class="form-control" required>
                                            {{ $keywords }}
                                        </textarea>

                                    </div>
                                    <div class="form-group">
                                        <label for="technical_specification" class="control-label mb-1">Technical Specification</label>
                                        <textarea id="technical_specification" name="technical_specification" class="form-control" required>
                                            {{ $technical_specification }}
                                        </textarea>

                                    </div>
                                    <div class="form-group">
                                        <label for="uses" class="control-label mb-1">Uses</label>
                                        <textarea id="uses" name="uses" class="form-control" required>
                                            {{ $uses }}
                                        </textarea>

                                    </div>
                                    <div class="form-group">
                                        <label for="warranty" class="control-label mb-1">Warranty</label>
                                        <textarea id="warranty" name="warranty" class="form-control" required>
                                            {{ $warranty }}
                                        </textarea>

                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="lead_time" class="control-label mb-1">Lead Time</label>
                                                <input id="lead_time" name="lead_time" type="text" class="form-control" value="{{ $lead_time }}" aria-required="true" aria-invalid="false">

                                            </div>
                                            <div class="col-md-6">
                                                <label for="tax_id" class="control-label mb-1">Tax</label>
                                                <select id="tax_id" name="tax_id" class="form-control" required>
                                                    <option value="">Select Tax</option>
                                                    @foreach($taxes as $list)
                                                        @if($tax_id==$list->id)
                                                            <option selected value="{{$list->id}}">
                                                        @else
                                                            <option value="{{$list->id}}">
                                                        @endif
                                                        {{$list->tax_description}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label for="is_promo" class="control-label mb-1">Is Promo</label>
                                                <select id="is_promo" name="is_promo" class="form-control" required>
                                                    @if ($is_promo == '1')
                                                        <option selected value="1">Yes</option>
                                                        <option value="0">No</option>
                                                    @else
                                                        <option value="1">Yes</option>
                                                        <option selected value="0">No</option>
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="is_featured" class="control-label mb-1">Is Featured</label>
                                                <select id="is_featured" name="is_featured" class="form-control" required>
                                                    @if ($is_featured == '1')
                                                        <option selected value="1">Yes</option>
                                                        <option value="0">No</option>
                                                    @else
                                                        <option value="1">Yes</option>
                                                        <option selected value="0">No</option>
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="is_discounted" class="control-label mb-1">Is Discounted</label>
                                                <select id="is_discounted" name="is_discounted" class="form-control" required>
                                                    @if ($is_discounted == '1')
                                                        <option selected value="1">Yes</option>
                                                        <option value="0">No</option>
                                                    @else
                                                        <option value="1">Yes</option>
                                                        <option selected value="0">No</option>
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="is_trending" class="control-label mb-1">Is Trending</label>
                                                <select id="is_trending" name="is_trending" class="form-control" required>
                                                    @if ($is_trending == '1')
                                                        <option selected value="1">Yes</option>
                                                        <option value="0">No</option>
                                                    @else
                                                        <option value="1">Yes</option>
                                                        <option selected value="0">No</option>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <input type="hidden" name="id" value="{{ $id }}"/>

                            </div>
                        </div>
                </div>

                <h3 class="ml-4 mt-4 mb-3"><u>Product Images</u></h3>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <div class="row" id="product_images_box">
                                @php
                                $loop_count_num=1;
                                @endphp
                                @foreach($productImagesArr as $key=>$val)
                                @php
                                $loop_count_prev=$loop_count_num;
                                $pIArr=(array)$val;
                                @endphp
                                <input id="piid" type="hidden" name="piid[]" value="{{$pIArr['id']}}">
                                <div class="col-md-4 product_images_{{$loop_count_num++}}"  >
                                    <label for="images" class="control-label mb-1"> Image</label>
                                    <input id="images" name="images[]" type="file" class="form-control" aria-required="true" aria-invalid="false" >

                                    @if($pIArr['images']!='')
                                        <a href="{{asset('storage/media/'.$pIArr['images'])}}" target="_blank"><img width="100px" src="{{asset('storage/media/'.$pIArr['images'])}}"/></a>
                                    @endif
                                </div>

                                <div class="col-md-2">
                                    <label for="images" class="control-label mb-1">
                                    &nbsp;&nbsp;&nbsp;</label>

                                    @if($loop_count_num==2)
                                        <button type="button" class="btn btn-md btn-info btn-block" onclick="add_image_more()">
                                        <i class="fa fa-plus"></i>&nbsp; Add</button>
                                    @else
                                    <a href="{{url('admin/product/product_images_delete/')}}/{{$pIArr['id']}}/{{$id}}"><button type="button" class="btn btn-md btn-danger btn-block">
                                        <i class="fa fa-minus"></i>&nbsp; Remove</button></a>
                                    @endif

                                </div>
                                @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


                <h3 class="ml-4 mt-4 mb-3"><u>Product Attributes</u></h3>
                <div class="col-lg-12" id="product_attr_box">

                    @php
                        $loop_count_num = 1;
                    @endphp

                    @foreach ($productAttrArr as $key=>$value)

                    @php
                        $pAttrArr = (array)$value;
                        $loop_count_prev = $loop_count_num;
                        // echo '<pre>';
                        // print_r($pAttrArr);
                    @endphp
                    <input id="paid" type="hidden" name="paid[]" value="{{$pAttrArr['id']}}">
                        <div class="card" id="product_attr_{{ $loop_count_num++ }}">
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label for="sku" class="control-label mb-1">SKU</label>
                                            <input id="sku" name="sku[]" type="text" class="form-control" value="{{ $pAttrArr['sku'] }}" aria-required="true" aria-invalid="false" required>

                                        </div>
                                        <div class="col-md-3">
                                            <label for="mrp" class="control-label mb-1">MRP</label>
                                            <input id="mrp" name="mrp[]" type="text" class="form-control" value="{{ $pAttrArr['mrp'] }}" aria-required="true" aria-invalid="false" required>

                                        </div>
                                        <div class="col-md-3">
                                            <label for="price" class="control-label mb-1">Price</label>
                                            <input id="price" name="price[]" type="text" class="form-control" value="{{ $pAttrArr['price'] }}" aria-required="true" aria-invalid="false" required>

                                        </div>
                                        <div class="col-md-3">
                                            <label for="quantity" class="control-label mb-1">Quantity</label>
                                            <input id="quantity" name="quantity[]" type="text" class="form-control" value="{{ $pAttrArr['quantity'] }}" aria-required="true" aria-invalid="false" required>

                                        </div>
                                    </div>

                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label for="size_id" class="control-label mb-1">Size</label>

                                            <select id="size_id" name="size_id[]" class="form-control">
                                                <option value="">Size</option>
                                                @foreach($sizes as $list)
                                                    @if ($pAttrArr['size_id'] == $list->id)
                                                        <option selected value="{{$list->id}}">
                                                            {{$list->size}}
                                                        </option>
                                                    @else
                                                        <option value="{{$list->id}}">
                                                            {{$list->size}}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-3">
                                            <label for="color_id" class="control-label mb-1">Color</label>

                                            <select id="color_id" name="color_id[]" class="form-control">
                                                <option value="">Color</option>
                                                @foreach($colors as $list)
                                                    @if ($pAttrArr['color_id'] == $list->id)
                                                        <option selected value="{{$list->id}}">
                                                            {{$list->color}}
                                                        </option>
                                                    @else
                                                        <option value="{{$list->id}}">
                                                            {{$list->color}}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-3">
                                            <label for="attr_image" class="control-label mb-1">Attribute Image</label>
                                            <input id="attr_image" name="attr_image[]" type="file" class="form-control" aria-required="true" aria-invalid="false" {{$image_required}}>

                                            @if ($pAttrArr['attr_image'])
                                                <img src="{{ asset('storage/media') }}/{{ $pAttrArr['attr_image'] }}" width="100px" class="mt-2">
                                            @endif
                                            @error('attr_image')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-3">

                                            @if ($loop_count_num == 2)
                                                <label for="" class="control-label mb-1">&nbsp;</label>
                                                <button id="add-button" onclick="add_more()" type="button" class="btn btn-md btn-info btn-block">
                                                    <i class="fa fa-plus"></i>&nbsp;&nbsp;<span id="add-button">Add</span>
                                                </button>
                                            @else
                                                <label for="" class="control-label mt-4 pt-3">&nbsp;</label>
                                                <a href="{{ url('admin/product/product_attr_delete/') }}/{{ $pAttrArr['id'] }}/{{ $id }}">
                                                <button id="remove-button" type="button" class="btn btn-md btn-danger btn-block">
                                                    <i class="fa fa-times"></i>&nbsp;&nbsp;<span id="remove-button">Remove</span>
                                                </button></a>
                                            @endif

                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div>
                    <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                        <span id="payment-button-amount">Submit</span>
                        <span id="payment-button-sending" style="display:none;">Sending…</span>
                    </button>
                </div>
            </form>
        {{-- </div> --}}
    {{-- </div> --}}

</div>

<script>

    var loop_count = 1;
    function add_more()
    {
        loop_count++;
        var html = '<input id="paid" type="hidden" name="paid[]"><div class="card" id="product_attr_'+loop_count+'"><div class="card-body"><div class="form-group"><div class="row">';

        html += '<div class="col-md-3"><label for="sku" class="control-label mb-1">SKU</label><input id="sku" name="sku[]" type="text" class="form-control" aria-required="true" aria-invalid="false" required></div>';
        html += '<div class="col-md-3"><label for="mrp" class="control-label mb-1">MRP</label><input id="mrp" name="mrp[]" type="text" class="form-control" aria-required="true" aria-invalid="false" required></div>';
        html += '<div class="col-md-3"><label for="price" class="control-label mb-1">Price</label><input id="price" name="price[]" type="text" class="form-control" aria-required="true" aria-invalid="false" required></div>';
        html += '<div class="col-md-3"><label for="quantity" class="control-label mb-1">Quantity</label><input id="quantity" name="quantity[]" type="text" class="form-control" aria-required="true" aria-invalid="false" required></div>';

        var size_id_html = jQuery('#size_id').html();
        size_id_html = size_id_html.replace("selected", "");
        html += '<div class="col-md-3"><label for="size" class="control-label mb-1">Size</label><select id="size_id" name="size_id[]" class="form-control" aria-required="true" aria-invalid="false">'+size_id_html+'</select></div>';

        var color_id_html = jQuery('#color_id').html();
        color_id_html = color_id_html.replace("selected", "");
        html += '<div class="col-md-3"><label for="color" class="control-label mb-1">Color</label><select id="color_id" name="color_id[]" class="form-control" aria-required="true" aria-invalid="false">'+color_id_html+'</select></div>';

        html += '<div class="col-md-3"><label for="attr_image" class="control-label mb-1">Attribut Image</label><input id="attr_image[]" name="attr_image" type="file" class="form-control" aria-required="true" aria-invalid="false" {{$image_required}}></div>';

        html += '<div class="col-md-3"><label for="" class="control-label mb-1">&nbsp;</label><button id="remove-button" onclick=remove_more("'+loop_count+'") type="button" class="btn btn-md btn-danger btn-block"><i class="fa fa-times"></i>&nbsp;&nbsp;<span id="remove-button">Remove</span></button></div>';

        html += '</div></div></div></div>';

        jQuery('#product_attr_box').append(html);
    }

    function remove_more(loop_count){
        jQuery('#product_attr_'+loop_count).remove();
    }

    var loop_image_count=1;
   function add_image_more(){
      loop_image_count++;
      var html='<input id="piid" type="hidden" name="piid[]" value=""><div class="col-md-4 product_images_'+loop_image_count+'"><label for="images" class="control-label mb-1"> Image</label><input id="images" name="images[]" type="file" class="form-control" aria-required="true" aria-invalid="false" ></div>';
      //product_images_box
       html+='<div class="col-md-2 product_images_'+loop_image_count+'""><label for="attr_image" class="control-label mb-1"> &nbsp;&nbsp;&nbsp;</label><button type="button" class="btn btn-md btn-danger btn-block" onclick=remove_image_more("'+loop_image_count+'")><i class="fa fa-minus"></i>&nbsp; Remove</button></div>';
       jQuery('#product_images_box').append(html)
   }

   function remove_image_more(loop_image_count){
        jQuery('.product_images_'+loop_image_count).remove();
   }

   CKEDITOR.replace('short_description');
   CKEDITOR.replace('description');
   CKEDITOR.replace('technical_specification');
</script>
@endsection
