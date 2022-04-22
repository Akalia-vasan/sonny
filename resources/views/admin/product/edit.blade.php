@extends('admin.layouts.admin')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9">
        <h2>Edit Product </h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.home') }}">Home</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Edit Product </strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">

    <div class="row">
        <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Edit Product </h5>
                    </div>
                    <div class="ibox-content">
                        <form action="{{ route('admin.product.update',$product->id) }}" method="POST"  enctype="multipart/form-data">
                            @csrf
                            {{ method_field('PUT') }}
                            <input type="hidden" class="form-control" name="id" value="{{ $product->id}}" />
                                 
                            <div class="form-group row">
                                <div class="col-sm-2 col-sm-offset-2">
                                    <b><span>Choose Center </span></b>
                                </div>
                                <div class="col-sm-8 mb-2">
                                    <select name="center_id" class="chosen-select form-control"  tabindex="-1">
                                        <option value="0"> -- Select Center-- </option>
                                        @foreach($center as $center1)
                                            <option  @if($product->center_id == $center1->id) selected @endif  value="{{ $center1->id}}">{{ $center1->center_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-2 col-sm-offset-2">
                                    <b><span>Choose Product Category </span></b>
                                </div>
                                <div class="col-sm-8 mb-2">
                                    <select name="product_cat_id" class="chosen-select form-control"  tabindex="-2">
                                            <option value="0"> -- Select Product Category-- </option>
                                            @foreach($productcategory as $productcategory1)
                                                <option  @if($product->product_cat_id == $productcategory1->id) selected @endif  value="{{ $productcategory1->id}}">{{ $productcategory1->category_name }}</option>
                                            @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-2 col-sm-offset-2">
                                    <b><span>Product Name </span></b>
                                </div>
                                <div class="col-sm-8 mb-2">
                                    <input type="text" class="form-control" name="product_name"  value="{{ $product->product_name }}"/>
                                    @if($errors->has('product_name'))
                                    <div class="error">{{ $errors->first('product_name') }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-2 col-sm-offset-2">
                                    <b><span>Product Price </span></b>
                                </div>
                                <div class="col-sm-8 mb-2">
                                    <input  type="number" min="1" class="form-control" name="product_price" value="{{ $product->product_price }}" />
                                    @if($errors->has('product_price'))
                                    <div class="error">{{ $errors->first('product_price') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2 col-sm-offset-2">
                                    <b><span>Offer Price </span></b>
                                </div>
                                <div class="col-sm-8 mb-2">
                                    <input  type="number" min="1" class="form-control" name="offer_price"  value="{{ $product->offer_price }}" />
                                    @if($errors->has('offer_price'))
                                    <div class="error">{{ $errors->first('offer_price') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2 col-sm-offset-2">
                                    <b><span>Slug </span></b>
                                </div>
                                <div class="col-sm-8 mb-2">
                                    <input type="text" class="form-control" name="slug"   value="{{ $product->slug }}"/>
                                    @if($errors->has('slug'))
                                    <div class="error">{{ $errors->first('slug') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2 col-sm-offset-2">
                                    <b><span>Product Stock </span></b>
                                </div>
                                <div class="col-sm-8 mb-2">
                                    <input  type="number" min="1" class="form-control" name="stock"   value="{{ $product->stock }}" />
                                    @if($errors->has('stock'))
                                    <div class="error">{{ $errors->first('stock') }}</div>
                                    @endif
                                </div>
                            </div> 
                            <div class="form-group row" id="choose_file">
                                <div class="col-sm-2 col-sm-offset-2">
                                    <b><span>Product Image</span></b>
                                </div>
                                <div class="col-sm-8 mb-2">
                                    <div class="custom-file">
                                        <input id="logo" type="file" name="product_image" accept="image/*" class="custom-file-input">
                                        <label for="logo" class="custom-file-label">Choose file...</label>
                                        @if($errors->has('product_image'))
                                        <div class="error">{{ $errors->first('product_image') }}</div>
                                        @endif
                                    </div> 
                                </div>
                                <div class="col-sm-2 mb-2">
                                    <img src="{{ $product->product_image }}" height="50px" width="50px" />                          
                                </div>
                            </div> 
                    
                

                                    <div class="form-group row">
                                        <div class="col-sm-2 col-sm-offset-2">
                                            <b><span>Status </span></b>
                                        </div>
                                        <div class="col-sm-8 mb-2">
                                            <input type="checkbox" name="status" class="js-switch" @if($product->active == '1') checked @endif />
                                            @if($errors->has('status'))
                                            <div class="error">{{ $errors->first('status') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-2 col-sm-offset-2">
                                            <b><span>Is Favorite </span></b>
                                        </div>
                                        <div class="col-sm-8 mb-2">
                                            <input type="checkbox" name="fav" class="js-switch1" @if($product->fav == '1') checked @endif />
                                            @if($errors->has('fav'))
                                                <div class="error">{{ $errors->first('fav') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <div class="col-sm-3 col-sm-offset-2">
                                            <button class="btn btn-primary btn-md" type="submit">Update</button>
                                        </div>
                                    </div>
                               
                        </form>
                    </div>
                </div>
        </div>
    </div>
</div>
@endsection
@push('script')
<script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>

<!-- Chosen -->
<script src="{{ asset('js/plugins/chosen/chosen.jquery.js') }}"></script>
    <script>
        var elem = document.querySelector('.js-switch');
        var switchery = new Switchery(elem, { color: '#1AB394' });

        var elem1 = document.querySelector('.js-switch1');
        var switchery1 = new Switchery(elem1, { color: '#1AB394' });

        $(document).ready(function(){

            $('.chosen-select').chosen({width: "100%"});

            $('.custom-file-input').on('change', function() {
                let fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').addClass("selected").html(fileName);
            }); 

        });
    </script>
@endpush

