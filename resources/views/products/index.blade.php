<x-app-layout>

<style>
table {
    border-collapse: collapse;
    width: 60%;
    margin-top: 20px;
}

th, td {
    border: 1px solid #333;
    padding: 10px;
    text-align: center;
}

th {
    background-color: #f0f0f0;
}

tr:nth-child(even) {
    background-color: #fafafa;
}

button {
    padding: 5px 10px;
    background-color: #4CAF50;
    color: white;
    border: none;
    cursor: pointer;
}

button:hover {
    background-color: #45a049;
}

a {
    color: blue;
    text-decoration: underline;
}
</style>

<h1>商品一覧</h1>

@if (session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif

<a href="/cart">カートを見る</a>

<table>
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
        document.getElementById('cart-count').innerText = data.count;
        alert('カートに追加しました');
    });
}
</script>

</x-app-layout>