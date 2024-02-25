<ul class="nav nav-tabs " id="myTab" role="tablist">

    <li class="nav-item">
        <a class="nav-link {{ request()->is('profile') ? 'active' : '' }}" href="{{ route('profile.index') }}" role="tab" aria-controls="home" aria-selected="true">Profile</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->is('security') ? 'active' : '' }}" href="{{ route('security.index') }}" role="tab" aria-controls="security" aria-selected="false">Security</a>
    </li>
    @if (Auth()->user()->role == "Admin")
        <li class="nav-item">
            <a class="nav-link {{ request()->is('page') ? 'active' : '' }}" href="{{ route('page.index') }}" role="tab" aria-controls="page" aria-selected="false">Page</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('tentang') ? 'active' : '' }}" href="{{ route('tentang.index') }}" role="tab" aria-controls="tentang" aria-selected="false">Tentang</a>
        </li>
    @endif
</ul>

<x-alert type="success" class="mt-4" style="margin-bottom: -20px"/>
<x-alert type="danger" class="mt-4" style="margin-bottom: -20px"/>
