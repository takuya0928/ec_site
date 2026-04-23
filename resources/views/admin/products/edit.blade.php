<x-app-layout>

<h1>商品編集</h1>

<form method="POST" action="/admin/products/{{ $product->id }}">
    @csrf
    @method('PUT')

    <p>
        商品名<br>
        <input type="text" name="name" value="{{ $product->name }}">
    </p>

    <p>
        価格<br>
        <input type="number" name="price" value="{{ $product->price }}">
    </p>

    <p>
        在庫<br>
        <input type="number" name="stock" value="{{ $product->stock }}">
    </p>

    <button type="submit">更新</button>
</form>

</x-app-layout>