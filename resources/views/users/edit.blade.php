<title>Edit users</title>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Actualizar usuarios') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('users.update', $user) }}" method="POST">

                    @method('PUT')

                    @csrf

                    <label class="uppercase text-gray-700 text-xs">Name</label>
                    <span class="text-xs text-red-600"> @error('name') {{ $message }} @enderror</span>
                    <input type="text" name="name" class="rounded border-gray-200 w-full mb-4" value="{{ $user->name }}">

                    <label class="uppercase text-gray-700 text-xs">Lastname</label>
                    <span class="text-xs text-red-600"> @error('lastname') {{ $message }} @enderror</span>
                    <input type="text" name="lastname" class="rounded border-gray-200 w-full mb-4" value="{{ $user->lastname }}">

                    <label class="uppercase text-gray-700 text-xs">Phone</label>
                    <span class="text-xs text-red-600"> @error('phone') {{ $message }} @enderror</span>
                    <input type="text" name="phone" class="rounded border-gray-200 w-full mb-4" value="{{ $user->phone }}">

                    <label class="uppercase text-gray-700 text-xs">Email</label>
                    <span class="text-xs text-red-600"> @error('email') {{ $message }} @enderror</span>
                    <input type="text" name="email" class="rounded border-gray-200 w-full mb-4" value="{{ $user->email }}">

                    <div class="flex justify-between items-center">
                        <a href="{{ route('users.index') }}" class="text-indigo-600">Volver</a>

                        <input type="submit" value="Enviar" class="bg-gray-800 text-white rounded px-4 py-2">

                    </div>
                    

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
