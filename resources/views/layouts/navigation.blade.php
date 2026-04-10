<nav class="header">

    <!-- ロゴ -->
    <div class="logo">
        🛒 MyShop
    </div>

    <!-- メニュー -->
    <div class="nav-links">
        <a href="/">商品一覧</a>

        <a href="/cart">
            カート（<span id="cart-count">{{ count(session('cart', [])) }}</span>）
        </a>
    </div>

    <!-- ユーザー -->
    <div class="user-area">
        @auth
            <span>{{ Auth::user()->name }}</span>

            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit">ログアウト</button>
            </form>
        @else
            <a href="/login">ログイン</a>
            <a href="/register">登録</a>
        @endauth
    </div>

</nav>

<!-- カート件数を毎回更新 -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    fetch('/cart/count')
        .then(res => res.json())
        .then(data => {
            const el = document.getElementById('cart-count');
            if (el) {
                el.innerText = data.count;
            }
        });
});
</script>