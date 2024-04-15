@section('category')
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
@endsection