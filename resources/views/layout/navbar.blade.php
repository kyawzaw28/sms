
<a class="navbar-brand d-none d-md-flex" href="index.html">

                        <!-- Logo icon -->
                        <b class="logo-icon">
                            <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                            <!-- Dark Logo icon -->
                            <!-- <img src="{{asset('admin/assets/images/[removal.ai]_535d621a-bef4-4b84-a129-576bf5f0ac1f-o-technique200.png')}}" alt="homepage" class="light-logo" /> -->

                        </b>
                        <!--End Logo icon -->
                        <!-- Logo text -->
                        <span class="logo-text ">
                            <!-- dark Logo text -->
                            {{-- <img src="{{asset('admin/assets/images/logo-text.png')}}" alt="homepage" class="light-logo" /> --}}
                            <h5 class=" mb-0">School Management</h5>

                        </span>
                        <!-- Logo icon -->
                        <!-- <b class="logo-icon"> -->
                        <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                        <!-- Dark Logo icon -->
                        <!-- <img src="../../assets/images/logo-text.png" alt="homepage" class="light-logo" /> -->

                        <!-- </b> -->
                        <!--End Logo icon -->
                    </a>

                    <!-- ============================================================== -->
                    <!-- Toggle which is visible on mobile only -->
                    <!-- ============================================================== -->

                            <a class="nav-toggler  d-block d-md-none" href="javascript:void(0)"><i
                                class="ti-menu ti-close font-22 pt-2"></i></a>

                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->

<div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->

                    <ul class="navbar-nav float-start me-auto">
                        <li class="d-none d-md-block">
                            <a
                                class="nav-link sidebartoggler " href="javascript:void(0)"
                                data-sidebartype="mini-sidebar"><i class="mdi mdi-menu h2 mb-0"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- ============================================================== -->
                    <!-- Right side toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav float-end">
                        <!-- ============================================================== -->
                        <!-- Comment -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown setting">
                            <a class="nav-link dropdown-toggle d-flex justify-content-center align-items-center" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-settings h2 mb-0"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="{{ route('course.index') }}">Courses</a></li>
                                <li><a class="dropdown-item" href=" {{ route('lecturer.index')  }} ">Lecturers</a></li>

                            </ul>
                        </li>
                        <!-- ============================================================== -->
                        <!-- End Comment -->
                        <!-- ============================================================== -->
                        <!-- ============================================================== -->
                        <!-- Messages -->
                        <!-- ============================================================== -->

                            <li class="nav-item dropdown">
                                <a class="acc-container d-flex justify-content-center align-items-center  nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic" href="#"
                                    id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    {{-- <img src="{{ asset('admin/assets/images/users/1.jpg') }}" alt="user" class="rounded-circle"
                                        width="31"> --}}
                                        <h3 class="user-account-name" >
                                        {{strtoupper(substr(auth()->user()->name,0,1))}}
                                        </h3>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="{{ route('user.show',auth()->user()->id) }}">Profile edit</a></li>
                                    <li><a class="dropdown-item" href="{{route('user.logout')}}">Logout</a></li>

                                </ul>
                            </li>

                        <!-- ============================================================== -->
                        <!-- End Messages -->
                        <!-- ============================================================== -->

                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->

                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
