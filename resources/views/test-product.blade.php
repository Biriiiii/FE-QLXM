<!DOCTYPE html>
<html>
<head>
    <title>Test Product API</title>
    <meta charset="utf-8">
</head>
<body>
    <h1>Test Product API</h1>
    
    @if(isset($error))
        <div style="color: red; padding: 20px; border: 1px solid red; margin: 20px 0;">
            <h3>Error:</h3>
            <p>{{ $error }}</p>
        </div>
    @endif

    @if(isset($product))
        <div style="color: green; padding: 20px; border: 1px solid green; margin: 20px 0;">
            <h3>Product Found:</h3>
            <pre>{{ json_encode($product, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
        </div>
    @else
        <div style="color: orange; padding: 20px; border: 1px solid orange; margin: 20px 0;">
            <h3>No Product Data</h3>
        </div>
    @endif

    @if(isset($relatedProducts) && count($relatedProducts) > 0)
        <div style="color: blue; padding: 20px; border: 1px solid blue; margin: 20px 0;">
            <h3>Related Products:</h3>
            <pre>{{ json_encode($relatedProducts, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
        </div>
    @endif

    <div style="margin: 20px 0;">
        <h3>Test Links:</h3>
        <ul>
            <li><a href="/test-product/12">Test Product ID 12</a></li>
            <li><a href="/test-product/1">Test Product ID 1</a></li>
            <li><a href="/test-product/999">Test Product ID 999 (should fail)</a></li>
        </ul>
    </div>
</body>
</html>