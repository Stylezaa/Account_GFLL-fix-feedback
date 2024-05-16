<!-- User -->
<span>
    <b>{{Auth::user()->name}}</b>
    <span class="text-info">{{trans('user.isOnline',[],session()->get('locale'))}}</span>
</span>
<li class="nav-item navbar-dropdown dropdown-user dropdown">
    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
        <div class="avatar avatar-online">
            <img src="{{asset('assets/img/avatars/1.png')}}" alt="username" class="w-px-40 h-auto rounded-circle">
        </div>
    </a>
    <ul class="dropdown-menu dropdown-menu-end p-1">
        <li>
            <a class="dropdown-item" href="pages-account-settings-account.html">
                <div class="d-flex">
                    <div class="flex-shrink-0 me-3">
                        <div class="avatar avatar-online">
                            <img src="{{asset('assets/img/avatars/1.png')}}" alt
                                 class="w-px-40 h-auto rounded-circle">
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <span class="fw-semibold d-block">John Doe</span>
                        <small class="text-muted">Admin</small>
                    </div>
                </div>
            </a>
        </li>
        <li>
            <div class="dropdown-divider"></div>
        </li>
        <li>
            <a class="dropdown-item" href="pages-profile-user.html">
                <i class="bx bx-user me-2"></i>
                <span class="align-middle">My Profile</span>
            </a>
        </li>
        <li>
            <a class="dropdown-item" href="pages-account-settings-account.html">
                <i class="bx bx-cog me-2"></i>
                <span class="align-middle">Settings</span>
            </a>
        </li>
        <li>
            <div class="dropdown-divider"></div>
        </li>
        <li>
            <a class="dropdown-item" href="pages-help-center-landing.html">
                <i class="bx bx-support me-2"></i>
                <span class="align-middle">Help</span>
            </a>
        </li>
        <li>
            <a class="dropdown-item" href="pages-faq.html">
                <i class="bx bx-help-circle me-2"></i>
                <span class="align-middle">FAQ</span>
            </a>
        </li>
        <li>
            <a class="dropdown-item" href="pages-pricing.html">
                <i class="bx bx-dollar me-2"></i>
                <span class="align-middle">Pricing</span>
            </a>
        </li>
        <li>
            <div class="dropdown-divider"></div>
        </li>
        <li>
            <form method="post" action="{{route('logout')}}">
                @csrf
                <button type="submit" class="dropdown-item">
                    <i class="bx bx-power-off me-2"></i>
                    <span class="align-middle">Log Out</span>
                </button>
            </form>
        </li>
    </ul>
</li>
<!--/ User -->
