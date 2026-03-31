<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>商品一覧</title>

    <script>
    function addToCart(productId) {
        fetch('/cart/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ product_id: productId })
        })
        .then(res => res.json())
        .then(data => {
            alert('カートに追加しました');
        });
    }
    </script>
</head>
<body>
    <h1>商品一覧</h1>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <a href="/cart">カートを見る</a>

    <table border="1">
        <tr>
            <th>商品名</th>
            <th>価格</th>
            <th>在庫</th>
            <th>操作</th>
        </tr>

        @foreach ($products as $product)
        <tr>
            <td>{{ $product->name }}</td>
            <td>{{ $product->price }}</td>
            <td>{{ $product->stock }}</td>
            <td>
                @auth
                    @if ($product->stock > 0)
                        <button onclick="addToCart({{ $product->id }})">
                            カートに追加
                        </button>
                    @else
                        売り切れ
                    @endif
                @else
                    <a href="/login">ログインして購入</a>
                @endauth
            </td>
        </tr>
        @endforeach
    </table>
</body>
</html>