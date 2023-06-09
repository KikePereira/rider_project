<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Conversación con {{ $friend->name }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto">
                <div class="p-4">
  <!-- Mostrar los mensajes -->
@if ($messages->isEmpty())
    <div class="alert alert-info">No tienes mensajes. Se el primero en enviar uno!</div>
@else
    @foreach ($messages as $message)
        <div class="bg-white shadow-md rounded-lg">
            <div class="mb-4 p-4">
                <div class="{{ $message->sender_id === auth()->user()->id ? 'text-end' : 'text-start' }}">
                    <p><strong>{{ $message->sender->name }}</strong></p>
                    <p class="text-dark">{{ $message->message }}</p>
                    <span class="text-gray-600 text-sm">{{ $message->created_at->format('d/m/Y H:i') }}</span>
                </div>
            </div>
        </div>
    @endforeach
@endif


                    <!-- Formulario para enviar un nuevo mensaje -->
                    <form action="{{ route('messages.send', $friend->id) }}" method="POST">
                        @csrf
                        <div class="mt-4">
                            <label for="content" class="block text-gray-700 font-medium">Nuevo mensaje:</label>
                            <textarea name="message" id="message" rows="3" class="form-input mt-1 block w-full" required></textarea>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="text-primary">Enviar mensaje</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
