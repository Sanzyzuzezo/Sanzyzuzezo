<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = [
            [
                'name' => 'site_name',
                'value' => '',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'default_language',
                'value' => '',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'email',
                'value' => '',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'address',
                'value' => '{"kecamatan":null,"kota":null,"provinsi":null,"detail":null}',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'phone',
                'value' => '',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'whatsapp',
                'value' => '',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'email_receive',
                'value' => '[]',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'social_media',
                'value' => '[]',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'logo',
                'value' => '',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'favicon',
                'value' => '',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'min_purchase',
                'value' => '',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'internal_courier_price',
                'value' => '',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'info',
                'value' => '{"jam_masuk":"08:00:00","jam_keluar":"17:00:00","tanggal_tutup_buku":"26"}',
                'created_at' => date('Y-m-d H:i:s')
            ],
        ];
        foreach ($settings as $key => $val) {
            Setting::create($val);
        }
    }
}
