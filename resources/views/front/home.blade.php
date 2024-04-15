@extends('front.layouts.app')
@extends('front.layouts.search')

@section('custom-css')
<link rel="stylesheet" type="text/css" href="{{ asset('front-assets/css/home.css') }}" />
@endsection


@section('content')
<section class="section-6 pt-3">
	<div class="container">
		<div class="row">
			<div class="col-md-3 sidebar">
				<div class="sub-title">
					<h2>Categories</h3>
				</div>

				<div class="card">
					<div class="card-body">

						<div class="accordion accordion-flush" id="accordionExample">
							@if(getCategories()->isNotEmpty())
							@foreach(getCategories() as $key => $category)
							<div class="accordion-item">
								<h2 class="accordion-header" id="headingOne">
									<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne-{{$key}}" aria-expanded="false" aria-controls="collapseOne"> {{$category->name}}</button>
								</h2>
								<div id="collapseOne-{{$key}}" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
									<div class="accordion-body">
										<div class="navbar-nav">
											<a href="{{route('front.home', $category->slug)}}" class="nav-link nav-item">All {{$category->name }}</a>
											@if($category->sub_category->isNotEmpty())
											@foreach($category->sub_category as $subcategory)
											<a href="{{route('front.home', [$category->slug, $subcategory->slug])}}" class="nav-item nav-link">{{ $subcategory->name }}</a>
											@endforeach
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
			</div>
			<div class="col-md-9">
				<div class="row pb-3">
					<div class="col-12 pb-1">
						<div class="d-flex align-items-center justify-content-end mb-4">
							<div class="ml-2">
								<div class="btn-group">
									<button type="button" class="btn btn-sm btn-light dropdown-toggle" data-bs-toggle="dropdown">Sorting</button>
									<div class="dropdown-menu dropdown-menu-right">
										<a class="dropdown-item" href="#">Latest</a>
										<a class="dropdown-item" href="#">Price High</a>
										<a class="dropdown-item" href="#">Price Low</a>
									</div>
								</div>
							</div>
						</div>
					</div>

					@if ($products->isNotEmpty())
					@foreach ($products as $product)
					<div class="col-md-4">
						<div class="card product-card">
							<div class="product-image position-relative">
								<a href="" class="product-img"><img class="custom-product-img card-img-top" src="{{ $product->image }}" alt=""></a>

								<div class="product-action">
									@if ($product->qty > 0)
									<a class="btn btn-dark" href="#">
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
								<a class="h6 link" href="product.php">{{$product->title}}</a>
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
					<!-- <div class="col-md-12 pt-5">
						<nav aria-label="Page navigation example">
							<ul class="pagination justify-content-end">
								<li class="page-item disabled">
									<a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
								</li>
								<li class="page-item"><a class="page-link" href="#">1</a></li>
								<li class="page-item"><a class="page-link" href="#">2</a></li>
								<li class="page-item"><a class="page-link" href="#">3</a></li>
								<li class="page-item">
									<a class="page-link" href="#">Next</a>
								</li>
							</ul>
						</nav>
					</div> -->
				</div>
			</div>
		</div>
	</div>
</section>
@endsection