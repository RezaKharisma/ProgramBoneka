<nav class="topnav navbar navbar-light">
    <button type="button" class="p-0 mt-2 mr-3 navbar-toggler text-muted collapseSidebar">
        <i class="fe fe-menu navbar-toggler-icon"></i>
    </button>

    {{-- <form class="mr-auto form-inline searchform text-muted">
        <input class="pl-4 bg-transparent border-0 form-control mr-sm-2 text-muted" type="search" placeholder="Type something..." aria-label="Search">
      </form> --}}

    <ul class="nav">
        <li class="nav-item nav-notif">
            <a class="my-2 nav-link text-muted" href="./#" data-toggle="modal" data-target=".modal-notif">
                <span class="fe fe-bell fe-16"></span>
                <span class="dot dot-md bg-success"></span>
            </a>
        </li>
        <li class="nav-item dropdown">
            <a class="pr-0 nav-link dropdown-toggle text-muted" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mt-2 avatar avatar-sm">
                    @if (Auth()->user()->foto)
                        <img src="{{ asset('profile_photo/'.Auth()->user()->foto) }}" alt="..." class="avatar-img rounded-circle" style="height: 30px;width: 30px;object-fit: cover;" />
                    @else
                        <img src="{{ asset('profile_photo/default.png') }}" alt="..." class="avatar-img rounded-circle" />
                    @endif
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item" href="{{ route('profile.index') }}">Settings</a>
                <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
            </div>
        </li>
    </ul>
</nav>
