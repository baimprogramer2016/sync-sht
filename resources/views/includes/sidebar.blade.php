<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
        <a class="sidebar-brand brand-logo" href="index.html"><img src="{{ asset('images/logo_sht.png') }}"
                alt="logo" /></a>
        <a class="sidebar-brand brand-logo-mini text-white" href="index.html">SHT</a>
    </div>
    <ul class="nav">
        <li class="nav-item profile">
            <div class="profile-desc">
                <div class="profile-pic">
                    <div class="count-indicator">
                        <img class="img-xs rounded-circle" src="{{ asset('assets/images/faces/face15.jpg') }}" alt="" />
                        <span class="count bg-success"></span>
                    </div>
                    <div class="profile-name">
                        <h5 class="mb-0 font-weight-normal">Admin</h5>
                        <span>administrator</span>
                    </div>
                </div>
                <a href="#" id="profile-dropdown" data-toggle="dropdown"><i class="mdi mdi-dots-vertical"></i></a>
                <div class="dropdown-menu dropdown-menu-right sidebar-dropdown preview-list"
                    aria-labelledby="profile-dropdown">
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-dark rounded-circle">
                                <i class="mdi mdi-onepassword text-info"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <p class="preview-subject ellipsis mb-1 text-small">
                                Change Password
                            </p>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-dark rounded-circle">
                                <i class="mdi mdi-logout text-danger"></i>
                            </div>
                        </div>
                        <div class="preview-item-content" id="logout">
                            <p class="preview-subject ellipsis mb-1 text-small">
                                Logout
                            </p>
                        </div>
                    </a>
                </div>
            </div>
        </li>
        <li class="nav-item nav-category">
            <span class="nav-link">Navigation</span>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" href="{{ route('dashboard') }}">
                <span class="menu-icon">
                    <i class="mdi mdi-speedometer"></i>
                </span>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        {{-- <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                <span class="menu-icon">
                    <i class="mdi mdi-laptop"></i>
                </span>
                <span class="menu-title">Basic UI Elements</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="pages/ui-features/buttons.html">Buttons</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pages/ui-features/dropdowns.html">Dropdowns</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pages/ui-features/typography.html">Typography</a>
                    </li>
                </ul>
            </div>
        </li> --}}
        <li class="nav-item menu-items">
            <a class="nav-link" href="{{ route('synchronize') }}">
                <span class="menu-icon">
                    <i class="mdi mdi-sync"></i>
                </span>
                <span class="menu-title">Synchronize</span>
            </a>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" href="{{ route('history') }}">
                <span class="menu-icon">
                    <i class="mdi mdi-history"></i>
                </span>
                <span class="menu-title">History</span>
            </a>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" href="{{ route('queue') }}">
                <span class="menu-icon">
                    <i class="mdi mdi-av-timer "></i>
                </span>
                <span class="menu-title">Queue</span>
            </a>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" href="{{ route('failed') }}">
                <span class="menu-icon">
                    <i class="mdi mdi-message-alert"></i>
                </span>
                <span class="menu-title">Error</span>
            </a>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" href="#">
                <span class="menu-icon">
                    <i class="mdi mdi-file-excel"></i>
                </span>
                <span class="menu-title">Report</span>

            </a>

        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" href="#">
                <span class="menu-icon">
                    <i class="mdi mdi-file-document-box"></i>
                </span>
                <span class="menu-title">Documentation</span>
            </a>
        </li>
    </ul>
</nav>
@push('script')
<script>
    document.getElementById('logout').addEventListener('click', function(event) {
        event.preventDefault(); // Mencegah tautan mengarahkan langsung ke logout

        // Lakukan permintaan AJAX untuk logout
        fetch('/logout', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Jika Anda menggunakan csrf token
            }
        })
        .then(response => {
            if (response.ok) {
                // Jika logout berhasil, arahkan pengguna ke halaman login
                window.location.href = '/login';
            } else {
                // Jika logout gagal, lakukan penanganan kesalahan sesuai kebutuhan
                console.error('Gagal logout');
            }
        })
        .catch(error => {
            console.error('Kesalahan:', error);
        });
    });
</script>
@endpush
