<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
  
    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
      <i class="fa fa-bars"></i>
    </button>
    
    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">
    
        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                    {{ auth()->user()->name }}
                    <br>
                    <small>{{ auth()->user()->level }}</small>
                </span>
                <img class="img-profile rounded-circle" src="https://startbootstrap.github.io/startbootstrap-sb-admin-2/img/undraw_profile.svg">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="/profile">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profil
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" id="logoutButton">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Keluar
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="GET" style="display: none;">
                    @csrf
                </form>
            </div>
        </li>
    
    </ul>
    
  </nav>
  

  <!-- SweetAlert JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Konfirmasi logout dengan SweetAlert -->
<script>
    document.getElementById('logoutButton').addEventListener('click', function(event) {
        event.preventDefault();
        Swal.fire({
            title: 'Anda yakin?',
            text: "Anda Akan Keluar Dari Akun",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Keluar Akun '
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logout-form').submit();
            }
        })
    });

    // Membuat form logout yang disubmit secara otomatis
    var logoutForm = document.getElementById('logout-form');
    if (!logoutForm) {
        logoutForm = document.createElement('form');
        logoutForm.setAttribute('id', 'logout-form');
        logoutForm.setAttribute('method', 'POST');
        logoutForm.setAttribute('action', '{{ route('logout') }}');
        logoutForm.style.display = 'none';
        var csrfInput = document.createElement('input');
        csrfInput.setAttribute('type', 'hidden');
        csrfInput.setAttribute('name', '_token');
        csrfInput.setAttribute('value', '{{ csrf_token() }}');
        logoutForm.appendChild(csrfInput);
        document.body.appendChild(logoutForm);
    }
</script>
  
