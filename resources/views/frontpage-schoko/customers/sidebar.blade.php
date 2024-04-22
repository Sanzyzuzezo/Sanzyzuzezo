 <div class="row">
    <div class="ec-shop-leftside ec-vendor-sidebar col-lg-12 col-md-12">
        <div class="ec-sidebar-wrap">
            <div class="ec-sidebar-block">
                <div class="ec-vendor-block">
                    <div class="ec-vendor-block-items">
                        <ul>
                            <li><a href="{{ route('profile') }}">{{ __('profile.user_profile') }}</a></li>
                            <li><a href="{{ route('address') }}">{{ __('profile.address') }}</a></li>
                            <li><a href="{{ route('order_history') }}">{{ __('profile.transaction') }}</a></li>
                            <li><a href="{{ route('cart') }}">Cart</a></li>
                            <li><a href="{{ route('wishlist') }}">Wishlist</a></li>
                            <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
