<header class="main-header">
    <!-- Logo -->
    <a href="{{route('admin.dashboard')}}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">{{Auth::user()->name}}</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

                <li class="dropdown user user-menu">
                    <a href="{{route('admin.logout')}}" class="btn" >
                        <span class="hidden-xs">Logout</span>
                    </a>

                </li>
                <!-- Control Sidebar Toggle Button -->
                <!-- Notifications: style can be found in dropdown.less -->
                <li class="dropdown notifications-menu ">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                        <i class="fa fa-bell-o"></i>
                        <span class="label label-warning total-notification"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">You have <span class="notification-count"></span> notifications</li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                @foreach($notifications as $notification)
                                    @if($notification->is_active == '1')
                                        <li>
                                            <a id="notification-status" data-id="{!! $notification->id !!}" href="javascript:void(0)" data-type="{!!  $notification->link!!}">
                                                {!! $notification->icon !!}  {{$notification->message}}
                                            </a>
                                        </li>
                                    @else
                                        <li >
                                            <a id="notification-status" data-id="{!! $notification->id !!}" class="active" href="javascript:void(0)" data-type="{!!  $notification->link!!}">
                                                {!! $notification->icon !!}  {{$notification->message}}
                                            </a>
                                        </li>
                                        @endif
                                @endforeach

                            </ul>
                        </li>
                        <li class="footer"><a href="#">View all</a></li>
                    </ul>
                </li>


            </ul>
        </div>
    </nav>
</header>
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{asset('backend/dist/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{Auth::user()->name}}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- search form -->
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            <li class="active"><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            @can('isAdmin')
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-users"></i> <span>User Management</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{route('admin.broker.index')}}"><i class="fa fa-male" aria-hidden="true"></i>Broker</a></li>
                    <li><a href="{{route('admin.users.index')}}"><i class="fa fa-user" aria-hidden="true"></i> Users</a></li>
                    <li><a href="{{route('admin.technician.index')}}"><i class="fa fa-wrench" aria-hidden="true"></i>Technician</a></li>
                    <li><a href="{{route('admin.vendor.index')}}"><i class="fa fa-handshake-o" aria-hidden="true"></i>Vendor</a></li>

                </ul>
            </li>
            @endcan
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-globe"></i> <span>Location</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{route('admin.location.index')}}"><i class="fa fa-map-marker" aria-hidden="true"></i> City</a></li>
                    <li><a href="{{route('admin.place.index')}}"><i class="fa fa-location-arrow" aria-hidden="true"></i> Address</a></li>


                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-home"></i> <span>Property Management</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{route('admin.category.index')}}"><i class="fa fa-list" aria-hidden="true"></i> Category</a></li>
                    <li><a href="{{route('admin.subcategory.index')}}"><i class="fa fa-tasks" aria-hidden="true"></i> Subcategory</a></li>
                    <li><a href="{{route('admin.aminities.index')}}"><i class="fa fa-caret-square-o-left" aria-hidden="true"></i>Amitities</a></li>
                    <li><a href="{{route('admin.property.index')}}"><i class="fa fa-building" aria-hidden="true"></i> Property</a></li>
                    <li><a href="{{route('admin.booking.index')}}"><i class="fa fa-book" aria-hidden="true"></i>Property Booking</a></li>

                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-cog"></i> <span>Service Management</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{route('admin.service_category.index')}}"><i class="fa fa-list" aria-hidden="true"></i> Category</a></li>
                    <li><a href="{{route('admin.service.index')}}"><i class="fa fa-cogs" aria-hidden="true"></i> Service</a></li>
                    <li><a href="{{route('admin.servicerequest.index')}}"><i class="fa fa-book" aria-hidden="true"></i>Service Order List</a></li>


                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-cart-plus"></i> <span>Product Management</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{route('admin.product_category.index')}}"><i class="fa fa-list" aria-hidden="true"></i> Category</a></li>
                    <li><a href="{{route('admin.product.index')}}"><i class="fa fa-product-hunt" aria-hidden="true"></i>Product List</a></li>
                    <li><a href="{{route('admin.product.order')}}"><i class="fa fa-book" aria-hidden="true"></i>Product Order List</a></li>

                </ul>
            </li>
    
            @can('isAdmin')
            <!-- Advertisement -->
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-bullhorn"></i> <span>Ads</span>
                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{route('admin.advertisement.create')}}"><i class="fa fa-plus" aria-hidden="true"></i>Add</a></li>
                    <li><a href="{{route('admin.advertisement.index')}}"><i class="fa fa-list" aria-hidden="true"></i>List</a></li>

                </ul>
            </li>
            <!-- Advertisement  Ends-->

            <!-- Setting -->
            <li>
                <a href="{{route('admin.setting.index')}}">
                    <i class="fa fa-cog"></i> <span>Setting</span>
                </a>
            </li>
            <!-- Setting Ends -->
            @endcan

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>