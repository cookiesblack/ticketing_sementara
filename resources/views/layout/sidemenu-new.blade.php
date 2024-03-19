<!--**********************************
            Sidebar start
        ***********************************-->
<div class="deznav">
    <div class="deznav-scroll">
        <ul class="metismenu" id="menu">
            <li><a class="has-arrow ai-icon" href="{{ route('dashboard') }}" aria-expanded="false">
                    <i class="flaticon-381-networking"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>
            <li>
                <a class="has-arrow ai-icon" href="javascript:void(0);" aria-expanded="false">
                    <i class="flaticon-381-id-card"></i>
                    <span class="nav-text">Ticket<span class="badge badge-xs badge-danger ms-2">New</span></span>
                </a>
                <ul aria-expanded="false">
                    <li><a {{ session('type') != 'user' ? 'hidden' : '' }} href="{{ route('create_ticket') }}">Create
                            Ticket</a></li>
                    <li><a href="{{ route('all_ticket') }}">All Ticket</a></li>
                </ul>
            </li>
            <li><a {{ session('type') != 'admin' ? 'hidden' : '' }} class="has-arrow ai-icon"
                    href="{{ route('kalender') }}" aria-expanded="false">
                    <i class="flaticon-381-networking"></i>
                    <span class="nav-text">Kalender</span>
                </a>
            </li>
            <li><a {{ session('type') != 'admin' ? 'hidden' : '' }} class="has-arrow ai-icon" href="{{ route('user') }}"
                    aria-expanded="false">
                    <i class="flaticon-381-networking"></i>
                    <span class="nav-text">User Management</span>
                </a>
            </li>
            <li><a class="ai-icon" href="{{ route('logout') }}" aria-expanded="false">
                    <i class="flaticon-381-networking"></i>
                    <span class="nav-text">Logout</span>
                </a>
            </li>

        </ul>
        <!-- <div class="copyright">
     <p>Tixia Ticketing Admin Dashboard <br>© <span class="current-year">2024</span> All Rights Reserved
     </p>

     <p class="op5">Made with <span class="heart"></span> by DexignZone</p>
    </div> -->
    </div>
</div>
<!--**********************************
            Sidebar end
        ***********************************-->
