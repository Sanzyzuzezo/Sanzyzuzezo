<?php

namespace App\Exports;

use App\Models\Orders;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;


class OrdersExport implements FromCollection, WithHeadings, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */

    Public function headings(): array
    {
        return [
            'Transaction Date',
            'Invoice Number',
            'Customer Name',
            'Status',
            'Courier',
            'Resi',
            'Address',
            'Billing Status',
        ];
    }

    public function collection()
    {
        $company_id = getCompanyId();
        
        $query = Orders::leftjoin('customers', 'customers.id', '=', 'orders.customer_id')
        ->leftjoin('order_shippings', 'order_shippings.order_id', '=', 'orders.id')
        ->leftjoin('order_billings', 'order_billings.order_id', '=', 'orders.id')
        ->select(
            'orders.transaction_date',
                            'orders.invoice_number',
                            'customers.name as cust_name',
                            'orders.status',
                            'order_shippings.courier as courier',
                            'order_shippings.resi as resi',
                            'order_shippings.address',
                            // json_extract('order_shippings.address', '$.address'),
                            'order_billings.status as billing_status',
                            )
                            ->orderBy('orders.created_at', 'DESC');
        if ($company_id != 0) {
            $query->where('orders.company_id', $company_id);
        }
        $data = $query->get();

       return  $data;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true]],
        ];
    }
}
