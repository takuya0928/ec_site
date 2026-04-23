<x-app-layout>

<h1>商品登録</h1>

<form method="POST" action="/admin/products">
    @csrf

    <p>
        商品名<br>
        <input type="text" name="name">
    </p>

    <p>
        価格<br>
        <input type="number" name="price">
    </p>

    <p>
        在庫<br>
        <input type="number" name="stock">
    </p>

    <button type="submit">登録</button>
</form>

</x-app-layout>