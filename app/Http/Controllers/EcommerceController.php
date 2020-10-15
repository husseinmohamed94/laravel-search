<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\Tag;
use Nicolaslopezj\Searchable\SearchableTrait;
use Illuminate\Support\Facades\Validator;

class EcommerceController extends Controller
{

    public function index(Request $request){

        $keyword            = $request->has('keyword') ? $request->get('keyword') : null;
        $selected_price     = $request->has('price') ? $request->get('price') : null;
        $selected_category  = $request->has('category') ? $request->get('category') : null;
        $selected_tags      = $request->has('tags') ? $request->get('tags') :[];

        
        $categiers = Category::all();
        $tags       =  Tag::all(); 

        $products = Product::with(['category','tags']);
            if($keyword != null){
                $products   = $products->search($keyword);
            }

            if($selected_price != null){
                $products = $products->when($selected_price,function($query) use ($selected_price){
                    if($selected_price == 'price_0_500'){
                        $query->whereBetween('price',[0,500]);
                    }elseif($selected_price == 'price_501_1500'){
                        $query->whereBetween('price',[501,1500]);
                    }elseif($selected_price == 'price_1501_3000'){
                        $query->whereBetween('price',[1501,3000]);
                    }elseif($selected_price == 'price_3001_5000'){
                        $query->whereBetween('price',[3001,5000]);
                    }        

                });
            }

            if($selected_category != null){
                $products =$products->whereCategoryId($selected_category);
            }
            if(is_array($selected_tags) && count($selected_tags) > 0){
                $products = $products->whereHas('tags',function($query) use($selected_tags){
                    $query->whereIn('product_tag.tag_id',$selected_tags);
                });
            }


          $products =  $products->orderByDesc('id');
         $products  = $products->paginate(9);
        return view('frontend.index',compact('products','categiers','tags','keyword','selected_price','selected_category','selected_tags'));
    }

    public function index_list(Request $request){

        $keyword            = $request->has('keyword') ? $request->get('keyword') : null;
        $selected_price     = $request->has('price') ? $request->get('price') : null;
        $selected_category  = $request->has('category') ? $request->get('category') : null;
        $selected_tags      = $request->has('tags') ? $request->get('tags') :[];

        
        $categiers = Category::all();
        $tags       =  Tag::all(); 

        $products = Product::with(['category','tags']);
            if($keyword != null){
                $products   = $products->search($keyword);
            }

            if($selected_price != null){
                $products = $products->when($selected_price,function($query) use ($selected_price){
                    if($selected_price == 'price_0_500'){
                        $query->whereBetween('price',[0,500]);
                    }elseif($selected_price == 'price_501_1500'){
                        $query->whereBetween('price',[501,1500]);
                    }elseif($selected_price == 'price_1501_3000'){
                        $query->whereBetween('price',[1501,3000]);
                    }elseif($selected_price == 'price_3001_5000'){
                        $query->whereBetween('price',[3001,5000]);
                    }        

                });
            }

            if($selected_category != null){
                $products =$products->whereCategoryId($selected_category);
            }
            if(is_array($selected_tags) && count($selected_tags) > 0){
                $products = $products->whereHas('tags',function($query) use($selected_tags){
                    $query->whereIn('product_tag.tag_id',$selected_tags);
                });
            }


          $products =  $products->orderByDesc('id');
         $products  = $products->paginate(9);
        return view('frontend.index_list',compact('products','categiers','tags','keyword','selected_price','selected_category','selected_tags'));
    }

    public function create(){
        $categiers = Category::all();
        $tags       =  Tag::all(); 
        return view('frontend.create',compact('categiers','tags'));
    }
    public function store(Request $request){
        $validater= Validator::make($request->all(),[ 
        'name'                     => 'required',
        'description'              => 'required',
        'price'                    => 'required|numeric',
        'category_id'              => 'required',
        'tags'                     => 'required',
        'image'                     => 'required|url',
        ]);
        if($validater->fails()){
            return redirect()->back()->withErrors($validater)->withInput();
        }
        $product = Product::create([
            'name'                     => $request->name,
            'description'              => $request->description,
            'price'                    => $request->price,
            'category_id'              => $request->category_id,
            'image'                     => $request->image,
                 ]);
            $product->tags()->attach($request->tags);

            return redirect()->route('ecommerce.index_list')->with([
                'message' => 'product added successfully',
                'alert-type' => 'success'
            ]);

    }
    public function edit($id){
        $product = Product::whereId($id)->first();
        $categiers = Category::all();
        $tags       =  Tag::all(); 
        return view('frontend.edit',compact('product','categiers','tags'));
    }
    public function update(Request $request ,$id){
        $validater= Validator::make($request->all(),[ 
            'name'                     => 'required',
            'description'              => 'required',
            'price'                    => 'required|numeric',
            'category_id'              => 'required',
            'tags'                     => 'required',
            'image'                     => 'required|url',
            ]);
            if($validater->fails()){
                return redirect()->back()->withErrors($validater)->withInput();
            }
            $product = Product::whereId($id)->first();

            $data['name']            =$request->name;
            $data['description']     = $request->description;
            $data['price']           = $request->price;
            $data['category_id']     = $request->category_id;
            $data['image']           = $request->image;

            $product->update($data);
            $product->tags()->sync($request->tags);


                return redirect()->route('ecommerce.index_list')->with([
                    'message' => 'product update successfully',
                    'alert-type' => 'success'
                ]);
    
    }
    public function destroy($id){
        $product = Product::whereId($id)->first();
        if($product){
            $product->delete();
            return redirect()->route('ecommerce.index_list')->with([
                'message' => 'product delete successfully',
                'alert-type' => 'success'
            ]);
        }
        return redirect()->back();

    }

    }
