@extends('front.layouts.app')
@extends('front.layouts.search')
@extends('front.layouts.category')

@section('content')
<div class="col-md-9">
    <div class="row">
        <div class="col-md-5">
            <img class="w-100 h-100" src="{{$product->image}}" alt="Image">
        </div>
        <div class="col-md-7">
            <div class="bg-light right">
                <h1>{{$product->title}}</h1>
                <h2 class="pt-2 price">${{$product->price}}</h2>
                @if ($product->qty > 0)
                <p class="h6 texy-primary">Instock: {{$product->qty}} {{$product->unit}}</p>
                @else
                <p class="h6 text-danger">Out of stock</p>
                @endif
                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Perferendis officiis dolor aut nihil iste porro ullam repellendus inventore voluptatem nam veritatis exercitationem doloribus voluptates dolorem nobis voluptatum qui, minus facere.</p>

                @if ($product->qty > 0)
                <a href="javascript:void(0);" onclick="addToCart({{ $product->id }});" class="btn btn-dark">
                    <i class="fas fa-shopping-cart"></i> &nbsp;ADD TO CART
                </a>
                @else
                <a href="#" class="btn btn-dark disabled">
                    <i class="fas fa-shopping-cart"></i> &nbsp;OUT OF STOCK
                </a>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-9 mt-4">
        <div class="section-title">
            <h2>Related Products</h2>
        </div>
        <div class="row pb-3">
            @if ($relatedProducts->isNotEmpty())
            @foreach ($relatedProducts as $relatedProduct)
            <div class="col-md-4">
                <div class="card product-card">
                    <div class="product-image position-relative">
                        <a href="{{ route('front.product', $relatedProduct->slug) }}" class="card-img-top"><img class="custom-product-img card-img-top" src="{{$relatedProduct->image}}" alt=""></a>
                        <div class="product-action">
                            @if ($relatedProduct->qty > 0)
                            <a href="javascript:void(0);" onclick="addToCart({{ $relatedProduct->id }});" class="btn btn-dark">
                                <i class="fa fa-shopping-cart"></i> Add To Cart
                            </a>
                            @else
                            <a class="btn btn-dark disabled" href="#">
                                <i class="fa fa-shopping-cart"></i> Out of stock
                            </a>
                            @endif
                        </div>
                    </div>
                    <div class="card-body text-center mt-3">
                        <a class="h6 link" href="{{ route('front.product', $relatedProduct->slug) }}">{{$relatedProduct->title}}</a>
                        <div class="price mt-2">
                            <span class="h5"><strong>${{$relatedProduct->price}}</strong></span>
                            <br>
                            @if ($relatedProduct->qty > 0)
                            <span class="h6 texy-primary">Instock: {{$relatedProduct->qty}} {{$relatedProduct->unit}}</span>
                            @else
                            <span class="h6 text-danger">Out of stock</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @endif
        </div>
    </div>
</div>
@endsection