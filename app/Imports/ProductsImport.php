<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\ProductVariant;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Conserns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Throwable;

class ProductsImport implements ToCollection, WithHeadingRow, WithValidation
{
    public function __construct($brand, $category)
    {
        $this->brand_id = $brand;
        $this->category_id = $category;
    }

    public function rules(): array
    {
        return [
            'name' => ["required"],
            'description' => ["required"],
            'variant_sku' => ["required"],
            'variant_name' => ["required"],
            'variant_price' => ["required"],
            'variant_minimal_stock' => ["required"],
            // 'variant_stock' => ["required"],
        ];
    }

    public function customValidationMessages(){
        return [
            "name" => "name is required",
            'description' => "required",
            'variant_sku' => "required",
            'variant_name' => "required",
            'variant_price' => "required",
            'variant_minimal_stock' => "required",
            // 'variant_stock' => "required",
        ];
    }

    public function collection(Collection $rows)
    {
        $company_id = getCompanyId();

        foreach ($rows as $row) {

            $product = Product::create([
                'name'              => $row['name'],
                'description'       => $row['description'],
                'brand_id'          => $this->brand_id,
                'category_id'       => $this->category_id,
                'status'            => true,
                'company_id'        => $company_id,
            ]);

            $product->variants()->create([
                'sku'           => $row['variant_sku'],
                'name'          => $row['variant_name'],
                'description'   => $row['variant_description'],
                'price'         => str_replace(',', '', $row['variant_price']),
                'minimal_stock' => str_replace(',', '', $row['variant_minimal_stock']),
                // 'stock'         => str_replace(',', '', $row['variant_stock']),
                // 'dimensions'    => str_replace(',', '', isset($row['variant_dimensions']) ? $row['variant_dimensions'] : ''),
                'weight'        => str_replace(',', '', $row['variant_weight']),
                'dimensions'    => '{"length":"'.$row['variant_length'].'","width":"'.$row['variant_width'].'","height":"'.$row['variant_height'].'"}',
                'status'        => true,
            ]);
        }
    }

    public function onError(Throwable $error)
    {

    }
}

// 'weight'        => str_replace(',', '', $row['variant_weight']),
// 'dimensions'    => '{"length":"'.$row['variant_length'].'","width":"'.$row['variant_width'].'","height":"'.$row['variant_height'].'"}',
