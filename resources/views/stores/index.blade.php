@extends('layouts.app')

@section('content')
    <x-header>
        <x-slot name="header">
            My Stores
        </x-slot>
    </x-header>

    <div class="mt-4 p-4 grid grid-cols-12 gap-6">
        <div class="col-span-6">Details</div>
        <div class="col-span-2">Revenue</div>
        <div class="col-span-2">Profit</div>
    </div>
    <div class="bg-white rounded-lg divide-y">
        @foreach($stores as $store)
            <a href="{{ route('journals.index', ['openStore' => $store->number]) }}" class="grid grid-cols-12 gap-6 items-center p-4">
                <div title="{{ $store->brand->name }}">
                    <x-dynamic-component :component="'brand.' . Str::slug($store->brand->name)" class="h-20"  />
                </div>
                <div class="col-span-5">
                    <h2 class="text-lg">{{ $store->brand->name }} #{{ $store->number }}</h2>
                    <div class="text-sm mt-1">
                        {{ $store->address }}<br>
                        {{ $store->city }}, {{ $store->state }} {{ $store->zip_code }}
                    </div>
                </div>

                <span class="col-span-2 tabular-nums">
                    <div>
                        ${{ number_format($store->total_revenue) }}
                    </div>
                </span>

                <span class="col-span-2 tabular-nums">
                    <div>
                        ${{ number_format($store->total_profit) }}
                    </div>
                </span>
            </a>
        @endforeach
    </div>
@endsection
