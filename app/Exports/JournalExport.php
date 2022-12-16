<?php

namespace App\Exports;

use App\Models\Journal;
use App\Models\Store;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class JournalExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    public function headings(): array
    {
        return [
            'ID',
            'Brand',
            'Store',
            'Date',
            'Revenue',
            'Food Cost',
            'Food Cost Percentage',
            'Labor Cost',
            'Labor Cost Percentage',
            'Profit',
        ];
    }

    public function map($entry): array
    {
        return [
            $entry->id,
            $entry->store->brand->name,
            $entry->store->number,
            $entry->date->format('M j, Y'),
            $entry->revenue,
            $entry->food_cost,
            $entry->food_cost_percent,
            $entry->labor_cost,
            $entry->labor_cost_percent,
            $entry->profit,
        ];
    }

    public function forBrand($brand)
    {
        $this->brand = $brand;
        return $this;
    }

    public function forStore($store)
    {
        $this->store = $store;
        return $this;
    }

    public function query()
    {
        return Journal::query()
            ->where(function($query) {
                if (isset($this->store)) {
                    $store = Store::whereNumber($this->store->number)->firstOrFail();

                    return $query->where('store_id', $store->id);
                }

                if (isset($this->brand)) {
                    $brandStores = Store::where('brand_id', $this->brand->id)->get()->pluck('id');

                    return $query->whereIn('store_id', $brandStores);
                }

                $stores = Store::get()->pluck('id');

                return $query->whereIn('store_id', $stores);
            })
            ->with('store.brand')
            ->orderBy('date', 'desc');
    }
}
