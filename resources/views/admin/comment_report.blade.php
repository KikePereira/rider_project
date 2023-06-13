<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Comentarios denunciados') }}
        </h2>

        <a href="{{ route('admin'); }}">Usuarios</a>
        <span> | </span>

        <a href="{{ route('admin.routes_report'); }}">
            Rutas denunciadas</a>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                @if($reportedComments->isEmpty())
                        <p>No hay comentarios reportados.</p>
                    @else
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Usuario</th>
                                    <th>Contenido</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($reportedComments as $comment)
                                <tr>
                                    <td>{{ $comment->id }}</td>
                                    <td>{{ $comment->user->nickname }}</td>
                                    <td>{{ $comment->content }}</td>
                                    <td>
                                        <div class="flex">
                                    <form action="{{ route('admin.comment_report_accept', $comment->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="text-success mr-2">Aceptar Denuncia</button>
                                            </form>

                                            <form action="{{ route('admin.comment_report_deny', $comment->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="text-danger mr-2">Denegar Denuncia</button>
                                            </form>
                                        <a href="{{ route('route.show', $comment->route_id) }}" class="text-primary">
                                            Ver Ruta
                                        </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif

                {{ $reportedComments->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
