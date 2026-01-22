<!DOCTYPE html>
<html>
<head>
    <title>Order Receipt #{{ $order->order_number }}</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        @page {
            size: 80mm 297mm; /* POS printer paper size */
            margin: 0;
            padding: 0;
        }

        body {
            width: 80mm;
            margin: 0;
            padding: 5mm;
            font-family: 'Courier New', monospace;
            font-size: 12px;
            color: #000;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
        }

        .company-name {
            font-weight: bold;
            font-size: 16px;
        }

        .receipt-info {
            margin: 10px 0;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }

        .items-table th {
            text-align: left;
            border-bottom: 1px dashed #000;
            padding: 3px 0;
        }

        .items-table td {
            padding: 3px 0;
        }

        .total-section {
            margin-top: 10px;
            border-top: 1px dashed #000;
            padding-top: 5px;
        }

        .footer {
            text-align: center;
            margin-top: 15px;
            font-style: italic;
        }

        .barcode-container {
            text-align: center;
            margin-top: 10px;
        }

        .barcode-number {
            font-family: 'Courier New', monospace;
            font-size: 14px;
            letter-spacing: 2px;
            margin-top: 2px;
        }

        @media print {
            body {
                width: 80mm !important;
            }
            .no-print {
                display: none !important;
            }
        }
        @media print {
            @page {
                size: 80mm auto; /* Exact receipt width */
                margin: 0; /* Remove default margins */
            }
        }
        .dashed-table {
            border-collapse: separate; /* <-- changed from collapse */
            border-spacing: 0;         /* no gaps */
            width: 100%;
        }

        .dashed-table th,
        .dashed-table td {
            border: 1px dashed #000;
            padding: 8px;
            text-align: left;
        }
    </style>
    <!-- Include JsBarcode library -->
    <script src="{{ asset('assets/js/JsBarcode.all.min.js') }}"></script>
</head>
<body onload="window.print();generateBarcode()">
<div class="header">
    <div class="company-name">{{ $settings[0]['shop_name'] }}</div>
    <div>{{ $settings[0]['shop_address'] }}</div>
    <div>Phone: {{ $settings[0]['shop_phone'] }}</div>
</div>

<div class="receipt-info">
    <div><strong>Date:</strong> {{ $order->created_at->format('Y-m-d H:i') }}</div>
    <div><strong>Order #:</strong> {{ $order->order_number }}</div>
    <div><strong>Customer:</strong> {{ $order->customer->name }}</div>
</div>
@php
    $subtotal = 0;
    $totalTax = 0;
@endphp

<table class="items-table dashed-table">
    <thead>
    <tr>
        <th>Item</th>
        <th>Total</th>
    </tr>
    </thead>
    <tbody>
    @foreach($order->orderDetails as $item)
        @php
            $lineSubtotal = $item->price * $item->quantity;

            $discount = $item->discount_type === 'Percentage'
                ? $lineSubtotal * $item->discount / 100
                : $item->discount;

            $discountedSubtotal = $lineSubtotal - $discount;

            $tax = 0;
            if($item->tax_type === 'Exclusive') {
                $tax = $discountedSubtotal * ($item->tax / 100);
                $totalTax += $tax;
            }

            $subtotal += $discountedSubtotal;
        @endphp
        <tr>
            <td>
                {{ $item->product->name }}
                - ({{ $item->quantity.' '.$item->product->unit->name }} * {{ number_format($item->price, 2) }}﷼)
                @if($item->discount > 0)
                    | Disc: {{ $item->discount }}{{ $item->discount_type === 'Percentage' ? '%' : '﷼' }}
                @endif
                @if($item->tax_type === 'Exclusive')
                    | {{ $item->tax }}% (Exc Tax)
                @endif
            </td>
            <td>{{ number_format($discountedSubtotal, 2) }}﷼</td>
        </tr>
    @endforeach
    </tbody>
</table>

<div class="total-section">
    <div style="text-align: right;">
        <div>Subtotal: {{ number_format($subtotal, 2) }}﷼</div>

        @if($totalTax > 0)
            <div>Tax (Exclusive): {{ number_format($totalTax, 2) }}﷼</div>
        @else
            <div>Tax: {{ number_format(0, 2) }}﷼</div>
        @endif
        <div style="font-weight: bold; border-top: 1px solid #000; margin-top: 3px; padding-top: 3px;">
            Total: {{ number_format($subtotal + $totalTax, 2) }}﷼
        </div>

        <div>Paid: {{ number_format($order->pay, 2) }}﷼</div>
        <div>Due: {{ number_format($order->due, 2) }}﷼</div>
    </div>
</div>


<div class="payment-method">
    <strong>Payment Method:</strong> {{ strtoupper($order->payment_method) }}
</div>

<!-- Barcode Section -->
<div class="barcode-container">
    <svg id="barcode"></svg>
    <div class="barcode-number">{{ $order->order_number }}</div>
</div>

<div class="footer" style="padding-bottom: 5px">
    {{ $settings[0]['receipt_message'] }}
</div>
<div style="border-top: 1px dashed black; padding-top: 1px; text-align: center">
    <p>Powered By <b>Raw It Solutions</b> <br><b>Call: </b> +8801897964444 <br> <b>Email: </b> mail@rawitsolutions.com</p>

</div>

<div class="no-print" style="margin-top: 20px; text-align: center;">
    <button onclick="window.print()">Print Again</button>
    <button onclick="CloseFun()">Close</button>
</div>

<script>
    // Auto-close after printing (optional)
    window.onafterprint = function() {
        setTimeout(() => {
            window.close();
        }, 500);
    };
    // Close function
    function CloseFun() {
        if (document.referrer) {
            window.location.href = document.referrer;
        } else {
            window.location.href = "{{ route('POS') }}"; // Fallback
        }
    }

    // Generate barcode
    function generateBarcode() {
        JsBarcode("#barcode", "{{ $order->order_number }}", {
            format: "CODE128", // Standard barcode format
            width: 2,
            height: 50,
            displayValue: false, // We'll display the number separately
            margin: 10,
            fontSize: 0 // Hide text under barcode
        });
    }
</script>
</body>
</html>
