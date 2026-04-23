<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>注文完了のお知らせ</title>
</head>
<body style="font-family: Arial, sans-serif; background-color:#f5f5f5; padding:20px;">

    <div style="max-width:600px; margin:auto; background:#ffffff; padding:20px; border-radius:8px;">

        <h1 style="color:#333; text-align:center;">ご注文ありがとうございます！</h1>

        <p>以下の内容でご注文を受け付けました。</p>

        <hr>

        <h2>■ 注文内容</h2>

        <table width="100%" border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse;">
            <tr style="background-color:#f0f0f0;">
                <th align="left">商品名</th>
                <th align="center">数量</th>
                <th align="right">価格</th>
                <th align="right">小計</th>
            </tr>

            @php $total = 0; @endphp

            @foreach ($cart as $id => $qty)
                @php
                    $product = \App\Models\Product::find($id);
                    $subtotal = $product->price * $qty;
                    $total += $subtotal;
                @endphp
                <tr>
                    <td>{{ $product->name }}</td>
                    <td align="center">{{ $qty }}</td>
                    <td align="right">¥{{ number_format($product->price) }}</td>
                    <td align="right">¥{{ number_format($subtotal) }}</td>
                </tr>
            @endforeach

        </table>

        <h3 style="text-align:right; margin-top:20px;">
            合計：¥{{ number_format($total) }}
        </h3>

        <hr>

        <p>※ご注文内容に関しては本メールをご確認ください。</p>
        <p>※本メールは自動送信です。</p>

        <p style="margin-top:30px;">
            今後とも <strong>MyShop</strong> をよろしくお願いいたします。
        </p>

    </div>

</body>
</html>