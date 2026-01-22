<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>@yield('title') | Mini POS</title>
    {{--General CSS Files--}}
    <link rel="stylesheet" href="{{ asset('assets/backend/css/app.min.css') }}">
    {{--Data Table--}}
    <link rel="stylesheet" href="{{ asset('assets/backend/bundles/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/backend/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
    {{--Template CSS--}}
    <link rel="stylesheet" href="{{ asset('assets/backend/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/backend/css/components.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/backend/bundles/summernote/summernote-bs4.css') }}">
    {{--Tag Info--}}
    <link rel="stylesheet" href="{{ asset('assets/backend/bundles/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
    {{--CheckBox--}}
    <link rel="stylesheet" href="{{ asset('assets/backend/bundles/pretty-checkbox/pretty-checkbox.min.css') }}">
    {{--Select 2--}}
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
    {{--Custom style CSS--}}
    <link rel="stylesheet" href="{{ asset('assets/backend/css/custom.css') }}">
    <link rel='icon' type="image/png" href='{{ asset('assets/images/favicon.png') }}' />
    {{--Toastify CSS--}}
    <link rel="stylesheet" href="{{ asset('assets/css/toastify.min.css') }}">
</head>
<body>
<div class="loader"></div>
<div id="app">
    <div class="main-wrapper main-wrapper-1">
        <div class="navbar-bg"></div>
        <nav class="navbar navbar-expand-lg main-navbar sticky">
            <div class="form-inline mr-auto">
                <ul class="navbar-nav mr-3">
                    <li>
                        <a href="#" data-toggle="sidebar" class="nav-link nav-link-lgcollapse-btn">
                            <i data-feather="align-justify"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link nav-link-lg fullscreen-btn">
                            <i data-feather="maximize"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <ul class="navbar-nav navbar-right">
                <li class="dropdown dropdown-list-toggle">
                    <a href="#" data-toggle="dropdown" class="nav-link nav-link-lg message-toggle">
                        <i data-feather="bell" id="ActiveNotificationIcon"></i>
                        <span class="badge headerBadge1" id="ActiveNotificationNumber"></span>
                    </a>
                    <div class="dropdown-menu dropdown-list dropdown-menu-right pullDown">
                        <div class="dropdown-header">
                            Notifications
                            <div class="float-right">
                                <a class="text-danger" onclick="MarkAllRead()" style="cursor: pointer"><u>Mark All As Read</u></a>
                            </div>
                        </div>
                        <div class="dropdown-list-content dropdown-list-icons" id="ActiveNotificationData">

                        </div>
                        <div class="dropdown-footer text-center">
                            <a href="{{ route('notifications') }}">View All <i class="fas fa-chevron-right"></i></a>
                        </div>
                    </div>
                </li>
                <li class="dropdown">
                    <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                        <img alt="image" src="@if($admin->image === null) {{asset('assets/backend/img/user.png') }} @else {{ asset('assets/uploads/profile/').'/'.$admin->image }} @endif" class="user-img-radious-style">
                        <span class="d-sm-none d-lg-inline-block"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right pullDown">
                        <div class="dropdown-title">Hello User</div>
                        <a href="{{ route('Profile') }}" class="dropdown-item has-icon">
                            <i class="far fa-user"></i> Profile
                        </a>
                        <a href="{{ route('Setting') }}" class="dropdown-item has-icon"> <i class="fas fa-cog"></i>
                            Settings
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('Logout') }}" class="dropdown-item has-icon text-danger"> <i class="fas fa-sign-out-alt"></i>
                            Logout
                        </a>
                    </div>
                </li>
            </ul>
        </nav>
        <div class="main-sidebar sidebar-style-2">
            <aside id="sidebar-wrapper">
                <div class="sidebar-brand">
                    <a href="{{ route('Dashboard') }}">
                        <img alt="image" src="{{ asset('assets/images/logo.png') }}" class="img-fluid" style="padding-bottom: 30px; padding-top: 20px"/>
                    </a>
                </div>
                <ul class="sidebar-menu">
                    <li class="dropdown {{ request()->routeIs('Dashboard') ? 'active' : '' }}">
                        <a href="{{ route('Dashboard') }}" class="nav-link"><i class="fas fa-home"></i><span>Dashboard</span></a>
                    </li>
                    <li class="dropdown {{ request()->routeIs('Categories', 'Categories', 'Brands', 'Taxes', 'Units', 'Products', 'Product.Create', 'Product.Single.View', 'Product.Single.update') ? 'active' : '' }}">
                        <a href="#" class="menu-toggle nav-link has-dropdown">
                            <i class="fas fa-suitcase"></i><span>Products</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="{{ request()->routeIs('Categories') ? 'active' : '' }}"><a class="nav-link" href="{{ route('Categories') }}">Categories</a></li>
                            <li class="{{ request()->routeIs('Brands') ? 'active' : '' }}"><a class="nav-link" href="{{ route('Brands') }}">Brands</a></li>
                            <li class="{{ request()->routeIs('Taxes') ? 'active' : '' }}"><a class="nav-link" href="{{ route('Taxes') }}">Taxes</a></li>
                            <li class="{{ request()->routeIs('Units') ? 'active' : '' }}"><a class="nav-link" href="{{ route('Units') }}">Units</a></li>
                            <li class="{{ request()->routeIs('Products', 'Product.Create', 'Product.Single.View', 'Product.Single.update') ? 'active' : '' }}"><a class="nav-link" href="{{ route('Products') }}">Products</a></li>
                        </ul>
                    </li>
                    <li class="dropdown {{ request()->routeIs('Customers') ? 'active' : '' }}">
                        <a href="{{ route('Customers') }}" class="nav-link"><i class="fas fa-user"></i><span>Customer</span></a>
                    </li>
                    <li class="dropdown {{ request()->routeIs('POS') ? 'active' : '' }}">
                        <a href="{{ route('POS') }}" class="nav-link"><i class="fas fa-tv"></i><span>POS</span></a>
                    </li>
                    <li class="dropdown {{ request()->routeIs('Orders') ? 'active' : '' }}">
                        <a href="{{ route('Orders') }}" class="nav-link"><i class="fas fa-shopping-bag"></i><span>Orders</span></a>
                    </li>
                    <li class="dropdown {{ request()->routeIs('notifications') ? 'active' : '' }}">
                        <a href="{{ route('notifications') }}" class="nav-link"><i class="fas fa-bell"></i><span>Notification</span></a>
                    </li>
                    <li class="dropdown {{ request()->routeIs('Setting') ? 'active' : '' }}">
                        <a href="{{ route('Setting') }}" class="nav-link"><i class="fas fa-cogs"></i><span>Setting</span></a>
                    </li>
                    <li class="dropdown {{ request()->routeIs('Support') ? 'active' : '' }}">
                        <a href="{{ route('Support') }}" class="nav-link"><i class="fas fa-headset"></i><span>Support</span></a>
                    </li>
                </ul>
            </aside>
        </div>

        {{--Main Content--}}
        @yield('content')

        <footer class="main-footer">
            <div class="footer-left">
                <a href="https://www.mdmaraz.net" target="_blank" rel="noopener noreferrer">Developed By Md. Maraz</a>
            </div>
            <div class="footer-right">
            </div>
        </footer>
    </div>
</div>

{{--General JS Scripts--}}
<script src="{{ asset('assets/backend/js/app.min.js') }}"></script>
{{--JS Libraies--}}
<script src="{{ asset('assets/backend/bundles/apexcharts/apexcharts.min.js') }}"></script>
{{--Page Specific JS File--}}
<script src="{{ asset('assets/backend/js/page/index.js') }}"></script>
{{--Axios--}}
<script src="{{ asset('assets/js/axios.min.js') }}"></script>
{{--Toastify JS--}}
<script src="{{ asset('assets/js/toastify-js.js') }}"></script>
<!-- JS Libraies -->
<script src="{{ asset('assets/backend/bundles/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('assets/backend/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/backend/bundles/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('assets/backend/bundles/jquery-selectric/jquery.selectric.min.js') }}"></script>
{{--Tag Input--}}
<script src="{{ asset('assets/backend/bundles/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
{{--Page Specific JS File--}}
<script src="{{ asset('assets/backend/js/page/datatables.js') }}"></script>
{{--JS Libraies--}}
<script src="{{ asset('assets/backend/bundles/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/backend/bundles/summernote/summernote-bs4.js') }}"></script>
{{--Select2--}}
<script src="{{ asset('assets/js/select2.min.js') }}"></script>
{{--Template JS File--}}
<script src="{{ asset('assets/backend/js/scripts.js') }}"></script>
{{--Custom Config--}}
<script src="{{ asset('assets/js/custom-config.js') }}"></script>
<script>
    // Mark all notifications as read
    async function MarkAllRead(){
        try{
            showLoader();
            let res = await axios.get("/backendData/activeNotificationMarkAllRead");
            document.getElementById('ActiveNotificationNumber').innerText = '';
            document.getElementById('ActiveNotificationIcon').classList.remove('bell');
            document.getElementById('ActiveNotificationIcon').style.color = '';
            getFiveNotificationData();
            hideLoader();
        }catch (e) {
            console.error(e);
        }
    }
    // Load active notifications on page load
    getActiveNotificationData();
    // Get active notifications
    async function getActiveNotificationData() {
        try {
            let res = await axios.get("/backendData/activeNotifications-list");
            // count the number of notifications
            let count = res.data['data'].length;
            if( count > 0) {
                document.getElementById('ActiveNotificationNumber').innerText = count;
                document.getElementById('ActiveNotificationIcon').classList.add('bell');
                document.getElementById('ActiveNotificationIcon').style.color = 'red';
            } else {
                document.getElementById('ActiveNotificationNumber').innerText = '';
                document.getElementById('ActiveNotificationIcon').classList.remove('bell');
                document.getElementById('ActiveNotificationIcon').style.color = '';
                getFiveNotificationData();
            }
            let DataList = $("#ActiveNotificationData");
            DataList.empty(); // clear old data
            // Build table rows dynamically
            res.data['data'].forEach(function(item) {
                // Get current time and notification time
                let now = new Date();
                let createdAt = new Date(item['created_at']);
                // Calculate difference in seconds
                let diffInSeconds = Math.floor((now - createdAt) / 1000);
                let timeAgo = '';
                if (diffInSeconds < 60) {
                    timeAgo = `${diffInSeconds} seconds ago`;
                } else if (diffInSeconds < 3600) {
                    let minutes = Math.floor(diffInSeconds / 60);
                    timeAgo = `${minutes} minute${minutes > 1 ? 's' : ''} ago`;
                } else if (diffInSeconds < 86400) {
                    let hours = Math.floor(diffInSeconds / 3600);
                    timeAgo = `${hours} hour${hours > 1 ? 's' : ''} ago`;
                } else {
                    let days = Math.floor(diffInSeconds / 86400);
                    timeAgo = `${days} day${days > 1 ? 's' : ''} ago`;
                }
                let row = `
                                        <a href="${item['url']}" class="dropdown-item dropdown-item-unread">
                                            <span class="dropdown-item-icon bg-primary text-white">
                                                <i class="fas fa-bell"></i>
                                            </span>
                                            <span class="dropdown-item-desc">
                                                ${item['message']}
                                                <span class="time">${timeAgo}</span>
                                            </span>
                                        </a>
                                `;
                DataList.append(row);
            });
        } catch (e) {
            hideLoader();
            console.error(e);
        }
    }
    // Get last five notifications
    async function getFiveNotificationData() {
        try {
            let res = await axios.get("/backendData/fiveNotifications-list");
            let DataList = $("#ActiveNotificationData");
            DataList.empty(); // clear old data
            // Build table rows dynamically
            res.data['data'].forEach(function(item) {
                // Get current time and notification time
                let now = new Date();
                let createdAt = new Date(item['created_at']);
                // Calculate difference in seconds
                let diffInSeconds = Math.floor((now - createdAt) / 1000);
                let timeAgo = '';
                if (diffInSeconds < 60) {
                    timeAgo = `${diffInSeconds} seconds ago`;
                } else if (diffInSeconds < 3600) {
                    let minutes = Math.floor(diffInSeconds / 60);
                    timeAgo = `${minutes} minute${minutes > 1 ? 's' : ''} ago`;
                } else if (diffInSeconds < 86400) {
                    let hours = Math.floor(diffInSeconds / 3600);
                    timeAgo = `${hours} hour${hours > 1 ? 's' : ''} ago`;
                } else {
                    let days = Math.floor(diffInSeconds / 86400);
                    timeAgo = `${days} day${days > 1 ? 's' : ''} ago`;
                }
                let row = `
                                        <a href="${item['url']}" class="dropdown-item dropdown-item-unread">
                                            <span class="dropdown-item-icon bg-primary text-white">
                                                <i class="fas fa-bell"></i>
                                            </span>
                                            <span class="dropdown-item-desc">
                                                ${item['message']}
                                                <span class="time">${timeAgo}</span>
                                            </span>
                                        </a>
                                `;
                DataList.append(row);
            });
        } catch (e) {
            hideLoader();
            console.error(e);
        }
    }
</script>
@yield('scripts')
</body>
</html>
