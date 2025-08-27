<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex   text-start " href="index.php">
        <div class="sidebar-brand-text">RS INFRA</div>
    </a>
    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="/">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Heading -->
    <div class="sidebar-heading">
        <br>Management
    </div>

    <!-- Start ========================================================= Project List -->
    <li class="nav-item">
        <a class="nav-link" href="/contacts">
            <i class="fas fa-user"></i>
            <span>Contact Management</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/users">
            <i class="fas fa-user"></i>
            <span>User Management</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/projects">
            <i class="fas fa-file"></i>
            <span>Project Management</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/task-management">
            <i class="fas fa-tasks"></i>
            <span>Task Management</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="/materials">
            <i class="fas fa-archive"></i>
            <span>Material & Inventory</span></a>
    </li>


    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseExpense"
            aria-expanded="false" aria-controls="collapseExpense">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Expense Management</span>
            <i class="fas ms-2 fa-arrow-down"></i>
        </a>

        <div id="collapseExpense" class="bg-white py-2 collapse-inner rounded collapse"
            data-bs-parent="#accordionSidebar">
            <div class="bg-white collapse-inner rounded">
                <a class="collapse-item" href="/budget-planning">Budget planning</a>
                <a class="collapse-item" href="/expense-track">Expense tracking</a>
            </div>
        </div>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    <!-- Heading -->
    <div class="sidebar-heading">
        <br> <br>Activity
    </div>
    <li class="nav-item">
        <a class="nav-link" href="/finance-billing">
            <i class="fas fa-money-bill"></i>
            <span>Finance & Billing</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/payment-settlement">
            <i class="fas fa-fw fa-table"></i>
            <span>Payment & settlement logs</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/proposals">
            <i class="fas fa-fw fa-table"></i>
            <span>Proposal Management</span></a>
    </li>
    <!-- END ========================================================== Project List -->
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>