<!DOCTYPE html>
<html>
<head>
    <title>カート</title>
</head>
<body>
    <h1>カート</h1>

    <a href="/">商品一覧へ戻る</a>

    <table border="1">
        <tr>
            <th>商品名</th>
            <th>価格</th>
            <th>数量</th>
            <th>小計</th>
            <th>操作</th>
        </tr>

        @php $total = 0; @endphp

        @foreach ($products as $product)
        <tr>
            <td>{{ $product->name }}</td>
            <td>{{ $product->price }}</td>
            <td>{{ $cart[$product->id] }}</td>
            <td>{{ $product->price * $cart[$product->id] }}</td>

            <td>
                <form method="POST" action="/cart/remove">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <button type="submit">削除</button>
                </form>
            </td>
        </tr>

        @php $total += $product->price * $cart[$product->id]; @endphp
        @endforeach
    </table>

    <h2>合計: {{ $total }} 円</h2>

    <form method="POST" action="/order">
    @csrf
    <button type="submit">注文する</button>
</form>

</body>
</html>