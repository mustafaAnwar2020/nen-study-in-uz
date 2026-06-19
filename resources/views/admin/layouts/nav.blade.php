<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>

        {{--
        <li class="nav-item d-none d-sm-inline-block">
            <a href="#" class="nav-link">طلبات تسعير الشركات</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="#" class="nav-link">طلبات تسعير مزودي الخدمات</a>
        </li>--}}
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

      {{--  <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                <span class="badge badge-warning navbar-badge">{{currentUser()->unreadNotifications->count()}}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header">{{currentUser()->unreadNotifications->count()}} إشعار</span>
                <div class="dropdown-divider"></div>

                @foreach(currentUser()->unreadNotifications as $notification)
                    <p class="mt-2 mb-2 p-2">
                        <i class="fas fa-envelope mr-2"></i> {{$notification->data['message']}}
                        <span class="float-right text-muted text-sm"> {{$notification->created_at->diffForHumans()}} </span>
                    </p>
                    <div class="dropdown-divider"></div>
                @endforeach
                <a href="{{route('admin.notifications.mark-all-read')}}" class="dropdown-item dropdown-footer">تحديد الكل كمقروء</a>
            </div>
        </li>--}}

        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                {{currentUser()->name}}
                <i class="fa fa-user"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <a href="{{route('admin.logout')}}" class="dropdown-item dropdown-footer">Logout</a>
                <div class="dropdown-divider"></div>

            </div>
        </li>
    </ul>
</nav>
<!-- /.navbar -->
