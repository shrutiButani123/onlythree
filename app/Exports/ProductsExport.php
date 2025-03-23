<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsExport implements FromCollection, WithHeadings
{
    protected $products;

    public function __construct($products)
    {
        $this->products = $products;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $products =  $this->products;
        $data_array = [];

        foreach ($products as $product) {
            $data_array[] = [
                $product->id,
                $product->name,
                $product->price,
                $product->category->name ?? 'N/A',
                $product->subcategory->name ?? 'N/A',
                $product->description,
                $product->created_at->format('d M Y'),
            ];
        }

        return collect($data_array);
    }

    public function headings(): array
    {
        return [
            'Number', 'Name', 'Price', 'Category', 'Sub Category', 'Description','Date',
        ];
    }
}
