<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $invoice_number }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: sans-serif; font-size: 12px; color: #333; line-height: 1.5; }
        .container { padding: 30px; }
        .header { display: table; width: 100%; margin-bottom: 30px; border-bottom: 3px solid #D4A017; padding-bottom: 20px; }
        .header-left { display: table-cell; width: 50%; vertical-align: top; }
        .header-right { display: table-cell; width: 50%; vertical-align: top; text-align: right; }
        .company-name { font-size: 24px; font-weight: bold; color: #D4A017; margin-bottom: 5px; }
        .company-details { font-size: 10px; color: #666; }
        .invoice-title { font-size: 28px; font-weight: bold; color: #333; margin-bottom: 5px; }
        .invoice-meta { font-size: 11px; color: #666; }
        .invoice-meta strong { color: #333; }
        .addresses { display: table; width: 100%; margin-bottom: 25px; }
        .address-box { display: table-cell; width: 50%; vertical-align: top; padding: 15px; }
        .address-box:first-child { padding-left: 0; }
        .address-box:last-child { padding-right: 0; }
        .address-label { font-size: 10px; text-transform: uppercase; letter-spacing: 1px; color: #999; margin-bottom: 8px; font-weight: bold; }
        .address-content { font-size: 11px; color: #333; }
        .address-content strong { display: block; font-size: 13px; margin-bottom: 3px; }
        table.items { width: 100%; border-collapse: collapse; margin-bottom: 25px; }
        table.items th { background: #f8f4eb; color: #333; font-weight: bold; padding: 10px 12px; text-align: left; font-size: 10px; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #D4A017; }
        table.items td { padding: 10px 12px; border-bottom: 1px solid #eee; font-size: 11px; }
        table.items tr:last-child td { border-bottom: none; }
        table.items .text-right { text-align: right; }
        table.items .text-center { text-align: center; }
        .summary { width: 300px; margin-left: auto; }
        .summary-row { display: table; width: 100%; padding: 6px 0; }
        .summary-label { display: table-cell; width: 60%; text-align: right; padding-right: 15px; font-size: 11px; color: #666; }
        .summary-value { display: table-cell; width: 40%; text-align: right; font-size: 11px; color: #333; font-weight: 500; }
        .summary-total { border-top: 2px solid #D4A017; margin-top: 8px; padding-top: 8px; }
        .summary-total .summary-label,
        .summary-total .summary-value { font-size: 14px; font-weight: bold; color: #333; }
        .gst-note { margin-top: 25px; padding: 12px; background: #f8f8f8; border-radius: 4px; font-size: 10px; color: #666; }
        .gst-note strong { color: #333; }
        .footer { margin-top: 30px; padding-top: 15px; border-top: 1px solid #eee; text-align: center; font-size: 10px; color: #999; }
        .badge { display: inline-block; padding: 3px 10px; border-radius: 3px; font-size: 10px; font-weight: bold; text-transform: uppercase; }
        .badge-paid { background: #dcfce7; color: #166534; }
        .badge-pending { background: #fef9c3; color: #854d0e; }
        .badge-cod { background: #e0e7ff; color: #3730a3; }
    </style>
</head>
<body>
    <div class="container">
        {{-- Header --}}
        <div class="header">
            <div class="header-left">
                <div class="company-name">{{ $company['name'] }}</div>
                <div class="company-details">
                    {{ $company['address'] }}<br>
                    @if($company['phone']) Phone: {{ $company['phone'] }}<br> @endif
                    @if($company['email']) Email: {{ $company['email'] }}<br> @endif
                    @if($company['gst']) GSTIN: {{ $company['gst'] }} @endif
                </div>
            </div>
            <div class="header-right">
                <div class="invoice-title">TAX INVOICE</div>
                <div class="invoice-meta">
                    <strong>Invoice #:</strong> {{ $invoice_number }}<br>
                    <strong>Date:</strong> {{ $invoice_date }}<br>
                    <strong>Order #:</strong> {{ $order->order_number }}<br>
                    <strong>Payment:</strong>
                    @if($order->payment_status->value === 'paid')
                        <span class="badge badge-paid">Paid</span>
                    @elseif($order->payment_method->value === 'cod')
                        <span class="badge badge-cod">COD</span>
                    @else
                        <span class="badge badge-pending">Pending</span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Addresses --}}
        <div class="addresses">
            <div class="address-box">
                <div class="address-label">Bill To / Ship To</div>
                <div class="address-content">
                    <strong>{{ $order->shipping_address['name'] ?? 'Customer' }}</strong>
                    {{ $order->shipping_address['line1'] ?? '' }}<br>
                    @if($order->shipping_address['line2'] ?? '')
                        {{ $order->shipping_address['line2'] }}<br>
                    @endif
                    {{ $order->shipping_address['city'] ?? '' }}, {{ $order->shipping_address['district'] ?? '' }}<br>
                    {{ $order->shipping_address['state'] ?? 'Tamil Nadu' }} - {{ $order->shipping_address['pincode'] ?? '' }}<br>
                    @if($order->shipping_address['phone'] ?? '')
                        Phone: {{ $order->shipping_address['phone'] }}
                    @endif
                </div>
            </div>
            <div class="address-box">
                <div class="address-label">Payment Details</div>
                <div class="address-content">
                    <strong>{{ $order->payment_method->label() }}</strong>
                    Status: {{ $order->payment_status->label() }}<br>
                    @if($order->transactions->isNotEmpty())
                        Transaction ID: {{ $order->transactions->first()->transaction_id }}
                    @endif
                </div>
            </div>
        </div>

        {{-- Items Table --}}
        <table class="items">
            <thead>
                <tr>
                    <th style="width: 5%;">#</th>
                    <th style="width: 40%;">Item Description</th>
                    <th class="text-center" style="width: 10%;">HSN</th>
                    <th class="text-center" style="width: 10%;">Qty</th>
                    <th class="text-right" style="width: 15%;">Rate</th>
                    <th class="text-right" style="width: 20%;">Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            {{ $item->product_name }}
                            @if($item->variant_name)
                                <br><small style="color: #888;">{{ $item->variant_name }}</small>
                            @endif
                        </td>
                        <td class="text-center">1515</td>
                        <td class="text-center">{{ $item->quantity }}</td>
                        <td class="text-right">{{ number_format($item->unit_price, 2) }}</td>
                        <td class="text-right">{{ number_format($item->total, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Summary --}}
        <div class="summary">
            <div class="summary-row">
                <div class="summary-label">Subtotal</div>
                <div class="summary-value">&#8377;{{ number_format($order->subtotal, 2) }}</div>
            </div>

            @if($order->discount > 0)
                <div class="summary-row">
                    <div class="summary-label">Discount{{ $order->coupon_code ? ' ('.$order->coupon_code.')' : '' }}</div>
                    <div class="summary-value" style="color: #16a34a;">-&#8377;{{ number_format($order->discount, 2) }}</div>
                </div>
            @endif

            <div class="summary-row">
                <div class="summary-label">Shipping</div>
                <div class="summary-value">
                    @if($order->shipping_cost > 0)
                        &#8377;{{ number_format($order->shipping_cost, 2) }}
                    @else
                        FREE
                    @endif
                </div>
            </div>

            @php
                $taxableAmount = $order->subtotal - $order->discount;
                $cgst = round($order->tax / 2, 2);
                $sgst = round($order->tax / 2, 2);
            @endphp

            <div class="summary-row">
                <div class="summary-label">CGST (2.5%)</div>
                <div class="summary-value">&#8377;{{ number_format($cgst, 2) }}</div>
            </div>

            <div class="summary-row">
                <div class="summary-label">SGST (2.5%)</div>
                <div class="summary-value">&#8377;{{ number_format($sgst, 2) }}</div>
            </div>

            <div class="summary-row summary-total">
                <div class="summary-label">Total</div>
                <div class="summary-value">&#8377;{{ number_format($order->total, 2) }}</div>
            </div>
        </div>

        {{-- GST Note --}}
        <div class="gst-note">
            <strong>Tax Summary:</strong> Total taxable value: &#8377;{{ number_format($taxableAmount, 2) }} |
            CGST @ 2.5%: &#8377;{{ number_format($cgst, 2) }} |
            SGST @ 2.5%: &#8377;{{ number_format($sgst, 2) }} |
            Total Tax: &#8377;{{ number_format($order->tax, 2) }}
            <br><br>
            <em>This is a computer-generated invoice and does not require a signature.</em>
        </div>

        {{-- Footer --}}
        <div class="footer">
            <strong>{{ $company['name'] }}</strong> &mdash; Thank you for your purchase!
            @if($company['gst'])
                <br>GSTIN: {{ $company['gst'] }}
            @endif
        </div>
    </div>
</body>
</html>
