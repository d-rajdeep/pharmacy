<header class="topbar" data-navbarbg="skin6">
    <nav class="navbar top-navbar navbar-expand-lg border-bottom">
        <div class="navbar-header" data-logobg="skin6">
            <a class="nav-toggler waves-effect waves-light d-block d-lg-none" href="javascript:void(0)">
                <i class="ti-menu ti-close"></i>
            </a>

            <div class="navbar-brand w-100 d-flex justify-content-start ps-4 align-items-center">
                <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center text-decoration-none">
                    <img src="{{ asset('assets/images/drugs.png') }}" alt="Logo" class="img-fluid me-2"
                        style="height: 35px; object-fit: contain;">
                    <h4 class="mb-0 text-dark fw-bold" style="letter-spacing: -0.5px;">PharmaCore</h4>
                </a>
            </div>

            <a class="topbartoggler d-block d-lg-none waves-effect waves-light" href="javascript:void(0)"
                data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="ti-more"></i>
            </a>
        </div>

        <div class="navbar-collapse collapse" id="navbarSupportedContent">
            <ul class="navbar-nav float-left me-auto ms-3 ps-1"></ul>

            <ul class="navbar-nav float-end align-items-center">
                <li class="nav-item d-none d-md-block me-3">
                    <a class="nav-link" href="javascript:void(0)">
                        <form>
                            <div class="customize-input position-relative">
                                <i class="fas fa-search position-absolute text-muted"
                                    style="left: 12px; top: 12px; z-index: 10;"></i>
                                <input class="form-control border-0" type="search" placeholder="Search..."
                                    aria-label="Search" style="width: 250px;">
                            </div>
                        </form>
                    </a>
                </li>

                <li class="nav-item dropdown pe-3">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="javascript:void(0)"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="{{ asset('assets/images/users/profile-pic.jpg') }}" alt="user"
                            class="rounded-circle shadow-sm" width="35" height="35" style="object-fit: cover;">
                        <span class="ms-2 d-none d-lg-inline-block text-dark">
                            <span class="text-muted text-sm">Hello,</span> <span class="fw-semibold">Mridul</span>
                            <i data-feather="chevron-down" class="svg-icon ms-1" style="width: 14px;"></i>
                        </span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-right user-dd animated flipInY shadow-lg border-0"
                        style="border-radius: 12px;">
                        <div class="px-4 py-3 border-bottom">
                            <h6 class="mb-0 text-dark fw-bold">Mridul Medhi</h6>
                            <small class="text-muted">Administrator</small>
                        </div>

                        <a class="dropdown-item mt-2" href="javascript:void(0)">
                            <i data-feather="user" class="svg-icon me-2 text-primary"></i> My Profile
                        </a>
                        <a class="dropdown-item" href="javascript:void(0)">
                            <i data-feather="settings" class="svg-icon me-2 text-info"></i> Account Settings
                        </a>

                        <div class="dropdown-divider"></div>

                        <form action="{{ route('admin.logout') }}" method="POST">
                            @csrf
                            <button class="dropdown-item text-danger fw-semibold" type="submit">
                                <i data-feather="power" class="svg-icon me-2"></i> Logout
                            </button>
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>
