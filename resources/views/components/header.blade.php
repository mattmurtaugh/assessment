<header class="flex items-center justify-between">
    <h1 class="text-3xl font-bold">{{ $header }}</h1>

    @isset($actions)
        <div class="flex items-center space-x-4">
            {{ $actions }}
        </div>
    @endisset
</header>
