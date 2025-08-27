<nav class="navbar navbar-expand navbar-light bg-white shadow mb-4">
    <!-- Sidebar Toggle (Topbar) -->
    <button class="btn btn-link d-md-none rounded-circle me-3" id="sidebarToggleTop">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Right Side Navbar -->
    <ul class="navbar-nav ms-auto">

        <!-- Search (XS Only) -->
        <li class="nav-item dropdown d-sm-none">
            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-end p-3 shadow" aria-labelledby="searchDropdown">
                <form class="d-flex w-100">
                    <input class="form-control me-2 bg-light border-0 small" type="search" placeholder="Search for...">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search fa-sm"></i>
                    </button>
                </form>
            </div>
        </li>

        <!-- Alerts -->
        <li class="nav-item dropdown mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <span class="badge bg-danger rounded-pill position-absolute top-0 start-100 translate-middle">3+</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="alertsDropdown">
                <li>
                    <h6 class="dropdown-header">Alerts Center</h6>
                </li>
                <li>
                    <a class="dropdown-item d-flex align-items-center" href="#">
                        <div class="me-3">
                            <div class="icon-circle bg-primary text-white p-2 rounded-circle">
                                <i class="fas fa-file-alt"></i>
                            </div>
                        </div>
                        <div>
                            <div class="small text-gray-500">July 1, 2025</div>
                            <span class="fw-bold">New monthly report available!</span>
                        </div>
                    </a>
                </li>
                <li><a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a></li>
            </ul>
        </li>

        <!-- Messages -->
        <li class="nav-item dropdown mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-envelope fa-fw"></i>
                <span class="badge bg-danger rounded-pill position-absolute top-0 start-100 translate-middle">7</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="messagesDropdown">
                <li>
                    <h6 class="dropdown-header">Message Center</h6>
                </li>
                <li>
                    <a class="dropdown-item d-flex align-items-center" href="#">
                        <div class="me-3">
                            <img class="rounded-circle" src="img/undraw_profile_1.svg" alt="" width="40">
                            <div class="status-indicator bg-success"></div>
                        </div>
                        <div class="fw-bold">
                            <div class="text-truncate">Can you help me with a problem?</div>
                            <div class="small text-gray-500">Emily Fowler · 1h</div>
                        </div>
                    </a>
                </li>
                <li><a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a></li>
            </ul>
        </li>

        <!-- Divider -->
        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- User Info -->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown"
                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="me-2 d-none d-lg-inline text-gray-600 small">{{ optional(auth()->user())->name ?? 'Guest' }}</span>
                <img class="img-profile rounded-circle" src="/img/undraw_profile.svg" width="32" height="32">
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown">
                <li><a class="dropdown-item" href="profile.php"><i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i> Profile</a></li>

                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i> Logout
                    </a>
                </li>
            </ul>
        </li>

    </ul>
</nav>