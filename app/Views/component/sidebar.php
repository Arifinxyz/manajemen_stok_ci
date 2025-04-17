<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion position-sticky" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url() ?>">
        <div class="sidebar-brand-icon rotate-n-15">
        </div>
        <div class="sidebar-brand-text mx-3">E-ASBARA</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item <?= uri_string() == '' ? 'active' : ''  ?>">
        <a class="nav-link" href="<?= base_url() ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Menu Utama</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Antarmuka
    </div>

    <?php if(userAdminRole()){ ?>
        <li class="nav-item  <?= uri_string() == 'users' ? 'active' : '' ?>">
        <a class="nav-link" href="/users">
            <i class="fas fa-fw fa-user"></i>
            <span>Daftar Pengguna</span>
        </a>

    </li>
    <?php } ?>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item  <?= uri_string() == 'products' ? 'active' : '' ?>">
        <a class="nav-link" href="/products">
            <i class="fas fa-fw fa-boxes"></i>
            <span>Daftar Produk</span>
        </a>

    </li>
    <hr class="sidebar-divider">
    <?php if (petugasRole()) {?>
    <li class="nav-item <?=uri_string() == 'stockin' ? 'active' : ''?>">
        <a class="nav-link" href="/stockin">
            <i class="fas fa-fw fa-box"></i>
            <span>Stok Masuk</span>
        </a>

    </li>
    <?php } ?>
    <li class="nav-item <?=uri_string() == 'stockin/data' ? 'active' : ''?>">
        <a class="nav-link" href="/stockin/data">
            <i class="fas fa-fw fa-box"></i>
            <span>Data Stok Masuk</span>
        </a>

    </li>
    <?php if (petugasRole()) {?>

    <hr class="sidebar-divider">
    <li class="nav-item">
        <a class="nav-link <?=uri_string() == 'stockout' ? 'active' : ''?>" href="/stockout">
            <i class="fas fa-fw fa-box-open"></i>
            <span>Stok Keluar</span>
        </a>


    </li>
    <?php } ?>
    <li class="nav-item">
        <a class="nav-link <?=uri_string() == 'stockout/data' ? 'active' : ''?>" href="/stockout/data">
            <i class="fas fa-fw fa-box-open"></i>
            <span>Data Stok Keluar</span>
        </a>

    </li>
</ul>
<!-- End of Sidebar -->