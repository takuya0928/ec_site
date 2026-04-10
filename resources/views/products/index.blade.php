<x-app-layout>

<h1>商品一覧</h1>

@if (session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif

<div class="product-list">

    @foreach ($products as $product)
    <div class="product-card">

        <h2>{{ $product->name }}</h2>

        <p>価格：¥{{ number_format($product->price) }}</p>

        <p>
            在庫：
            @if ($product->stock > 0)
                {{ $product->stock }}
            @else
                <span class="soldout">売り切れ</span>
            @endif
        </p>

        @auth
            @if ($product->stock > 0)
                <button onclick="addToCart({{ $product->id }})">
                    カートに追加
                </button>
            @endif
        @else
            <a href="/login">ログインして購入</a>
        @endauth

    </div>
    @endforeach

</div>

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