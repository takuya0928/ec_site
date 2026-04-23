
<x-app-layout>

<h1 style="color:red;">ここ管理画面です</h1>
<h1>商品管理</h1>

<a href="/admin/products/create">＋ 商品を追加</a>

<table border="1" style="margin-top:20px;">
    <tr>
        <th>ID</th>
        <th>商品名</th>
        <th>価格</th>
        <th>在庫</th>
        <th>操作</th>
    </tr>

    @foreach ($products as $product)
    
    <tr>
        <td>{{ $product->id }}</td>
        <td>{{ $product->name }}</td>
        <td>¥{{ number_format($product->price) }}</td>
        <td>{{ $product->stock }}</td>
        <td>
            <a href="/admin/products/{{ $product->id }}/edit">編集</a>

            <form method="POST" action="/admin/products/{{ $product->id }}" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" onclick="return confirm('削除しますか？')">
            削除
        </button>
    </form>

        </td>
    </tr>
    @endforeach
</table>

</x-app-layout>