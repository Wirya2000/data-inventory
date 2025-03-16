<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 "
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="{{ route('home') }}"
            target="_blank">
            <img src="{{ asset('img/logo-ct-dark.png') }}" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-1 font-weight-bold">Argon Dashboard 2 Laravel</span>
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('customers.*') ? 'active' : '' }}" href="#customerSubmenu" data-bs-toggle="collapse" aria-expanded="false">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-single-02 text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Customer</span>
                    <i class="fas fa-chevron-down ms-auto"></i>
                </a>
                <ul class="collapse list-unstyled {{ request()->routeIs('customers.*') ? 'show' : '' }}" id="customerSubmenu">
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'customers.index' ? 'active' : '' }}" href="{{ route('customers.index') }}">
                            List Customer
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'customers.create' ? 'active' : '' }}" href="{{ route('customers.create') }}">
                            Add Customer
                        </a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'profile.settings' ? 'active' : '' }}" href="{{ route('profile.settings') }}">
                            Settings
                        </a>
                    </li> --}}
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('suppliers.*') ? 'active' : '' }}" href="#supplierSubmenu" data-bs-toggle="collapse" aria-expanded="false">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-single-02 text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Supplier</span>
                    <i class="fas fa-chevron-down ms-auto"></i>
                </a>
                <ul class="collapse list-unstyled {{ request()->routeIs('suppliers.*') ? 'show' : '' }}" id="supplierSubmenu">
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'suppliers.index' ? 'active' : '' }}" href="{{ route('suppliers.index') }}">
                            List Supplier
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'suppliers.create' ? 'active' : '' }}" href="{{ route('suppliers.create') }}">
                            Add Supplier
                        </a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'profile.settings' ? 'active' : '' }}" href="{{ route('profile.settings') }}">
                            Settings
                        </a>
                    </li> --}}
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}" href="#supplierSubmenu" data-bs-toggle="collapse" aria-expanded="false">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-single-02 text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Karyawan</span>
                    <i class="fas fa-chevron-down ms-auto"></i>
                </a>
                <ul class="collapse list-unstyled {{ request()->routeIs('users.*') ? 'show' : '' }}" id="supplierSubmenu">
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'users.index' ? 'active' : '' }}" href="{{ route('users.index') }}">
                            List Karyawan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'users.create' ? 'active' : '' }}" href="{{ route('users.create') }}">
                            Add Karyawan
                        </a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'profile.settings' ? 'active' : '' }}" href="{{ route('profile.settings') }}">
                            Settings
                        </a>
                    </li> --}}
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('kategoris.*') ? 'active' : '' }}" href="#kategorisSubmenu" data-bs-toggle="collapse" aria-expanded="false">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-single-02 text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Kategoris</span>
                    <i class="fas fa-chevron-down ms-auto"></i>
                </a>
                <ul class="collapse list-unstyled {{ request()->routeIs('kategoris.*') ? 'show' : '' }}" id="kategorisSubmenu">
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'kategoris.index' ? 'active' : '' }}" href="{{ route('kategoris.index') }}">
                            List Kategoris
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'kategoris.create' ? 'active' : '' }}" href="{{ route('kategoris.create') }}">
                            Add Kategoris
                        </a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'profile.settings' ? 'active' : '' }}" href="{{ route('profile.settings') }}">
                            Settings
                        </a>
                    </li> --}}
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('barangs.*') ? 'active' : '' }}" href="#barangSubmenu" data-bs-toggle="collapse" aria-expanded="false">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-single-02 text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Barang</span>
                    <i class="fas fa-chevron-down ms-auto"></i>
                </a>
                <ul class="collapse list-unstyled {{ request()->routeIs('barangs.*') ? 'show' : '' }}" id="barangSubmenu">
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'barangs.index' ? 'active' : '' }}" href="{{ route('barangs.index') }}">
                            List Barang
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'barangs.create' ? 'active' : '' }}" href="{{ route('barangs.create') }}">
                            Add Barang
                        </a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'profile.settings' ? 'active' : '' }}" href="{{ route('profile.settings') }}">
                            Settings
                        </a>
                    </li> --}}
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('pembelians.*') ? 'active' : '' }}" href="#pembelianSubmenu" data-bs-toggle="collapse" aria-expanded="false">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-single-02 text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Pembelian</span>
                    <i class="fas fa-chevron-down ms-auto"></i>
                </a>
                <ul class="collapse list-unstyled {{ request()->routeIs('pembelians.*') ? 'show' : '' }}" id="pembelianSubmenu">
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'pembelians.index' ? 'active' : '' }}" href="{{ route('pembelians.index') }}">
                            List Pembelian
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'pembelians.create' ? 'active' : '' }}" href="{{ route('pembelians.create') }}">
                            Add Pembelian
                        </a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'profile.settings' ? 'active' : '' }}" href="{{ route('profile.settings') }}">
                            Settings
                        </a>
                    </li> --}}
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('penjualans.*') ? 'active' : '' }}" href="#penjualanSubmenu" data-bs-toggle="collapse" aria-expanded="false">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-single-02 text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Penjualan</span>
                    <i class="fas fa-chevron-down ms-auto"></i>
                </a>
                <ul class="collapse list-unstyled {{ request()->routeIs('penjualans.*') ? 'show' : '' }}" id="penjualanSubmenu">
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'penjualans.index' ? 'active' : '' }}" href="{{ route('penjualans.index') }}">
                            List Penjualan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'penjualans.create' ? 'active' : '' }}" href="{{ route('penjualans.create') }}">
                            Add Penjualan
                        </a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'profile.settings' ? 'active' : '' }}" href="{{ route('profile.settings') }}">
                            Settings
                        </a>
                    </li> --}}
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}" href="#reportSubmenu" data-bs-toggle="collapse" aria-expanded="false">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-single-02 text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Laporan</span>
                    <i class="fas fa-chevron-down ms-auto"></i>
                </a>
                <ul class="collapse list-unstyled {{ request()->routeIs('reports.*') ? 'show' : '' }}" id="reportSubmenu">
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'reports.index' ? 'active' : '' }}" href="{{ route('reports.index') }}">
                            Laporan...
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'reports.create' ? 'active' : '' }}" href="{{ route('reports.create') }}">
                            Laporan...
                        </a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'profile.settings' ? 'active' : '' }}" href="{{ route('profile.settings') }}">
                            Settings
                        </a>
                    </li> --}}
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('customers.*') ? 'active' : '' }}" href="#customerSubmenu" data-bs-toggle="collapse" aria-expanded="false">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-single-02 text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Customer</span>
                    <i class="fas fa-chevron-down ms-auto"></i>
                </a>
                <ul class="collapse list-unstyled {{ request()->routeIs('customers.*') ? 'show' : '' }}" id="customerSubmenu">
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'customers.index' ? 'active' : '' }}" href="{{ route('customers.index') }}">
                            List Customer
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'customers.create' ? 'active' : '' }}" href="{{ route('customers.create') }}">
                            Add Customer
                        </a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'profile.settings' ? 'active' : '' }}" href="{{ route('profile.settings') }}">
                            Settings
                        </a>
                    </li> --}}
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('customers.*') ? 'active' : '' }}" href="#customerSubmenu" data-bs-toggle="collapse" aria-expanded="false">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-single-02 text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Customer</span>
                    <i class="fas fa-chevron-down ms-auto"></i>
                </a>
                <ul class="collapse list-unstyled {{ request()->routeIs('customers.*') ? 'show' : '' }}" id="customerSubmenu">
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'customers.index' ? 'active' : '' }}" href="{{ route('customers.index') }}">
                            List Customer
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'customers.create' ? 'active' : '' }}" href="{{ route('customers.create') }}">
                            Add Customer
                        </a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'profile.settings' ? 'active' : '' }}" href="{{ route('profile.settings') }}">
                            Settings
                        </a>
                    </li> --}}
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('customers.*') ? 'active' : '' }}" href="#customerSubmenu" data-bs-toggle="collapse" aria-expanded="false">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-single-02 text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Customer</span>
                    <i class="fas fa-chevron-down ms-auto"></i>
                </a>
                <ul class="collapse list-unstyled {{ request()->routeIs('customers.*') ? 'show' : '' }}" id="customerSubmenu">
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'customers.index' ? 'active' : '' }}" href="{{ route('customers.index') }}">
                            List Customer
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'customers.create' ? 'active' : '' }}" href="{{ route('customers.create') }}">
                            Add Customer
                        </a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'profile.settings' ? 'active' : '' }}" href="{{ route('profile.settings') }}">
                            Settings
                        </a>
                    </li> --}}
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('customers.*') ? 'active' : '' }}" href="#customerSubmenu" data-bs-toggle="collapse" aria-expanded="false">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-single-02 text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Customer</span>
                    <i class="fas fa-chevron-down ms-auto"></i>
                </a>
                <ul class="collapse list-unstyled {{ request()->routeIs('customers.*') ? 'show' : '' }}" id="customerSubmenu">
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'customers.index' ? 'active' : '' }}" href="{{ route('customers.index') }}">
                            List Customer
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'customers.create' ? 'active' : '' }}" href="{{ route('customers.create') }}">
                            Add Customer
                        </a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'profile.settings' ? 'active' : '' }}" href="{{ route('profile.settings') }}">
                            Settings
                        </a>
                    </li> --}}
                </ul>
            </li>
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Pages</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ str_contains(request()->url(), 'tables') == true ? 'active' : '' }}" href="{{ route('page', ['page' => 'tables']) }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Tables</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{  str_contains(request()->url(), 'billing') == true ? 'active' : '' }}" href="{{ route('page', ['page' => 'billing']) }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-credit-card text-success text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Billing</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'virtual-reality' ? 'active' : '' }}" href="{{ route('virtual-reality') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-app text-info text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Virtual Reality</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'rtl' ? 'active' : '' }}" href="{{ route('rtl') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-world-2 text-danger text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">RTL</span>
                </a>
            </li>
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Account pages</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'profile-static' ? 'active' : '' }}" href="{{ route('profile-static') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-single-02 text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Profile</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="{{ route('sign-in-static') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-single-copy-04 text-warning text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Sign In</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="{{ route('sign-up-static') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-collection text-info text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Sign Up</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="sidenav-footer mx-3 ">
        <div class="card card-plain shadow-none" id="sidenavCard">
            <img class="w-50 mx-auto" src="/img/illustrations/icon-documentation-warning.svg"
                alt="sidebar_illustration">
            <div class="card-body text-center p-3 w-100 pt-0">
                <div class="docs-info">
                    <h6 class="mb-0">Need help?</h6>
                    <p class="text-xs font-weight-bold mb-0">Please check our docs</p>
                </div>
            </div>
        </div>
        <a href="/docs/bootstrap/overview/argon-dashboard/index.html" target="_blank"
            class="btn btn-dark btn-sm w-100 mb-3">Documentation</a>
        <a class="btn btn-primary btn-sm mb-0 w-100"
            href="https://www.creative-tim.com/product/argon-dashboard-pro-laravel" target="_blank" type="button">Upgrade to PRO</a>
    </div>
</aside>
