<!doctype html>
<html lang="{{ app()->getLocale() }}" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap core CSS -->
    <link href = {{ asset("css/app.css") }} rel="stylesheet" />

    <title>Cart</title>
</head>

<body>
<div class="container">
    <div class="col-lg-9"><h1>Cart({{ $products_count }})</h1></div>
    <div class="col-lg-3"><h1><a href="{{url('products')}}">Product List</a></h1></div>
        <div class="font-weight-bold col-lg-2"><strong>Name</strong></div>
        <div class="font-weight-bold col-lg-2"><strong>Quantity</strong></div>
        <div class="font-weight-bold col-lg-2"><strong>Price</strong></div>
        <div class="font-weight-bold col-lg-2"><strong>Action</strong></div>
    <div class="clearfix"></div>
    <br />

    @foreach ($products as $product)
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-2">{{ $product['name'] }}</div>
                <div class="col-lg-2">{{ $product['quantity'] }}</div>
                <div class="col-lg-2">${{ $product['price'] }}</div>
                <div class="col-lg-2">
                    <form method="POST" action="{{url('cart/remove')}}">
                        <input type="hidden" name="id" value="{{ $product['id'] }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <button type="submit" class="btn btn-danger">
                            Remove
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <br />
    @endforeach

    <br />
    <div class="row">
        <div class="col-lg-10">
            <div class="row"><span>Total Price: <strong>${{ $total_price }}</strong></span></div>
            <div class="row">Discount: <strong>${{ $discount }}</strong></div>
        </div>
        @if (count($products))
            <div class="col-lg-2">
                <form method="POST" action="{{url('cart/clear')}}">
                    <input type="hidden" name="user_id" value="1">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <button type="submit" class="btn btn-danger">
                        Clear cart
                    </button>
                </form>
            </div>
        @endif
    </div>
    <div class="clearfix"></div>
    <br />
    <div class="ront" style="font-size: x-large">Order Price: <strong>${{ $order_price }}</strong></div>
</div>
</body>

</html>