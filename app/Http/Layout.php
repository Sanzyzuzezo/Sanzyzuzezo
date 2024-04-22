<?php
namespace App\Http;

use Harimayco\Menu\Models\Menus;
use Harimayco\Menu\Models\MenuItems;
use App\Models\Setting;
use Illuminate\Support\Facades\Cookie;
use App\Models\Pages;
use App\Models\Product;
use DB;

class Layout {

    public static function currentTime() {
        return time();
    }

    public static function getLayout() {
        $menu = Menus::limit(1)->with('items')->first();
        if ($menu !== null) {
            $navbar = Menus::limit(1)->with('items')->first();
        }else{
            $navbar = '-';
        }
        // array_column($settings, 'value', 'name');
        $layout = [
            'navbar' => $navbar,
            // 'navbar' => array_column(Setting::get()->toArray(), 'value', 'name'),
            'settings' => array_column(Setting::get()->toArray(), 'value', 'name'),
            'pages' => Pages::where('status', true)->get()
        ];
        if (!empty($layout['navbar'])) {
            return $layout;
        }

        return [];

    }

    public function notification()
    {
        $company_id = getCompanyId();
        $query_notification = Product::select('products.name AS product_name', 'product_variants.name AS variant_name')
            ->leftJoin('product_variants', 'product_variants.product_id', '=', 'products.id')
            ->leftJoin('stock', 'product_variants.id', '=', 'stock.item_variant_id')
            ->whereRaw("CAST(stock.stock AS INTEGER) < CAST(product_variants.minimal_stock AS INTEGER)");

            if ($company_id !== 0) {
                $query_notification->where('products.company_id', $company_id);
            }       
            $notif = $query_notification->get();

        return $notif;
    }

}
