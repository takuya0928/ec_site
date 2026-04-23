<x-app-layout>

<h1>ユーザー管理</h1>

<table border="1" style="margin-top:20px;">
    <tr>
        <th>ID</th>
        <th>名前</th>
        <th>メール</th>
        <th>操作</th>
    </tr>

    @foreach ($users as $user)
    <tr>
        <td>{{ $user->id }}</td>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        <td>
            <form method="POST" action="/admin/users/{{ $user->id }}">
                @csrf
                @method('DELETE')
                <button onclick="return confirm('削除しますか？')">
                    削除
                </button>
            </form>
        </td>
    </tr>
    @endforeach
</table>

</x-app-layout>