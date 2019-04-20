<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Clever | Admin</title>

    <link rel="stylesheet" href="/css/app.css">

</head>
<body class="hold-transition sidebar-mini">
<div id="app" class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
            </li>
        </ul>

        <!-- SEARCH FORM -->
        <div class="input-group input-group-sm col-md-3">
            <input class="form-control form-control-navbar" @keyup="searchThis" v-model="search" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-navbar" @click="searchThis">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>

        <div class="input-group input-group-sm text-right" style="display:block;">
            <a class="btn btn-default" href="/"><i class="fas fa-home"></i> Homepage</a>
        </div>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <router-link to="/dashboard" class="brand-link not-active-style logo">
            <img src="data:image/webp;base64,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" alt="Admin Logo" class="brand-image img-circle elevation-3 img-logo withborder"
                 style="opacity: .8">
            <span class="brand-text font-weight-light">Admin Panel</span>
        </router-link>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image col-md-4">
                    <router-link class="not-active-style" to="/profile">
                        <img id="profile-img" src="img/profile/{{ Auth::user()->photo }}" onerror="this.src='img/profile/profile.png'" class="img-circle elevation-2" alt="User Image">
                    </router-link>
                </div>
                <div class="info col-md-8">
                    <router-link class="d-block not-active-style" to="/profile">
                        <span class="label-name">{{ Auth::user()->name }}</span>
                        <span class="label-type text-capitalize">{{ Auth::user()->type }}</span>
                    </router-link>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <router-link to="/dashboard" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt blue"></i>
                            <p class="blue">Dashboard</p>
                        </router-link>
                    </li>

                    @can('isAdminOrAuthor')
                    <li class="nav-item">
                        <router-link to="/contacts" class="nav-link">
                            <i class="fas fa-address-book nav-icon orange"></i>
                            <p class="orange">Contacts</p>
                        </router-link>
                    </li>

                    <li class="nav-item">
                        <router-link to="/users" class="nav-link">
                            <i class="fas fa-users nav-icon teal"></i>
                            <p class="teal">Users</p>
                        </router-link>
                    </li>
                    @endcan

                    @can('isAdmin')
                    <li class="nav-item">
                        <router-link to="/developer" class="nav-link">
                            <i class="nav-icon fas fa-cogs red"></i>
                            <p class="red">Developer</p>
                        </router-link>
                    </li>
                    @endcan

                    <li class="nav-item">
                        <router-link to="/profile" class="nav-link">
                            <i class="nav-icon fas fa-user-alt green"></i>
                            <p class="green">Profile</p>
                        </router-link>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link btn btn-danger btn-logout" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="nav-icon fas fa-power-off strong"></i>
                            <p class="strong">{{ __('Logout') }}</p>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                            @csrf
                        </form>
                    </li>

                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <router-view></router-view>
                <vue-progress-bar></vue-progress-bar>
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- To the right -->
        <div class="float-right d-none d-sm-inline">
            v3.0
        </div>
        <!-- Default to the left -->
        <strong>Copyright &copy; 2014-2018 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved. | Developed by Ricardo Fernandes
    </footer>
</div>
<!-- ./wrapper -->

@auth
    <script>
        window.user = @json(auth()->user())
    </script>
@endauth

<script src="{{ asset('js/app.js') }}"></script>
<!-- Make toastr render -->
{!! toastr()->render() !!}
</body>
</html>
