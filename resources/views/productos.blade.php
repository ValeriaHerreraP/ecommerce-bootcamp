<title>Products</title>
<style>
    .principal {
        width: 100%;
        display: flex;
        justify-content: center;
        flex-direction: column;
    }
    .items-prueba {
        flex-basis: auto !important;
        min-width: 250px !important; /* Puedes modificar este tamaño si necesitas que la caja tenga un tamaño minimo */
        max-width: 280px !important; /* Puedes modificar este tamaño si necesIitas que la caja tenga un tamaño maximo */
        flex-grow: 1 !important; 
    }
    .items-content {
        width: 100% !important; /* Ancho automatico para todas las pantallas*/
        max-width: 1080px !important; /* Se limita a 1080px para que no se expanda tanto en pantallas mas grandes*/
        display: flex !important;
        flex-wrap: wrap !important; /* Coloca el contenido en la siguiente linea cuando no cabe en el ancho total establecido*/
        justify-content: center !important;
        align-items: center !important;
        gap: 10px !important; /* Agrega un espaciado entre cajas*/
    }
    .items-img {
        width: 100% !important;
        height: 250px !important;
        object-fit: cover !important;
    }
</style>

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
                                </div>

                            </div>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
            {{$products->links()}}
        
    </div>
   
</x-app-layout>




    


