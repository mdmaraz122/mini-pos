@section('title', 'Product Create')
@extends('Backend.Layouts.Master')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Point of Sale</h4>
                            </div>
                            <div class="card-body p-0">
                                <div class="row no-gutters">
                                    <!-- Order Items Section (Left) -->
                                    <div class="col-md-6 p-3 border-right">
                                        <div class="table-responsive" style="max-height: 355px;">
                                            <select class="form-control mb-3" id="customer">
                                            </select>
                                            <table class="table table-striped mt-4">
                                                <thead class="bg-light">
                                                <tr>
                                                    <th width="5%">#</th>
                                                    <th width="30%">Item</th>
                                                    <th width="15%">Unit</th>
                                                    <th width="15%">Price</th>
                                                    <th width="15%">Discount</th>
                                                    <th width="15%">Tax</th>
                                                    <th width="15%">Total</th>
                                                    <th width="15%">Alert</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-8">
                                                <textarea itemid="orderNote" class="form-control" cols="7" placeholder="Notes..." id="order-notes"></textarea>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="card h-100 bg-success text-white shadow-sm border-0">
                                                    <div class="card-body p-4">
                                                        <h6 class="text-center mb-2">Total</h6>
                                                        <h3 class="text-center fw-bold" id="totalCartAmount">0</h3>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <button class="btn btn-success btn-block w-100 mt-2" type="button" onclick="submitOrder()">Place Order</button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Categories Section (Middle) -->
                                    <div class="col-md-2 p-3 border-right">
                                        <div class="form-group">
                                            <input type="text" id="category-search" oninput="getCategoryBySearch()" class="form-control" placeholder="Search categories...">
                                        </div>
                                        <div class="categories-container" style="max-height: 65vh; overflow-y: auto;">
                                            <div class="list-group" id="category-list">
                                                <!-- Categories will be loaded here -->
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Products Section (Right) -->
                                    <div class="col-md-4 p-3">
                                        <div class="form-group">
                                            <input type="text" id="product-search" class="form-control" placeholder="Search products..." oninput="filterProducts()">
                                        </div>
                                        <div class="products-container" style="max-height: 65vh; overflow-y: auto;">
                                            <div class="row" id="product-list">
                                                @foreach($products as $product)
                                                    <div class="col-6 col-md-4 mb-2 product-item" data-id="{{ $product->id }}" data-category="{{ $product->category_id }}" data-barcode="{{ $product->barcode }}" data-name="{{ strtolower($product->name) }}">
                                                        <div class="card product-card h-100" style="cursor: pointer;" onclick="addToCart({{ json_encode($product) }})">
                                                            <img src="{{ $product->image ? asset('assets/uploads/products/'.$product->image) : asset('assets/images/default.jpg') }}"
                                                                 alt="{{ $product->name }}" class="card-img-top p-2">
                                                            <div class="card-body p-2 ">
                                                                <h6 class="card-title mb-1">{{ $product->name }}</h6>
                                                                <p> {{ number_format($product->selling_price) }} ﷼  </p>
                                                                <small class="{{ $product->quantity > 0 ? 'text-success' : 'text-danger' }}">
                                                                    {{ $product->quantity > 0 ? 'In Stock: '.$product->quantity : 'Out of Stock' }}
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="modal fade" id="FinalOrderModel"  role="dialog" aria-labelledby="formModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formModal">Order Summary</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="subCategoryCreateForm">
                        <div class="form-group">
                            <label for="ModelFinalAmount">Amount <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        ﷼
                                    </div>
                                </div>
                                <input type="number" oninput="calculateOrderSummary()" class="form-control" placeholder="Amount" id="ModelFinalAmount">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="PaymentBY">Payment By <span class="text-danger">*</span></label>
                            <select class="form-control" id="PaymentBY">
                                <option value="Cash">Cash</option>
                                <option value="Card">Card</option>
                                <option value="Online">Online</option>
                            </select>
                        </div>
                        <hr>
                        <div class="row border border-danger">
                            <div class="col-md-6 border-right border-bottom border-danger">
                                <h4>Total Items</h4>
                            </div>
                            <div class="col-md-6 border-bottom border-danger">
                                <h5 id="ModelTotalItem"></h5>
                            </div>
                            <div class="col-md-6 border-right border-bottom border-danger">
                                <h4>Total</h4>
                            </div>
                            <div class="col-md-6 border-bottom border-danger">
                                <h5 id="model2total"></h5>
                            </div>
                            <div class="col-md-6 border-right border-bottom border-danger">
                                <h4>Paid</h4>
                            </div>
                            <div class="col-md-6 border-bottom border-danger">
                                <h5 id="modelPaid"></h5>
                            </div>
                            <div class="col-md-6 border-right border-danger">
                                <h4>Due</h4>
                            </div>
                            <div class="col-md-6">
                                <h5 id="modelDue"></h5>
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary m-t-15 w-100 waves-effect" onclick="PlaceOrder()">Create</button>
                        <button type="button" data-dismiss="modal" id="closeBtn" aria-label="Close" class="btn btn-outline-secondary m-t-15 w-100 waves-effect">Close</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Global variables
        let cartItems = [];
        let currentCategory = null;
        let currentSearchTerm = '';
        let allProducts = [];

        // Initialize when page loads
        document.addEventListener('DOMContentLoaded', function() {
            getCategories();
            getCustomer();

            // Initialize products
            allProducts = Array.from(document.querySelectorAll('.product-item')).map(item => {
                return {
                    element: item,
                    id: item.dataset.id,
                    category: item.dataset.category,
                    name: item.dataset.name,
                    barcode: item.dataset.barcode
                };
            });
        });

        // Function to load customers
        async function getCustomer() {
            try {
                const res = await axios.get('/backendData/customers-list');
                const customers = res.data['data'];

                const customerSelect = document.getElementById('customer');
                customerSelect.innerHTML = '<option value="">Select Customer</option>';

                customers.forEach((customer) => {
                    const option = document.createElement('option');
                    option.value = customer.id;
                    option.text = customer.name;

                    if (customer.name === 'Walking Customer') {
                        option.selected = true;
                    }

                    customerSelect.appendChild(option);
                });

                // Initialize Select2
                $('#customer').select2({
                    theme: 'bootstrap4'
                });
            } catch (e) {
                hideLoader();
                errorToast('Failed to load customers');
            }
        }

        // Function to load all categories
        async function getCategories() {
            try {
                let res = await axios.get('/backendData/get-category-by-status');
                renderCategories(res.data.data);
            } catch (e) {
                console.error('Failed to load categories:', e);
                errorToast('Failed to load categories');
            }
        }

        // Function to search categories by name
        async function getCategoryBySearch() {
            try {
                let searchTerm = document.getElementById('category-search').value.trim();

                if (searchTerm === '') {
                    await getCategories();
                    return;
                }

                let res = await axios.post('/backendData/get-category-by-name', {
                    category: searchTerm
                });
                renderCategories(res.data.data);
            } catch (e) {
                console.error('Failed to search categories:', e);
                errorToast('Failed to search categories');
            }
        }

        // Helper function to render categories
        function renderCategories(categories) {
            const categoryList = document.getElementById('category-list');
            categoryList.innerHTML = '';

            if (!categories || categories.length === 0) {
                categoryList.innerHTML = `
                    <div class="list-group-item text-muted">
                        No categories found
                    </div>
                `;
                return;
            }

            categories.forEach(category => {
                const categoryItem = document.createElement('button');
                categoryItem.className = 'list-group-item list-group-item-action d-flex justify-content-between align-items-center';
                categoryItem.innerHTML = category.name;

                categoryItem.addEventListener('click', () => {
                    // Toggle category selection
                    if (categoryItem.classList.contains('active')) {
                        categoryItem.classList.remove('active');
                        clearCategoryFilter();
                    } else {
                        document.querySelectorAll('#category-list button').forEach(btn => {
                            btn.classList.remove('active');
                        });
                        categoryItem.classList.add('active');
                        filterProductsByCategory(category.id);
                    }
                });

                categoryList.appendChild(categoryItem);
            });
        }

        // Filter products by category
        function filterProductsByCategory(categoryId) {
            currentCategory = categoryId;
            applyFilters();
        }

        // Clear category filter
        function clearCategoryFilter() {
            currentCategory = null;
            applyFilters();
        }

        // Filter products by search term
        function filterProducts() {
            currentSearchTerm = document.getElementById('product-search').value.toLowerCase();
            applyFilters();
        }

        // Apply both category and search filters
        function applyFilters() {
            allProducts.forEach(product => {
                const matchesCategory = !currentCategory || product.category == currentCategory;
                const matchesSearch = !currentSearchTerm ||
                    product.name.includes(currentSearchTerm) ||
                    product.barcode.includes(currentSearchTerm);

                product.element.style.display = matchesCategory && matchesSearch ? 'block' : 'none';
            });
        }

        // Add to cart function
        function addToCart(product) {
            if (product.quantity <= 0) {
                errorToast("Product is out of stock!");
                return;
            }

            const existingRow = document.querySelector(`#product-row-${product.id}`);
            if (existingRow) {
                const qtyInput = existingRow.querySelector('.qty-input');
                let currentQty = parseInt(qtyInput.value) || 0;

                if (currentQty + 1 > product.quantity) {
                    errorToast("⚠️ Not enough stock available!");
                    return;
                }

                qtyInput.value = currentQty + 1;
                updateRowTotal(qtyInput);
                return;
            }
            cartItems.push(product);

            // Set default tax if not exists
            if (!product.tax) {
                product.tax = { percentage: 0 };
            }

            const taxRate = parseFloat(product.tax.percentage) || 0;
            const taxType = product.tax_type === 'Inclusive' ? 'Incl.' : 'Excl.';
            const basePrice = parseFloat(product.selling_price);
            const discountType = product.discount_type || 'Fixed';
            const maxDiscount = product.discount || 0;

            const tableBody = document.querySelector("table tbody");
            const rowCount = tableBody.rows.length + 1;

            const newRow = document.createElement("tr");
            newRow.setAttribute("id", `product-row-${product.id}`);
            newRow.innerHTML = `
                <td>${rowCount}</td>
                <td>${product.name}</td>
                <td><input type="number" class="qty-input" value="1" min="1" max="${product.quantity}" style="width: 60px;" onchange="updateRowTotal(this)"></td>
                <td><input type="number" class="price-input" value="${basePrice.toFixed(2)}" style="width: 60px;" onchange="updateRowTotal(this)"></td>
                <td>
                    <input type="number" class="discount-input" value="0" min="0" max="${maxDiscount}" style="width: 60px;" onchange="updateRowTotal(this)">
                    <small>${discountType === 'Percentage' ? '%' : '﷼'}</small>
                </td>
                <td>
                    <input type="number" class="tax-input" value="${taxRate}" style="width: 60px;" onchange="updateRowTotal(this)">
                    <small>${taxType}</small>
                </td>
                <td class="line-total">${basePrice.toFixed(2)} <small>(${taxType})</small></td>
                <td>
                    <button type="button" class="btn btn-sm btn-danger" onclick="removeFromCart(this, ${product.id})">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            `;

            newRow.dataset.discountType = discountType;
            newRow.dataset.maxDiscount = maxDiscount;
            newRow.dataset.taxType = product.tax_type;

            tableBody.appendChild(newRow);
            calculateCartTotal();
        }

        function updateRowTotal(inputElement) {
            const row = inputElement.closest('tr');
            const qtyInput = row.querySelector('.qty-input');
            const priceInput = row.querySelector('.price-input');
            const discountInput = row.querySelector('.discount-input');
            const taxInput = row.querySelector('.tax-input');
            const lineTotalCell = row.querySelector('.line-total');

            const quantity = parseInt(qtyInput.value) || 1;
            let price = parseFloat(priceInput.value) || 0;
            let discount = parseFloat(discountInput.value) || 0;
            const taxRate = parseFloat(taxInput.value) || 0;

            const maxDiscount = parseFloat(row.dataset.maxDiscount) || 0;
            const discountType = row.dataset.discountType || 'Fixed';

            // Validate discount
            discount = Math.max(0, Math.min(discount, maxDiscount));
            discountInput.value = discount;

            // Calculate discounted price
            let discountedPrice = price;
            if (discountType === 'Percentage') {
                discountedPrice = price - (price * (discount / 100));
            } else {
                discountedPrice = price - discount;
            }
            discountedPrice = Math.max(0, discountedPrice);

            // Calculate tax
            const taxType = row.dataset.taxType;
            let taxAmount = 0;
            let finalPrice = discountedPrice;

            if (taxType === 'Exclusive') {
                taxAmount = discountedPrice * (taxRate / 100);
                finalPrice = discountedPrice + taxAmount;
            } else if (taxType === 'Inclusive') {
                finalPrice = discountedPrice;
            }

            const total = finalPrice * quantity;
            lineTotalCell.innerHTML = `${total.toFixed(2)} ﷼ <small>(${taxType === 'Inclusive' ? 'Incl.' : 'Excl.'})</small>`;

            calculateCartTotal();
        }

        function calculateCartTotal() {
            const rows = document.querySelectorAll("table tbody tr");
            let total = 0;
            let totalItems = 0;

            rows.forEach(row => {
                const qtyInput = row.querySelector('.qty-input');
                const priceInput = row.querySelector('.price-input');
                const discountInput = row.querySelector('.discount-input');
                const taxInput = row.querySelector('.tax-input');

                const quantity = parseFloat(qtyInput.value) || 1;
                let price = parseFloat(priceInput.value) || 0;
                let discount = parseFloat(discountInput.value) || 0;
                const taxRate = parseFloat(taxInput.value) || 0;

                const maxDiscount = parseFloat(row.dataset.maxDiscount) || 0;
                const discountType = row.dataset.discountType || 'Fixed';

                discount = Math.max(0, Math.min(discount, maxDiscount));

                let discountedPrice = price;
                if (discountType === 'Percentage') {
                    discountedPrice = price - (price * (discount / 100));
                } else {
                    discountedPrice = price - discount;
                }
                discountedPrice = Math.max(0, discountedPrice);

                const taxType = row.dataset.taxType;
                let finalPrice = discountedPrice;

                if (taxType === 'Exclusive') {
                    finalPrice = discountedPrice + (discountedPrice * (taxRate / 100));
                } else if (taxType === 'Inclusive') {
                    finalPrice = discountedPrice;
                }

                total += finalPrice * quantity;
                totalItems += quantity;
            });

            document.getElementById("totalCartAmount").innerText = `${total.toFixed(2)} ﷼`;
            return { total, totalItems };
        }

        function removeFromCart(button, productId) {
            const row = button.closest("tr");
            row.remove();

            cartItems = cartItems.filter(item => item.id !== productId);

            // Re-index row numbers
            document.querySelectorAll("table tbody tr").forEach((r, index) => {
                r.querySelector("td:first-child").textContent = index + 1;
            });

            calculateCartTotal();
        }

        // Submit order function
        function submitOrder() {
            const customerSelect = document.getElementById('customer');
            if (customerSelect.value === '') {
                errorToast('Please select a customer');
                return;
            }

            const rows = document.querySelectorAll("table tbody tr");
            if (rows.length === 0) {
                errorToast('Please add at least one product to the order');
                return;
            }

            const { total, totalItems } = calculateCartTotal();

            document.getElementById('ModelFinalAmount').value = total.toFixed(2);
            document.getElementById('model2total').innerHTML = `${total.toFixed(2)} ﷼`;
            document.getElementById('ModelTotalItem').innerHTML = totalItems;
            document.getElementById('modelPaid').innerHTML = `${total.toFixed(2)} ﷼`;
            document.getElementById('modelDue').innerHTML = '0 ﷼';

            $('#FinalOrderModel').modal('show');
        }

        // Place Order function
        async function PlaceOrder() {
            try {
                const customerId = document.getElementById('customer').value;
                if (!customerId) {
                    errorToast('Please select a customer');
                    return;
                }

                const rows = document.querySelectorAll("table tbody tr");
                if (rows.length === 0) {
                    errorToast('Please add at least one product to the order');
                    return;
                }

                const paymentMethod = document.getElementById('PaymentBY').value;
                const paidAmount = parseFloat(document.getElementById('ModelFinalAmount').value) || 0;
                const { total } = calculateCartTotal();
                const notes = document.getElementById('order-notes').value;

                // Prepare order items
                const orderItems = [];
                let isValid = true;

                rows.forEach(row => {
                    const productId = row.id.replace('product-row-', '');
                    const qtyInput = row.querySelector('.qty-input');
                    const priceInput = row.querySelector('.price-input');
                    const discountInput = row.querySelector('.discount-input');
                    const taxInput = row.querySelector('.tax-input');

                    const quantity = parseFloat(qtyInput.value) || 1;
                    const price = parseFloat(priceInput.value) || 0;
                    const discount = parseFloat(discountInput.value) || 0;
                    const taxRate = parseFloat(taxInput.value) || 0;

                    if (quantity <= 0) {
                        errorToast(`Quantity must be greater than 0 for product ${productId}`);
                        isValid = false;
                        return;
                    }

                    orderItems.push({
                        product_id: productId,
                        quantity: quantity,
                        price: price,
                        discount: discount,
                        discount_type: row.dataset.discountType || 'Fixed',
                        tax_rate: taxRate,
                        tax_type: row.dataset.taxType || 'Exclusive'
                    });
                });

                if (!isValid) return;
                // Prepare order data
                const orderData = {
                    customer_id: customerId,
                    order_items: orderItems,
                    notes: notes,
                    payment_method: paymentMethod,
                    paid_amount: paidAmount,
                    total_amount: total
                };

                showLoader();
                const res = await axios.post('/backendData/order-create', orderData);
                hideLoader();

                if (res.data.status === 'success') {
                    successToast('Order placed successfully!');
                    // Reset the POS interface
                    document.querySelector("table tbody").innerHTML = '';
                    document.getElementById('totalCartAmount').textContent = '0';
                    document.getElementById('ModelFinalAmount').value = '';
                    document.getElementById('order-notes').value = '';
                    cartItems = [];

                    $('#FinalOrderModel').modal('hide');
                    // REDIRECT AFTER 2 second
                    setTimeout(() => {
                        window.location.href = '/order/print/' + res.data['data'];
                    }, 1000);
                } else {
                    errorToast(res.data.message || 'Failed to place order');
                }
            } catch (e) {
                hideLoader();
                console.error('Error placing order:', e);

                if (e.response) {
                    if (e.response.data.errors) {
                        // Handle validation errors
                        const errors = e.response.data.errors;
                        for (const key in errors) {
                            errorToast(errors[key][0]);
                        }
                    } else if (e.response.data.message) {
                        errorToast(e.response.data.message);
                    }
                } else {
                    errorToast('Failed to place order. Please try again.');
                }
            }
        }

        // Order summary calculation
        function calculateOrderSummary() {
            var pay = parseFloat(document.getElementById('ModelFinalAmount').value) || 0;
            var total = parseFloat(document.getElementById('model2total').innerHTML) || 0;

            var due = total - pay;
            document.getElementById('modelDue').innerText = `${due.toFixed(2)} ﷼`;
        }


    </script>
@endsection
