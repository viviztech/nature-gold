<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'Segoe UI', Tahoma, sans-serif; background: #FFF8E7; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #fff; border-radius: 16px; overflow: hidden; }
        .header { background: linear-gradient(135deg, #D4A017, #2D6A2E); padding: 30px; text-align: center; }
        .header h1 { color: #fff; font-size: 24px; margin: 0; }
        .content { padding: 30px; }
        .product-name { font-size: 20px; font-weight: bold; color: #1a1a1a; }
        .variant { color: #666; font-size: 14px; margin-top: 4px; }
        .cta { display: inline-block; margin-top: 20px; padding: 14px 32px; background: #2D6A2E; color: #fff; text-decoration: none; border-radius: 12px; font-weight: 600; font-size: 16px; }
        .footer { padding: 20px 30px; text-align: center; color: #999; font-size: 12px; border-top: 1px solid #f0f0f0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Back in Stock!</h1>
        </div>
        <div class="content">
            <p>Hi {{ $user->name }},</p>
            <p>Great news! The product you were waiting for is now back in stock:</p>

            <p class="product-name">{{ $product->name_en }}</p>
            @if($variant)
                <p class="variant">{{ $variant->name }}</p>
            @endif

            <a href="{{ route('product.show', $product->slug) }}" class="cta">Shop Now</a>

            <p style="margin-top: 20px; color: #666; font-size: 14px;">Hurry, stock is limited!</p>
        </div>
        <div class="footer">
            <p>Nature Gold - 100% Natural, Cold-Pressed Oils</p>
        </div>
    </div>
</body>
</html>
