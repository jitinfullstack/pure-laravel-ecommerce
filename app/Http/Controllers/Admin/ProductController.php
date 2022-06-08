<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Admin\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Nette\Utils\Random;
use Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return view('admin.product.all_product', ['products' => $products]);
    }

    public function manage_product(Request $request, $product_id = '')
    {
        if ($product_id > 0) {
            $product = Product::where(['id' => $product_id])->get();
            $result['category_id'] = $product['0']->category_id;
            $result['name'] = $product['0']->name;
            $result['slug'] = $product['0']->slug;
            $result['image'] = $product['0']->image;
            $result['brand'] = $product['0']->brand;
            $result['model'] = $product['0']->model;
            $result['short_description'] = $product['0']->short_description;
            $result['description'] = $product['0']->description;
            $result['keywords'] = $product['0']->keywords;
            $result['technical_specification'] = $product['0']->technical_specification;
            $result['uses'] = $product['0']->uses;
            $result['warranty'] = $product['0']->warranty;

            $result['lead_time'] = $product['0']->lead_time;
            $result['tax_id'] = $product['0']->tax_id;
            $result['is_promo'] = $product['0']->is_promo;
            $result['is_featured'] = $product['0']->is_featured;
            $result['is_discounted'] = $product['0']->is_discounted;
            $result['is_trending'] = $product['0']->is_trending;

            $result['status'] = $product['0']->status;
            $result['id'] = $product['0']->id;

            $result['productAttrArr'] = DB::table('product_attrs')->where(['product_id' => $product_id])->get();

            $productImagesArr = DB::table('product_images')->where(['product_id' => $product_id])->get();

            if (!isset($productImagesArr[0])) {
                $result['productImagesArr']['0']['id'] = '';
                $result['productImagesArr']['0']['images'] = '';
            } else {
                $result['productImagesArr'] = $productImagesArr;
            }
        } else {
            $result['category_id'] = '';
            $result['name'] = '';
            $result['slug'] = '';
            $result['image'] = '';
            $result['brand'] = '';
            $result['model'] = '';
            $result['short_description'] = '';
            $result['description'] = '';
            $result['keywords'] = '';
            $result['technical_specification'] = '';
            $result['uses'] = '';
            $result['warranty'] = '';

            $result['lead_time'] = '';
            $result['tax_id'] = '';
            $result['is_promo'] = '';
            $result['is_featured'] = '';
            $result['is_discounted'] = '';
            $result['is_trending'] = '';

            $result['status'] = '';
            $result['id'] = 0;

            $result['productAttrArr'][0]['id'] = '';
            $result['productAttrArr'][0]['product_id'] = '';
            $result['productAttrArr'][0]['sku'] = '';
            $result['productAttrArr'][0]['attr_image'] = '';
            $result['productAttrArr'][0]['mrp'] = '';
            $result['productAttrArr'][0]['price'] = '';
            $result['productAttrArr'][0]['quantity'] = '';
            $result['productAttrArr'][0]['size_id'] = '';
            $result['productAttrArr'][0]['color_id'] = '';

            $result['productImagesArr']['0']['id'] = '';
            $result['productImagesArr']['0']['images'] = '';
        }

        $result['category'] = DB::table('categories')->where(['status' => 1])->get();

        $result['sizes'] = DB::table('sizes')->where(['status' => 1])->get();

        $result['colors'] = DB::table('colors')->where(['status' => 1])->get();

        $result['brands'] = DB::table('brands')->where(['status' => 1])->get();

        $result['taxes'] = DB::table('taxes')->where(['status' => 1])->get();

        // echo "<pre>";
        // print_r($result['productAttrArr']);
        // die();

        return view('admin.product.manage_product', $result);
    }

    public function manage_product_process(Request $request)
    {
        // return $request->post();
        // echo '<pre>';
        // print_r($request->post());
        // die();

        if ($request->post('id') > 0) {
            $image_validation = "mimes:jpeg,jpg,png";
        } else {
            $image_validation = "required|mimes:jpeg,jpg,png";
        }
        $request->validate([
            'name' => 'required',
            'image' => $image_validation,
            'slug' => 'required|unique:products,slug,' . $request->post('id'),
            'attr_image.*' => 'mimes:png,jpg,jpeg',
            'images.*' => 'mimes:jpg,jpeg,png'
        ]);

        $skuArr = $request->post('sku');
        $mrpArr = $request->post('mrp');
        $priceArr = $request->post('price');
        $quantityArr = $request->post('quantity');
        $size_idArr = $request->post('size_id');
        $color_idArr = $request->post('color_id');
        $paidArr = $request->post('paid');
        foreach ($skuArr as $key => $value) {
            $check = DB::table('product_attrs')->where('sku', '=', $skuArr[$key])->where('id', '!=', $paidArr[$key])->get();

            if (isset($check[0])) {
                $request->session()->flash('error_message', $skuArr[$key] . ' SKU is already used!');
                return redirect(request()->headers->get('referer'));
            }
        }

        if ($request->post('id') > 0) {
            $product = Product::find($request->post('id'));
            $msg = "Product has been updated successfully!";
        } else {
            $product = new Product();
            $msg = "Product has been created successfully!";
        }

        if ($request->hasfile('image')) {

            if ($request->post('id') > 0) {
                $arrImage = DB::table('products')->where(['id' => $request->post('id')])->get();
                if (Storage::exists('/public/media/' . $arrImage[0]->image)) {
                    Storage::delete('/public/media/' . $arrImage[0]->image);
                }
            }

            $image = $request->file('image');
            $ext = $image->extension();
            $image_name = time() . '.' . $ext;
            $image->storeAs('/public/media', $image_name);
            $product->image = $image_name;
        }

        $product->category_id = $request->post('category_id');
        $product->name = $request->post('name');
        $product->slug = $request->post('slug');
        $product->brand = $request->post('brand');
        $product->model = $request->post('model');
        $product->short_description = $request->post('short_description');
        $product->description = $request->post('description');
        $product->keywords = $request->post('keywords');
        $product->technical_specification = $request->post('technical_specification');
        $product->uses = $request->post('uses');
        $product->warranty = $request->post('warranty');

        $product->lead_time = $request->post('lead_time');
        $product->tax_id = $request->post('tax_id');
        $product->is_promo = $request->post('is_promo');
        $product->is_featured = $request->post('is_featured');
        $product->is_discounted = $request->post('is_discounted');
        $product->is_trending = $request->post('is_trending');

        $product->status = 1;
        $product->save();

        $pid = $product->id;

        // Product Attr Start

        // $skuArr = $request->post('sku');
        // $mrpArr = $request->post('mrp');
        // $priceArr = $request->post('price');
        // // $imageArr = $request->post('attr_image');
        // $quantityArr = $request->post('quantity');
        // $size_idArr = $request->post('size_id');
        // $color_idArr = $request->post('color_id');
        // $paidArr = $request->post('paid');

        foreach ($skuArr as $key => $value) {
            $productAttrArr = [];
            $productAttrArr['product_id'] = $pid;
            $productAttrArr['sku'] = $skuArr[$key];
            // $productAttrArr['attr_image'] = $imageArr[$key];
            $productAttrArr['mrp'] = (int)$mrpArr[$key];
            $productAttrArr['price'] = (int)$priceArr[$key];
            $productAttrArr['quantity'] = (int)$quantityArr[$key];

            if ($size_idArr[$key] == '') {
                $productAttrArr['size_id'] = 0;
            } else {
                $productAttrArr['size_id'] = $size_idArr[$key];
            }

            if ($color_idArr[$key] == '') {
                $productAttrArr['color_id'] = 0;
            } else {
                $productAttrArr['color_id'] = $color_idArr[$key];
            }

            // $productAttrArr['attr_image'] = 'test';

            if ($request->hasFile("attr_image.$key")) {

                if ($paidArr[$key] != '') {

                    $arrImage = DB::table('product_attrs')->where(['id' => $paidArr[$key]])->get();

                    if (Storage::exists('/public/media/' . $arrImage[0]->attr_image)) {
                        Storage::delete('/public/media/' . $arrImage[0]->attr_image);
                    }
                }

                $rand = rand('111111111', '999999999');
                $attr_image = $request->file("attr_image.$key");
                $ext = $attr_image->extension();
                $image_name = $rand . '.' . $ext;
                $request->file("attr_image.$key")->storeAs('/public/media', $image_name);
                $productAttrArr['attr_image'] = $image_name;
            }
            // else {
            //     $productAttrArr['attr_image'] = 'default.jpg';
            // }

            if ($paidArr[$key] != '') {
                DB::table('product_attrs')->where(['id' => $paidArr[$key]])->update($productAttrArr);
            } else {
                DB::table('product_attrs')->insert($productAttrArr);
            }

            // $productAttrArr['product_id'] = $pid;
            // DB::table('product_attrs')->insert($productAttrArr);
        }

        // Product Attr End

        /*Product Images Start*/
        $piidArr = $request->post('piid');
        foreach ($piidArr as $key => $val) {
            $productImageArr['product_id'] = $pid;
            if ($request->hasFile("images.$key")) {

                if ($piidArr[$key] != '') {
                    $arrImage = DB::table('product_images')->where(['id' => $piidArr[$key]])->get();
                    if (Storage::exists('/public/media/' . $arrImage[0]->images)) {
                        Storage::delete('/public/media/' . $arrImage[0]->images);
                    }
                }

                $rand = rand('111111111', '999999999');
                $images = $request->file("images.$key");
                $ext = $images->extension();
                $image_name = $rand . '.' . $ext;
                $request->file("images.$key")->storeAs('/public/media', $image_name);
                $productImageArr['images'] = $image_name;

                if ($piidArr[$key] != '') {
                    DB::table('product_images')->where(['id' => $piidArr[$key]])->update($productImageArr);
                } else {
                    DB::table('product_images')->insert($productImageArr);
                }
            }
        }
        /*Product Images End*/

        $request->session()->flash('message', $msg);

        return redirect('admin/product');
    }

    public function delete_product(Request $request, $product_id)
    {
        $arrImage = DB::table('products')->where(['id' => $product_id])->get();

        if (Storage::exists('/public/media/' . $arrImage[0]->image)) {
            Storage::delete('/public/media/' . $arrImage[0]->image);
        }

        $product = Product::find($product_id);
        $product->delete();
        $request->session()->flash('message', 'Product has been deleted successfully!');
        return redirect('admin/product');
    }

    public function product_attr_delete(Request $request, $product_attribute_id, $product_id)
    {
        $arrImage = DB::table('product_attrs')->where(['id' => $product_attribute_id])->get();

        if (Storage::exists('/public/media/' . $arrImage[0]->attr_image)) {
            Storage::delete('/public/media/' . $arrImage[0]->attr_image);
        }

        DB::table('product_attrs')->where(['id' => $product_attribute_id])->delete();
        return redirect('admin/product/manage_product/' . $product_id);
    }

    public function product_images_delete(Request $request, $paid, $pid)
    {
        $arrImage = DB::table('product_images')->where(['id' => $paid])->get();

        if (Storage::exists('/public/media/' . $arrImage[0]->images)) {
            Storage::delete('/public/media/' . $arrImage[0]->images);
        }

        DB::table('product_images')->where(['id' => $paid])->delete();
        return redirect('admin/product/manage_product/' . $pid);
    }

    public function product_status(Request $request, $status, $product_id)
    {
        $product = Product::find($product_id);
        $product->status = $status;
        $product->save();
        $request->session()->flash('message', 'Product status has been updated successfully!');
        return redirect('admin/product');
    }
}
