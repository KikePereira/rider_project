<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Rutas reportadas') }}
        </h2>

        <a href="{{ route('admin'); }}">Usuarios</a>
        <span> | </span>
        <a href="{{ route('admin.comment_report'); }}">Comentarios Denunciados</a>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if($reportedRoutes->isEmpty())
                        <p>No hay rutas reportadas.</p>
                    @else
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Usuario</th>
                                    <th>Título</th>
                                    <th>Descripción</th>
                                    <th>Likes</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($reportedRoutes as $route)
                                    <tr>
                                        <td>{{ $route->id }}</td>
                                        <td>{{ $route->user->nickname}}</td>
                                        <td>{{ $route->title }}</td>
                                        <td>{{ $route->description }}</td>
                                        <td>{{ $route->likes }}</td>
                                        <td>
                                            <div class="flex">
                                            <form action="{{ route('admin.routes_report_accept', $route->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="text-success mr-2">Aceptar Denuncia</button>
                                            </form>

                                            <form action="{{ route('admin.routes_report_deny', $route->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="text-danger mr-2">Denegar Denuncia</button>
                                            </form>

                                            <a href="{{ route('route.show', $route->id) }}" class="text-primary mr-2">Ver</a>
                                            </div>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif

                    {{ $reportedRoutes->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
