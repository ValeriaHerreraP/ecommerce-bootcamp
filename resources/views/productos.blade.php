<title>Products</title>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __(' Products') }}  
        </h2>
        
    </x-slot>
    <div class="py-1">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <form action="{{ route('productos') }}" method="GET">
                    <input type="text" name="search" placeholder="Search products name" value="{{ request('search') }}"
                    class="border border-gray-200 rounded py-2 px-4 w-1/2">
                </form>
        </div>
    </div>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-4 lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-2 ">
                @foreach ($products as $product)
                    <div class="w-full px-4 lg:px-0">
                        <div class="p-2 bg-white rounded shadow-md">
                            <div class="">
                                <div class="relative w-full mb-3 h-62 lg:mb-0">
                                <img src="{{ $product->image }}" alt="Just a flower"
                                    class="object-fill w-full h-full rounded">
                                </div>
                                <div class="flex-auto p-2 justify-evenly">
                                <div class="flex flex-wrap ">
                                    <div class="flex items-center justify-between w-full min-w-0 ">
                                    <h2 class="mt-1 text-xl font-semibold">
                                        {{ $product->product }}
                                    </h2>
                                    </div>
                                </div>
                                <div class="mr-auto text-lg cursor-pointer hover:text-gray-900 ">{{ $product->price }}</div>
                                <div class="mr-auto text-lg cursor-pointer hover:text-gray-900 ">{{ $product->description }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                {{$products->links()}}
            </div>
        </div>
    </div>
   

</x-app-layout>