<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
  
<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
  <div class="sidebar-brand-icon">
    <i class="fas fa-boxes"></i>
  </div>
  <div class="sidebar-brand-text mx-3">Manajemen Stok</div>
</a>
  
  <!-- Divider -->
  <hr class="sidebar-divider my-0">
  
  <!-- Nav Item - Dashboard -->
  <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('dashboard') }}">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Dashboard</span></a>
  </li>
  
    @if(Auth::check() && Auth::user()->role === 'admin')
    <!-- Nav Item - User Management -->
    <li class="nav-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('users.index') }}">
        <i class="fas fa-fw fa-users"></i>
        <span>Pengguna</span></a>
    </li>
    @endif

  <!-- Nav Item - Categories -->
  @if(Auth::check() && Auth::user()->role === 'admin')
  <li class="nav-item {{ request()->routeIs('categories.*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('categories.index') }}">
      <i class="fas fa-fw fa-th"></i>
      <span>Kategori</span></a>
  </li>
  @endif

  <!-- Nav Item - Products -->
  <li class="nav-item {{ request()->routeIs('products.index') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('products.index') }}">
      <i class="fas fa-fw fa-box"></i>
      <span>Barang</span></a>
  </li>
  
  <!-- Nav Item - Suppliers -->
  <li class="nav-item {{ request()->routeIs('suppliers.*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('suppliers.index') }}">
        <i class="fas fa-fw fa-truck"></i>
        <span>Master Supplier</span>
    </a>
  </li>

  
  <!-- Divider -->
  <hr class="sidebar-divider d-none d-md-block">
  
  <!-- Heading -->
  <div class="sidebar-heading">
    Inventaris Stok
  </div>
  
  <!-- Nav Item - Stock Entry -->
  <li class="nav-item {{ request()->routeIs('stock.entry') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('stock.entry') }}">
      <i class="fas fa-fw fa-arrow-circle-right"></i>
      <span>Stok Masuk</span></a>
  </li>
  
  <!-- Nav Item - Stock Exit -->
  <li class="nav-item {{ request()->routeIs('stock.exit') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('stock.exit') }}">
      <i class="fas fa-fw fa-arrow-circle-left"></i>
      <span>Stok Keluar</span></a>
  </li>

   <!-- Nav Item - Stock History -->
<li class="nav-item {{ request()->routeIs('stock.history*') ? 'active' : '' }}">
  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#stockHistoryCollapse" aria-expanded="true" aria-controls="stockHistoryCollapse">
      <i class="fas fa-fw fa-history"></i>
      <span>Riwayat Stok</span>
  </a>
  <div id="stockHistoryCollapse" class="collapse {{ request()->routeIs('stock.history*') ? 'show' : '' }}" aria-labelledby="headingStockHistory" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
          <h6 class="collapse-header">Pilihan Riwayat Stok:</h6>
          <a class="collapse-item {{ request()->routeIs('stock.history.entry') ? 'active' : '' }}" href="{{ route('stock.history.entry') }}">Riwayat Stok Masuk</a>
          <a class="collapse-item {{ request()->routeIs('stock.history.exit') ? 'active' : '' }}" href="{{ route('stock.history.exit') }}">Riwayat Stok Keluar</a>
      </div>
  </div>
</li>


  <!-- Nav Item - Stock Summary -->
  <li class="nav-item {{ request()->routeIs('stock.summary') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('stock.summary') }}">
      <i class="fas fa-fw fa-list-alt"></i>
      <span>Ringkasan Stok</span></a>
  </li>
  
  <!-- Divider -->
  <hr class="sidebar-divider d-none d-md-block">
  
  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>
  
</ul>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $(document).click(function (e) {
            var target = $(e.target);
            
            // Jika klik di luar elemen sidebar, tutup menu jika terbuka
            if (!target.closest('#accordionSidebar').length && !target.closest('[data-toggle="collapse"]').length) {
                $('.collapse').collapse('hide');
            }
        });

        // Jika klik di dalam elemen collapsible, jangan menutup
        $('.collapse').click(function (e) {
            e.stopPropagation();
        });
    });
</script>
