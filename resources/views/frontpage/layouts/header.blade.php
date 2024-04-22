<header class="ec-header">
    <div class="header-top bg-color">
        <div class="container">
            <div class="row align-items-center">
                <div class="col text-left header-top-left d-none d-lg-block">
                    <div class="header-top-social">
                        <span class="social-text text-upper">Follow us on:</span>
                        @php $list_socmed = json_decode($navbar['settings']['social_media']); @endphp
                        <ul class="mb-0">
                            @foreach ($list_socmed as $socmed)
                                <li class="list-inline-item">
                                    <a title="{{ $socmed->title }}" class="hdr-{{ $socmed->icon }}" href="{{ $socmed->link }}">
                                        <i class="ecicon eci-{{ $socmed->icon }}"></i>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col header-top-right d-none d-lg-block">
                    <div class="header-top-lan-curr d-flex justify-content-end">
                        <div class="header-top-lan dropdown">
                            <button class="dropdown-toggle text-upper" data-bs-toggle="dropdown">Language <i
                                    class="ecicon eci-caret-down" aria-hidden="true"></i></button>
                            <ul class="dropdown-menu">
                                <li class="active"><a class="dropdown-item changeLanguage" data-lang="en" href="#">English</a></li>
                                <li><a class="dropdown-item changeLanguage" data-lang="id" href="#">Indonesia</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col d-lg-none ">
                    <div class="ec-header-bottons">
                        <a href="{{ route("cart") }}" class="ec-header-btn">
                            <div class="header-icon"><img src="{{ asset_frontpage("assets/images/icons/cart.svg") }}" class="svg_img header_svg" alt="" /></div>
                            <div class="basket-item-count">
                                <span class="ec-header-count cart-count-lable"></span>
                            </div>
                        </a>
                        <a href="{{ route('wishlist') }}" class="ec-header-btn ec-header-wishlist">
                            <div class="header-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -28 512.001 512" src="assets/images/icons/wishlist.svg" class="svg_img header_svg" alt=""><path d="m256 455.515625c-7.289062 0-14.316406-2.640625-19.792969-7.4375-20.683593-18.085937-40.625-35.082031-58.21875-50.074219l-.089843-.078125c-51.582032-43.957031-96.125-81.917969-127.117188-119.3125-34.644531-41.804687-50.78125-81.441406-50.78125-124.742187 0-42.070313 14.425781-80.882813 40.617188-109.292969 26.503906-28.746094 62.871093-44.578125 102.414062-44.578125 29.554688 0 56.621094 9.34375 80.445312 27.769531 12.023438 9.300781 22.921876 20.683594 32.523438 33.960938 9.605469-13.277344 20.5-24.660157 32.527344-33.960938 23.824218-18.425781 50.890625-27.769531 80.445312-27.769531 39.539063 0 75.910156 15.832031 102.414063 44.578125 26.191406 28.410156 40.613281 67.222656 40.613281 109.292969 0 43.300781-16.132812 82.9375-50.777344 124.738281-30.992187 37.398437-75.53125 75.355469-127.105468 119.308594-17.625 15.015625-37.597657 32.039062-58.328126 50.167969-5.472656 4.789062-12.503906 7.429687-19.789062 7.429687zm-112.96875-425.523437c-31.066406 0-59.605469 12.398437-80.367188 34.914062-21.070312 22.855469-32.675781 54.449219-32.675781 88.964844 0 36.417968 13.535157 68.988281 43.882813 105.605468 29.332031 35.394532 72.960937 72.574219 123.476562 115.625l.09375.078126c17.660156 15.050781 37.679688 32.113281 58.515625 50.332031 20.960938-18.253907 41.011719-35.34375 58.707031-50.417969 50.511719-43.050781 94.136719-80.222656 123.46875-115.617188 30.34375-36.617187 43.878907-69.1875 43.878907-105.605468 0-34.515625-11.605469-66.109375-32.675781-88.964844-20.757813-22.515625-49.300782-34.914062-80.363282-34.914062-22.757812 0-43.652344 7.234374-62.101562 21.5-16.441406 12.71875-27.894532 28.796874-34.609375 40.046874-3.453125 5.785157-9.53125 9.238282-16.261719 9.238282s-12.808594-3.453125-16.261719-9.238282c-6.710937-11.25-18.164062-27.328124-34.609375-40.046874-18.449218-14.265626-39.34375-21.5-62.097656-21.5zm0 0"></path></svg></div>
                            <span class="ec-header-count count-cart">0</span>
                        </a>
                        <div class="ec-header-user dropdown">
                            <button class="dropdown-toggle" data-bs-toggle="dropdown"><img src="{{ asset_frontpage("assets/images/icons/user.svg") }}" class="svg_img header_svg" alt="" /></button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                @auth
                                <li><a class="dropdown-item" href="{{ route('profile') }}">Profil {{ Auth::user()->name }}</a></li>
                                <li><a class="dropdown-item" href="{{ route('order_history') }}">Transaksi</a></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                                </li>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                                @else
                                <li><a class="dropdown-item" href="{{ route('register') }}">Register</a></li>
                                <li><a class="dropdown-item" href="{{ route('login') }}">Login</a></li>
                                @endauth
                            </ul>
                        </div>
                        <a href="#ec-mobile-menu" class="ec-header-btn ec-side-toggle d-lg-none">
                            <img src="{{ asset_frontpage("assets/images/icons/menu.svg") }}" class="svg_img header_svg" alt="icon" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="ec-header-bottom d-none d-lg-block">
        <div class="container position-relative">
            <div class="row">
                <div class="ec-flex">
                    <div class="align-self-center">
                        <div class="header-logo">
                            <a href="{{ route("home") }}">
                                <img src="{{ img_src($navbar['settings']['logo'], "logo") }}" alt="Site Logo" />
                                <img class="dark-logo" src="{{ img_src($navbar['settings']['logo'], "logo") }}" alt="Site Logo" style="display: none;" />
                            </a>
                        </div>
                    </div>

                    <div class="align-self-center">
                        <div class="header-search">
                        </div>
                    </div>
                    @if (Route::has('login'))
                    <div class="align-self-center">
                        <div class="ec-header-bottons">
                            <a href="{{ route("cart") }}" class="ec-header-btn">
                                <div class="header-icon"><img src="{{ asset_frontpage("assets/images/icons/cart.svg") }}" class="svg_img header_svg" alt="" /></div>
                                <div class="basket-item-count" >
                                    <span class="ec-header-count cart-count-lable"></span>
                                </div>
                            </a>
                            <a href="{{ route('wishlist') }}" class="ec-header-btn ec-header-wishlist">
                                <div class="header-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -28 512.001 512" src="assets/images/icons/wishlist.svg" class="svg_img header_svg" alt=""><path d="m256 455.515625c-7.289062 0-14.316406-2.640625-19.792969-7.4375-20.683593-18.085937-40.625-35.082031-58.21875-50.074219l-.089843-.078125c-51.582032-43.957031-96.125-81.917969-127.117188-119.3125-34.644531-41.804687-50.78125-81.441406-50.78125-124.742187 0-42.070313 14.425781-80.882813 40.617188-109.292969 26.503906-28.746094 62.871093-44.578125 102.414062-44.578125 29.554688 0 56.621094 9.34375 80.445312 27.769531 12.023438 9.300781 22.921876 20.683594 32.523438 33.960938 9.605469-13.277344 20.5-24.660157 32.527344-33.960938 23.824218-18.425781 50.890625-27.769531 80.445312-27.769531 39.539063 0 75.910156 15.832031 102.414063 44.578125 26.191406 28.410156 40.613281 67.222656 40.613281 109.292969 0 43.300781-16.132812 82.9375-50.777344 124.738281-30.992187 37.398437-75.53125 75.355469-127.105468 119.308594-17.625 15.015625-37.597657 32.039062-58.328126 50.167969-5.472656 4.789062-12.503906 7.429687-19.789062 7.429687zm-112.96875-425.523437c-31.066406 0-59.605469 12.398437-80.367188 34.914062-21.070312 22.855469-32.675781 54.449219-32.675781 88.964844 0 36.417968 13.535157 68.988281 43.882813 105.605468 29.332031 35.394532 72.960937 72.574219 123.476562 115.625l.09375.078126c17.660156 15.050781 37.679688 32.113281 58.515625 50.332031 20.960938-18.253907 41.011719-35.34375 58.707031-50.417969 50.511719-43.050781 94.136719-80.222656 123.46875-115.617188 30.34375-36.617187 43.878907-69.1875 43.878907-105.605468 0-34.515625-11.605469-66.109375-32.675781-88.964844-20.757813-22.515625-49.300782-34.914062-80.363282-34.914062-22.757812 0-43.652344 7.234374-62.101562 21.5-16.441406 12.71875-27.894532 28.796874-34.609375 40.046874-3.453125 5.785157-9.53125 9.238282-16.261719 9.238282s-12.808594-3.453125-16.261719-9.238282c-6.710937-11.25-18.164062-27.328124-34.609375-40.046874-18.449218-14.265626-39.34375-21.5-62.097656-21.5zm0 0"></path></svg></div>
                                <span class="ec-header-count count-cart" id="count-cart">0</span>
                            </a>
                            <div class="ec-header-user dropdown">
                                <button class="dropdown-toggle" data-bs-toggle="dropdown"><img src="{{ asset_frontpage("assets/images/icons/user.svg") }}" class="svg_img header_svg" alt="" /></button>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    @auth
                                    <li><a class="dropdown-item" href="{{ route('profile') }}">Profil {{ Auth::user()->name }}</a></li>
                                    <li><a class="dropdown-item" href="{{ route('order_history') }}">Transaksi</a></li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                                    </li>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                    @else
                                    <li><a class="dropdown-item" href="{{ route('register') }}">Register</a></li>
                                    <li><a class="dropdown-item" href="{{ route('login') }}">Login</a></li>
                                    @endauth
                                </ul>
                            </div>

                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="ec-header-bottom d-lg-none">
        <div class="container position-relative">
            <div class="row ">
                <div class="col">
                    <div class="header-logo">
                        <a href="{{ route("home") }}"><img src="{{ img_src($navbar['settings']['logo'], "logo") }}" alt="Site Logo" /><img
                                class="dark-logo" src="{{ img_src($navbar['settings']['logo'], "logo") }}" alt="Site Logo"
                                style="display: none;" /></a>
                    </div>
                </div>
                <div class="col">
                    <div class="header-search">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="ec-main-menu-desk" class="d-none d-lg-block sticky-nav">
        <div class="container position-relative">
            <div class="row">
                <div class="col-md-12 align-self-center">
                    <div class="ec-main-menu">
                        <ul>
                            @if (!empty($navbar['navbar']))
                                @if ($navbar['navbar'] != '-')
                                    @foreach ($navbar['navbar']->items as $item)
                                    @if (count($item->child) <= 0)
                                        <li class="{{ url()->full() == $item->link ? 'active' : '' }}"><a href="{{ $item->link }}">{{ $item->label }}</a></li>
                                    @else
                                    <li class="dropdown"><a href="javascript:void(0)">{{ $item->label }}</a>
                                        <ul class="sub-menu">
                                            @foreach ($item->child as $item)
                                                <li><a href="{{ $item->link }}">{{ $item->label }}</a></li>
                                            @endforeach
                                        </ul>
                                    </li>
                                    @endif
                                    @endforeach
                                @endif
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="ec-mobile-menu" class="ec-side-cart ec-mobile-menu">
        <div class="ec-menu-title">
            <span class="menu_title">Menu</span>
            <button class="ec-close">×</button>
        </div>
        <div class="ec-menu-inner">
            <div class="ec-menu-content">
                <ul>
                    @if (!empty($navbar['navbar']))
                        @if ($navbar['navbar'] != '-')
                            @foreach ($navbar['navbar']->items as $item)
                            @if (count($item->child) <= 0)
                                <li class="{{ url()->full() == $item->link ? 'active' : '' }}"><a href="{{ $item->link }}">{{ $item->label }}</a></li>
                            @else
                            <li class="dropdown"><a href="javascript:void(0)">{{ $item->label }}</a>
                                <ul class="sub-menu">
                                    @foreach ($item->child as $item)
                                        <li><a href="{{ $item->link }}">{{ $item->label }}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                            @endif
                            @endforeach
                        @endif
                    @endif
                </ul>
            </div>
            <div class="header-res-lan-curr">
                <div class="header-top-lan-curr">
                    <div class="header-top-lan-curr d-flex justify-content-end">
                        <div class="header-top-lan dropdown">
                            <button class="dropdown-toggle text-upper" data-bs-toggle="dropdown">Language <i
                                    class="ecicon eci-caret-down" aria-hidden="true"></i></button>
                            <ul class="dropdown-menu">
                                <li class="active"><a class="dropdown-item changeLanguage" data-lang="en" href="#">English</a></li>
                                <li><a class="dropdown-item changeLanguage" data-lang="id" href="#">Indonesia</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="header-res-social">
                    <div class="header-top-social">
                        <ul class="mb-0">
                            @foreach ($list_socmed as $socmed)
                                <li class="list-inline-item">
                                    <a title="{{ $socmed->title }}" class="hdr-{{ $socmed->icon }}" href="{{ $socmed->link }}">
                                        <i class="ecicon eci-{{ $socmed->icon }}"></i>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
