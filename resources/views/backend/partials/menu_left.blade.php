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
            <li class="header">DANH MỤC</li>
            <li class="{{(Route::currentRouteName()=='home.index')?"active":""}}">
                <a href="{{URL::route('home.index')}}">
                    <i class="fa fa-dashboard"></i> <span>Tổng hợp</span>
                </a>
            </li>
            <li class="treeview {{(Route::currentRouteName()=='phone.index')
                                   || (Route::currentRouteName()=='pay-card.index')
                                   ?"active open-menu":""}}">
                <a href="#">
                    <i class="fa fa-id-card-o"></i> <span>Mạng VINAPHONE</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{(Route::currentRouteName()=='phone.index')?"active":""}}"><a href="{{URL::route('phone.index')}}"><i class="fa fa-circle-o"></i>Danh Sách Số Điện Thoại</a></li>
                    <li class="{{(Route::currentRouteName()=='pay-card.index')?"active":""}}"><a href="{{URL::route('pay-card.index')}}"><i class="fa fa-circle-o"></i> Log Giao Dịch</a></li>
                </ul>
            </li>
            <li class="{{(Route::currentRouteName()=='api.index')?"active":""}}">
                <a href="{{URL::route('api.index')}}">
                    <i class="fa fa-send-o"></i> <span>Key Api</span>
                </a>
            </li>

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>