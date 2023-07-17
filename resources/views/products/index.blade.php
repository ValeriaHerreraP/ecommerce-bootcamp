<title>Manege Products</title>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center justify-between">
            {{ __('Manage products') }}  
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <form action="{{ route('products.index') }}" method="GET" class="flex-grow">
                    <input type="text" name="search" placeholder="Search products name" value="{{ request('search') }}"
                    class="border border-gray-200 rounded py-2 px-4 w-1/2">
                </form>
            </div>
            <a href="{{ route('products.create') }}" class="text-xs bg-gray-800 text-white rounded px-4 py-2">Create product</a>
  
        </h2>
    </x-slot>

    <div class="py-12">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">          
                <div class="p-6 text-gray-900">
            
                    <table class="table-fixed w-full">
                        <thead>
                            <tr class="bg-gray-800 text-white">
                                <th class="border px-4 py-2">Id</th>
                                <th class="border px-4 py-2">Product</th>
                                <th class="border px-4 py-2">Price</th>
                                <th class="border px-4 py-2">Description</th>
                                <th class="border px-4 py-2">Image</th>
                                <th class="border px-4 py-2">Edit</th>
                                <th class="border px-4 py-2">State</th>
                                <th class="border px-4 py-2">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                           @foreach ($products as $product)
                           <tr class = "border-b border-gray-200 text-sm">
                            <td class="px-6 py-4">{{ $product->id }}</td>
                            <td class="px-6 py-4">{{ $product->product }}</td>   
                            <td class="px-6 py-4">{{ $product->price }}</td> 
                            <td class="px-6 py-4">{{ $product->description }}</td>    
                            <td>
                                <img src="{{$product->image}}" width="200">
                            </td>     
                            <td class="px-6 py-4">
                                <a href="{{ route('products.edit', $product) }}" class="text-indigo-600">Edit</a>
                            </td> 
                            <td class="px-6 py-4">
                                <form action="{{ route('products.updateState', $product) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    @if ($product->state == 1)
                                    <input 
                                        type="submit"
                                        name="state"
                                        value="Deshabilitar" 
                                        class="bg-gray-800 text-white rounded px-4 py-2"
                                    >
                                    @else
                                    <input 
                                        type="submit"
                                        name="state"
                                        value="Habilitar" 
                                        class="bg-gray-800 text-white rounded px-4 py-2"
                                    >
                                    @endif
                                </form>
                            </td> 
                            <td class="px-6 py-4">
                                <form action="{{ route('products.destroy', $product) }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <input 
                                        type="submit"
                                        value="Delete"
                                        class="bg-red-800 text-white rounded px-4 py-2"
                                        onclick="return confirm('Desea eliminar el producto?')"
                                    >
                                </form>  
                            </td> 
                            </tr>
                           @endforeach
                        </tbody>
                    </table>
                    {{$products->links()}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

