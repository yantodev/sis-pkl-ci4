<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="#" class="brand-link">
        <img src="<?= base_url(); ?>/assets/img/logo/logo-login.png" alt="Logo" class="brand-image
        img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-bold">SIS PKL</span>
    </a>
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?= base_url(); ?>/assets/img/users/default.png" class="img-circle elevation-2"
                     alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?= $users; ?></a>
            </div>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="<?= base_url('admin'); ?>" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-database"></i>
                        <p>
                            Data PKL
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('admin/iduka'); ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Data Siswa</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('admin/guru'); ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Nilai Siswa</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('admin/guru'); ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Laporan Siswa</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-database"></i>
                        <p>
                            Master Data
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('admin/iduka'); ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Iduka</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('admin/guru'); ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Guru</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('admin/tp'); ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tahun Pelajaran</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('admin/master_sekolah'); ?>" class="nav-link">
                        <i class="nav-icon fa fa-school"></i>
                        <p>
                            Master Sekolah
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('admin/print'); ?>" class="nav-link">
                        <i class="nav-icon fa fa-print"></i>
                        <p>Cetak</p>
                    </a>
                </li>
            </ul>
        </nav>
        <hr style="border-color: white;">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item" onclick="logout()">
                    <div class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>
                            Logout
                        </p>
                    </div>
                </li>
            </ul>
        </nav>
    </div>
</aside>
