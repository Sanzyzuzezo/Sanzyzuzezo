<?php

namespace Database\Seeders;

use App\Models\Orders;
use App\Models\OrderBillings;
use App\Models\OrderItems;
use App\Models\OrderShippings;
use Illuminate\Database\Seeder;

class OrdersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $orders = [
            [
                'user_id' => 0,
                'customer_id' => 1,
                'invoice_number' => 202202011,
                'status' => 'waiting_for_payment',
                'transaction_date' => '2022-02-01 00:00:00',
                'discount_order' => 5,
                'discount_customer' => 2,
                'total' => 296000,
                'old_total' => 0,
                'total_item' => 0,
                'store_id' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'company_id' => 0
            ],
            [
                'user_id' => 0,
                'customer_id' => 1,
                'invoice_number' => 202202012,
                'status' => 'processed',
                'transaction_date' => '2022-02-01 00:00:00',
                'discount_order' => 10,
                'total' => 100000,
                'old_total' => 0,
                'total_item' => 0,
                'store_id' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'company_id' => 0
            ],
            [
                'user_id' => 0,
                'customer_id' => 1,
                'invoice_number' => 202202013,
                'status' => 'shipping',
                'transaction_date' => '2022-02-01 00:00:00',
                'total' => 100000,
                'old_total' => 0,
                'total_item' => 0,
                'store_id' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'company_id' => 0
            ],
            [
                'user_id' => 0,
                'customer_id' => 1,
                'invoice_number' => 202202014,
                'status' => 'finished',
                'transaction_date' => '2022-02-01 00:00:00',
                'total' => 100000,
                'old_total' => 0,
                'total_item' => 0,
                'store_id' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'company_id' => 0
            ],
            [
                'user_id' => 0,
                'customer_id' => 1,
                'invoice_number' => 202202014,
                'status' => 'complain',
                'transaction_date' => '2022-02-01 00:00:00',
                'total' => 100000,
                'old_total' => 0,
                'total_item' => 0,
                'store_id' => 0,
                'note' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
                'created_at' => date('Y-m-d H:i:s'),
                'company_id' => 0
            ],
        ];
        foreach ($orders as $key => $val) {
            Orders::create($val);
        }
        
        $order_billings = [
            [
                'payment_method' => 'bank transfer',
                'payment_method_id' => 0,
                'order_id' => 2,
                'data' => 'Nl24IBAN34553477847370033',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'payment_method' => 'bank transfer',
                'payment_method_id' => 0,
                'order_id' => 3,
                'data' => 'Nl24IBAN34553477847370033',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'payment_method' => 'bank transfer',
                'payment_method_id' => 0,
                'order_id' => 4,
                'data' => 'Nl24IBAN34553477847370033',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'payment_method' => 'bank transfer',
                'payment_method_id' => 0,
                'order_id' => 5,
                'data' => 'Nl24IBAN34553477847370033',
                'created_at' => date('Y-m-d H:i:s')
            ],
        ];
        foreach ($order_billings as $key => $val) {
            OrderBillings::create($val);
        }
        
        $order_items = [
            [
                'order_id' => 1,
                'product_id' => 1,
                'product_variant_id' => 1,
                'quantity' => 1,
                'price' => 0,
                'grand_total' => 0,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'order_id' => 2,
                'product_id' => 1,
                'product_variant_id' => 1,
                'quantity' => 1,
                'price' => 0,
                'grand_total' => 0,
                'discount_product' => 5,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'order_id' => 3,
                'product_id' => 1,
                'product_variant_id' => 1,
                'quantity' => 1,
                'price' => 0,
                'grand_total' => 0,
                'noted' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'order_id' => 4,
                'product_id' => 1,
                'product_variant_id' => 1,
                'quantity' => 1,
                'price' => 0,
                'grand_total' => 0,
                'discount_product' => 10,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'order_id' => 5,
                'product_id' => 1,
                'product_variant_id' => 1,
                'quantity' => 1,
                'price' => 0,
                'grand_total' => 0,
                'discount_product' => 2,
                'noted' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
                'created_at' => date('Y-m-d H:i:s')
            ],
        ];
        foreach ($order_items as $key => $val) {
            OrderItems::create($val);
        }
        
        $order_shippings = [
            [
                'order_id' => 1,
                'type' => 0,
                'courier' => 'INT',
                'service' => 'ekspress',
                'weight' => 100.00,
                'dimensions' => '{"length":"10","width":"3","height":"2"}',
                'distance' => 1.00,
                'cost' => 10000,
                'address' => '-',
                'store_id' => 0,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'order_id' => 2,
                'type' => 0,
                'courier' => 'INT',
                'service' => 'ekspress',
                'weight' => 100.00,
                'dimensions' => '{"length":"10","width":"3","height":"2"}',
                'distance' => 2.00,
                'cost' => 20000,
                'address' => '-',
                'store_id' => 0,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'order_id' => 3,
                'resi' => 'JNE001',
                'type' => 1,
                'courier' => 'JNE',
                'service' => 'reguler',
                'weight' => 100.00,
                'dimensions' => '{"length":"10","width":"3","height":"2"}',
                'distance' => 1.00,
                'cost' => 11000,
                'address' => '-',
                'store_id' => 0,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'order_id' => 4,
                'resi' => 'JNE002',
                'type' => 1,
                'courier' => 'JNE',
                'service' => 'reguler',
                'weight' => 100.00,
                'dimensions' => '{"length":"10","width":"3","height":"2"}',
                'distance' => 1.10,
                'cost' => 12000,
                'address' => '-',
                'store_id' => 0,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'order_id' => 5,
                'resi' => 'JNT001',
                'type' => 1,
                'courier' => 'JNT',
                'service' => 'reguler',
                'weight' => 100.00,
                'dimensions' => '{"length":"10","width":"3","height":"2"}',
                'distance' => 2.00,
                'cost' => 21000,
                'address' => '-',
                'store_id' => 0,
                'created_at' => date('Y-m-d H:i:s')
            ],
        ];
        foreach ($order_shippings as $key => $val) {
            OrderShippings::create($val);
        }
    }
}
