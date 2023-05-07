<title>Users</title>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Usuarios registrados') }}
                
            <form action="{{ route('users.index') }}" method="GET" class="flex-grow">
                    <input type="text" name="search" placeholder="Buscar" value="{{ request('search') }}"
                    class="border border-gray-200 rounded py-2 px-4 w-1/2">
            </form>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <table class="mb-4">
                        @foreach ($users as $user)
                        <tr class = "border-b border-gray-200 text-sm">
                            <td class="px-6 py-4">{{ $user->name }}</td>
                            <td>{{ $user->lastname }}</td>
                            <td class="px-6 py-4">
                                <a href="{{ route('users.edit', $user) }}" class="text-indigo-600">Actualizar</a>
                            </td>
                            <td class="px-6 py-4">
                                <form action="{{ route('users.updateState', $user) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    @if ($user->state == 1)
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
                                <form action="{{ route('users.destroy', $user) }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <input 
                                        type="submit"
                                        value="Eliminar"
                                        class="bg-red-800 text-white rounded px-4 py-2"
                                        onclick="return confirm('Desea eliminar el usuario?')"
                                    >
                                </form>    
                            </td>        

                        </tr>
                        @endforeach


                    </table>
                  {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
