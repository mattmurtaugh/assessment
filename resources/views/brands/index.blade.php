@foreach($brands as $brand)
    <div>
        <h1>{{ $brand->name }}</h1>
        <x-dynamic-component :component="'brand.' . Str::slug($brand->name)" style="height: 150px; width: auto;" />
    </div>
@endforeach
