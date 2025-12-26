<aside class="left-sidebar" data-sidebarbg="skin6">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar" data-sidebarbg="skin6">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <!-- Dashboard -->
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('admin.dashboard') }}">
                        <i data-feather="home" class="feather-icon"></i>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>

                <li class="list-divider"></li>

                <!-- Medicines -->
                @php
                    $isMedicines = request()->is('admin/medicines*') || request()->is('admin/categories*');
                @endphp

                <li class="sidebar-item {{ $isMedicines ? 'selected' : '' }}">
                    <a class="sidebar-link has-arrow {{ $isMedicines ? 'active' : '' }}" href="javascript:void(0)">
                        <i data-feather="package" class="feather-icon"></i>
                        <span class="hide-menu">Medicines</span>
                    </a>
                    <ul class="collapse first-level base-level-line {{ $isMedicines ? 'in' : '' }}">
                        <li class="sidebar-item">
                            <a href="{{ route('admin.medicines.index') }}"
                                class="sidebar-link {{ request()->routeIs('admin.medicines.index') ? 'active' : '' }}">
                                All Medicines
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="{{ route('admin.categories.index') }}"
                                class="sidebar-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                                Medicine Category
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="{{ route('admin.medicines.create') }}"
                                class="sidebar-link {{ request()->routeIs('admin.medicines.create') ? 'active' : '' }}">
                                Add Medicine
                            </a>
                        </li>
                    </ul>
                </li>


                <!-- Inventory -->
                @php
                    $isInventory = request()->is('admin/inventory*');
                @endphp

                <li class="sidebar-item {{ $isInventory ? 'selected' : '' }}">
                    <a class="sidebar-link has-arrow {{ $isInventory ? 'active' : '' }}" href="javascript:void(0)">
                        <i data-feather="database" class="feather-icon"></i>
                        <span class="hide-menu">Inventory</span>
                    </a>

                    <ul class="collapse first-level base-level-line {{ $isInventory ? 'in' : '' }}">
                        <li class="sidebar-item">
                            <a href="{{ route('admin.inventory.summary') }}"
                                class="sidebar-link {{ request()->routeIs('admin.inventory.summary') ? 'active' : '' }}">
                                Stock Summary
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="{{ route('admin.medicines.index') }}" class="sidebar-link">
                                Adjust Stock
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Billing -->
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow" href="javascript:void(0)">
                        <i data-feather="shopping-bag" class="feather-icon"></i>
                        <span class="hide-menu">Billing</span>
                    </a>

                    <ul aria-expanded="false" class="collapse first-level base-level-line">

                        <!-- All Purchases / Bills -->
                        <li class="sidebar-item">
                            <a href="{{ route('admin.billing.index') }}" class="sidebar-link">
                                <span class="hide-menu">All Purchases</span>
                            </a>
                        </li>

                        <!-- Add Purchase / New Bill -->
                        <li class="sidebar-item">
                            <a href="{{ route('admin.billing.create') }}" class="sidebar-link">
                                <span class="hide-menu">Add Purchase</span>
                            </a>
                        </li>

                    </ul>
                </li>


                <!-- Sales -->
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow" href="javascript:void(0)">
                        <i data-feather="shopping-cart" class="feather-icon"></i>
                        <span class="hide-menu">Sales</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level base-level-line">
                        <li class="sidebar-item"> <a href="table-basic.html" class="sidebar-link"> <span
                                    class="hide-menu"> All Sales </span> </a> </li>
                        <li class="sidebar-item"> <a href="table-dark-basic.html" class="sidebar-link"> <span
                                    class="hide-menu"> New Sale </span> </a> </li>
                    </ul>
                </li>


                <!-- Customers -->
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow" href="javascript:void(0)">
                        <i data-feather="users" class="feather-icon"></i>
                        <span class="hide-menu">Customers</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level base-level-line">
                        <li class="sidebar-item"> <a href="table-basic.html" class="sidebar-link"> <span
                                    class="hide-menu"> Customer List </span> </a> </li>
                        <li class="sidebar-item"> <a href="table-dark-basic.html" class="sidebar-link"> <span
                                    class="hide-menu"> Add Customer </span> </a> </li>
                    </ul>
                </li>

                <!-- Suppliers -->
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow" href="javascript:void(0)">
                        <i data-feather="truck" class="feather-icon"></i>
                        <span class="hide-menu">Suppliers</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level base-level-line">
                        <li class="sidebar-item"> <a href="table-basic.html" class="sidebar-link"> <span
                                    class="hide-menu"> Supplier List </span> </a> </li>
                        <li class="sidebar-item"> <a href="table-dark-basic.html" class="sidebar-link"> <span
                                    class="hide-menu"> Add Supplier </span> </a> </li>
                    </ul>
                </li>

                <!-- Reports -->
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow" href="javascript:void(0)">
                        <i data-feather="bar-chart-2" class="feather-icon"></i>
                        <span class="hide-menu">Reports</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level base-level-line">
                        <li class="sidebar-item"> <a href="table-basic.html" class="sidebar-link"> <span
                                    class="hide-menu"> Sales Report </span> </a> </li>
                        <li class="sidebar-item"> <a href="table-dark-basic.html" class="sidebar-link"> <span
                                    class="hide-menu"> Inventory Report </span> </a> </li>
                    </ul>
                </li>

                <li class="list-divider"></li>

                <!-- Logout -->
                <li class="sidebar-item">
                    <form action="{{ route('admin.logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit"
                            class="sidebar-link bg-transparent border-0 text-danger w-100 text-start d-flex align-items-center">
                            <i data-feather="log-out" class="feather-icon me-2"></i>
                            <span class="hide-menu">Logout</span>
                        </button>
                    </form>
                </li>
            </ul>
        </nav>
    </div>
    <!-- End Sidebar scroll-->
</aside>
