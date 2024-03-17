<aside class="navbar navbar-vertical navbar-expand-lg" data-bs-theme="dark">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu"
            aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <h1 class="navbar-brand navbar-brand-autodark">
            {{-- <a href=".">
                <img src="./static/logo.svg" width="110" height="32" alt="Tabler" class="navbar-brand-image">
            </a> --}}
        </h1>
        <div class="collapse navbar-collapse" id="sidebar-menu">
            <ul class="navbar-nav pt-lg-3">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard') }}">
                        <span
                            class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                                <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                                <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                            </svg>
                        </span>
                        <span class="nav-link-title">
                            Dashboard
                        </span>
                    </a>
                </li>
                <li class="nav-item dropdown @if (request()->is('*master*')) active @endif">
                    <a class="nav-link dropdown-toggle" href="#navbar-extra" data-bs-toggle="dropdown"
                        data-bs-auto-close="false" role="button" aria-expanded="false">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-database">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 6m-8 0a8 3 0 1 0 16 0a8 3 0 1 0 -16 0" />
                                <path d="M4 6v6a8 3 0 0 0 16 0v-6" />
                                <path d="M4 12v6a8 3 0 0 0 16 0v-6" />
                            </svg>
                        </span>
                        <span class="nav-link-title">
                            Master Data
                        </span>
                    </a>
                    <div class="dropdown-menu @if (request()->is('*master*')) show @endif">
                        <div class="dropdown-menu-columns">
                            <div class="dropdown-menu-column">
                                <a class="dropdown-item" href="{{ route('master.buyer') }}">
                                    Buyer
                                </a>
                                <a class="dropdown-item" href="{{ route('master.material') }}">
                                    Material
                                </a>
                                <a class="dropdown-item" href="{{ route('master.material.type') }}">
                                    Material Type
                                </a>
                                <a class="dropdown-item" href="{{ route('master.satuan') }}">
                                    Unit of Measurement
                                </a>
                                <a class="dropdown-item" href="{{ route('master.account') }}">
                                    Account
                                </a>
                                <a class="dropdown-item" href="{{ route('master.jenis.bc') }}">
                                    Jenis BC
                                </a>
                                <a class="dropdown-item" href="{{ route('master.group') }}">
                                    Group
                                </a>
                                <a class="dropdown-item" href="{{ route('master.purchase.order') }}">
                                    Purchase Order
                                </a>
                                <a class="dropdown-item" href="{{ route('master.tujuan') }}">
                                    Tujuan
                                </a>
                                <a class="dropdown-item" href="{{ route('master.currency') }}">
                                    Currency
                                </a>
                                <a class="dropdown-item" href="{{ route('master.pic') }}">
                                    PIC
                                </a>
                                <a class="dropdown-item" href="{{ route('master.supplier') }}">
                                    Supplier
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="nav-item dropdown @if (request()->is('*marketing*')) active @endif">
                    <a class="nav-link dropdown-toggle" href="#navbar-extra" data-bs-toggle="dropdown"
                        data-bs-auto-close="false" role="button" aria-expanded="false">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-timeline-event">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 20m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                <path d="M10 20h-6" />
                                <path d="M14 20h6" />
                                <path
                                    d="M12 15l-2 -2h-3a1 1 0 0 1 -1 -1v-8a1 1 0 0 1 1 -1h10a1 1 0 0 1 1 1v8a1 1 0 0 1 -1 1h-3l-2 2z" />
                            </svg>
                        </span>
                        <span class="nav-link-title">
                            Sales
                        </span>
                    </a>
                    <div class="dropdown-menu @if (request()->is('*marketing*')) show @endif">
                        <div class="dropdown-menu-columns">
                            <div class="dropdown-menu-column">
                                <a class="dropdown-item" href="{{ route('marketing.index') }}">
                                    Order Production
                                </a>
                                <a class="dropdown-item" href="{{ route('marketing.index') }}">
                                    Sales
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="nav-item dropdown @if (request()->is('*approval*')) active @endif">
                    <a class="nav-link dropdown-toggle" href="#navbar-extra" data-bs-toggle="dropdown"
                        data-bs-auto-close="false" role="button" aria-expanded="false">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-checks">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M7 12l5 5l10 -10" />
                                <path d="M2 12l5 5m5 -5l5 -5" />
                            </svg>
                        </span>
                        <span class="nav-link-title">
                            Approval
                        </span>
                    </a>
                    <div class="dropdown-menu @if (request()->is('*approval*')) show @endif">
                        <div class="dropdown-menu-columns">
                            <div class="dropdown-menu-column">
                                <a class="dropdown-item" href="{{ route('approval.index') }}">
                                    Order Production
                                </a>
                                <a class="dropdown-item" href="{{ route('approval.list.approved') }}">
                                    Approved List
                                </a>
                                <a class="dropdown-item" href="{{ route('approval.list.rejected') }}">
                                    Rejected List
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="nav-item dropdown @if (request()->is('*bill-of-material*')) active @endif">
                    <a class="nav-link dropdown-toggle" href="#navbar-extra" data-bs-toggle="dropdown"
                        data-bs-auto-close="false" role="button" aria-expanded="false">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-spacing-horizontal">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M20 20h-2a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h2" />
                                <path d="M4 20h2a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" />
                                <path d="M12 8v8" />
                            </svg>
                        </span>
                        <span class="nav-link-title">
                            PPIC
                        </span>
                    </a>
                    <div class="dropdown-menu @if (request()->is('*bill-of-material*')) show @endif">
                        <div class="dropdown-menu-columns">
                            <div class="dropdown-menu-column">
                                <a class="dropdown-item" href="{{ route('bom.production') }}">
                                    BOM Production
                                </a>
                                <a class="dropdown-item" href="{{ route('bom.production') }}">
                                    Allocation
                                </a>
                                <a class="dropdown-item" href="{{ route('bom.production') }}">
                                    Non-Allocation
                                </a>
                                <a class="dropdown-item" href="{{ route('bom.production') }}">
                                    General
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="nav-item dropdown @if (request()->is('*bill-of-material*')) active @endif">
                    <a class="nav-link dropdown-toggle" href="#navbar-extra" data-bs-toggle="dropdown"
                        data-bs-auto-close="false" role="button" aria-expanded="false">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-spacing-horizontal">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M20 20h-2a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h2" />
                                <path d="M4 20h2a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" />
                                <path d="M12 8v8" />
                            </svg>
                        </span>
                        <span class="nav-link-title">
                            Purchasing
                        </span>
                    </a>
                    <div class="dropdown-menu @if (request()->is('*bill-of-material*')) show @endif">
                        <div class="dropdown-menu-columns">
                            <div class="dropdown-menu-column">
                                <a class="dropdown-item" href="{{ route('bom.production') }}">
                                    ??
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="nav-item dropdown @if (request()->is('*bill-of-material*')) active @endif">
                    <a class="nav-link dropdown-toggle" href="#navbar-extra" data-bs-toggle="dropdown"
                        data-bs-auto-close="false" role="button" aria-expanded="false">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-spacing-horizontal">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M20 20h-2a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h2" />
                                <path d="M4 20h2a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" />
                                <path d="M12 8v8" />
                            </svg>
                        </span>
                        <span class="nav-link-title">
                            EXIM
                        </span>
                    </a>
                    <div class="dropdown-menu @if (request()->is('*bill-of-material*')) show @endif">
                        <div class="dropdown-menu-columns">
                            <div class="dropdown-menu-column">
                                <a class="dropdown-item" href="{{ route('bom.production') }}">
                                    ??
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="nav-item dropdown @if (request()->is('*bill-of-material*')) active @endif">
                    <a class="nav-link dropdown-toggle" href="#navbar-extra" data-bs-toggle="dropdown"
                        data-bs-auto-close="false" role="button" aria-expanded="false">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-spacing-horizontal">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M20 20h-2a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h2" />
                                <path d="M4 20h2a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" />
                                <path d="M12 8v8" />
                            </svg>
                        </span>
                        <span class="nav-link-title">
                            Warehouse
                        </span>
                    </a>
                    <div class="dropdown-menu @if (request()->is('*bill-of-material*')) show @endif">
                        <div class="dropdown-menu-columns">
                            <div class="dropdown-menu-column">
                                <a class="dropdown-item" href="{{ route('bom.production') }}">
                                    Raw Material
                                </a>
                                <a class="dropdown-item" href="{{ route('bom.production') }}">
                                    Finish Good
                                </a>
                                <a class="dropdown-item" href="{{ route('bom.production') }}">
                                    Production
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="nav-item dropdown @if (request()->is('*bill-of-material*')) active @endif">
                    <a class="nav-link dropdown-toggle" href="#navbar-extra" data-bs-toggle="dropdown"
                        data-bs-auto-close="false" role="button" aria-expanded="false">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-spacing-horizontal">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M20 20h-2a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h2" />
                                <path d="M4 20h2a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" />
                                <path d="M12 8v8" />
                            </svg>
                        </span>
                        <span class="nav-link-title">
                            Accounting
                        </span>
                    </a>
                    <div class="dropdown-menu @if (request()->is('*bill-of-material*')) show @endif">
                        <div class="dropdown-menu-columns">
                            <div class="dropdown-menu-column">
                                <a class="dropdown-item" href="{{ route('bom.production') }}">
                                    ??
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="nav-item dropdown @if (request()->is('*bill-of-material*')) active @endif">
                    <a class="nav-link dropdown-toggle" href="#navbar-extra" data-bs-toggle="dropdown"
                        data-bs-auto-close="false" role="button" aria-expanded="false">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-spacing-horizontal">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M20 20h-2a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h2" />
                                <path d="M4 20h2a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" />
                                <path d="M12 8v8" />
                            </svg>
                        </span>
                        <span class="nav-link-title">
                            Custom
                        </span>
                    </a>
                    <div class="dropdown-menu @if (request()->is('*bill-of-material*')) show @endif">
                        <div class="dropdown-menu-columns">
                            <div class="dropdown-menu-column">
                                <a class="dropdown-item" href="{{ route('bom.production') }}">
                                    Report
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</aside>
