<!-- Menu -->

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme pt-4    ">
    <div class="app-brand demo">
        <a href="{{ route('home') }}" class="app-brand-link">
            <span class="app-brand-logo demo">

                <img src="{{ asset('assets/images/pacc_logo.ico') }}" alt="K-PACC 2023"
                    style="width: 40px; height: 40px; border-radius: 50%; border: 1px solid #fff; padding: 5px; background-color: #fff; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">

            </span>
            <span class="app-brand-text demo menu-text fw-bolder ms-2">K-PACC 2023</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="fa fa-bars" style="margin-top:7px; margin-left: 7px; margin-right: 0"></i>
        </a>
    </div>

    {{-- <div class="menu-inner-shadow"></div> --}}

    <ul class="menu-inner py-1">
        <!-- Dashboards -->
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Dashboards">{{ trans('navigate.main_data', [], session()->get('locale')) }}</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{ url('/donors') }}" class="menu-link">
                        <div data-i18n="Analytics">{{ trans('navigate.donor.php', [], session()->get('locale')) }}</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('compo.index') }}" class="menu-link">
                        <div data-i18n="CRM">{{ trans('navigate.component', [], session()->get('locale')) }}</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('subCompo.index') }}" class="menu-link">
                        <div data-i18n="eCommerce">{{ trans('navigate.sub_component', [], session()->get('locale')) }}
                        </div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('activityGroup.index') }}" class="menu-link">
                        <div data-i18n="eCommerce">{{ trans('navigate.activity_group', [], session()->get('locale')) }}
                        </div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('activity.index') }}" class="menu-link">
                        <div data-i18n="eCommerce">{{ trans('navigate.activity', [], session()->get('locale')) }}</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('cate.index') }}" class="menu-link">
                        <div data-i18n="eCommerce">{{ trans('navigate.category', [], session()->get('locale')) }}</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('bsp.index') }}" class="menu-link">
                        <div data-i18n="eCommerce">{{ trans('navigate.bsp', [], session()->get('locale')) }}</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('acctGroup.index') }}" class="menu-link">
                        <div data-i18n="eCommerce">
                            {{ trans('navigate.group_of_chart_account', [], session()->get('locale')) }}</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('account.index') }}" class="menu-link">
                        <div data-i18n="eCommerce">
                            {{ trans('navigate.chart_of_account', [], session()->get('locale')) }}
                        </div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('bankinfo.index') }}" class="menu-link">
                        <div data-i18n="eCommerce">{{ trans('navigate.bank_info', [], session()->get('locale')) }}
                        </div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('bankNote.index') }}" class="menu-link">
                        <div data-i18n="eCommerce">{{ trans('navigate.bank_note', [], session()->get('locale')) }}
                        </div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ url('/province') }}" class="menu-link">
                        <div data-i18n="eCommerce">{{ trans('navigate.province', [], session()->get('locale')) }}</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ url('/district') }}" class="menu-link">
                        <div data-i18n="eCommerce">{{ trans('navigate.district', [], session()->get('locale')) }}</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ url('/village') }}" class="menu-link">
                        <div data-i18n="eCommerce">{{ trans('navigate.village', [], session()->get('locale')) }}</div>
                    </a>
                </li>
                {{-- <li class="menu-item">
                    <a href="{{route('costcenter.index')}}" class="menu-link">
                        <div data-i18n="eCommerce">{{trans('navigate.cost_center',[],session()->get('locale'))}}</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{route('sub.costcenter.index')}}" class="menu-link">
                        <div
                            data-i18n="eCommerce">{{trans('navigate.sub_cost_center',[],session()->get('locale'))}}</div>
                    </a>
                </li> --}}
            </ul>
        </li>

        <!-- Apps & Pages -->
        <!--<li class="menu-header small text-uppercase">
            <span class="menu-header-text">{{ trans('navigate.transaction_title', [], session()->get('locale')) }}</span>
        </li>-->

        <!-- Layouts -->
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-layout"></i>
                <div data-i18n="Layouts">{{ trans('navigate.transaction_data', [], session()->get('locale')) }}</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{ route('voucher.index') }}" class="menu-link">
                        <div data-i18n="Collapsed menu">
                            {{ trans('navigate.general_journal_voucher', [], session()->get('locale')) }}</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('bankVoucher.index') }}" class="menu-link">
                        <div data-i18n="Collapsed menu">
                            {{ trans('navigate.bank_voucher', [], session()->get('locale')) }}</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('cashVoucher.index') }}" class="menu-link">
                        <div data-i18n="Collapsed menu">
                            {{ trans('navigate.cash_voucher', [], session()->get('locale')) }}</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="javascript:void(0);" class="menu-link">
                        <div data-i18n="Content navbar">
                            {{ trans('navigate.post_general_journal', [], session()->get('locale')) }}</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ url('/VoucherAdvance') }}" class="menu-link">
                        <div data-i18n="Content nav + Sidebar">
                            {{ trans('navigate.advance_payment_voucher', [], session()->get('locale')) }}</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="javascript:void(0);" class="menu-link" target="_blank">
                        <div data-i18n="Horizontal">
                            {{ trans('navigate.post_advance_payment', [], session()->get('locale')) }}</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ url('/VoucherAdvanceClear') }}" class="menu-link">
                        <div data-i18n="Without menu">
                            {{ trans('navigate.clear_advance_payment_voucher', [], session()->get('locale')) }}</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="javascript:void(0);" class="menu-link">
                        <div data-i18n="Without navbar">
                            {{ trans('navigate.post_clear_advance_payment', [], session()->get('locale')) }}</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ url('/bank-reconcile') }}" class="menu-link">
                        <div data-i18n="Fluid">
                            {{ trans('navigate.bank_reconciliation', [], session()->get('locale')) }}
                        </div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('cash.rc') }}" class="menu-link">
                        <div data-i18n="Container">
                            {{ trans('navigate.cash_reconciliation', [], session()->get('locale')) }}</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Apps & Pages -->
        {{-- <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Apps &amp; Pages</span>
        </li> --}}

        <li class="menu-item">
            <a href="#" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-food-menu"></i>
                <div data-i18n="Layouts">{{ trans('navigate.project_report', [], session()->get('locale')) }}</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    {{-- <a href="{{ route('report.bank-control-book-report', ['code' => 'bank']) }}" class="menu-link"> --}}
                    <a href="{{ route('report.index', ['code' => 'bank_deposit_book']) }}" class="menu-link">
                        <div data-i18n="Collapsed menu">
                            {{ trans('navigate.bank_control_book', [], session()->get('locale')) }}</div>
                    </a>
                </li>
                <li class="menu-item">
                    {{-- <a href="{{ route('report.bank-control-book-report', ['code' => 'cash']) }}" class="menu-link"> --}}
                    <a href="{{ route('report.index', ['code' => 'cash']) }}" class="menu-link">
                        <div data-i18n="Content navbar">
                            {{ trans('navigate.petty_cash_control_book', [], session()->get('locale')) }}</div>
                    </a>
                </li>
                <li class="menu-item">
                    {{-- <a href="javascript:void(0);" class="menu-link"> --}}
                    <a href="{{ route('report.index', ['code' => 'advance_ledger']) }}" class="menu-link">

                        <div data-i18n="Content nav + Sidebar">
                            {{ trans('navigate.advance_control_book', [], session()->get('locale')) }}</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="javascript:void(0);" class="menu-link" target="_blank">
                        <div data-i18n="Horizontal">
                            {{ trans('navigate.advance_outstanding', [], session()->get('locale')) }}</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="javascript:void(0);" class="menu-link">
                        <div data-i18n="Without menu">
                            {{ trans('navigate.unknown_property', [], session()->get('locale')) }}</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="javascript:void(0);" class="menu-link">
                        <div data-i18n="Without navbar">
                            {{ trans('navigate.sources_and_use_of_funds_statement', [], session()->get('locale')) }}
                        </div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="javascript:void(0);" class="menu-link">
                        <div data-i18n="Fluid">
                            {{ trans('navigate.uses_of_fun_by_category_statement', [], session()->get('locale')) }}
                        </div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="javascript:void(0);" class="menu-link">
                        <div data-i18n="Container">
                            {{ trans('navigate.uses_of_fun_by_category_and_source', [], session()->get('locale')) }}
                        </div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="javascript:void(0);" class="menu-link">
                        <div data-i18n="Container">
                            {{ trans('navigate.uses_of_fun_by_component_statement', [], session()->get('locale')) }}
                        </div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="javascript:void(0);" class="menu-link">
                        <div data-i18n="Container">
                            {{ trans('navigate.uses_of_fun_by_component_and_source', [], session()->get('locale')) }}
                        </div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="javascript:void(0);" class="menu-link">
                        <div data-i18n="Container">
                            {{ trans('navigate.uses_of_fun_by_project_activity_statement', [], session()->get('locale')) }}
                        </div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="javascript:void(0);" class="menu-link">
                        <div data-i18n="Container">
                            {{ trans('navigate.uses_of_fun_by_project_activity_and_source', [], session()->get('locale')) }}
                        </div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="javascript:void(0);" class="menu-link">
                        <div data-i18n="Container">
                            {{ trans('navigate.uses_of_fun_by_bsp_category_statement', [], session()->get('locale')) }}
                        </div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="javascript:void(0);" class="menu-link">
                        <div data-i18n="Container">
                            {{ trans('navigate.uses_of_fun_by_bsp_category_and_source', [], session()->get('locale')) }}
                        </div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bxs-report"></i>
                <div data-i18n="Users">{{ trans('navigate.accounting_report', [], session()->get('locale')) }}</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{ route('report.index', ['code' => 'transaction']) }}" class="menu-link">
                        <div data-i18n="List">
                            {{ trans('navigate.general_transaction_report', [], session()->get('locale')) }}</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('report.index', ['code' => 'journal']) }}" class="menu-link">
                        <div data-i18n="List">{{ trans('navigate.general_journal', [], session()->get('locale')) }}
                        </div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('report.index', ['code' => 'ledger']) }}" class="menu-link">
                        <div data-i18n="Account">{{ trans('navigate.general_ledger', [], session()->get('locale')) }}
                        </div>
                    </a>
                </li>
                <li class="menu-item">
                    {{-- <a href="{{route('trialBalance.index')}}" class="menu-link"> --}}
                    <a href="{{ route('report.index', ['code' => 'trialBalance']) }}" class="menu-link">
                        <div data-i18n="Account">{{ trans('navigate.trail_balance', [], session()->get('locale')) }}
                        </div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('report.index', ['code' => 'transaction']) }}" class="menu-link">
                        <div data-i18n="Security">{{ trans('navigate.balance_sheet', [], session()->get('locale')) }}
                        </div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-cog"></i>
                <div data-i18n="Users">{{ trans('navigate.setting', [], session()->get('locale')) }}</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{ route('office.index') }}" class="menu-link">
                        <div data-i18n="List">{{ trans('navigate.office_info', [], session()->get('locale')) }}</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="javascript:void(0);" class="menu-link">
                        <div data-i18n="List">{{ trans('navigate.user_guide', [], session()->get('locale')) }}</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('open.index') }}" class="menu-link">
                        <div data-i18n="Account">{{ trans('navigate.opening_balance', [], session()->get('locale')) }}
                        </div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('closing.index') }}" class="menu-link">
                        <div data-i18n="Account">{{ trans('navigate.closing_account', [], session()->get('locale')) }}
                        </div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('pad-budget.index') }}" class="menu-link">
                        <div data-i18n="Security">{{ trans('navigate.pda_budget', [], session()->get('locale')) }}
                        </div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('report.quarter') }}" class="menu-link">
                        <div data-i18n="Security">{{ trans('navigate.quarterly', [], session()->get('locale')) }}
                        </div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('users.index') }}" class="menu-link">
                        <div data-i18n="Security">{{ trans('navigate.user_info', [], session()->get('locale')) }}
                        </div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('users.my-account') }}" class="menu-link">
                        <div data-i18n="Security">{{ trans('navigate.change_pwd', [], session()->get('locale')) }}
                        </div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-item sticky-bottom position-relative">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-user-circle"></i>
                <div data-i18n="Users">{{ Auth::user()->name }}</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <form action="{{ route('lang.switch', ['locale' => 'en']) }}" method="GET">
                        <button type="submit" class="menu-link" data-language="en">
                            <i class="menu-icon tf-icons fi fi-us fis rounded-circle fs-4 me-1"></i> &nbsp;
                            <span class="align-middle">English</span>
                        </button>
                    </form>
                </li>
                <li class="menu-item">
                    <form method="GET" action="{{ route('lang.switch', ['locale' => 'la']) }}">
                        <button type="submit" class="menu-link" data-language="la">
                            <i class="menu-icon tf-icons fi fi-la fis rounded-circle fs-4 me-1"></i> &nbsp;
                            <span class="align-middle">ພາສາລາວ</span>
                        </button>
                    </form>
                </li>
                <li class="menu-item">
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button type="submit" class="menu-link">
                            <i class="menu-icon bx bx-log-out"></i> &nbsp;
                            <span class="align-middle"
                                data-i18n="Logout">{{ trans('navigate.logout', [], session()->get('locale')) }}</span>
                        </button>
                    </form>
                </li>
            </ul>
        </li>
    </ul>
</aside>
<!-- / Menu -->
