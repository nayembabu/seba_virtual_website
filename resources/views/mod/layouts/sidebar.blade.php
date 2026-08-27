<aside class="left-sidebar" data-sidebarbg="skin6">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar" data-sidebarbg="skin6">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">

               
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{route('mod.index')}}" aria-expanded="false">
                            <i data-feather="home" class="feather-icon"></i>
                            <span class="hide-menu">@lang('Dashboard')</span>
                        </a>
                    </li>
                    
                      <li class="sidebar-item {{menuActive(['mod.applications'],3)}}">
                        <a class="sidebar-link" href="{{route('mod.applications')}}" aria-expanded="false">
                           <i class="fas fa-file"></i>
                            <span class="hide-menu">@lang('Applications') ( <span style="color:red" id="tt"> {{ get_pending_app_count() }} </span> ) </span>
                        </a>
                    </li>
                    
                     <li class="sidebar-item {{menuActive(['mod.my-applications'],3)}}">
                        <a class="sidebar-link" href="{{route('mod.my-applications')}}" aria-expanded="false">
                           <i class="fas fa-file"></i>
                            <span class="hide-menu">@lang('My Applications')</span>
                        </a>
                    </li>
               
                
                    {{--<li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('mod.deposits') }}" aria-expanded="false">
                            <i class="fas fa-wallet"></i>
                            <span class="hide-menu">@lang('Deposit History')</span>
                        </a>
                    </li>
                    
                     <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('mod.withdraw') }}" aria-expanded="false">
                            <i class="fas fa-wallet"></i>
                            <span class="hide-menu">@lang('Withdraw')</span>
                        </a>
                    </li>
                     
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('mod.withdrawals') }}" aria-expanded="false">
                            <i class="fas fa-wallet"></i>
                            <span class="hide-menu">@lang('Withdrawal History')</span>
                        </a>
                    </li>
                  
                   <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('mod.transactions') }}" aria-expanded="false">
                            <i class="fas fa-wallet"></i>
                            <span class="hide-menu">@lang('Transaction History')</span>
                        </a>
                    </li>
                    
                   <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('mod.members') }}" aria-expanded="false">
                            <i class="fas fa-user"></i>
                            <span class="hide-menu">@lang('Members')</span>
                        </a>
                    </li>
                    
                 <li class="sidebar-item">
                        <a class="sidebar-link" target="_blank" href="https://wa.me/{{ get_site_config()->whatsapp }}" aria-expanded="false">
                            <i class="fab fa-whatsapp"></i>
                            <span class="hide-menu">@lang('Whatsapp Support')</span>
                        </a>
                    </li>--}}
                    
            
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
