<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="index3.html" class="brand-link">
    <img src="{{ asset('AdminLTE/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">BWA Bank</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{asset('AdminLTE/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block">Admin</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="/admin" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dasboard
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('admin.transactions.index') }}" class="nav-link">
            <i class="nav-icon fas fa-chart-bar"></i>
            <p>
              Transaction
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('admin.transaction_types.index') }}" class="nav-link">
            <i class="nav-icon fas fa-suitcase-rolling"></i>
            <p>
              Transaction Type
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('admin.payment_methods.index') }}" class="nav-link">
            <i class="nav-icon fas fa-credit-card"></i>
            <p>
              Payment Method
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('admin.tips.index') }}" class="nav-link">
            <i class="nav-icon fas fa-newspaper"></i>
            <p>
              Tips
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('admin.auth.logout') }}" class="nav-link">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p>
              Log Out
            </p>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>