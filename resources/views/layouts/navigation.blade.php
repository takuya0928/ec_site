<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            {{-- 左 --}}
            <div class="flex items-center space-x-6">

                <a href="/" class="text-gray-700 font-bold">
                    商品一覧
                </a>

                <a href="/cart" class="text-gray-700">
                    カート（<span id="cart-count">{{ count(session('cart', [])) }}</span>
                </a>

            </div>

            {{-- 右 --}}
            <div class="hidden sm:flex sm:items-center sm:ms-6">

                @auth
                    <span class="mr-4">{{ Auth::user()->name }}</span>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-600 hover:text-gray-900">
                            ログアウト
                        </button>
                    </form>
                @else
                    <a href="/login" class="mr-4">ログイン</a>
                    <a href="/register">会員登録</a>
                @endauth

            </div>

        </div>
    </div>

    {{-- モバイルメニューはそのまま残してOK --}}
</nav>