            <!--
                Helper classes

                Adding .sidebar-mini-hide to an element will make it invisible (opacity: 0) when the sidebar is in mini mode
                Adding .sidebar-mini-show to an element will make it visible (opacity: 1) when the sidebar is in mini mode
                    If you would like to disable the transition, just add the .sidebar-mini-notrans along with one of the previous 2 classes

                Adding .sidebar-mini-hidden to an element will hide it when the sidebar is in mini mode
                Adding .sidebar-mini-visible to an element will show it only when the sidebar is in mini mode
                    - use .sidebar-mini-visible-b if you would like to be a block when visible (display: block)
            -->
            <nav id="sidebar">
                <!-- Sidebar Content -->
                <div class="sidebar-content">
                    <!-- Side Header -->
                    <div class="content-header content-header-fullrow px-15">
                        <!-- Mini Mode -->
                        <div class="content-header-section sidebar-mini-visible-b">
                            <!-- Logo -->
                            <span class="content-header-item font-w700 font-size-xl float-left animated fadeIn">
                                <span class="text-dual-primary-dark">c</span><span class="text-primary">b</span>
                            </span>
                            <!-- END Logo -->
                        </div>
                        <!-- END Mini Mode -->

                        <!-- Normal Mode -->
                        <div class="content-header-section text-center align-parent sidebar-mini-hidden">
                            <!-- Close Sidebar, Visible only on mobile screens -->
                            <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                            <button type="button" class="btn btn-circle btn-dual-secondary d-lg-none align-v-r"
                                data-toggle="layout" data-action="sidebar_close">
                                <i class="fa fa-times text-danger"></i>
                            </button>
                            <!-- END Close Sidebar -->

                            <!-- Logo -->
                            <div class="content-header-item">
                                <a class="link-effect font-w700" href="index.html">
                                    <span class="font-size-xl text-dual-primary-dark">Schema</span><span
                                        class="font-size-xl text-primary">Ticketing</span>
                                </a>
                            </div>
                            {{-- <div class="content-header-item">
                                <a class="link-effect font-w700" href="#">
                                    <img src="{{asset("logo.png")}}" alt="" style="height: 100%">
                                </a>
                            </div> --}}
                            <!-- END Logo -->
                        </div>
                        <!-- END Normal Mode -->
                    </div>
                    <!-- END Side Header -->

                    <!-- Side Navigation -->
                    <div class="content-side content-side-full">
                        <ul class="nav-main">
                            <li>
                                <a class="" href="{{ route('dashboard') }}"><i class="si si-cup"></i><span
                                        class="sidebar-mini-hide">Dashboard</span></a>
                            </li>
                            <li class="open">
                                <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i
                                        class="si si-envelope"></i><span class="sidebar-mini-hide">Ticket</span></a>
                                <ul>
                                    <li>
                                        <a {{ session('type') != 'user' ? 'hidden' : '' }}
                                            href="{{ route('create_ticket') }}">Create Ticket</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('all_ticket') }}">All Ticket</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a {{ session('type') != 'admin' ? 'hidden' : '' }} class=""
                                    href="{{ route('user') }}"><i class="si si-users"></i><span
                                        class="sidebar-mini-hide">User Management</span></a>
                            </li>
                            <li>
                                <a class="" href="{{ route('logout') }}"><i class="si si-logout"></i><span
                                        class="sidebar-mini-hide">Sign Out</span></a>
                            </li>
                        </ul>
                    </div>
                    <!-- END Side Navigation -->
                </div>
                <!-- Sidebar Content -->
            </nav>
