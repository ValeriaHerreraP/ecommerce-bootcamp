<title>Users</title>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center justify-between">
            {{ __('Usuarios registrados') }}
                <div>
            <form action="{{ route('users.index') }}" method="GET" class="flex-grow">
                    <input type="text" name="search" placeholder="Buscar" value="{{ request('search') }}"
                    class="border border-gray-200 rounded py-2 px-4 w-1/2">
            </form>
                </div>
        </h2>
    </x-slot>

    <div class="py-4">
       
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class= "p-6 text-gray-900 max-w-7xl mx-auto sm:px-6 lg:px-8">

                    <table class="mb-4">
                    <thead>
                            <tr class="bg-gray-800 text-white">
                                <th class="border px-4 py-2">Name</th>
                                <th class="border px-4 py-2">LastName</th>
                                <th class="border px-4 py-2">Phone</th>
                                <th class="border px-4 py-2">Email</th>
                                <th class="border px-4 py-2">Update</th>
                                <th class="border px-4 py-2">Disable</th>
                                <th class="border px-4 py-2">Enabled</th>
                                <th class="border px-4 py-2">Delete</th>
                            </tr>
                        </thead>
                        @foreach ($users as $user)
                        <tr class = "border-b border-gray-200 text-sm">
                            <td class="px-6 py-4">{{ $user->name }}</td>
                            <td class="px-6 py-4">{{ $user->lastname }}</td>
                            <td class="px-6 py-4">{{ $user->phone }}</td>
                            <td class="px-6 py-4">{{ $user->email }}</td>
                            <td class="px-6 py-4">
                                <a href="{{ route('users.edit', $user) }}" class="text-indigo-600">Actualizar</a>
                            </td>
                            <td class="px-6 py-4">
                                <form action="{{ route('users.updateStateEnable', $user) }}" method="POST">
                                @if ($user->state == 0)
                                    {{('Deshabilitado')}}
                                    @else
                                    @csrf
                                    @method('PUT')
                                    <input type="submit" value="Deshabilitar" class="bg-gray-800 text-white rounded px-4 py-2">
                                </form>
                                @endif
                            </td>  
                                <form action="{{ route('users.index', $user) }}" method="POST"> </form>
                            <td class="px-6 py-4">
                                <form action="{{ route('users.updateStateDisable', $user) }}" method="POST">
                                @if ($user->state == 1)
                                    {{('Habilitado')}}
                                    @else
                                    @csrf
                                    @method('PUT')
                                    <input type="submit" value="Habilitar" class="bg-gray-800 text-white rounded px-4 py-2">
                                    @endif
                                </form>
                            </td>  
                           
                            <td class="px-6 py-4">
                                <form action="{{ route('users.destroy', $user) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="submit" value="Eliminar" class="bg-red-800 text-white rounded px-4 py-2"
                                        onclick="return confirm('Desea eliminar el usuario?')">
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
