<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap core CSS -->
    <link href = {{ asset("css/app.css") }} rel="stylesheet" />

    <title>Products</title>
</head>

<body>
<div class="container">
    <div class="row">
        <div class="col-lg-10"><h1>Product List</h1></div>
        <div class="col-lg-2"><h1><a href="{{url('cart/')}}">Cart({{ $items_count }})</a></h1></div>
        @foreach ($products as $product)
            <div class="col-lg-6">
                <div class="product-item">
                    <h3 style="font-weight: bold;">${{ $product->price }}</h3>
                    <p>{{ $product->name }}</p>
                    <form method="POST" action="{{url('cart/add')}}">
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <button type="submit" class="btn btn-success">
                            Add to cart
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>
</body>

</html>