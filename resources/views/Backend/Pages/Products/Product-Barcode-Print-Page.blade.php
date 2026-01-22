<!DOCTYPE html>
<html>
<head>
    <title>Product Barcode Stickers</title>
    <meta charset="UTF-8">
    <style>
        @page {
            size: 80mm auto; /* POS printer paper width */
            margin: 0;
            padding: 0;
        }

        body {
            width: 80mm;
            margin: 0;
            padding: 0;
            font-family: 'Courier New', monospace;
            font-size: 12px;
        }

        .sticker {
            padding: 2mm 0;
            text-align: center;
            border-bottom: 1px dashed #000; /* Cut guide */
        }

        .product-name {
            font-weight: bold;
            margin-bottom: 1mm;
            text-transform: uppercase;
        }

        .barcode-container {
            margin: 1mm 0;
        }

        .price-sku {
            display: flex;
            justify-content: space-between;
            padding: 0 10mm;
        }

        .product-price {
            font-weight: bold;
        }

        @media print {
            body {
                width: 80mm !important;
            }
            .no-print {
                display: none !important;
            }
        }
    </style>
    <!-- Include JsBarcode library -->
    <script src="{{ asset('assets/js/JsBarcode.all.min.js') }}"></script>
</head>
<body onload="generateBarcodes(); window.print();">
<div class="no-print" style="padding: 5mm; text-align: center;">
    <h3>Product Barcode Stickers</h3>
    <p>Configure printer to use thermal paper roll (80mm width)</p>
    <button onclick="window.print()">Print Again</button>
    <button onclick="Back()">Back</button>
</div>

@foreach($products as $product)
    <div class="sticker">
        <div class="product-name">{{ Str::limit($product->name, 30) }}</div>

        <div class="barcode-container">
            <svg class="barcode" data-value="{{ $product->barcode }}"></svg>
        </div>



        <div class="price-sku">
            <span class="product-price">{{ number_format($product->selling_price, 2),'﷼ ' }}@if($product->tax_type === 'Exclusive' && isset($product->tax['percentage']))
                    + {{ $product->tax['percentage'] }}% Tax
                @endif</span>
            <span class="product-sku">{{ $product->barcode }}</span>
        </div>
    </div>
@endforeach


<script>
    function generateBarcodes() {
        document.querySelectorAll('.barcode').forEach(el => {
            JsBarcode(el, el.getAttribute('data-value'), {
                format: "CODE128",
                width: 1.2,
                height: 30,
                displayValue: false,
                margin: 0
            });
        });
    }

    window.onafterprint = function() {
        setTimeout(() => window.close(), 500);
    };

    function Back() {
        window.location.href = '/products';
    }
</script>
</body>
</html>
