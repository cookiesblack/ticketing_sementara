 @php
     $activeMenu = request()->segment(count(request()->segments()));
 @endphp

 <!-- Row #5 -->
 <div class="col-md-12">
    <div class="block">
        {{-- <div class="block-content block-content-full">
            <div class="pull-all">
                <img src="{{ asset('assets') }}/admin.jpg" style="width: 100%" alt="">
            </div>
        </div> --}}
        {{-- <div class="block-content">
            <div class="row items-push">
                <div class="col-6 col-sm-4 text-center text-sm-left">
                    <div class="font-size-sm font-w600 text-uppercase text-muted">Selamat datang di Schema Ticketing, </div>
                </div>
            </div>
        </div> --}}
    </div>
</div>

<div {{ session('type') != 'user' ? 'hidden' : '' }} class="col-6 col-md-4 col-xl-2">
    <a class="block block-link-shadow text-center" href="{{ route('create_ticket') }}">
        <div class="block-content {{ $activeMenu == 'create_ticket' ? 'btn-danger' : '' }}"">
            <p class="mt-5">
                <i class="si si-envelope fa-3x"></i>
            </p>
            <p class="font-w600">Create Ticket</p>
        </div>
    </a>
</div>
<div class="col-6 col-md-4 col-xl-2">
    <a class="block block-link-shadow text-center" href="{{ route('all_ticket') }}">
        <div class="block-content {{ $activeMenu == 'all_ticket' ? 'btn-danger' : '' }}"">
            <p class="mt-5">
                <i class="si si-envelope-letter fa-3x"></i>
            </p>
            <p class="font-w600">All Ticket</p>
        </div>
    </a>
</div>
<div {{ session('type') != 'admin' ? 'hidden' : '' }} class="col-6 col-md-4 col-xl-2">
    <a class="block block-link-shadow text-center" href="{{ route('user') }}">
        <div class="block-content {{ $activeMenu == 'user' ? 'btn-danger' : '' }}"">
            <p class="mt-5">
                <i class="si si-users fa-3x"></i>
            </p>
            <p class="font-w600">User Management</p>
        </div>
    </a>
</div>

 <!-- END Row #5 -->

