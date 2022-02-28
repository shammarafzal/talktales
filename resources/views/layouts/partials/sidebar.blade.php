<!-- Left Sidenav -->
<div class="left-sidenav">
    <!-- LOGO -->
    <div class="brand">
        <a href="{{ route('index') }}" class="logo">
            <span>
                <img src="{{ asset('assets/images/logo.png') }}" alt="logo-large" class="logo-sm">
            </span>
        </a>
    </div>
    <!--end logo-->
    <div class="menu-content h-100" data-simplebar>
        <ul class="metismenu left-sidenav-menu">
            <li class="menu-label mt-0">Main</li>
            <li>
                <a href="{{ route('index') }}"> <i data-feather="home" class="align-self-center menu-icon"></i><span>Dashboard</span></a>
            </li>
            <li>
                <a href="{{ route('user.index') }}"><i data-feather="users" class="align-self-center menu-icon"></i><span>Users</span></a>
            </li>
            <li>
                <a href="{{ route('book.index') }}"><i data-feather="users" class="align-self-center menu-icon"></i><span>Books</span></a>
            </li>
            <li>
                <a href="{{ route('notification.index') }}"><i data-feather="bell" class="align-self-center menu-icon"></i><span>Notifications</span></a>
            </li>
        </ul>
    </div>
</div>
<!-- end left-sidenav-->