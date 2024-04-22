<?php

namespace Database\Seeders;

use App\Models\SettingCompany;
use Illuminate\Database\Seeder;

class SettingsCompanySeeder extends Seeder
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
                'created_at' => date('Y-m-d H:i:s'),
                'company_id' => 0,
            ],
            [
                'name' => 'default_language',
                'value' => '',
                'created_at' => date('Y-m-d H:i:s'),
                'company_id' => 0,
            ],
            [
                'name' => 'email',
                'value' => '',
                'created_at' => date('Y-m-d H:i:s'),
                'company_id' => 0,
            ],
            [
                'name' => 'address',
                'value' => '{"kecamatan":null,"kota":null,"provinsi":null,"detail":null}',
                'created_at' => date('Y-m-d H:i:s'),
                'company_id' => 0,
            ],
            [
                'name' => 'phone',
                'value' => '',
                'created_at' => date('Y-m-d H:i:s'),
                'company_id' => 0,
            ],
            [
                'name' => 'whatsapp',
                'value' => '',
                'created_at' => date('Y-m-d H:i:s'),
                'company_id' => 0,
            ],
            [
                'name' => 'email_receive',
                'value' => '[]',
                'created_at' => date('Y-m-d H:i:s'),
                'company_id' => 0,
            ],
            [
                'name' => 'social_media',
                'value' => '[]',
                'created_at' => date('Y-m-d H:i:s'),
                'company_id' => 0,
            ],
            [
                'name' => 'logo',
                'value' => '',
                'created_at' => date('Y-m-d H:i:s'),
                'company_id' => 0,
            ],
            [
                'name' => 'favicon',
                'value' => '',
                'created_at' => date('Y-m-d H:i:s'),
                'company_id' => 0,
            ],
            [
                'name' => 'min_purchase',
                'value' => '',
                'created_at' => date('Y-m-d H:i:s'),
                'company_id' => 0,
            ],
            [
                'name' => 'internal_courier_price',
                'value' => '',
                'created_at' => date('Y-m-d H:i:s'),
                'company_id' => 0,
            ],
            [
                'name' => 'info',
                'value' => '{"jam_masuk":"08:00:00","jam_keluar":"17:00:00","tanggal_tutup_buku":"26"}',
                'created_at' => date('Y-m-d H:i:s'),
                'company_id' => 0,
            ],
            [
                'name' => 'gudang_penjualan',
                'value' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'company_id' => 0,
            ],
        ];
        foreach ($settings as $key => $val) {
            SettingCompany::create($val);
        }
    }
}
