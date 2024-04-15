@section('cart-and-search-box')
<div class="col-lg-6 col-6 text-left d-flex justify-content-end align-items-center">
    <a href="cart.php" class="ml-3 nav-link d-flex">
        <i class="fas fa-shopping-cart text-primary"></i>					
    </a>
    <form action="{{ route('front.home') }}", method="get">					
        <div class="input-group">
            <input value="{{ Request::get('search') }}" name="search" type="text" placeholder="Search For Products" class="form-control" aria-label="Amount (to the nearest dollar)">
            <button class="input-group-text" type="submit">
                <i class="fa fa-search"></i>
            </button>
        </div>
    </form>
</div>	
@endsection