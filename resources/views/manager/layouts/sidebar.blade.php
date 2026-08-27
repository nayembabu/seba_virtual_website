<aside class="left-sidebar" data-sidebarbg="skin6">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar" data-sidebarbg="skin6">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">

             
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{route('manager.dashboard')}}" aria-expanded="false">
                            <i data-feather="home" class="feather-icon"></i>
                            <span class="hide-menu">@lang('Dashboard')</span>
                        </a>
                    </li>
                    <li class="sidebar-item {{menuActive(['manager.supports'],3)}}">
                        <a class="sidebar-link" href="/manager/supports" aria-expanded="false">
                           <i class="fas fa-life-ring"></i>
                            <span class="hide-menu">@lang('Support Tickets')</span>
                        </a>
                    </li>
                    
                    <li class="sidebar-item {{menuActive(['manager.moderators','manager.add-moderator','manager.moderator-reports'],3)}}">
                        <a class="sidebar-link" href="{{route('manager.moderators')}}" aria-expanded="false">
                           <i class="fas fa-user"></i>
                            <span class="hide-menu">@lang('Moderators')</span>
                        </a>
                    </li>
                    
                     <li class="sidebar-item {{menuActive(['manager.users'],3)}}">
                        <a class="sidebar-link" href="{{route('manager.users')}}" aria-expanded="false">
                           <i class="fas fa-users"></i>
                            <span class="hide-menu">@lang('Users')</span>
                        </a>
                    </li>
                    
                     <li class="sidebar-item {{menuActive(['manager.add-user'],3)}}">
                        <a class="sidebar-link" href="{{route('manager.add-user')}}" aria-expanded="false">
                           <i class="fas fa-user-plus"></i>
                            <span class="hide-menu">@lang('Add User')</span>
                        </a>
                    </li>
                    
                    <li class="sidebar-item {{menuActive(['admin.transactions'],3)}}">
                        <a class="sidebar-link" href="{{ route('manager.transactions') }}" aria-expanded="false">
                            <i class="fas fa-history"></i>
                            <span class="hide-menu">@lang('Transactions')</span>
                        </a>
                    </li>
                    
                    
                      <li class="nav-small-cap"><span class="hide-menu">@lang('Manage Notifications')</span></li>
                    
                    <li class="sidebar-item {{menuActive(['admin.notifications','admin.send-notification'],3)}}">
                        <a class="sidebar-link" href="{{route('admin.notifications')}}" aria-expanded="false">
                           <i class="fas fa-bell"></i>
                            <span class="hide-menu">@lang('Notifications')</span>
                        </a>
                    </li>
                   
              
                
                
              <!--  <li class="list-divider"></li>-->
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
