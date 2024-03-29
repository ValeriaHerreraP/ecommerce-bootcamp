<title>Products</title>
<style>
    .principal {
        width: 100% !important;
        display: flex !important;
        justify-content: center !important;
        flex-direction: column !important;
    }
    .items-prueba {
        flex-basis: auto !important;
        min-width: 280px !important; /* Puedes modificar este tamaño si necesitas que la caja tenga un tamaño minimo */
        max-width: 300px !important; /* Puedes modificar este tamaño si necesIitas que la caja tenga un tamaño maximo */
        flex-grow: 1 !important; 
    }
    .items-content {
        width: 100% !important; /* Ancho automatico para todas las pantallas*/
        max-width: 1080px !important; /* Se limita a 1080px para que no se expanda tanto en pantallas mas grandes*/
        display: flex !important;
        flex-wrap: wrap !important; /* Coloca el contenido en la siguiente linea cuando no cabe en el ancho total establecido*/
        justify-content: center !important;
        align-items: center !important;
        gap: 20px !important; /* Agrega un espaciado entre cajas*/
    }
    .items-img {
        width: 100% !important;
        height: 250px !important;
        object-fit: cover !important;
    }
</style>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center justify-between">
            {{ __(' Products') }}  
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <form action="{{ route('cart.shop') }}" method="GET">
                    <input type="text" name="search" placeholder="Search products name" value="{{ request('search') }}"
                    class="text-s" class="border border-gray-200 rounded py-2 px-4 w-1/2">
                </form>
        </div>
        </h2>
        <hr/> 
    
    <div class="py-1">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
         
    </div>

    <div class="principal">
            <div class="items-content">
                @foreach ($products as $product)
                @if ($product->state == 1)
                    <div class="items-prueba">
                        <div class="p-2 bg-white rounded shadow-md">
                            <div class="row align-items-center">
                                <div class="">
                                <img src="{{ $product->image }}" alt="Just a flower"
                                    class="object-fill w-full h-full rounded items-img">
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
                                
                                <form action="{{ route('cart.store') }}" method="POST">
                                        {{ csrf_field() }}
                                        <input type="hidden" value="{{ $product->id }}" id="id" name="id">
                                        <input type="hidden" value="{{ $product->product }}" id="name" name="name">
                                        <input type="hidden" value="{{ $product->price }}" id="price" name="price">
                                        <input type="hidden" value="{{ $product->image }}" id="img" name="img">
                                        <input type="hidden" value="1" id="quantity" name="quantity">
                                        <div class="card-footer" style="background-color: white;">

                                
                                <div class="row">
                                    <button class="bg-gray-800 text-white rounded px-4 py-2" class="btn btn-secondary btn-sm" class="tooltip-test" title="add to cart">
                                                     Agregar al carrito</button>
                                </div>
                                        </div>
                                </form>

                            </div>

                            </div>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
            {{$products->links()}}
        
    </div>
      </x-slot>
</x-app-layout>




    


