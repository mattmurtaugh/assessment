<?php

namespace App\Http\Livewire\Journal;

use App\Jobs\SendExportJob;
use App\Models\Brand;
use App\Models\Journal;
use App\Models\Store;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $store_id;
    public $store;
    public $brand_id;
    public $brand;

    protected $rules = [
        'store_id' => '',
        'brand_id' => '',
        'store' => '',
        'brand' => '',
    ];

    public function mount()
    {
        if (isset($_GET['openStore'])) {
            $this->store = Store::whereNumber($_GET['openStore'])->firstOrFail();
            $this->store_id = $this->store->number;
            $this->brand  = $this->store->brand->id;
        }
    }

    public function updatedBrandId($value)
    {
        $this->brand = Brand::whereId($value)->firstOrFail();

        $this->store = null;
        $this->store_id = 'all';
    }

    public function updatedStoreId($value)
    {
        if ($value == 'all') {
            $this->store = null;
        } else {
            $this->store = Store::whereNumber($this->store_id)->first();
        }
    }

    public function exportData()
    {
        SendExportJob::dispatch($this->brand, $this->store);

        session()->flash('flash.banner', 'Your export is processing in the background. You will be emailed a link when it is complete.');
    }

    public function render()
    {
        // Get all the stores that belong to the user (uses belongsToUser global scope)
        $stores = Store::get();

        // Figure out what brands a user has stores in
        $availableBrands = Brand::whereIn('id', $stores->pluck('brand_id')->unique())->get();

        // Group stores by brand for look up by brand
        $storesByBrand = $stores->groupBy('brand_id');


        $entries = Journal::query()
            ->where(function($query) use ($storesByBrand, $stores) {
                if ($this->store) {
                    return $query->where('store_id', $this->store->id);
                }

                if ($this->brand_id) {
                    return $query->whereIn('store_id', $storesByBrand[$this->brand_id]->pluck('id'));
                }

                return $query->whereIn('store_id', $stores->pluck('id'));
            })
            ->with('store.brand')
            ->orderBy('date', 'desc')
            ->paginate(30);

        return view('livewire.journal.index', compact('entries', 'availableBrands', 'storesByBrand'));
    }
}
