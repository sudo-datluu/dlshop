@extends('front.layouts.app')
@extends('front.layouts.search')
@extends('front.layouts.category')
@section('content')

			<div class="col-md-9">
				<div class="row pb-3">
					@if ($products->isNotEmpty())
					@foreach ($products as $product)
					<div class="col-md-4">
						<div class="card product-card">
							<div class="product-image position-relative">
								<a href="{{ route('front.product', $product->slug) }}" class="product-img">
									<img class="custom-product-img card-img-top" src="{{ $product->image }}" alt="">
								</a>

								<div class="product-action">
									@if ($product->qty > 0)
									<a href="javascript:void(0);" onclick="addToCart({{ $product->id }});" class="btn btn-dark">
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
								<a class="h6 link" href="{{ route('front.product', $product->slug) }}">{{$product->title}}</a>
								<div class="price mt-2">
									<span class="h5"><strong>${{$product->price}}</strong></span>
									<br>
									@if ($product->qty > 0)
									<span class="h6 texy-primary">Instock: {{$product->qty}} {{$product->unit}}</span>
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
		
@endsection