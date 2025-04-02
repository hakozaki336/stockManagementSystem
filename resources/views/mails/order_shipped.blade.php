<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>注文が発送されました</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Nunito:wght@400;600&display=swap');
        
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-900">
    <div class="max-w-3xl mx-auto bg-white p-8 rounded-lg shadow-lg">
        <h1 class="text-3xl font-semibold text-blue-600 mb-4">ご注文の商品が発送されました！</h1>

        <p class="text-lg mb-4">こんにちは、{{ $order->customer_name }} さん。</p>
        <p class="mb-6">ご注文いただいた商品が発送されました。以下の詳細をご確認ください。</p>

        <div class="bg-gray-50 p-6 rounded-lg border border-gray-200 mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">注文情報</h2>
            <p><strong class="font-medium">注文番号：</strong>#{{ $order->order_number }}</p>
            <p><strong class="font-medium">商品名：</strong>{{ $order->product_name }}</p>
            <p><strong class="font-medium">数量：</strong>{{ $order->quantity }} 個</p>
            <p><strong class="font-medium">配送方法：</strong>{{ $order->shipping_method }}</p>
            <p><strong class="font-medium">追跡番号：</strong>{{ $order->tracking_number }}</p>
            <p><strong class="font-medium">発送日：</strong>{{ $order->shipped_at->format('Y年m月d日') }}</p>
        </div>

        <p>ご利用いただきありがとうございます！もしご質問があれば、お気軽にお問い合わせください。</p>

        <div class="mt-6 text-center">
            <a href="{{ url('/') }}" class="text-blue-600 hover:underline">ホームページに戻る</a>
        </div>
    </div>
</body>
</html>
