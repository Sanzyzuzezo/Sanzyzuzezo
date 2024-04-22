@php $navbar = Layout::getLayout() @endphp
@php $permissions = getPermissionModuleGroup(); @endphp
@php use App\Models\User; $data_user = User::find(auth()->user()->id); @endphp
<div id="kt_aside" class="aside aside-dark aside-hoverable" data-kt-drawer="true" data-kt-drawer-name="aside"
    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
    data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start"
    data-kt-drawer-toggle="#kt_aside_mobile_toggle">
    <div class="aside-logo flex-column-auto" id="kt_aside_logo">
        <a href="{{ route('admin.dashboard') }}">
            <img alt="Logo" src="{{ img_src($navbar['settings']['logo'], 'logo') }}" class="h-50px logo" />
        </a>
        <div id="kt_aside_toggle" class="btn btn-icon w-auto px-0 btn-active-color-primary aside-toggle"
            data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body"
            data-kt-toggle-name="aside-minimize">
            <span class="svg-icon svg-icon-1 rotate-180">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    fill="none">
                    <path opacity="0.5"
                        d="M14.2657 11.4343L18.45 7.25C18.8642 6.83579 18.8642 6.16421 18.45 5.75C18.0358 5.33579 17.3642 5.33579 16.95 5.75L11.4071 11.2929C11.0166 11.6834 11.0166 12.3166 11.4071 12.7071L16.95 18.25C17.3642 18.6642 18.0358 18.6642 18.45 18.25C18.8642 17.8358 18.8642 17.1642 18.45 16.75L14.2657 12.5657C13.9533 12.2533 13.9533 11.7467 14.2657 11.4343Z"
                        fill="black" />
                    <path
                        d="M8.2657 11.4343L12.45 7.25C12.8642 6.83579 12.8642 6.16421 12.45 5.75C12.0358 5.33579 11.3642 5.33579 10.95 5.75L5.40712 11.2929C5.01659 11.6834 5.01659 12.3166 5.40712 12.7071L10.95 18.25C11.3642 18.6642 12.0358 18.6642 12.45 18.25C12.8642 17.8358 12.8642 17.1642 12.45 16.75L8.2657 12.5657C7.95328 12.2533 7.95328 11.7467 8.2657 11.4343Z"
                        fill="black" />
                </svg>
            </span>
        </div>
    </div>
    <div class="aside-menu flex-column-fluid">
        <div class="hover-scroll-overlay-y" id="kt_aside_menu_wrapper" data-kt-scroll="true"
            data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto"
            data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer" data-kt-scroll-wrappers="#kt_aside_menu"
	        data-kt-scroll-offset="0">
            <div class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500"
                id="#kt_aside_menu" data-kt-menu="true">

                @if ($data_user->general_admin != 1)
                <div class="menu-item show menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none">
                                    <rect x="2" y="2" width="9" height="9" rx="2"
                                        fill="black" />
                                    <rect opacity="0.3" x="13" y="2" width="9" height="9"
                                        rx="2" fill="black" />
                                    <rect opacity="0.3" x="13" y="13" width="9" height="9"
                                        rx="2" fill="black" />
                                    <rect opacity="0.3" x="2" y="13" width="9" height="9"
                                        rx="2" fill="black" />
                                </svg>
                            </span>
                        </span>
                        <a href="{{ route('admin.dashboard') }}" class="menu-title">Dashboard</a>
                    </span>
                </div>
                @endif

                @if ($data_user->general_admin == 1)
                <div class="menu-item show menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none">
                                    <rect x="2" y="2" width="9" height="9" rx="2"
                                        fill="black" />
                                    <rect opacity="0.3" x="13" y="2" width="9" height="9"
                                        rx="2" fill="black" />
                                    <rect opacity="0.3" x="13" y="13" width="9" height="9"
                                        rx="2" fill="black" />
                                    <rect opacity="0.3" x="2" y="13" width="9" height="9"
                                        rx="2" fill="black" />
                                </svg>
                            </span>
                        </span>
                        <a href="{{ route('admin.user-admins-dashboard') }}" class="menu-title">User Admins</a>
                    </span>
                </div>
                @endif

                @if (showModule('item_groups', $permissions)||showModule('units', $permissions)||showModule('warehouse', $permissions)||showModule('supplier', $permissions)||showModule('unit_conversions', $permissions)||showModule('ingredients', $permissions)||showModule('stock_card', $permissions)||showModule('adjusment', $permissions)||showModule('warehouse', $permissions)||showModule('brands', $permissions)||showModule('categories', $permissions)||showModule('items', $permissions)||showModule('promo_products', $permissions)||showModule('buys', $permissions)||showModule('produksi', $permissions)||showModule('orders', $permissions)||showModule('sales', $permissions)||showModule('delivery_note', $permissions))
                <div class="menu-item show">
                    <span class="menu-link">
                        <p href="{{ route('admin.dashboard') }}" class="menu-title m-0">Product</p>
                    </span>
                </div>
                @endif

                @if (showModule('item_groups', $permissions)||showModule('units', $permissions)||showModule('warehouse', $permissions)||showModule('supplier', $permissions))
                <div data-kt-menu-trigger="click" class="menu-item here menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none">
                                    <rect x="8" y="9" width="3" height="10" rx="1.5"
                                        fill="black" />
                                    <rect opacity="0.5" x="13" y="5" width="3" height="14"
                                        rx="1.5" fill="black" />
                                    <rect x="18" y="11" width="3" height="8"
                                        rx="1.5" fill="black" />
                                    <rect x="3" y="13" width="3" height="6"
                                        rx="1.5" fill="black" />
                                </svg>
                            </span>
                        </span>
                        <span class="menu-title">Master Data</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        @if (showModule('item_groups', $permissions))
                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('admin.item_groups') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Item Groups</span>
                            </a>
                        </div>
                        @endif
                        @if (showModule('units', $permissions))
                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('admin.units') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Units</span>
                            </a>
                        </div>
                        @endif
                        @if (showModule('warehouse', $permissions))
                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('admin.warehouse') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Warehouse</span>
                            </a>
                        </div>
                        @endif
                        @if (showModule('supplier', $permissions))
                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('admin.supplier') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Supplier</span>
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                @if (showModule('brands', $permissions)||showModule('categories', $permissions)||showModule('items', $permissions)||showModule('promo_products', $permissions))
                <div data-kt-menu-trigger="click" class="menu-item here menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none">
                                    <path opacity="0.3" d="M5 8.04999L11.8 11.95V19.85L5 15.85V8.04999Z"
                                        fill="black" />
                                    <path
                                        d="M20.1 6.65L12.3 2.15C12 1.95 11.6 1.95 11.3 2.15L3.5 6.65C3.2 6.85 3 7.15 3 7.45V16.45C3 16.75 3.2 17.15 3.5 17.25L11.3 21.75C11.5 21.85 11.6 21.85 11.8 21.85C12 21.85 12.1 21.85 12.3 21.75L20.1 17.25C20.4 17.05 20.6 16.75 20.6 16.45V7.45C20.6 7.15 20.4 6.75 20.1 6.65ZM5 15.85V7.95L11.8 4.05L18.6 7.95L11.8 11.95V19.85L5 15.85Z"
                                        fill="black" />
                                </svg>
                            </span>
                        </span>
                        <span class="menu-title">Catalog</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        @if (showModule('brands', $permissions))
                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('admin.brands') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Brands</span>
                            </a>
                        </div>
                        @endif
                        @if (showModule('categories', $permissions))
                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('admin.categories') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Categories</span>
                            </a>
                        </div>
                        @endif
                        @if (showModule('items', $permissions))
                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('admin.items') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Items</span>
                            </a>
                        </div>
                        @endif
                        @if (showModule('promo_products', $permissions))
                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('admin.promo_products') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Promo Products</span>
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                @if (showModule('unit_conversions', $permissions)||showModule('ingredients', $permissions)||showModule('stock_card', $permissions)||showModule('adjusment', $permissions)||showModule('warehouse', $permissions))
                <div data-kt-menu-trigger="click" class="menu-item here menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11 2.375L2 9.575V20.575C2 21.175 2.4 21.575 3 21.575H9C9.6 21.575 10 21.175 10 20.575V14.575C10 13.975 10.4 13.575 11 13.575H13C13.6 13.575 14 13.975 14 14.575V20.575C14 21.175 14.4 21.575 15 21.575H21C21.6 21.575 22 21.175 22 20.575V9.575L13 2.375C12.4 1.875 11.6 1.875 11 2.375Z" fill="currentColor"/>
                                    </svg>
                            </span>
                        </span>
                        <span class="menu-title">Warehouse</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        @if (showModule('unit_conversions', $permissions))
                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('admin.unit_conversions') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Unit Conversions</span>
                            </a>
                        </div>
                        @endif
                        @if (showModule('ingredients', $permissions))
                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('admin.ingredients') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Ingredients</span>
                            </a>
                        </div>
                        @endif
                        @if (showModule('stock_card', $permissions))
                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('admin.stock_card') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Stock Card</span>
                            </a>
                        </div>
                        @endif
                        @if (showModule('adjusment', $permissions))
                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('admin.adjusment') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Adjusment</span>
                            </a>
                        </div>
                        @endif
                        @if (showModule('warehouse', $permissions))
                        <div class="menu-sub menu-sub-accordion menu-active-bg">
                            <div class="menu-item">
                                <a class="menu-link" href="{{ route('admin.warehouse.detail') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Stock Warehouse</span>
                                </a>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                @if (showModule('buys', $permissions))
                <div class="menu-item here menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M20 8H16C15.4 8 15 8.4 15 9V16H10V17C10 17.6 10.4 18 11 18H16C16 16.9 16.9 16 18 16C19.1 16 20 16.9 20 18H21C21.6 18 22 17.6 22 17V13L20 8Z" fill="currentColor"/>
                                    <path opacity="0.3" d="M20 18C20 19.1 19.1 20 18 20C16.9 20 16 19.1 16 18C16 16.9 16.9 16 18 16C19.1 16 20 16.9 20 18ZM15 4C15 3.4 14.6 3 14 3H3C2.4 3 2 3.4 2 4V13C2 13.6 2.4 14 3 14H15V4ZM6 16C4.9 16 4 16.9 4 18C4 19.1 4.9 20 6 20C7.1 20 8 19.1 8 18C8 16.9 7.1 16 6 16Z" fill="currentColor"/>
                                </svg>
                            </span>
                        </span>
                        <a href="{{ route('admin.buys') }}" class="menu-title">Purchase</a>
                    </span>
                </div>
                @endif
                
                @if (showModule('produksi', $permissions))
                <div class="menu-item here menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.3" d="M20.0381 4V10C20.0381 10.6 19.6381 11 19.0381 11H17.0381C16.4381 11 16.0381 10.6 16.0381 10V4C16.0381 2.9 16.9381 2 18.0381 2C19.1381 2 20.0381 2.9 20.0381 4ZM9.73808 18.9C10.7381 18.5 11.2381 17.3 10.8381 16.3L5.83808 3.29999C5.43808 2.29999 4.23808 1.80001 3.23808 2.20001C2.23808 2.60001 1.73809 3.79999 2.13809 4.79999L7.13809 17.8C7.43809 18.6 8.23808 19.1 9.03808 19.1C9.23808 19 9.53808 19 9.73808 18.9ZM19.0381 18H17.0381V20H19.0381V18Z" fill="currentColor"/>
                                    <path d="M18.0381 6H4.03809C2.93809 6 2.03809 5.1 2.03809 4C2.03809 2.9 2.93809 2 4.03809 2H18.0381C19.1381 2 20.0381 2.9 20.0381 4C20.0381 5.1 19.1381 6 18.0381 6ZM4.03809 3C3.43809 3 3.03809 3.4 3.03809 4C3.03809 4.6 3.43809 5 4.03809 5C4.63809 5 5.03809 4.6 5.03809 4C5.03809 3.4 4.63809 3 4.03809 3ZM18.0381 3C17.4381 3 17.0381 3.4 17.0381 4C17.0381 4.6 17.4381 5 18.0381 5C18.6381 5 19.0381 4.6 19.0381 4C19.0381 3.4 18.6381 3 18.0381 3ZM12.0381 17V22H6.03809V17C6.03809 15.3 7.33809 14 9.03809 14C10.7381 14 12.0381 15.3 12.0381 17ZM9.03809 15.5C8.23809 15.5 7.53809 16.2 7.53809 17C7.53809 17.8 8.23809 18.5 9.03809 18.5C9.83809 18.5 10.5381 17.8 10.5381 17C10.5381 16.2 9.83809 15.5 9.03809 15.5ZM15.0381 15H17.0381V13H16.0381V8L14.0381 10V14C14.0381 14.6 14.4381 15 15.0381 15ZM19.0381 15H21.0381C21.6381 15 22.0381 14.6 22.0381 14V10L20.0381 8V13H19.0381V15ZM21.0381 20H15.0381V22H21.0381V20Z" fill="currentColor"/>
                                </svg>
                            </span>
                        </span>
                        <a href="{{ route('admin.produksi') }}" class="menu-title">Production</a>
                    </span>
                </div>
                @endif

                @if (showModule('orders', $permissions))
                <div class="menu-item here menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none">
                                    <path opacity="0.3"
                                        d="M18.041 22.041C18.5932 22.041 19.041 21.5932 19.041 21.041C19.041 20.4887 18.5932 20.041 18.041 20.041C17.4887 20.041 17.041 20.4887 17.041 21.041C17.041 21.5932 17.4887 22.041 18.041 22.041Z"
                                        fill="black" />
                                    <path opacity="0.3"
                                        d="M6.04095 22.041C6.59324 22.041 7.04095 21.5932 7.04095 21.041C7.04095 20.4887 6.59324 20.041 6.04095 20.041C5.48867 20.041 5.04095 20.4887 5.04095 21.041C5.04095 21.5932 5.48867 22.041 6.04095 22.041Z"
                                        fill="black" />
                                    <path opacity="0.3"
                                        d="M7.04095 16.041L19.1409 15.1409C19.7409 15.1409 20.141 14.7409 20.341 14.1409L21.7409 8.34094C21.9409 7.64094 21.4409 7.04095 20.7409 7.04095H5.44095L7.04095 16.041Z"
                                        fill="black" />
                                    <path
                                        d="M19.041 20.041H5.04096C4.74096 20.041 4.34095 19.841 4.14095 19.541C3.94095 19.241 3.94095 18.841 4.14095 18.541L6.04096 14.841L4.14095 4.64095L2.54096 3.84096C2.04096 3.64096 1.84095 3.04097 2.14095 2.54097C2.34095 2.04097 2.94096 1.84095 3.44096 2.14095L5.44096 3.14095C5.74096 3.24095 5.94096 3.54096 5.94096 3.84096L7.94096 14.841C7.94096 15.041 7.94095 15.241 7.84095 15.441L6.54096 18.041H19.041C19.641 18.041 20.041 18.441 20.041 19.041C20.041 19.641 19.641 20.041 19.041 20.041Z"
                                        fill="black" />
                                </svg>
                            </span>
                        </span>
                        <a href="{{ route('admin.orders') }}" class="menu-title">Orders</a>
                    </span>
                </div>
                @endif

                @if (showModule('sales', $permissions))
                <div class="menu-item here menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24"/>
                                    <path d="M5.94290508,4 L18.0570949,4 C18.5865712,4 19.0242774,4.41271535 19.0553693,4.94127798 L19.8754445,18.882556 C19.940307,19.9852194 19.0990032,20.9316862 17.9963398,20.9965487 C17.957234,20.9988491 17.9180691,21 17.8788957,21 L6.12110428,21 C5.01653478,21 4.12110428,20.1045695 4.12110428,19 C4.12110428,18.9608266 4.12225519,18.9216617 4.12455553,18.882556 L4.94463071,4.94127798 C4.97572263,4.41271535 5.41342877,4 5.94290508,4 Z" fill="#000000" opacity="0.3"/>
                                    <path d="M7,7 L9,7 C9,8.65685425 10.3431458,10 12,10 C13.6568542,10 15,8.65685425 15,7 L17,7 C17,9.76142375 14.7614237,12 12,12 C9.23857625,12 7,9.76142375 7,7 Z" fill="#000000"/>
                                </g>
                            </svg></span>
                        </span>
                        <a href="{{ route('admin.sales') }}" class="menu-title">Sales</a>
                    </span>
                </div>
                @endif

                @if (showModule('delivery_note', $permissions))
                <div class="menu-item here menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24"/>
                                    <path d="M5,9 L19,9 C20.1045695,9 21,9.8954305 21,11 L21,20 C21,21.1045695 20.1045695,22 19,22 L5,22 C3.8954305,22 3,21.1045695 3,20 L3,11 C3,9.8954305 3.8954305,9 5,9 Z M18.1444251,10.8396467 L12,14.1481833 L5.85557487,10.8396467 C5.4908718,10.6432681 5.03602525,10.7797221 4.83964668,11.1444251 C4.6432681,11.5091282 4.77972206,11.9639747 5.14442513,12.1603533 L11.6444251,15.6603533 C11.8664074,15.7798822 12.1335926,15.7798822 12.3555749,15.6603533 L18.8555749,12.1603533 C19.2202779,11.9639747 19.3567319,11.5091282 19.1603533,11.1444251 C18.9639747,10.7797221 18.5091282,10.6432681 18.1444251,10.8396467 Z" fill="#000000"/>
                                    <path d="M11.1288761,0.733697713 L11.1288761,2.69017121 L9.12120481,2.69017121 C8.84506244,2.69017121 8.62120481,2.91402884 8.62120481,3.19017121 L8.62120481,4.21346991 C8.62120481,4.48961229 8.84506244,4.71346991 9.12120481,4.71346991 L11.1288761,4.71346991 L11.1288761,6.66994341 C11.1288761,6.94608579 11.3527337,7.16994341 11.6288761,7.16994341 C11.7471877,7.16994341 11.8616664,7.12798964 11.951961,7.05154023 L15.4576222,4.08341738 C15.6683723,3.90498251 15.6945689,3.58948575 15.5161341,3.37873564 C15.4982803,3.35764848 15.4787093,3.33807751 15.4576222,3.32022374 L11.951961,0.352100892 C11.7412109,0.173666017 11.4257142,0.199862688 11.2472793,0.410612793 C11.1708299,0.500907473 11.1288761,0.615386087 11.1288761,0.733697713 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(11.959697, 3.661508) rotate(-90.000000) translate(-11.959697, -3.661508) "/>
                                </g>
                            </svg></span>
                        </span>
                        <a href="{{ route('admin.delivery_note') }}" class="menu-title">Delivery Note</a>
                    </span>
                </div>
                @endif

                @if (showModule('invoice_sales', $permissions))
                <div class="menu-item here menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/keen/releases/2021-04-21-040700/theme/demo2/dist/../src/media/svg/icons/Communication/Clipboard-list.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24"/>
                                    <path d="M8,3 L8,3.5 C8,4.32842712 8.67157288,5 9.5,5 L14.5,5 C15.3284271,5 16,4.32842712 16,3.5 L16,3 L18,3 C19.1045695,3 20,3.8954305 20,5 L20,21 C20,22.1045695 19.1045695,23 18,23 L6,23 C4.8954305,23 4,22.1045695 4,21 L4,5 C4,3.8954305 4.8954305,3 6,3 L8,3 Z" fill="#000000" opacity="0.3"/>
                                    <path d="M11,2 C11,1.44771525 11.4477153,1 12,1 C12.5522847,1 13,1.44771525 13,2 L14.5,2 C14.7761424,2 15,2.22385763 15,2.5 L15,3.5 C15,3.77614237 14.7761424,4 14.5,4 L9.5,4 C9.22385763,4 9,3.77614237 9,3.5 L9,2.5 C9,2.22385763 9.22385763,2 9.5,2 L11,2 Z" fill="#000000"/>
                                    <rect fill="#000000" opacity="0.3" x="10" y="9" width="7" height="2" rx="1"/>
                                    <rect fill="#000000" opacity="0.3" x="7" y="9" width="2" height="2" rx="1"/>
                                    <rect fill="#000000" opacity="0.3" x="7" y="13" width="2" height="2" rx="1"/>
                                    <rect fill="#000000" opacity="0.3" x="10" y="13" width="7" height="2" rx="1"/>
                                    <rect fill="#000000" opacity="0.3" x="7" y="17" width="2" height="2" rx="1"/>
                                    <rect fill="#000000" opacity="0.3" x="10" y="17" width="7" height="2" rx="1"/>
                                </g>
                            </svg><!--end::Svg Icon--></span>
                        </span>
                        <a href="{{ route('admin.invoice_sales') }}" class="menu-title">Invoice Sales</a>
                    </span>
                </div>
                @endif

                @if (showModule('customers', $permissions)||showModule('customer_groups', $permissions)||showModule('visitors', $permissions)||showModule('menu_managements', $permissions)||showModule('store', $permissions)||showModule('human_resource', $permissions)||showModule('user_groups', $permissions)||showModule('user_groups', $permissions)||showModule('companies', $permissions)||showModule('payments', $permissions)||showModule('systems', $permissions))
                <div class="menu-item show">
                    <span class="menu-link">
                        <p href="{{ route('admin.dashboard') }}" class="menu-title m-0">Non Product</p>
                    </span>
                </div>
                @endif

                @if (showModule('customers', $permissions)||showModule('customer_groups', $permissions))
                <div data-kt-menu-trigger="click" class="menu-item here menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none">
                                    <path opacity="0.3"
                                        d="M22 12C22 17.5 17.5 22 12 22C6.5 22 2 17.5 2 12C2 6.5 6.5 2 12 2C17.5 2 22 6.5 22 12ZM12 7C10.3 7 9 8.3 9 10C9 11.7 10.3 13 12 13C13.7 13 15 11.7 15 10C15 8.3 13.7 7 12 7Z"
                                        fill="black" />
                                    <path
                                        d="M12 22C14.6 22 17 21 18.7 19.4C17.9 16.9 15.2 15 12 15C8.8 15 6.09999 16.9 5.29999 19.4C6.99999 21 9.4 22 12 22Z"
                                        fill="black" />
                                </svg>
                            </span>
                        </span>
                        <span class="menu-title">Customer</span>
                        <span class="menu-arrow"></span>
                    </span>
                    @if (showModule('customer_groups', $permissions))
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('admin.customer_group') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Customer Group</span>
                            </a>
                        </div>
                        @endif
                        @if (showModule('customers', $permissions))
                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('admin.customers') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Customers</span>
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                @if (showModule('visitors', $permissions))
                <div class="menu-item here menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none">
                                    <path
                                        d="M20 14H18V10H20C20.6 10 21 10.4 21 11V13C21 13.6 20.6 14 20 14ZM21 19V17C21 16.4 20.6 16 20 16H18V20H20C20.6 20 21 19.6 21 19ZM21 7V5C21 4.4 20.6 4 20 4H18V8H20C20.6 8 21 7.6 21 7Z"
                                        fill="black" />
                                    <path opacity="0.3"
                                        d="M17 22H3C2.4 22 2 21.6 2 21V3C2 2.4 2.4 2 3 2H17C17.6 2 18 2.4 18 3V21C18 21.6 17.6 22 17 22ZM10 7C8.9 7 8 7.9 8 9C8 10.1 8.9 11 10 11C11.1 11 12 10.1 12 9C12 7.9 11.1 7 10 7ZM13.3 16C14 16 14.5 15.3 14.3 14.7C13.7 13.2 12 12 10.1 12C8.10001 12 6.49999 13.1 5.89999 14.7C5.59999 15.3 6.19999 16 7.39999 16H13.3Z"
                                        fill="black" />
                                </svg>
                            </span>
                        </span>
                        <a href="{{ route('admin.visitors') }}" class="menu-title">Visitors</a>
                    </span>
                </div>
                @endif
                
                @if (showModule('menu_managements', $permissions))
                <div class="menu-item here menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none">
                                    <path opacity="0.3"
                                        d="M21 22H14C13.4 22 13 21.6 13 21V3C13 2.4 13.4 2 14 2H21C21.6 2 22 2.4 22 3V21C22 21.6 21.6 22 21 22Z"
                                        fill="black"></path>
                                    <path
                                        d="M10 22H3C2.4 22 2 21.6 2 21V3C2 2.4 2.4 2 3 2H10C10.6 2 11 2.4 11 3V21C11 21.6 10.6 22 10 22Z"
                                        fill="black"></path>
                                </svg>
                            </span>
                        </span>
                        <a href="{{ route('menu-management.index') }}"><span class="menu-title">Menu
                                Management</span></a>
                    </span>
                </div>
                @endif
                
                @if (showModule('store', $permissions))
                <div class="menu-item here menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none">
                                    <path opacity="0.3"
                                        d="M18 10V20C18 20.6 18.4 21 19 21C19.6 21 20 20.6 20 20V10H18Z"
                                        fill="black" />
                                    <path opacity="0.3"
                                        d="M11 10V17H6V10H4V20C4 20.6 4.4 21 5 21H12C12.6 21 13 20.6 13 20V10H11Z"
                                        fill="black" />
                                    <path opacity="0.3" d="M10 10C10 11.1 9.1 12 8 12C6.9 12 6 11.1 6 10H10Z"
                                        fill="black" />
                                    <path opacity="0.3" d="M18 10C18 11.1 17.1 12 16 12C14.9 12 14 11.1 14 10H18Z"
                                        fill="black" />
                                    <path opacity="0.3" d="M14 4H10V10H14V4Z" fill="black" />
                                    <path opacity="0.3" d="M17 4H20L22 10H18L17 4Z" fill="black" />
                                    <path opacity="0.3" d="M7 4H4L2 10H6L7 4Z" fill="black" />
                                    <path
                                        d="M6 10C6 11.1 5.1 12 4 12C2.9 12 2 11.1 2 10H6ZM10 10C10 11.1 10.9 12 12 12C13.1 12 14 11.1 14 10H10ZM18 10C18 11.1 18.9 12 20 12C21.1 12 22 11.1 22 10H18ZM19 2H5C4.4 2 4 2.4 4 3V4H20V3C20 2.4 19.6 2 19 2ZM12 17C12 16.4 11.6 16 11 16H6C5.4 16 5 16.4 5 17C5 17.6 5.4 18 6 18H11C11.6 18 12 17.6 12 17Z"
                                        fill="black" />
                                </svg>
                            </span>
                        </span>
                        <a href="{{ route('admin.store') }}"><span class="menu-title">Store</span></a>
                    </span>
                </div>
                @endif

                @if (showModule('human_resource', $permissions))
                <div data-kt-menu-trigger="click" class="menu-item here menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M6.28548 15.0861C7.34369 13.1814 9.35142 12 11.5304 12H12.4696C14.6486 12 16.6563 13.1814 17.7145 15.0861L19.3493 18.0287C20.0899 19.3618 19.1259 21 17.601 21H6.39903C4.87406 21 3.91012 19.3618 4.65071 18.0287L6.28548 15.0861Z"
                                        fill="currentColor" />
                                    <rect opacity="0.3" x="8" y="3" width="8"
                                        height="8" rx="4" fill="currentColor" />
                                </svg>
                            </span>
                        </span>
                        <span class="menu-title">Human Resource</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('admin.human_resource') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Employee</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('admin.human_resource.log') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Log </span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('admin.human_resource.setting') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Setting </span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('admin.human_resource.pengajuan_absensi') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Pengajuan Absensi </span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('admin.human_resource.rekap_absensi_per_bulan') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Rekap Absensi Per Bulan </span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('admin.human_resource.rekap_absensi_per_tahun') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Rekap Absensi Per Tahun </span>
                            </a>
                        </div>
                    </div>
                </div>
                @endif

                @if (showModule('user_groups', $permissions)||showModule('user_groups', $permissions))
                <div data-kt-menu-trigger="click" class="menu-item here menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none">
                                    <path
                                        d="M16.0173 9H15.3945C14.2833 9 13.263 9.61425 12.7431 10.5963L12.154 11.7091C12.0645 11.8781 12.1072 12.0868 12.2559 12.2071L12.6402 12.5183C13.2631 13.0225 13.7556 13.6691 14.0764 14.4035L14.2321 14.7601C14.2957 14.9058 14.4396 15 14.5987 15H18.6747C19.7297 15 20.4057 13.8774 19.912 12.945L18.6686 10.5963C18.1487 9.61425 17.1285 9 16.0173 9Z"
                                        fill="black" />
                                    <rect opacity="0.3" x="14" y="4" width="4"
                                        height="4" rx="2" fill="black" />
                                    <path
                                        d="M4.65486 14.8559C5.40389 13.1224 7.11161 12 9 12C10.8884 12 12.5961 13.1224 13.3451 14.8559L14.793 18.2067C15.3636 19.5271 14.3955 21 12.9571 21H5.04292C3.60453 21 2.63644 19.5271 3.20698 18.2067L4.65486 14.8559Z"
                                        fill="black" />
                                    <rect opacity="0.3" x="6" y="5" width="6"
                                        height="6" rx="3" fill="black" />
                                </svg>
                            </span>
                        </span>
                        <span class="menu-title">User Management</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        @if (showModule('user_groups', $permissions))
                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('admin.user_groups') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">User Groups</span>
                            </a>
                        </div>
                        @endif
                        @if (showModule('users', $permissions))
                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('admin.users') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Users</span>
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
                
                @if (showModule('companies', $permissions))
                <div class="menu-item here menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path opacity="0.3" d="M2 21h20V10H2v11zm4-3h4v-3H6v3zm14-1h-3v-2h3v2zm0-3h-3V7h3v7zM6 7h4V4H6v3z" fill="black" />
                                    <path d="M17 2v6h6V2h-6zm4 4h-4V4h4v2zm0 10h-3v-2h3v2zm0-3h-3v-2h3v2zM6 9H2V7h4v2z" fill="black" />
                                </svg>                                
                            </span>
                        </span>
                        <a href="{{ route('admin.companies') }}"><span class="menu-title">Company</span></a>
                    </span>
                </div>
                @endif

                @if (showModule('systems', $permissions))
                <div data-kt-menu-trigger="click" class="menu-item here menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none">
                                    <path d="M2 16C2 16.6 2.4 17 3 17H21C21.6 17 22 16.6 22 16V15H2V16Z"
                                        fill="black" />
                                    <path opacity="0.3" d="M21 3H3C2.4 3 2 3.4 2 4V15H22V4C22 3.4 21.6 3 21 3Z"
                                        fill="black" />
                                    <path opacity="0.3" d="M15 17H9V20H15V17Z" fill="black" />
                                </svg>
                            </span>
                        </span>
                        <span class="menu-title">System</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('admin.logs') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Logs</span>
                            </a>
                        </div>
                    </div>
                </div>
                @endif
                
                @if (showModule('payments', $permissions))
                <div class="menu-item here menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/keen/releases/2021-04-21-040700/theme/demo2/dist/../src/media/svg/icons/Shopping/Credit-card.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24"/>
                                    <rect fill="#000000" opacity="0.3" x="2" y="5" width="20" height="14" rx="2"/>
                                    <rect fill="#000000" x="2" y="8" width="20" height="3"/>
                                    <rect fill="#000000" opacity="0.3" x="16" y="14" width="4" height="2" rx="1"/>
                                </g>
                            </svg><!--end::Svg Icon--></span>
                        </span>
                        <a href="{{ route('admin.bank_accounts') }}"><span class="menu-title">Bank Accounts</span></a>
                    </span>
                </div>
                @endif

                @if (showModule('article_categories', $permissions)||showModule('article', $permissions)||showModule('banners', $permissions)||showModule('pages', $permissions)||showModule('settings', $permissions))
                <div class="menu-item show">
                    <span class="menu-link">
                        <p href="{{ route('admin.dashboard') }}" class="menu-title m-0">Content</p>
                    </span>
                </div>
                @endif

                @if (showModule('article_categories', $permissions)||showModule('article', $permissions))
                <div data-kt-menu-trigger="click" class="menu-item here menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="19"
                                    viewBox="0 0 16 19" fill="none">
                                    <path
                                        d="M12 0.400024H1C0.4 0.400024 0 0.800024 0 1.40002V2.40002C0 3.00002 0.4 3.40002 1 3.40002H12C12.6 3.40002 13 3.00002 13 2.40002V1.40002C13 0.800024 12.6 0.400024 12 0.400024Z"
                                        fill="black" />
                                    <path opacity="0.3"
                                        d="M15 8.40002H1C0.4 8.40002 0 8.00002 0 7.40002C0 6.80002 0.4 6.40002 1 6.40002H15C15.6 6.40002 16 6.80002 16 7.40002C16 8.00002 15.6 8.40002 15 8.40002ZM16 12.4C16 11.8 15.6 11.4 15 11.4H1C0.4 11.4 0 11.8 0 12.4C0 13 0.4 13.4 1 13.4H15C15.6 13.4 16 13 16 12.4ZM12 17.4C12 16.8 11.6 16.4 11 16.4H1C0.4 16.4 0 16.8 0 17.4C0 18 0.4 18.4 1 18.4H11C11.6 18.4 12 18 12 17.4Z"
                                        fill="black" />
                                </svg>
                            </span>
                        </span>
                        <span class="menu-title">Article</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        @if (showModule('article_categories', $permissions))
                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('admin.article_categories') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Category</span>
                            </a>
                        </div>
                        @endif
                        @if (showModule('article', $permissions))
                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('admin.article') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Article</span>
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                @if (showModule('banners', $permissions))
                <div class="menu-item show menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none">
                                    <path opacity="0.3"
                                        d="M22 5V19C22 19.6 21.6 20 21 20H19.5L11.9 12.4C11.5 12 10.9 12 10.5 12.4L3 20C2.5 20 2 19.5 2 19V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5ZM7.5 7C6.7 7 6 7.7 6 8.5C6 9.3 6.7 10 7.5 10C8.3 10 9 9.3 9 8.5C9 7.7 8.3 7 7.5 7Z"
                                        fill="black" />
                                    <path
                                        d="M19.1 10C18.7 9.60001 18.1 9.60001 17.7 10L10.7 17H2V19C2 19.6 2.4 20 3 20H21C21.6 20 22 19.6 22 19V12.9L19.1 10Z"
                                        fill="black" />
                                </svg>
                            </span>
                        </span>
                        <a href="{{ route('admin.banners') }}" class="menu-title">Banners</a>
                    </span>
                </div>
                @endif
                
                @if (showModule('pages', $permissions))
                <div class="menu-item here menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none">
                                    <rect x="2" y="2" width="9" height="9"
                                        rx="2" fill="black" />
                                    <rect opacity="0.3" x="13" y="2" width="9"
                                        height="9" rx="2" fill="black" />
                                    <rect opacity="0.3" x="13" y="13" width="9"
                                        height="9" rx="2" fill="black" />
                                    <rect opacity="0.3" x="2" y="13" width="9"
                                        height="9" rx="2" fill="black" />
                                </svg>
                            </span>
                        </span>
                        <a href="{{ route('admin.pages') }}"><span class="menu-title">Pages</span></a>
                    </span>
                </div>
                @endif
                
                @if (showModule('settings', $permissions))
                <div data-kt-menu-trigger="click" class="menu-item here menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none">
                                    <path opacity="0.3"
                                        d="M22.1 11.5V12.6C22.1 13.2 21.7 13.6 21.2 13.7L19.9 13.9C19.7 14.7 19.4 15.5 18.9 16.2L19.7 17.2999C20 17.6999 20 18.3999 19.6 18.7999L18.8 19.6C18.4 20 17.8 20 17.3 19.7L16.2 18.9C15.5 19.3 14.7 19.7 13.9 19.9L13.7 21.2C13.6 21.7 13.1 22.1 12.6 22.1H11.5C10.9 22.1 10.5 21.7 10.4 21.2L10.2 19.9C9.4 19.7 8.6 19.4 7.9 18.9L6.8 19.7C6.4 20 5.7 20 5.3 19.6L4.5 18.7999C4.1 18.3999 4.1 17.7999 4.4 17.2999L5.2 16.2C4.8 15.5 4.4 14.7 4.2 13.9L2.9 13.7C2.4 13.6 2 13.1 2 12.6V11.5C2 10.9 2.4 10.5 2.9 10.4L4.2 10.2C4.4 9.39995 4.7 8.60002 5.2 7.90002L4.4 6.79993C4.1 6.39993 4.1 5.69993 4.5 5.29993L5.3 4.5C5.7 4.1 6.3 4.10002 6.8 4.40002L7.9 5.19995C8.6 4.79995 9.4 4.39995 10.2 4.19995L10.4 2.90002C10.5 2.40002 11 2 11.5 2H12.6C13.2 2 13.6 2.40002 13.7 2.90002L13.9 4.19995C14.7 4.39995 15.5 4.69995 16.2 5.19995L17.3 4.40002C17.7 4.10002 18.4 4.1 18.8 4.5L19.6 5.29993C20 5.69993 20 6.29993 19.7 6.79993L18.9 7.90002C19.3 8.60002 19.7 9.39995 19.9 10.2L21.2 10.4C21.7 10.5 22.1 11 22.1 11.5ZM12.1 8.59998C10.2 8.59998 8.6 10.2 8.6 12.1C8.6 14 10.2 15.6 12.1 15.6C14 15.6 15.6 14 15.6 12.1C15.6 10.2 14 8.59998 12.1 8.59998Z"
                                        fill="black" />
                                    <path
                                        d="M17.1 12.1C17.1 14.9 14.9 17.1 12.1 17.1C9.30001 17.1 7.10001 14.9 7.10001 12.1C7.10001 9.29998 9.30001 7.09998 12.1 7.09998C14.9 7.09998 17.1 9.29998 17.1 12.1ZM12.1 10.1C11 10.1 10.1 11 10.1 12.1C10.1 13.2 11 14.1 12.1 14.1C13.2 14.1 14.1 13.2 14.1 12.1C14.1 11 13.2 10.1 12.1 10.1Z"
                                        fill="black" />
                                </svg>
                            </span>
                        </span>
                        <span class="menu-title">Settings</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        @if (showModule('settings', $permissions))
                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('admin.settings.general') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">General</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('admin.settings.company') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">General Company</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('admin.settings.smtp') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">SMTP</span>
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
                @if (showModule('article_categories', $permissions))
                <div class="menu-item show">
                    <span class="menu-link">
                        <p href="{{ route('admin.accurate.token') }}" class="menu-title m-0">Integrasi</p>
                    </span>
                </div>
                @endif
                
                @if (showModule('accurate', $permissions))
                <div data-kt-menu-trigger="click" class="menu-item here menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/keen/releases/2021-04-21-040700/theme/demo2/dist/../src/media/svg/icons/Shopping/Dollar.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24"/>
                                    <rect fill="#000000" opacity="0.3" x="11.5" y="2" width="2" height="4" rx="1"/>
                                    <rect fill="#000000" opacity="0.3" x="11.5" y="16" width="2" height="5" rx="1"/>
                                    <path d="M15.493,8.044 C15.2143319,7.68933156 14.8501689,7.40750104 14.4005,7.1985 C13.9508311,6.98949895 13.5170021,6.885 13.099,6.885 C12.8836656,6.885 12.6651678,6.90399981 12.4435,6.942 C12.2218322,6.98000019 12.0223342,7.05283279 11.845,7.1605 C11.6676658,7.2681672 11.5188339,7.40749914 11.3985,7.5785 C11.2781661,7.74950085 11.218,7.96799867 11.218,8.234 C11.218,8.46200114 11.2654995,8.65199924 11.3605,8.804 C11.4555005,8.95600076 11.5948324,9.08899943 11.7785,9.203 C11.9621676,9.31700057 12.1806654,9.42149952 12.434,9.5165 C12.6873346,9.61150047 12.9723317,9.70966616 13.289,9.811 C13.7450023,9.96300076 14.2199975,10.1308324 14.714,10.3145 C15.2080025,10.4981676 15.6576646,10.7419985 16.063,11.046 C16.4683354,11.3500015 16.8039987,11.7268311 17.07,12.1765 C17.3360013,12.6261689 17.469,13.1866633 17.469,13.858 C17.469,14.6306705 17.3265014,15.2988305 17.0415,15.8625 C16.7564986,16.4261695 16.3733357,16.8916648 15.892,17.259 C15.4106643,17.6263352 14.8596698,17.8986658 14.239,18.076 C13.6183302,18.2533342 12.97867,18.342 12.32,18.342 C11.3573285,18.342 10.4263378,18.1741683 9.527,17.8385 C8.62766217,17.5028317 7.88033631,17.0246698 7.285,16.404 L9.413,14.238 C9.74233498,14.6433354 10.176164,14.9821653 10.7145,15.2545 C11.252836,15.5268347 11.7879973,15.663 12.32,15.663 C12.5606679,15.663 12.7949989,15.6376669 13.023,15.587 C13.2510011,15.5363331 13.4504991,15.4540006 13.6215,15.34 C13.7925009,15.2259994 13.9286662,15.0740009 14.03,14.884 C14.1313338,14.693999 14.182,14.4660013 14.182,14.2 C14.182,13.9466654 14.1186673,13.7313342 13.992,13.554 C13.8653327,13.3766658 13.6848345,13.2151674 13.4505,13.0695 C13.2161655,12.9238326 12.9248351,12.7908339 12.5765,12.6705 C12.2281649,12.5501661 11.8323355,12.420334 11.389,12.281 C10.9583312,12.141666 10.5371687,11.9770009 10.1255,11.787 C9.71383127,11.596999 9.34650161,11.3531682 9.0235,11.0555 C8.70049838,10.7578318 8.44083431,10.3968355 8.2445,9.9725 C8.04816568,9.54816454 7.95,9.03200304 7.95,8.424 C7.95,7.67666293 8.10199848,7.03700266 8.406,6.505 C8.71000152,5.97299734 9.10899753,5.53600171 9.603,5.194 C10.0970025,4.85199829 10.6543302,4.60183412 11.275,4.4435 C11.8956698,4.28516587 12.5226635,4.206 13.156,4.206 C13.9160038,4.206 14.6918294,4.34533194 15.4835,4.624 C16.2751706,4.90266806 16.9686637,5.31433061 17.564,5.859 L15.493,8.044 Z" fill="#000000"/>
                                </g>
                            </svg><!--end::Svg Icon--></span>
                        </span>
                        <span class="menu-title">Accurate</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        @if (showModule('accurate', $permissions))
                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('admin.accurate.token') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Token</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('admin.accurate.sync') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Synchronization</span>
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
                @endif


            </div>
        </div>
    </div>
</div>
