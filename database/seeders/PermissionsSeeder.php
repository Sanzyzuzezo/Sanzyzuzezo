<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Module;
use App\Models\ModuleAccess;
use DB;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('modules')->truncate();
        DB::table('modules_access')->truncate();
        DB::table('user_group_permissions')->truncate();

        $modules = [
            [
                "identifiers"   => "item_groups",
                "name"          => "Item Groups",
                "access"        => [
                    [
                        "identifiers" => "view",
                        "name"        => "View",
                    ],
                    [
                        "identifiers" => "add",
                        "name"        => "Add",
                    ],
                    [
                        "identifiers" => "edit",
                        "name"        => "Edit",
                    ],
                    [
                        "identifiers" => "delete",
                        "name"        => "Delete",
                    ]
                ]
            ],
            [
                "identifiers"   => "units",
                "name"          => "Units",
                "access"        => [
                    [
                        "identifiers" => "view",
                        "name"        => "View",
                    ],
                    [
                        "identifiers" => "add",
                        "name"        => "Add",
                    ],
                    [
                        "identifiers" => "edit",
                        "name"        => "Edit",
                    ],
                    [
                        "identifiers" => "delete",
                        "name"        => "Delete",
                    ]
                ]
            ],
            [
                "identifiers"   => "warehouse",
                "name"          => "Warehouse",
                "access"        => [
                    [
                        "identifiers" => "view",
                        "name"        => "View",
                    ],
                    [
                        "identifiers" => "add",
                        "name"        => "Add",
                    ],
                    [
                        "identifiers" => "edit",
                        "name"        => "Edit",
                    ],
                    [
                        "identifiers" => "delete",
                        "name"        => "Delete",
                    ],
                    [
                        "identifiers" => "detail",
                        "name"        => "Detail",
                    ]
                ]
            ],
            [
                "identifiers"   => "supplier",
                "name"          => "Supplier",
                "access"        => [
                    [
                        "identifiers" => "view",
                        "name"        => "View",
                    ],
                    [
                        "identifiers" => "add",
                        "name"        => "Add",
                    ],
                    [
                        "identifiers" => "edit",
                        "name"        => "Edit",
                    ],
                    [
                        "identifiers" => "delete",
                        "name"        => "Delete",
                    ]
                ]
            ],
            [
                "identifiers"   => "unit_conversions",
                "name"          => "Unit Conversions",
                "access"        => [
                    [
                        "identifiers" => "view",
                        "name"        => "View",
                    ],
                    [
                        "identifiers" => "add",
                        "name"        => "Add",
                    ],
                    [
                        "identifiers" => "edit",
                        "name"        => "Edit",
                    ],
                    [
                        "identifiers" => "delete",
                        "name"        => "Delete",
                    ]
                ]
            ],
            [
                "identifiers"   => "ingredients",
                "name"          => "Ingredients",
                "access"        => [
                    [
                        "identifiers" => "view",
                        "name"        => "View",
                    ],
                    [
                        "identifiers" => "add",
                        "name"        => "Add",
                    ],
                    [
                        "identifiers" => "edit",
                        "name"        => "Edit",
                    ],
                    [
                        "identifiers" => "delete",
                        "name"        => "Delete",
                    ],
                    [
                        "identifiers" => "detail",
                        "name"        => "Detail",
                    ],
                    [
                        "identifiers" => "duplicate",
                        "name"        => "Duplicate",
                    ]
                ]
            ],
            [
                "identifiers"   => "stock_card",
                "name"          => "Stock Card",
                "access"        => [
                    [
                        "identifiers" => "view",
                        "name"        => "View",
                    ],
                    [
                        "identifiers" => "add",
                        "name"        => "Add",
                    ],
                    [
                        "identifiers" => "edit",
                        "name"        => "Edit",
                    ],
                    [
                        "identifiers" => "delete",
                        "name"        => "Delete",
                    ],
                    [
                        "identifiers" => "detail",
                        "name"        => "Detail",
                    ]
                ]
            ],
            [
                "identifiers"   => "adjusment",
                "name"          => "Adjusment",
                "access"        => [
                    [
                        "identifiers" => "view",
                        "name"        => "View",
                    ],
                    [
                        "identifiers" => "add",
                        "name"        => "Add",
                    ],
                    [
                        "identifiers" => "edit",
                        "name"        => "Edit",
                    ],
                    [
                        "identifiers" => "delete",
                        "name"        => "Delete",
                    ],
                    [
                        "identifiers" => "detail",
                        "name"        => "Detail",
                    ]
                ]
            ],
            [
                "identifiers"   => "brands",
                "name"          => "Brands",
                "access"        =>
                [
                    [
                        "identifiers" => "view",
                        "name"        => "View",
                    ],
                    [
                        "identifiers" => "add",
                        "name"        => "Add",
                    ],
                    [
                        "identifiers" => "edit",
                        "name"        => "Edit",
                    ],
                    [
                        "identifiers" => "delete",
                        "name"        => "Delete",
                    ]
                ]
            ],
            [
                "identifiers"   => "categories",
                "name"          => "Categories",
                "access"        => [
                    [
                        "identifiers" => "view",
                        "name"        => "View",
                    ],
                    [
                        "identifiers" => "add",
                        "name"        => "Add",
                    ],
                    [
                        "identifiers" => "edit",
                        "name"        => "Edit",
                    ],
                    [
                        "identifiers" => "delete",
                        "name"        => "Delete",
                    ],
                    [
                        "identifiers" => "detail",
                        "name"        => "Detail",
                    ]
                ]
            ],
            [
                "identifiers"   => "items",
                "name"          => "Items",
                "access"        => [
                    [
                        "identifiers" => "view",
                        "name"        => "View",
                    ],
                    [
                        "identifiers" => "add",
                        "name"        => "Add",
                    ],
                    [
                        "identifiers" => "edit",
                        "name"        => "Edit",
                    ],
                    [
                        "identifiers" => "delete",
                        "name"        => "Delete",
                    ],
                    [
                        "identifiers" => "detail",
                        "name"        => "Detail",
                    ],
                    [
                        "identifiers" => "duplicate",
                        "name"        => "Duplicate",
                    ]
                ]
            ],
            [
                "identifiers"   => "promo_products",
                "name"          => "Promo Products",
                "access"        => [
                    [
                        "identifiers" => "view",
                        "name"        => "View",
                    ],
                    [
                        "identifiers" => "add",
                        "name"        => "Add",
                    ],
                    [
                        "identifiers" => "edit",
                        "name"        => "Edit",
                    ],
                    [
                        "identifiers" => "delete",
                        "name"        => "Delete",
                    ],
                    [
                        "identifiers" => "detail",
                        "name"        => "Detail",
                    ]
                ]
            ],
            [
                "identifiers"   => "buys",
                "name"          => "Purchase",
                "access"        => [
                    [
                        "identifiers" => "view",
                        "name"        => "View",
                    ],
                    [
                        "identifiers" => "add",
                        "name"        => "Add",
                    ],
                    [
                        "identifiers" => "edit",
                        "name"        => "Edit",
                    ],
                    [
                        "identifiers" => "delete",
                        "name"        => "Delete",
                    ],
                    [
                        "identifiers" => "detail",
                        "name"        => "Detail",
                    ],
                    [
                        "identifiers" => "export",
                        "name"        => "Export",
                    ]
                ]
            ],
            [
                "identifiers"   => "produksi",
                "name"          => "Productions",
                "access"        => [
                    [
                        "identifiers" => "view",
                        "name"        => "View",
                    ],
                    [
                        "identifiers" => "add",
                        "name"        => "Add",
                    ],
                    [
                        "identifiers" => "edit",
                        "name"        => "Edit",
                    ],
                    [
                        "identifiers" => "delete",
                        "name"        => "Delete",
                    ],
                    [
                        "identifiers" => "detail",
                        "name"        => "Detail",
                    ],
                    [
                        "identifiers" => "export",
                        "name"        => "Export",
                    ]
                ]
            ],
            [
                "identifiers"   => "orders",
                "name"          => "Orders",
                "access"        => [
                    [
                        "identifiers" => "view",
                        "name"        => "View",
                    ],
                    [
                        "identifiers" => "add",
                        "name"        => "Add",
                    ],
                    [
                        "identifiers" => "edit",
                        "name"        => "Edit",
                    ],
                    [
                        "identifiers" => "delete",
                        "name"        => "Delete",
                    ],
                    [
                        "identifiers" => "detail",
                        "name"        => "Detail",
                    ],
                    [
                        "identifiers" => "updateStatus",
                        "name"        => "Update Status Order",
                    ],
                    [
                        "identifiers" => "paymentConfirmation",
                        "name"        => "Order Payment Confirmation",
                    ]
                ]
            ],
            [
                "identifiers"   => "sales",
                "name"          => "Sales",
                "access"        => [
                    [
                        "identifiers" => "view",
                        "name"        => "View",
                    ],
                    [
                        "identifiers" => "add",
                        "name"        => "Add",
                    ],
                    [
                        "identifiers" => "edit",
                        "name"        => "Edit",
                    ],
                    [
                        "identifiers" => "delete",
                        "name"        => "Delete",
                    ],
                    [
                        "identifiers" => "detail",
                        "name"        => "Detail",
                    ],
                    [
                        "identifiers" => "export",
                        "name"        => "Export",
                    ]
                ]
            ],
            [
                "identifiers"   => "delivery_note",
                "name"          => "Delivery Note",
                "access"        => [
                    [
                        "identifiers" => "view",
                        "name"        => "View",
                    ],
                    [
                        "identifiers" => "add",
                        "name"        => "Add",
                    ],
                    [
                        "identifiers" => "edit",
                        "name"        => "Edit",
                    ],
                    [
                        "identifiers" => "delete",
                        "name"        => "Delete",
                    ],
                    [
                        "identifiers" => "detail",
                        "name"        => "Detail",
                    ],
                    [
                        "identifiers" => "export",
                        "name"        => "Export",
                    ],
                    [
                        "identifiers" => "sales",
                        "name"        => "Sales",
                    ]
                ]
            ],
            [
                "identifiers"   => "invoice_sales",
                "name"          => "Invoice Sales",
                "access"        => [
                    [
                        "identifiers" => "view",
                        "name"        => "View",
                    ],
                    [
                        "identifiers" => "add",
                        "name"        => "Add",
                    ],
                    [
                        "identifiers" => "edit",
                        "name"        => "Edit",
                    ],
                    [
                        "identifiers" => "delete",
                        "name"        => "Delete",
                    ],
                    [
                        "identifiers" => "detail",
                        "name"        => "Detail",
                    ],
                    [
                        "identifiers" => "export",
                        "name"        => "Export",
                    ],
                    [
                        "identifiers" => "validasi",
                        "name"        => "Proof of Payment",
                    ],
                ]
            ],
            [
                "identifiers"   => "customer_groups",
                "name"          => "Customer Groups",
                "access"        => [
                    [
                        "identifiers" => "view",
                        "name"        => "View",
                    ],
                    [
                        "identifiers" => "add",
                        "name"        => "Add",
                    ],
                    [
                        "identifiers" => "edit",
                        "name"        => "Edit",
                    ],
                    [
                        "identifiers" => "delete",
                        "name"        => "Delete",
                    ],
                    [
                        "identifiers" => "detail",
                        "name"        => "Detail",
                    ]
                ]
            ],
            [
                "identifiers"   => "customers",
                "name"          => "Customers",
                "access"        => [
                    [
                        "identifiers" => "view",
                        "name"        => "View",
                    ],
                    [
                        "identifiers" => "add",
                        "name"        => "Add",
                    ],
                    [
                        "identifiers" => "edit",
                        "name"        => "Edit",
                    ],
                    [
                        "identifiers" => "delete",
                        "name"        => "Delete",
                    ],
                    [
                        "identifiers" => "detail",
                        "name"        => "Detail",
                    ]
                ]
            ],
            [
                "identifiers"   => "article_categories",
                "name"          => "Article Categories",
                "access"        =>
                [
                    [
                        "identifiers" => "view",
                        "name"        => "View",
                    ],
                    [
                        "identifiers" => "add",
                        "name"        => "Add",
                    ],
                    [
                        "identifiers" => "edit",
                        "name"        => "Edit",
                    ],
                    [
                        "identifiers" => "delete",
                        "name"        => "Delete",
                    ]
                ]
            ],
            [
                "identifiers"   => "article",
                "name"          => "Article",
                "access"        =>
                [
                    [
                        "identifiers" => "view",
                        "name"        => "View",
                    ],
                    [
                        "identifiers" => "add",
                        "name"        => "Add",
                    ],
                    [
                        "identifiers" => "edit",
                        "name"        => "Edit",
                    ],
                    [
                        "identifiers" => "delete",
                        "name"        => "Delete",
                    ],
                    [
                        "identifiers" => "detail",
                        "name"        => "Detail",
                    ]
                ]
            ],
            [
                "identifiers"   => "banners",
                "name"          => "Banners",
                "access"        => [
                    [
                        "identifiers" => "view",
                        "name"        => "View",
                    ],
                    [
                        "identifiers" => "add",
                        "name"        => "Add",
                    ],
                    [
                        "identifiers" => "edit",
                        "name"        => "Edit",
                    ],
                    [
                        "identifiers" => "delete",
                        "name"        => "Delete",
                    ],
                    [
                        "identifiers" => "detail",
                        "name"        => "Detail",
                    ]
                ]
            ],
            [
                "identifiers"   => "visitors",
                "name"          => "Visitors",
                "access"        =>
                [
                    [
                        "identifiers" => "view",
                        "name"        => "View",
                    ],
                    [
                        "identifiers" => "delete",
                        "name"        => "Delete",
                    ]
                ]
            ],
            [
                "identifiers"   => "pages",
                "name"          => "Pages",
                "access"        =>
                [
                    [
                        "identifiers" => "view",
                        "name"        => "View",
                    ],
                    [
                        "identifiers" => "add",
                        "name"        => "Add",
                    ],
                    [
                        "identifiers" => "edit",
                        "name"        => "Edit",
                    ],
                    [
                        "identifiers" => "delete",
                        "name"        => "Delete",
                    ],
                    [
                        "identifiers" => "detail",
                        "name"        => "Detail",
                    ]
                ]
            ],
            [
                "identifiers"   => "menu_managements",
                "name"          => "Menu Managements",
                "access"        =>
                [
                    [
                        "identifiers" => "view",
                        "name"        => "View",
                    ],
                    [
                        "identifiers" => "add",
                        "name"        => "Add",
                    ],
                    [
                        "identifiers" => "edit",
                        "name"        => "Edit",
                    ],
                    [
                        "identifiers" => "delete",
                        "name"        => "Delete",
                    ],
                    [
                        "identifiers" => "detail",
                        "name"        => "Detail",
                    ]
                ]
            ],
            [
                "identifiers"   => "store",
                "name"          => "Store",
                "access"        =>
                [
                    [
                        "identifiers" => "view",
                        "name"        => "View",
                    ],
                    [
                        "identifiers" => "add",
                        "name"        => "Add",
                    ],
                    [
                        "identifiers" => "edit",
                        "name"        => "Edit",
                    ],
                    [
                        "identifiers" => "delete",
                        "name"        => "Delete",
                    ],
                    [
                        "identifiers" => "detail",
                        "name"        => "Detail",
                    ]
                ]
            ],
            [
                "identifiers"   => "human_resource",
                "name"          => "Human Resource",
                "access"        =>
                [
                    [
                        "identifiers" => "view",
                        "name"        => "View",
                    ],
                    [
                        "identifiers" => "log",
                        "name"        => "Log",
                    ],
                    [
                        "identifiers" => "setting",
                        "name"        => "Setting",
                    ],
                    [
                        "identifiers" => "export",
                        "name"        => "Export",
                    ],
                    [
                        "identifiers" => "approval",
                        "name"        => "Approval",
                    ]
                ]
            ],
            [
                "identifiers"   => "products",
                "name"          => "Products",
                "access"        =>
                [
                    [
                        "identifiers" => "view",
                        "name"        => "View",
                    ],
                    [
                        "identifiers" => "add",
                        "name"        => "Add",
                    ],
                    [
                        "identifiers" => "edit",
                        "name"        => "Edit",
                    ],
                    [
                        "identifiers" => "delete",
                        "name"        => "Delete",
                    ],
                    [
                        "identifiers" => "detail",
                        "name"        => "Detail",
                    ],
                    [
                        "identifiers" => "duplicate",
                        "name"        => "Duplicate",
                    ],
                    [
                        "identifiers" => "import",
                        "name"        => "Import",
                    ]
                ]
            ],
            [
                "identifiers"   => "user_groups",
                "name"          => "User Groups",
                "access"        =>
                [
                    [
                        "identifiers" => "view",
                        "name"        => "View",
                    ],
                    [
                        "identifiers" => "add",
                        "name"        => "Add",
                    ],
                    [
                        "identifiers" => "edit",
                        "name"        => "Edit",
                    ],
                    [
                        "identifiers" => "delete",
                        "name"        => "Delete",
                    ],
                    [
                        "identifiers" => "detail",
                        "name"        => "Detail",
                    ]
                ]
            ],
            [
                "identifiers"   => "users",
                "name"          => "Users",
                "access"        =>
                [
                    [
                        "identifiers" => "view",
                        "name"        => "View",
                    ],
                    [
                        "identifiers" => "add",
                        "name"        => "Add",
                    ],
                    [
                        "identifiers" => "edit",
                        "name"        => "Edit",
                    ],
                    [
                        "identifiers" => "delete",
                        "name"        => "Delete",
                    ],
                    [
                        "identifiers" => "detail",
                        "name"        => "Detail",
                    ],
                ]
            ],
            [
                "identifiers"   => "companies",
                "name"          => "Companies",
                "access"        =>
                [
                    [
                        "identifiers" => "view",
                        "name"        => "View",
                    ],
                    [
                        "identifiers" => "add",
                        "name"        => "Add",
                    ],
                    [
                        "identifiers" => "edit",
                        "name"        => "Edit",
                    ],
                    [
                        "identifiers" => "delete",
                        "name"        => "Delete",
                    ],
                ]
            ],
            [
                "identifiers"   => "settings",
                "name"          => "Settings",
                "access"        =>
                [
                    [
                        "identifiers" => "general",
                        "name"        => "General",
                    ],
                    [
                        "identifiers" => "smtp",
                        "name"        => "SMTP",
                    ]
                ]
            ],
            [
                "identifiers"   => "payments",
                "name"          => "Bank Accounts",
                "access"        =>
                [
                    [
                        "identifiers" => "view",
                        "name"        => "View",
                    ],
                    [
                        "identifiers" => "add",
                        "name"        => "Add",
                    ],
                    [
                        "identifiers" => "edit",
                        "name"        => "Edit",
                    ],
                    [
                        "identifiers" => "delete",
                        "name"        => "Delete",
                    ]
                ]
            ],
            [
                "identifiers"   => "systems",
                "name"          => "Systems",
                "access"        =>
                [
                    [
                        "identifiers" => "logs",
                        "name"        => "Logs",
                    ]
                ]
            ],
            [
                "identifiers"   => "settings_companies",
                "name"          => "Settings Companies",
                "access"        =>
                [
                    [
                        "identifiers" => "settings_companies",
                        "name"        => "Settings Companies",
                    ],
                ]
            ],

        ];


        foreach ($modules as $data) {
            $data_access = $data['access'];
            $data_module = [
                "identifiers"   => $data["identifiers"],
                "name"          => $data["name"]
            ];
            $module = Module::create($data_module);
            foreach ($data_access as $row) {
                $module->access()->create([
                    "identifiers" => $row["identifiers"],
                    "name"        => $row["name"]
                ]);
            }
        }
    }
}
