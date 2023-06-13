<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin') }}
        </h2>

        <a href="{{ route('admin.routes_report'); }}">
            Rutas denunciadas</a>
            <span> | </span>

        <a href="{{ route('admin.comment_report'); }}">Comentarios denunciados</a>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="table text-center">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre usuario</th>
                                <th>Nombre</th>
                                <th>Primer Apellido</th>
                                <th>Segundo Apellido</th>
                                <th>Email</th>
                                <th>Localidad</th>
                                <th>Fecha nacimiento</th>
                                <th>Telefono</th>
                                <th>Administrador</th>
                                <th>Denuncias</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users->chunk(10) as $userChunk)
                                @foreach($userChunk as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->nickname }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->first_surname }}</td>
                                        <td>{{ $user->second_surname }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->locality }}</td>
                                        <td>{{ $user->birthday }}</td>
                                        <td>{{ $user->telephone }}</td>
                                        <td>
                                            @if($user->is_admin == '1')
                                                <form action="{{ route('admin.remove', $user->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="text-warning">Quitar Admin</button>
                                                </form>
                                            @else
                                                <form action="{{ route('admin.make', $user->id) }}" method="POST">
                                                    @csrf   
                                                    <button type="submit" class="text-success">Hacer Admin</button>
                                                </form>
                                            @endif
                                        </td>                                        <td>{{ $user->strike }}</td>
                                        <td class="text-danger">
                                        <form action="{{ route('admin.userDelete', $user->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                                <button type="submit" class="text-danger mr-2">Eliminar</button>
                                        </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
