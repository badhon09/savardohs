@php
$configData = Helper::applClasses();
@endphp
<div class="main-menu menu-fixed {{(($configData['theme'] === 'dark') || ($configData['theme'] === 'semi-dark')) ? 'menu-dark' : 'menu-light'}} menu-accordion menu-shadow" style="background: #443d91 !important;" data-scroll-to-active="true">
  <div class="navbar-header">
    <ul class="nav navbar-nav flex-row">
      <li class="nav-item me-auto">
        <a class="navbar-brand" href="{{ URL::to('/') }}">
          <span class="brand-logo">
{{--            <svg viewbox="0 0 139 95" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" height="24">--}}
              <img src="{{ asset('images/logo/logo.png') }}" alt="Logo">
              <defs>
                <lineargradient id="linearGradient-1" x1="100%" y1="10.5120544%" x2="50%" y2="89.4879456%">
                  <stop stop-color="#000000" offset="0%"></stop>
                  <stop stop-color="#FFFFFF" offset="100%"></stop>
                </lineargradient>
                <lineargradient id="linearGradient-2" x1="64.0437835%" y1="46.3276743%" x2="37.373316%" y2="100%">
                  <stop stop-color="#EEEEEE" stop-opacity="0" offset="0%"></stop>
                  <stop stop-color="#FFFFFF" offset="100%"></stop>
                </lineargradient>
              </defs>
              <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <g id="Artboard" transform="translate(-400.000000, -178.000000)">
                  <g id="Group" transform="translate(400.000000, 178.000000)">
                    <path class="text-primary" id="Path" d="M-5.68434189e-14,2.84217094e-14 L39.1816085,2.84217094e-14 L69.3453773,32.2519224 L101.428699,2.84217094e-14 L138.784583,2.84217094e-14 L138.784199,29.8015838 C137.958931,37.3510206 135.784352,42.5567762 132.260463,45.4188507 C128.736573,48.2809251 112.33867,64.5239941 83.0667527,94.1480575 L56.2750821,94.1480575 L6.71554594,44.4188507 C2.46876683,39.9813776 0.345377275,35.1089553 0.345377275,29.8015838 C0.345377275,24.4942122 0.230251516,14.560351 -5.68434189e-14,2.84217094e-14 Z" style="fill:currentColor"></path>
                    <path id="Path1" d="M69.3453773,32.2519224 L101.428699,1.42108547e-14 L138.784583,1.42108547e-14 L138.784199,29.8015838 C137.958931,37.3510206 135.784352,42.5567762 132.260463,45.4188507 C128.736573,48.2809251 112.33867,64.5239941 83.0667527,94.1480575 L56.2750821,94.1480575 L32.8435758,70.5039241 L69.3453773,32.2519224 Z" fill="url(#linearGradient-1)" opacity="0.2"></path>
                    <polygon id="Path-2" fill="#000000" opacity="0.049999997" points="69.3922914 32.4202615 32.8435758 70.5039241 54.0490008 16.1851325"></polygon>
                    <polygon id="Path-21" fill="#000000" opacity="0.099999994" points="69.3922914 32.4202615 32.8435758 70.5039241 58.3683556 20.7402338"></polygon>
                    <polygon id="Path-3" fill="url(#linearGradient-2)" opacity="0.099999994" points="101.428699 0 83.0667527 94.1480575 130.378721 47.0740288"></polygon>
                  </g>
                </g>
              </g>
            </svg>
          </span>
          <h2 class="brand-text">Cantt Board</h2>
        </a>
      </li> 
      <li class="nav-item nav-toggle text-white">
        <a class="nav-link modern-nav-toggle pe-0" data-toggle="collapse">
          <i class="d-block d-xl-none text-white toggle-icon font-medium-4" data-feather="x"></i>
          <i class="d-none d-xl-block collapse-toggle-icon font-medium-4 text-white" data-feather="disc" data-ticon="disc"></i>
        </a>
      </li>
    </ul>
  </div>
  <div class="shadow-bottom"></div>
  <div class="main-menu-content">
    <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
      @php $MenuList = Illuminate\Support\Facades\DB::table('dohs_menu')->where('billing_dept_id',Auth::user()->billing_dept_id)->where('is_active',1)->orderBy('seq_number')->get(); @endphp
      @php $mainMenuList = $MenuList->where('menu_parent_id',null)->where('sub_menu_id',null)->where('is_child',0); @endphp
      @foreach($mainMenuList as $item)
        @php $subMenuList = $MenuList->where('menu_parent_id',$item->id)->where('sub_menu_id',null)->where('is_child',0); @endphp
        @if(count($subMenuList)>0)
        <li class="nav-item has-sub">
          <a title="{{$item->menu_name}}" href="javascript:void(0)" class="d-flex align-items-center" target="_self">
            <i data-feather="{{ $item->icon_name }}"></i>
            <span class="menu-title text-truncate">{{$item->menu_name}}</span>
            <span class="badge rounded-pill badge-light-danger ms-auto me-1">{{count($subMenuList)}}</span>
          </a>
          <ul class="menu-content">     
            @foreach($subMenuList as $subMenu) 
            @php $childMenuList = $MenuList->where('menu_parent_id',$item->id)->where('sub_menu_id',$subMenu->id)->where('is_child',1); @endphp
            @if(count($childMenuList)>0)             
            <li class="nav-item has-sub">
              <a title="{{$subMenu->menu_name}}" href="javascript:void(1)" class="d-flex align-items-center" target="_self">
                <i data-feather="{{ $subMenu->icon_name }}"></i>
                <span class="menu-title text-truncate">{{$subMenu->menu_name}}</span>
                <span class="badge rounded-pill badge-light-danger ms-auto me-1">{{count($childMenuList)}}</span>
              </a>
              <ul class="menu-content">
                @foreach($childMenuList as $childMenu)
                <li class="nav-item {{(Request::url() == $childMenu->route_id)?'active':null}}">
                  <a title="{{$childMenu->menu_name}}" href="{{$childMenu->route_id}}" class="d-flex align-items-center" target="{{($childMenu->is_newtab == null)?'_self':'_blank'}}">
                    <i data-feather="{{ $childMenu->icon_name }}"></i>  
                    <span class="menu-item text-truncate">{{$childMenu->menu_name}}</span>
                  </a>
                </li>
                @endforeach
              </ul>
            </li>
            @else
            <li class="nav-item  {{(Request::url() == $subMenu->route_id)?'active':null}}">
              <a title="10E-Payment Details" href="{{$subMenu->route_id}}" class="d-flex align-items-center" target="{{($subMenu->is_newtab == null)?'_self':'_blank'}}">
                <i data-feather="{{ $subMenu->icon_name }}"></i>  
                <span class="menu-item text-truncate">{{$subMenu->menu_name}}</span>
              </a>
            </li>         
            @endif   
            @endforeach     
          </ul>
        </li>
        @else        
        <li class="nav-item  {{(Request::url() == $item->route_id)?'active':null}}">
          <a title="User Info" href="{{$item->route_id}}" class="d-flex align-items-center" target="{{($item->is_newtab == null)?'_self':'_blank'}}">
            <i data-feather="{{ $item->icon_name }}"></i>
            <span class="menu-title text-truncate">{{$item->menu_name}}</span>
          </a>
        </li>
        @endif
      @endforeach
    </ul>
  </div>
</div>
<!-- END: Main Menu-->
