<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="index3.html" class="brand-link p-2">
    <img src="{{$logo}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
         style="opacity: .8">
    <span class="brand-text font-weight-light">{{$name}}</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{auth()->user()->avatar}}" class="rounded-circle">
      </div>
      <div class="info">
        <a href="#" class="d-block">{{auth()->user()->name}}</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          
          <a href="{{route('dashboard')}}" class="nav-link {{Request::is('/')?'active':''}}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>

        <li class="nav-header">PRODUCTS</li>
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        <li class="nav-item has-treeview {{(Request::is('product*') || Request::is('categories*'))?'menu-open':''}}">
          <a href="#" class="nav-link {{(Request::is('product*') || Request::is('categories*'))?'active':''}}">
            <i class="nav-icon fas fa-shopping-bag"></i>
            <p>
              Products
              <i class="right nav-icon fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{route('categories.index')}}" class="nav-link {{Request::is('categories*')?'active':''}}">
                <i class="nav-icon far fa-circle nav-icon"></i>
                <p>Categories</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('product.index')}}" class="nav-link {{Request::is('product*')?'active':''}}">
                <i class="nav-icon far fa-circle nav-icon"></i>
                <p>Products</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-header">ORDERS</li>
        <li class="nav-item">
          <a href="{{route('order.index')}}" class="nav-link {{Request::is('order*')?'active':''}}">
            <i class="nav-icon fas fa-shopping-cart"></i>
            <p>
              Orders
              <span class="badge badge-info right">{{$pending->where('status','pending')->count()}}</span>
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{route('customer.index')}}" class="nav-link {{Request::is('customer*')?'active':''}}">
            <i class="nav-icon fas fa-users"></i>
            <p>
              Customers
            </p>
          </a>
        </li>

        <li class="nav-header">Users</li>

        <li class="nav-item">
          <a href="{{route('profile.index')}}" class="nav-link {{Request::is('profile*')?'active':''}}">
            <i class="nav-icon fas fa-user-circle"></i>
            <p>
              Profile
            </p>
          </a>
        </li>

        <li class="nav-header">SLIDERS</li>
        <li class="nav-item">
          <a href="{{route('slider.index')}}" class="nav-link {{Request::is('slider*')?'active':''}}">
            <i class="nav-icon nav-icon far fa-image"></i>
            <p>
              Sliders
            </p>
          </a>
        </li>
        
        <li class="nav-header">SETTING</li>
        <li class="nav-item mb-3">
          <a href="{{route('company.index')}}" class="nav-link {{Request::is('company*')?'active':''}}">
            <i class="fas fa-cog"></i>
            <p>
              Setting
            </p>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
