<div>
    <x-header>
        <x-slot name="header">
            Journal
        </x-slot>

        <x-slot name="actions">
            <select wire:model="brand_id" class="block p-3 mt-1 text-sm border-gray-300 rounded-md shadow-sm focus:border-red-300 focus:ring focus:ring-red-200 focus:ring-opacity-50 w-40">
                <option>Select brand</option>
                @foreach($availableBrands as $singleBrand)
                    <option value="{{ $singleBrand->id }}">{{ $singleBrand->name }}</option>
                @endforeach
            </select>

            <select wire:model="store_id" class="block p-3 mt-1 text-sm border-gray-300 rounded-md shadow-sm focus:border-red-300 focus:ring focus:ring-red-200 focus:ring-opacity-50 w-32" {{ !$brand_id ? 'disabled' : '' }}>
                @if($brand_id)
                    <option value="all">All</option>
                    @foreach($storesByBrand[$brand_id] as $single)
                        <option value="{{ $single->number }}">#{{ $single->number }}</option>
                    @endforeach
                @else
                    <option></option>
                @endif
            </select>

            <button wire:click="exportData" class="{{ !isset($brand) ? 'bg-gray-500' : '' }} py-3 px-4 rounded text-sm text-white" style="{{ isset($brand) ? 'background-color: ' . $brand->color : '' }}">
                Export
            </button>
        </x-slot>
    </x-header>

    @if(session('flash.banner'))
        <div class="items-center p-4 rounded-lg mt-4 border-b-4 border-green-600 bg-green-50">
           {{ session('flash.banner') }}
        </div>
    @endif

    @if($brand_id)
        <div class="grid grid-cols-12 gap-6 items-center p-4 bg-white rounded-lg mt-4 border-b-4" style="border-color: {{ $brand->color }}">
            <div title="{{ $brand->name }}">
                <x-dynamic-component :component="'brand.' . Str::slug($brand->name)" class="h-20"  />
            </div>
            @if($store)
                <div class="col-span-5">
                    <h2 class="text-lg">{{ $brand->name }} #{{ $store->number }}</h2>
                    <div class="text-sm mt-1">
                        {{ $store->address }}<br>
                        {{ $store->city }}, {{ $store->state }} {{ $store->zip_code }}
                    </div>
                </div>

                <span class="col-span-2 tabular-nums">
                    <span>Store Revenue</span>
                    <div>
                        ${{ number_format($store->total_revenue) }}
                    </div>
                </span>

                <span class="col-span-2 tabular-nums">
                    <span>Store Profit</span>
                    <div>
                        ${{ number_format($store->total_profit) }}
                    </div>
                </span>
            @else
                <div class="col-span-5">
                    <h2 class="text-lg">{{ $brand->name }}</h2>
                </div>
            @endif
        </div>
    @endif

    <div class=" p-4 text-sm text-gray-500 grid grid-cols-12 gap-6 w-full mt-4">
        <div class="col-span-2">Date</div>
        <div class="col-span-2">Revenue</div>
        <div class="col-span-2">Food Cost</div>
        <div class="col-span-2">Last Cost</div>
        <div class="col-span-2">Profit</div>
    </div>
    <div class="bg-white rounded-lg divide-y overflow-hidden">
        @forelse($entries as $entry)
            <div wire:key="journal-{{ $entry->id }}" class="flex justify-between items-center p-4 relative">
                <div class="grid grid-cols-12 gap-6 w-full text-gray-600">
                    <div class="col-span-2 text-black">
                        {{ $entry->date->format('M j, Y') }}
                    </div>

                    <div class="col-span-2 tabular-nums">
                        ${{ number_format($entry->revenue) }}
                    </div>

                    <div class="col-span-2 tabular-nums flex items-center">
                        ${{ number_format($entry->food_cost) }}

                        <x-cost-percent :percent="$entry->food_cost_percent" />
                    </div>

                    <div class="col-span-2 tabular-nums">
                        ${{ number_format($entry->labor_cost) }}

                        <x-cost-percent :percent="$entry->labor_cost_percent" />
                    </div>

                    <div class="col-span-2 tabular-nums">
                        ${{ number_format($entry->profit) }}
                    </div>

                    <div class="col-span-2">
                        {{ $entry->store->brand->name }} #{{ $entry->store->number }}
                    </div>
                </div>
            </div>
        @empty
            <div class="p-4">
                Please select a store to view journal
            </div>
        @endforelse
    </div>

    @if(count($entries))
        <div class="mt-4">
            {{ $entries->links() }}
        </div>
    @endif
</div>
