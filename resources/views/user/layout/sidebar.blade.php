<header class="main-header">
    <!-- Logo -->
{{--<a href="{{route('home')}}" class="logo">--}}
<!-- mini logo for sidebar mini 50x50 pixels -->
    <!-- logo for regular state and mobile devices -->
    <a href="javascript:void(0)" class="logo">
        <span class="logo-lg"> {{Auth::user()->name}}</span>

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
                    <a href="{{route('logout')}}" class="btn" >
                        <span class="hidden-xs">Logout</span>
                    </a>

                </li>
                <!-- Control Sidebar Toggle Button -->
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
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
                <p>Alexander Pierce</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- search form -->
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            <li class="active"><a href="{{route('auth.home')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li >
                <a href="{{route('profile.index')}}">Profile</a>
            </li>
            @if(auth()->user()->is_active != '1')
                <li class="treeview">
                    <a href="java:void(0)">Not Approved</a>
                </li>
            @endif
            @if(auth()->user()->is_active == '1')
            @if(auth()->user()->can('view-place'))
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-folder"></i> <span>Place </span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    @if(auth()->user()->can('add-place'))
                    <li><a href="{{route('auth.place.create')}}"><i class="fa fa-plus" aria-hidden="true"></i> Add</a></li>
                   @endif
                        @if(auth()->user()->can('view-place'))

                        <li><a href="{{route('auth.place.index')}}"><i class="fa fa-list" aria-hidden="true"></i> List</a></li>
                        @endif
                </ul>
            </li>
            @endif
                @if(auth()->user()->can('view-product-category'))
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-folder"></i> <span>Product Category </span>
                            <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            @if(auth()->user()->can('add-product-category'))
                                <li><a href="{{route('auth.product_category.create')}}"><i class="fa fa-plus" aria-hidden="true"></i> Add</a></li>
                            @endif
                            @if(auth()->user()->can('view-product-category'))

                                <li><a href="{{route('auth.product_category.index')}}"><i class="fa fa-list" aria-hidden="true"></i> List</a></li>
                            @endif
                                @if(auth()->user()->can('owner-product-category'))

                                    <li><a href="{{route('auth.product_category.owner')}}"><i class="fa fa-user" aria-hidden="true"></i>Owner</a></li>
                                @endif
                        </ul>
                    </li>
                @endif
                @if(auth()->user()->can('view-product'))
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-folder"></i> <span>Product  </span>
                            <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            @if(auth()->user()->can('add-product'))
                                <li><a href="{{route('auth.product.create')}}"><i class="fa fa-plus" aria-hidden="true"></i> Add</a></li>
                            @endif
                            @if(auth()->user()->can('view-product'))

                                <li><a href="{{route('auth.product.index')}}"><i class="fa fa-list" aria-hidden="true"></i> List</a></li>
                            @endif
                            @if(auth()->user()->can('owner-product'))

                                <li><a href="{{route('auth.product_owner.index')}}"><i class="fa fa-user" aria-hidden="true"></i>Owner</a></li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if(auth()->user()->can('view-property'))
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-folder"></i> <span>Property </span>
                            <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            @if(auth()->user()->can('add-property'))
                                <li><a href="{{route('auth.property.create')}}"><i class="fa fa-plus" aria-hidden="true"></i> Add</a></li>
                            @endif
                            @if(auth()->user()->can('view-property'))

                                <li><a href="{{route('auth.property.index')}}"><i class="fa fa-list" aria-hidden="true"></i> List</a></li>
                            @endif

                        </ul>
                    </li>
                @endif
                @if(auth()->user()->can('view-property-category'))
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-folder"></i> <span>Property Category </span>
                            <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            @if(auth()->user()->can('add-property-category'))
                                <li><a href="{{route('auth.property_category.create')}}"><i class="fa fa-plus" aria-hidden="true"></i> Add</a></li>
                            @endif
                            @if(auth()->user()->can('view-property-category'))

                                <li><a href="{{route('auth.property_category.index')}}"><i class="fa fa-list" aria-hidden="true"></i> List</a></li>
                            @endif

                        </ul>
                    </li>
                @endif
                @if(auth()->user()->can('view-property-subcategory'))
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-folder"></i> <span>Property SubCategory </span>
                            <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            @if(auth()->user()->can('add-property-subcategory'))
                                <li><a href="{{route('auth.property_subcategory.create')}}"><i class="fa fa-plus" aria-hidden="true"></i> Add</a></li>
                            @endif
                            @if(auth()->user()->can('view-property-subcategory'))

                                <li><a href="{{route('auth.property_subcategory.index')}}"><i class="fa fa-list" aria-hidden="true"></i> List</a></li>
                            @endif

                        </ul>
                    </li>
                @endif
                @if(auth()->user()->can('view-service'))
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-folder"></i> <span>Service </span>
                            <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            @if(auth()->user()->can('add-service'))
                                <li><a href="{{route('auth.service.create')}}"><i class="fa fa-plus" aria-hidden="true"></i> Add</a></li>
                            @endif
                            @if(auth()->user()->can('view-service'))

                                <li><a href="{{route('auth.service.index')}}"><i class="fa fa-list" aria-hidden="true"></i> List</a></li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if(auth()->user()->can('view-setting'))
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-folder"></i> <span>Setting </span>
                            <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            @if(auth()->user()->can('add-setting'))
                                <li><a href="{{route('setting.create')}}"><i class="fa fa-plus" aria-hidden="true"></i> Add</a></li>
                            @endif
                            @if(auth()->user()->can('view-setting'))

                                <li><a href="{{route('setting.index')}}"><i class="fa fa-list" aria-hidden="true"></i> List</a></li>
                            @endif
                        </ul>
                    </li>
                @endif
            @endif

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>