@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-3">
          <form action="{{route('ecommerce.index_list')}}" method="post">
          @csrf
           <h3>search</h3>
              <div class="form-group pd-3">
                <input type="text" name="keyword" class="form-control" value="{{old('keyword',$keyword)}}">
              </div>
                <div class="pd-3">
                   <h3>price</h3> 
                     <div class="form-check">
                         <label for="" class="form-check-label">
                            <input type="radio" class="form-check-input" name="price" value="price_0_500" {{isset($selected_price) && $selected_price =='price_0_500' ? 'checked' : '' }}> 0-500
                         </label>
                     </div>
                     <div class="form-check">
                         <label for="" class="form-check-label">
                            <input type="radio" class="form-check-input" name="price" value="price_501_1500"{{isset($selected_price) && $selected_price =='price_501_1500' ? 'checked' : '' }} > 501-1500
                         </label>
                     </div>
                     <div class="form-check">
                         <label for="" class="form-check-label">
                            <input type="radio" class="form-check-input" name="price" value="price_1501_3000" {{isset($selected_price) && $selected_price =='price_1501_3000' ? 'checked' : '' }}> 1501-3000
                         </label>
                     </div>
                     <div class="form-check">
                         <label for="" class="form-check-label">
                            <input type="radio" class="form-check-input" name="price" value="price_3001_5000" {{isset($selected_price) && $selected_price =='price_3001_5000' ? 'checked' : '' }}> 3001-5000
                         </label>
                     </div>
                </div>
                 <div class="pb-3">
                    <h3>category</h3>
                        @foreach($categiers as $category)
                        <div class="form-check">
                         <label for="" class="form-check-label">
                            <input type="radio" class="form-check-input" name="category" value="{{$category->id}}" {{isset($selected_category) && $selected_category == $category->id ? 'checked' : '' }}> {{$category->name}}
                         </label>
                         </div>
                        @endforeach
                 </div>
                 <div class="pb-3">
                    <h3>Tags</h3>
                        @foreach($tags as $tag)
                        <div class="form-check">
                         <label for="" class="form-check-label">
                            <input type="checkbox" class="form-check-input" name="tags[]" value="{{$tag->id}}" {{isset($selected_tags)&& in_array($tag->id,$selected_tags) ? 'checked' : ''}}> {{$tag->name}}
                         </label>
                         </div>
                        @endforeach
                 </div>
                    <div class="form-group pd-3">
                        <button type="submit" class="btn btn-primary btn-block">Search</button>
                        <a href="{{route('ecommerce.index_list')}}" class="btn btn-danger btn-block ">Reset</a>
                    </div>
          </form>
        </div>
        <div class="col-9">
           <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                       <tr>
                         <th>ID</th>
                         <th>Name</th>
                         <th>Catory</th>
                         <th>Tags</th>
                         <th>price</th>
                         <th>Action</th>

                       </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $product)
                        <tr>
                          <td>{{$product->id}}</td>
                          <td>{{$product->name}}</td>
                          <td>{{$product->category->name}}</td>
                          
                          <td>
                          @foreach($product->tags as $tag)
                              <span class="badge badge-primary">{{$tag->name}}</span>      
                          @endforeach
                          </td>
                            <td>{{$product->price}}</td>
                            <td>
                            <a href="{{route('ecommerce.edit',$product->id)}}" class="btn btn-primary btn-sm">edit</a>
                            <a href="javescript:void(0)" onclick="if(confirm('Are You Sure?')) {document.getElementById('delete--{{$product->id}}').submit();}
                            else{return false;}" class="btn btn-danger btn-sm">delete</a>
                                <form action="{{route('ecommerce.destroy',$product->id)}}" method="post" id="delete--{{$product->id}}" style="displsy:none;">
                                @csrf
                                @method('DELETE')
                                </form>

                                

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
           </div>
           <div class="d-flex justify-content-center">
               
               {{$products->appends(request()->input())->links()}}          
           </div>
       </div>

    </div>

@endsection
