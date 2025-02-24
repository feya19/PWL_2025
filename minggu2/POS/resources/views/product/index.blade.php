<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Index</title>
</head>
<body>
    <h1>Product Index Page</h1>
    <h2>Product Category : </h2>
    <li><a href="{{ route('product.food-beverage')}}"> Produk Makanan dan Minuman</a></li>
    <li><a href="{{ route('product.beauty-health')}}">Produk Kecantikan dan Kesehatan</a></li>
    <li><a href="{{ route('product.home-care')}}">Produk Perawatan Rumah</a> </li>
    <li><a href="{{ route('product.baby-kid')}}">Produk Bayi dan Anak-anak</a> </li>

</body>
</html>