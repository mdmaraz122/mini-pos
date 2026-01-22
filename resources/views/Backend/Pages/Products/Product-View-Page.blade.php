@section('title', 'Product Create')
@extends('Backend.Layouts.Master')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-md-12 mb-3 text-right">
                        <a class="btn btn-md btn-danger" href="{{ route('Products') }}"><i class="fas fa-backward"></i> Back</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h4>Product Images</h4>
                            </div>
                            <div class="card-body">
                                <img src="{{ $product->image === null ? asset('assets/images/default.jpg') : asset('assets/uploads/products/' . $product->image) }}" class="img-fluid" alt="Product Image">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h4>Product Details</h4>
                            </div>
                            <div class="card-body">
                                <h4 class="text-danger"><b>{{ $product->name }}</b></h4>
                                <h6 class="text-danger"><b>{{ $product->slug }}</b></h6>
                                <hr>
                                <table class="table">
                                    <tr>
                                        <td><h5><b class="text-danger">SKU: </b> {{ $product->sku }}</h5></td>
                                        <td colspan="2"><h5><b class="text-danger">Barcode: </b> @if(!$product->barcode) Barcode Does Not Available @else {{ $product->barcode}} @endif</h5></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="text-left">
                                            <h5><b class="text-danger">Brand: </b> @if($product->brand_id === null) N/A @else {{ $product->brand->name }} @endif</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h5><b class="text-danger">Category: </b> {{ $product->category->name }}</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <h5><b class="text-danger">Unit: </b> {{ $product->unit->name }}</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h5><b class="text-danger">Quantity: </b> {{ $product->quantity }}</h5>
                                        </td>
                                        <td colspan="2">
                                            <h5><b class="text-danger">Quantity Alert: </b> {{ $product->quantity_alert }}</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h5><b class="text-danger">Purchase Price: </b> {{ $product->purchase_price }} TK</h5>
                                        </td>
                                        <td>
                                            <h5><b class="text-danger">MRP: </b> {{ $product->mrp }} TK</h5>
                                        </td>
                                        <td>
                                            <h5><b class="text-danger">Selling Price: </b> {{ $product->selling_price }} TK</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h5><b class="text-danger">Discount: </b> {{ $product->discount ? $product->discount : '0' }}</h5>
                                        </td>
                                        <td colspan="2">
                                            <h5><b class="text-danger">Discount Type: </b> {{ $product->discount_type }}</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h5><b class="text-danger">Tax: </b> @if($product->tax !== null)
                                                {{ $product->tax->name }} ({{ $product->tax->percentage }}%) @else N/A @endif</h5>
                                        </td>
                                        <td colspan="2">
                                            <h5><b class="text-danger">Tax Type: </b> {{ $product->tax_type ? $product->tax_type : 'N/A' }}</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            <h5><b class="text-danger">Short Description: </b> {{ $product->short_description ? $product->short_description : 'N/A' }}</h5>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>


@endsection

