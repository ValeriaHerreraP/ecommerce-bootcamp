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
            <br>
        </h2>
    </x-slot>

    <div class="py-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">      
                    
            @can('products.export')
            <div class="font-semibold text-xl text-gray-800 leading-tight flex items-center justify-between max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('products.export') }}" class="text-xs bg-gray-800 text-white rounded px-4 py-2">Export Products</a>
            @if(session()->has('messag'))
           <div class="alert alert-success text-xs">
            {{ session()->get('messag') }}
    </div>
             @endif

        <a href="{{ route('products.exportdw') }}" class="text-xs bg-gray-800 text-white rounded px-4 py-2">Export Products DW</a>

@endcan

            <div>
            @can('products.import')
            <form action="{{ route('products.import') }}" method="POST" enctype="multipart/form-data">
                       @csrf
                       <input type="file" name="doc" class="rounded px-4 py-2 text-xs "/>
                       <button type="submit" class="text-xs bg-gray-800 text-white rounded px-4 py-2">Import Products
                       </button>
                       @if(session()->has('message'))
                      <div class = "text-xs" >
                      {{ session()->get('message') }}
                      </div>
                      @endif
            </form>  
            
            @can('products.import')
            <form action="{{ route('products.delete_import') }}" method="POST" enctype="multipart/form-data">
                       @csrf
                       <input type="file" name="import" class="rounded px-4 py-2 text-xs" />
                       <button type="submit" class="text-xs bg-gray-800 text-white rounded px-4 py-2 ">Delete Products and Import</button>
            @endcan

            @if(session()->has('mess'))
            <div class = "text-xs" >
            {{ session()->get('mess') }}
            </div>
            @endif
            @endcan
            </form> 
            </div>

            </div>
           
                <div class="p-6 text-gray-900 max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <table class="table-fixed w-full">
                        <thead>
                            <tr class="bg-gray-800 text-white">
                                <th class="border px-4 py-2">Id</th>
                                <th class="border px-4 py-2">Product</th>
                                <th class="border px-4 py-2">Price</th>
                                <th class="border px-4 py-2">Description</th>
                                <th class="border px-4 py-2">Image</th>
                                <th class="border px-4 py-2">Edit</th>
                                <th class="border px-4 py-2">Enabled</th>
                                <th class="border px-4 py-2">Disabled</th>
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
                                <form action="{{ route('products.updateStateDisable', $product) }}" method="POST">
                                @if ($product->state == 1)
                                    {{('Show product')}}
                                    @else
                                    @csrf
                                    @method('PUT')
                                    <input type="submit" value="Show product" class="bg-gray-800 text-white rounded px-4 py-2">
                                    @endif
                                </form>
                            </td> 
                            <td class="px-6 py-4">
                                <form action="{{ route('products.updateStateEnable', $product) }}" method="POST">
                                @if ($product->state == 0)
                                    {{('Hide product')}}
                                    @else
                                    @csrf
                                    @method('PUT')
                                    <input type="submit" value="Hide Product" class="bg-gray-800 text-white rounded px-4 py-2">
                                </form>
                                @endif
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

