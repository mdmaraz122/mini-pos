@section('title', 'Product Create')
@extends('Backend.Layouts.Master')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-md-12 text-right">
                        <a class="btn btn-md btn-danger" href="{{ route('Products') }}"><i class="fas fa-backward"></i> Back</a>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 onclick="getCategory()">Create Product</h4>
                                </div>
                                <hr>
                                <div class="card-body">
                                    <form id="wizard_with_validation" onkeydown="preventEnterSubmit(event)">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="name">Name <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <i class="fas fa-pen"></i>
                                                            </div>
                                                        </div>
                                                        <input type="text" oninput="textToSlug()" class="form-control" id="name" placeholder="Enter Product Name" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="slug">Slug <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <i class="fas fa-pen"></i>
                                                            </div>
                                                        </div>
                                                        <input type="text" class="form-control" disabled id="slug" placeholder="Enter Product Slug" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="category">Select Category <span class="text-danger">*</span></label>
                                                    <select class="form-control select2" id="category">
                                                        <option value="">Select Category</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="brand">Select Brand</label>
                                                    <select class="form-control js-example-basic-single" id="brand">
                                                        <option value="">Select Brand</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="sku">SKU <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <i class="fas fa-hashtag"></i>
                                                            </div>
                                                        </div>
                                                        <input type="text" class="form-control" id="sku" placeholder="Enter Product SKU" required>
                                                        <div class="input-group-append">
                                                            <button type="button" onclick="SKUGenerator()" class="btn btn-primary">Generate <i class="fas fa-retweet"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="barcode">Barcode</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <i class="fas fa-barcode"></i>
                                                            </div>
                                                        </div>
                                                        <input type="text" class="form-control" id="barcode" placeholder="Enter Product Barcode" required>
                                                        <div class="input-group-append">
                                                            <button type="button" onclick="BarCodeGenerator()" class="btn btn-primary">Generate <i class="fas fa-retweet"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="unit">Select Unit <span class="text-danger">*</span></label>
                                                    <select class="form-control js-example-basic-single" id="unit">
                                                        <option value="">Select Base Unit First</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="tax">Select Tax</label>
                                                    <select class="form-control js-example-basic-single" id="tax">
                                                        <option value="">Select Tax</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="taxType">Select Tax Type</label>
                                                    <select class="form-control js-example-basic-single" id="taxType">
                                                        <option value="">Select Tax Type</option>
                                                        <option value="Inclusive">Inclusive</option>
                                                        <option value="Exclusive">Exclusive</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="mainImage">Main Image</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <i class="fas fa-image"></i>
                                                            </div>
                                                        </div>
                                                        <input type="file" id="mainImage" class="form-control" oninput="showMainImage.src=window.URL.createObjectURL(this.files[0])">
                                                    </div>
                                                    <img width="60px" id="showMainImage" alt="Image" height="60px" class="border-danger border mt-3" src="{{ asset('assets/images/default.jpg') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="quantity">Quantity <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <i class="fas fa-weight-hanging"></i>
                                                            </div>
                                                        </div>
                                                        <input type="number" class="form-control" id="quantity" placeholder="Enter Quantity" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="quantityAlert">Quantity Alert <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <i class="fas fa-exclamation-triangle"></i>
                                                            </div>
                                                        </div>
                                                        <input type="number" class="form-control" id="quantityAlert" placeholder="Enter Quantity Alert" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="purchasePrice">Purchase Price <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <i class="fas fa-money-bill"></i>
                                                            </div>
                                                        </div>
                                                        <input type="number" class="form-control" id="purchasePrice" placeholder="Enter Purchase Price" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="mrp">MRP <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <i class="fas fa-money-bill"></i>
                                                            </div>
                                                        </div>
                                                        <input type="number" class="form-control" id="mrp" placeholder="Enter MRP" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="sellingPrice">Selling Price <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <i class="fas fa-money-bill"></i>
                                                            </div>
                                                        </div>
                                                        <input type="number" class="form-control" id="sellingPrice" placeholder="Enter Selling Price" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="discount">Discount</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <i class="fas fa-money-bill"></i>
                                                            </div>
                                                        </div>
                                                        <input type="number" class="form-control" id="discount" placeholder="Enter Discount Price" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="discountType">Select Discount Type</label>
                                                    <select class="form-control js-example-basic-single" id="discountType">
                                                        <option value="">Select Discount Type</option>
                                                        <option value="Fixed">Fixed</option>
                                                        <option value="Percentage">Percentage</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="shortDescription">Short Description</label>
                                                    <textarea id="shortDescription" class="form-control"> </textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <button class="btn btn-md btn-danger w-100" onclick="createProduct()" type="button">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        document.getElementById('wizard_with_validation').addEventListener('submit', function(e) {
            e.preventDefault(); // prevent default form submission
        });
        async function createProduct(){
            try{
                let name            = document.getElementById('name');
                let slug            = document.getElementById('slug');
                let category        = document.getElementById('category');
                let brand           = document.getElementById('brand');
                let sku             = document.getElementById('sku');
                let barcode         = document.getElementById('barcode');
                let unit            = document.getElementById('unit');
                let tax             = document.getElementById('tax');
                let taxType         = document.getElementById('taxType');
                let mainImage       = document.getElementById('mainImage');
                let quantity        = document.getElementById('quantity');
                let quantityAlert   = document.getElementById('quantityAlert');
                let purchasePrice   = document.getElementById('purchasePrice');
                let mrp             = document.getElementById('mrp');
                let sellingPrice    = document.getElementById('sellingPrice');
                let discount        = document.getElementById('discount');
                let discountType    = document.getElementById('discountType');
                let shortDescription= document.getElementById('shortDescription');
                // validate the data;
                if (name.value === '') {
                    name.focus();
                    errorToast('Please enter product name');
                    hideLoader();
                    return;
                }
                if(slug.value === '') {
                    slug.focus();
                    errorToast('Please enter product slug');
                    hideLoader();
                    return;
                }
                if(category.value === '') {
                    category.focus();
                    errorToast('Please select product category');
                    hideLoader();
                    return;
                }
                if(sku.value === '') {
                    sku.focus();
                    errorToast('Please enter product sku');
                    hideLoader();
                    return;
                }
                if(unit.value === '') {
                    unit.focus();
                    errorToast('Please select unit');
                    hideLoader();
                    return;
                }
                if(quantity.value === '') {
                    quantity.focus();
                    errorToast('Please enter quantity');
                    hideLoader();
                    return;
                }
                if(quantityAlert.value === '') {
                    quantityAlert.focus();
                    errorToast('Please enter quantity alert');
                    hideLoader();
                    return;
                }
                if(purchasePrice.value === '') {
                    purchasePrice.focus();
                    errorToast('Please enter purchase price');
                    hideLoader();
                    return;
                }
                if(mrp.value === '') {
                    mrp.focus();
                    errorToast('Please select mrp');
                    hideLoader();
                    return;
                }
                if(sellingPrice.value === '') {
                    sellingPrice.focus();
                    errorToast('Please select selling price');
                    hideLoader();
                    return;
                }
                let formData = new FormData();
                formData.append('name', name.value);
                formData.append('slug', slug.value);
                formData.append('category_id', category.value);
                formData.append('brand_id', brand.value);
                formData.append('sku', sku.value);
                formData.append('barcode', barcode.value);
                formData.append('unit_id', unit.value);
                formData.append('tax_id', tax.value);
                formData.append('tax_type', taxType.value);
                formData.append('quantity', quantity.value);
                formData.append('quantity_alert', quantityAlert.value);
                formData.append('purchase_price', purchasePrice.value);
                formData.append('mrp', mrp.value);
                formData.append('selling_price', sellingPrice.value);
                formData.append('discount', discount.value);
                formData.append('discount_type', discountType.value);
                formData.append('short_description', shortDescription.value);
                formData.append('main_image', mainImage.files[0]);
                showLoader();
                // Send request to backend
                let res = await axios.post('/backendData/product-create', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });
                if (res.data['status'] === 'success') {
                    document.getElementById('wizard_with_validation').reset();
                    document.getElementById('mainImage').src = "{{ asset('assets/images/default.jpg') }}";
                    hideLoader();
                    successToast(res.data['message']);
                    setTimeout(() => {
                        window.location.href = '/products';
                    }, 1000);
                } else {
                    errorToast(res.data['message']);
                    hideLoader();
                }
            }catch (e) {
                hideLoader();
                errorToast(e);
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            getCategory();
            getBrand();
            getUnit();
            getTaxes();
        });

        // Auto-load Category
        async function getCategory() {
            try {
                let res = await axios.get('/backendData/get-category-by-status');
                let categories = res.data['data'];

                // Clear previous options
                let categorySelect = document.getElementById('category');
                categorySelect.innerHTML = '<option value="">Select Category</option>';

                // Handle empty subcategory list
                if (!categories || categories.length === 0) {
                    let option = document.createElement('option');
                    option.text = 'No Category Found';
                    categorySelect.appendChild(option);
                    return;
                }

                // Add new options
                categories.forEach((category) => {
                    let option = document.createElement('option');
                    option.value = category.id;
                    option.text = category.name;
                    categorySelect.appendChild(option);
                });
                $('#category').select2();
            } catch (e) {
                hideLoader();
                errorToast('Failed to load categories');
            }
        }
        // Auto-load brand
        async function getBrand() {
            try {
                let res = await axios.get('/backendData/get-brand-by-status');
                let brands = res.data['data'];

                // Clear previous options
                let brandSelect = document.getElementById('brand');
                brandSelect.innerHTML = '<option value="">Select Brand</option>';

                // Add new options
                brands.forEach((brand) => {
                    let option = document.createElement('option');
                    option.value = brand.id;
                    option.text = brand.name;
                    brandSelect.appendChild(option);
                });
                $('#brand').select2();
            } catch (e) {
                hideLoader();
                errorToast('Failed to load brands');
            }
        }
        // Auto-load Unit
        async function getUnit() {
            try {
                let res = await axios.get('/backendData/units-by-status');
                let Units = res.data['data'];
                // Clear previous options
                let UnitSelect = document.getElementById('unit');
                UnitSelect.innerHTML = '<option value="">Select Base Unit</option>';
                // Add new options
                Units.forEach((unit) => {
                    let option = document.createElement('option');
                    option.value = unit.id;
                    option.text = unit.name;
                    UnitSelect.appendChild(option);
                });
                $('#unit').select2();
            } catch (e) {
                hideLoader();
                errorToast('Failed to load unit');
            }
        }
        // Auto-load brand
        async function getTaxes() {
            try {
                let res = await axios.get('/backendData/get-tax-by-status');
                let taxes = res.data['data'];
                // Clear previous options
                let TaxSelect = document.getElementById('tax');
                TaxSelect.innerHTML = '<option value="">Select Tax</option>';

                if (!taxes || taxes.length === 0) {
                    let option = document.createElement('option');
                    option.text = 'No Tax Found';
                    TaxSelect.appendChild(option);
                    return;
                }
                // Add new options
                taxes.forEach((tax) => {
                    let option = document.createElement('option');
                    option.value = tax.id;
                    option.text = tax.name+' - '+'('+tax.percentage+'%)';
                    TaxSelect.appendChild(option);
                });
                $('#tax').select2();
            } catch (e) {
                hideLoader();
                errorToast('Failed to load categories');
            }
        }
        async function SKUGenerator() {
            try {
                let category = document.getElementById('category').value;
                if(category === '') {
                    errorToast('Please select a category first');
                }else{
                    let res = await axios.post('/backendData/productSUKGenerator', {id : category});
                    document.getElementById('sku').value = res.data['data'];
                }
            } catch (e) {
                hideLoader();
                errorToast('Failed to load categories');
            }
        }
        async function BarCodeGenerator() {
            try {
                let res = await axios.post('/backendData/productBarcodeGenerator');
                document.getElementById('barcode').value = res.data['data'];
            } catch (e) {
                hideLoader();
                errorToast('Failed to load categories');
            }
        }
        // text to slug
        function textToSlug(){
            let name = document.getElementById('name').value;
            document.getElementById('slug').value = name.replace(/\s+/g, '-').toLowerCase();
        }
    </script>

@endsection

