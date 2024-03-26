<div class="aiz-sidebar-wrap">
    <div class="aiz-sidebar left c-scrollbar">
        <div class="aiz-side-nav-logo-wrap">
            <div class="d-block text-center my-3">
                @php
                $logo_type = !empty(get_static_option('dark_mode_for_admin_panel')) ? 'site_white_logo' : 'site_logo';
                @endphp
                {!! render_image_markup_by_attachment_id(get_static_option($logo_type)) !!}
                <br><br>
                <h3 class="fs-16  m-0 text-primary">{{ optional(auth('agent')->user())->name }}</h3>
                <p class="text-primary">{{ auth('agent')->user()->email }}</p>
            </div>
        </div>
        <div class="aiz-side-nav-wrap">
            <div class="px-20px mb-3">
                <input class="form-control bg-soft-secondary border-0 form-control-sm" type="text"
                    name="" placeholder="{{ __('Search in menu') }}" id="menu-search"
                    onkeyup="menuSearch()">
            </div>
            <ul class="aiz-side-nav-list" id="search-menu">
            </ul>
            <ul class="aiz-side-nav-list" id="main-menu" data-toggle="aiz-side-menu">
                <li class="aiz-side-nav-item">
                    <a href="{{ route('landlord.agent.dashboard') }}" class="aiz-side-nav-link {{ areActiveRoutes(['landlord.agent.dashboard']) }}">
                        <i class="las la-home aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">{{ __('Dashboard') }}</span>
                    </a>
                </li>
                <li class="aiz-side-nav-item">
                    <a href="#" class="aiz-side-nav-link">
                        <i class="las la-person-booth aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">{{ __('Clients') }}</span>
                        <span class="aiz-side-nav-arrow"></span>
                    </a>
                    <!--Submenu-->
                    <ul class="aiz-side-nav-list level-2">
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('landlord.agent.client.add') }}"
                                class="aiz-side-nav-link {{ areActiveRoutes(['landlord.agent.client.add']) }}">
                                <span class="aiz-side-nav-text">{{ __('Add new') }}</span>
                            </a>
                        </li>

                        <li class="aiz-side-nav-item">
                            <a href="{{ route('landlord.agent.client.view') }}"
                                class="aiz-side-nav-link {{ areActiveRoutes(['landlord.agent.client.view']) }}">
                                <span class="aiz-side-nav-text">{{ __('All Clients') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="aiz-side-nav-item">
                    <a href="#" class="aiz-side-nav-link">
                        <i class="las la-share-alt aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">{{ __('Agents') }}</span>
                        <span class="aiz-side-nav-arrow"></span>
                    </a>
                    <!--Submenu-->
                    <ul class="aiz-side-nav-list level-2">
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('landlord.agent.new') }}"
                                class="aiz-side-nav-link {{ areActiveRoutes(['landlord.agent.new']) }}">
                                <span class="aiz-side-nav-text">{{ __('Add new') }}</span>
                            </a>
                        </li>

                        <li class="aiz-side-nav-item">
                            <a href="{{ route('landlord.agent.myreferrals') }}"
                                class="aiz-side-nav-link {{ areActiveRoutes(['landlord.agent.myreferrals']) }}">
                                <span class="aiz-side-nav-text">{{ __('My Referrals') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="aiz-side-nav-item">
                    <a href="#" class="aiz-side-nav-link">
                        <i class="las la-money-bill-wave aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">{{ __('Payments') }}</span>
                        <span class="aiz-side-nav-arrow"></span>
                    </a>
                    <!--Submenu-->
                    <ul class="aiz-side-nav-list level-2">
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('landlord.agent.wallet') }}"
                                class="aiz-side-nav-link {{ areActiveRoutes(['landlord.agent.wallet']) }}">
                                <span class="aiz-side-nav-text">{{ __('Wallet') }}</span>
                            </a>
                        </li>

                        <li class="aiz-side-nav-item">
                            <a href="{{ route('landlord.agent.commission.history') }}"
                                class="aiz-side-nav-link {{ areActiveRoutes(['landlord.agent.commission.history']) }}">
                                <span class="aiz-side-nav-text">{{ __('CommissionHistory') }}</span>
                            </a>
                        </li>
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('landlord.agent.withdrawal.history') }}"
                                class="aiz-side-nav-link {{ areActiveRoutes(['landlord.agent.withdrawal.history']) }}">
                                <span class="aiz-side-nav-text">{{ __('Withdraw History') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="aiz-side-nav-item">
                    <a href="#" class="aiz-side-nav-link">
                        <i class="las la-address-card aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">{{ __('Kyc') }}</span>
                        <span class="aiz-side-nav-arrow"></span>
                    </a>
                    <!--Submenu-->
                    <ul class="aiz-side-nav-list level-2">
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('landlord.agent.kyc.verify') }}"
                                class="aiz-side-nav-link {{ areActiveRoutes(['landlord.agent.kyc.verify']) }}">
                                <span class="aiz-side-nav-text">{{ __('View Form') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="aiz-side-nav-item">
                    <a href="{{ route('landlord.agent.edit.profile') }}"
                        class="aiz-side-nav-link {{ areActiveRoutes(['landlord.agent.edit.profile']) }}">
                        <i class="las la-user aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">{{ __('Profile') }}</span>
                    </a>
                </li>
               
                {{-- <li class="aiz-side-nav-item">
                    <a href="{{ route('agent.home') }}"
                        class="aiz-side-nav-link {{ areActiveRoutes(['agent.home']) }}">
                        <i class="las la-car aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">{{ __('Milestone') }}</span>
                    </a>
                </li> --}}
                

                {{-- @php
                    $support_ticket = 1;
                @endphp
                <li class="aiz-side-nav-item">
                    <a href="{{ route('agent.homes') }}"
                        class="aiz-side-nav-link {{ areActiveRoutes(['agent.homes']) }}">
                        <i class="las la-atom aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">{{ __('Support Ticket') }}</span>
                        @if ($support_ticket > 0)
                            <span class="badge badge-inline badge-success">{{ $support_ticket }}</span>
                        @endif
                    </a>
                </li> --}}

            </ul>
        </div>
    </div>
    <div class="aiz-sidebar-overlay"></div>
</div>
