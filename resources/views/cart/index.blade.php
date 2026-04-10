<x-app-layout>

<h1>カート</h1>

<a href="/">← 商品一覧へ戻る</a>

<div class="cart-list">

    @php $total = 0; @endphp

    @foreach ($products as $product)
    <div class="cart-card">

        <h2>{{ $product->name }}</h2>

        <p>価格：¥{{ number_format($product->price) }}</p>

        <p>数量：{{ $cart[$product->id] }}</p>

        <p>
            小計：
            ¥{{ number_format($product->price * $cart[$product->id]) }}
        </p>

        <form method="POST" action="/cart/remove">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <button type="submit" class="delete-btn">
                削除
            </button>
        </form>

    </div>

    @php $total += $product->price * $cart[$product->id]; @endphp
    @endforeach

</div>

<h2 class="total">合計：¥{{ number_format($total) }}</h2>

<button onclick="checkout()" class="checkout-btn">
    注文する
</button>

<script>
function checkout() {

    const token = document.querySelector('meta[name="csrf-token"]').content;

    fetch('/cart/count')
    .then(res => res.json())
    .then(data => {
        const countEl = document.getElementById('cart-count');
        if (countEl) {
            countEl.innerText = data.count;
        }
    });

    fetch('/order/checkout', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
        }
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);
        location.href = '/';
    })
    .catch(() => {
        alert('注文に失敗しました');
    });
}
</script>

</x-app-layout>