<!-- Language -->
<li class="nav-item dropdown-language dropdown me-2 me-xl-0">
    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
       data-bs-toggle="dropdown">
        <i class='fi fi-{{session()->get('locale') === 'en' ? 'us' : 'la'}} fis rounded-circle fs-3 me-1'></i>
    </a>
    <ul class="dropdown-menu dropdown-menu-end">
        <li>
            <a class="dropdown-item" href="{{ route('lang.switch', 'en')}}" data-language="en">
                <i class="fi fi-us fis rounded-circle fs-4 me-1"></i>
                <span class="align-middle">English</span>
            </a>
        </li>
        <li>
            <a class="dropdown-item" href="{{ route('lang.switch', 'la')}}" data-language="fr">
                <i class="fi fi-la fis rounded-circle fs-4 me-1"></i>
                <span class="align-middle">ພາສາລາວ</span>
            </a>
        </li>
    </ul>
</li>
<!--/ Language -->

