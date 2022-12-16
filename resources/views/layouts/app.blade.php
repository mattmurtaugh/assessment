<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>@yield('page_title', 'Admin - '. config('app.name'))</title>
        {{--<link href="{{ asset('css/app.css') }}" rel="stylesheet">--}}
        @stack('styles')
        <script src="https://kit.fontawesome.com/ca00268a38.js" crossorigin="anonymous"></script>
        <script src="https://cdn.tailwindcss.com"></script>
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
        @livewireStyles
        <style>
            [x-cloak] { display: none !important; }
        </style>
    </head>
    <body class="font-sans antialiased bg-gray-50">
        <nav class="w-full bg-white shadow-md shadow-gray-200 py-3">
            <x-container>
                <div class="flex items-center space-x-6">
                    <a href="/">
                        <x-brand.yum class="h-12" />
                    </a>

                    <ul class="grow flex items-center">
                        <li>
                            <a href="{{ route('stores.index') }}" class="p-3 inline-block rounded hover:bg-gray-50">My Stores</a>
                        </li>
                        <li>
                            <a href="{{ route('journals.index') }}" class="p-3 inline-block rounded hover:bg-gray-50">Journals</a>
                        </li>
                    </ul>

                    <div class="flex items-center space-x-6">
                        @auth
                            <a href="#">
                                {{ Auth::user()->name }}
                            </a>


                            <div>
                                <a href="#" class="nav-link btn" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
                                <form id="logout-form" action="#" method="POST" style="display: none;">@csrf</form>
                            </div>
                        @endauth
                    </div>
                </div>
            </x-container>
        </nav>

        <main class="py-8">
            <x-container>
                @yield('content')


                <div class="mt-20">
                    <h2 class="text-2xl font-bold">Our Brands</h2>

                    <div class="flex gap-8 mt-3">
                        @foreach(App\Models\Brand::all() as $brand)
                            <div title="{{ $brand->name }}">
                                <x-dynamic-component :component="'brand.' . Str::slug($brand->name)" class="h-24"  />
                            </div>
                        @endforeach
                    </div>
                </div>
            </x-container>
        </main>

        <script src="{{ mix('js/app.js') }}"></script>

        @livewireScripts
        @stack('scripts')
    </body>
</html>
