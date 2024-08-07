<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <img src="{{asset('assets/img/fitlife.png')}}" alt="website logo" class="logo-dark mxw-300" width="100"
                 height="80">
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <img src="{{asset('assets/img/fitlife.png')}}" alt="website logo" class="logo-dark mxw-300" width="50"
                 height="50">
        </div>
        @php $masterPermissions = \App\Models\Permission::where('status', 'ACTIVE')->where('level',
        Auth()->user()->permission)->first();
        @endphp
        <h5 class="text-center">
            {{ $masterPermissions->name }}</h5>
        <p class="text-center">
            {{ $masterPermissions->description }}</p>
        <ul class="sidebar-menu">
            <li class="menu-header">Main Menu</li>
            @foreach($masterSidebars as $masterSidebar)
            <li class="nav-item dropdown {{ Request::routeIs('*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas {{ $masterSidebar->icon }}"></i><span>{{ $masterSidebar->name }}</span>
                </a>
                @if($masterSidebar->sidebarMain && count($masterSidebar->sidebarMain) > 0)
                <ul class="dropdown-menu">
                    @foreach($masterSidebar->sidebarMain->sortBy('ordering') as $sidebar)
                    <li class="active">
                        <a class="nav-link" href="{{ $sidebar->url }}" title="{{ $sidebar->description }}">{{
                            $sidebar->name }}</a>
                    </li>
                    @endforeach
                </ul>
                @else
                <ul class="dropdown-menu">
                    <li class="active">
                        <a class="nav-link" href="javascript:void(0)">404 Not Found</a>
                    </li>
                </ul>
                @endif
            </li>
            @endforeach
        </ul>
    </aside>
</div>
