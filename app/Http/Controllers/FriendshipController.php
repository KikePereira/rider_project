<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Friendship;


class FriendshipController extends Controller
{    
    public function index()
    {
        $user = Auth::user();
        $friends = $user->friends()->paginate(10); // Cambia el número 10 según tus necesidades de paginación
    
        return view('friendship.index', compact('friends'));
    }
    


    public function send(Request $request)
    {
        $user = Auth::user(); // Obtén el usuario autenticado
        $friend = User::where('nickname', $request->nickname)->first(); // Busca al amigo por su nickname

        if (!$friend) {
            return redirect()->back()->with('error', 'El usuario no existe.'); // Redirecciona si el amigo no existe
        }
    
        if ($user->id == $friend->id) {
            return redirect()->back()->with('error', 'No puedes enviarte una solicitud de amistad a ti mismo.'); // Redirecciona si el usuario intenta enviarse una solicitud a sí mismo
        }
    
        if ($user->friends->contains($friend->id)) {
            return redirect()->back()->with('error', 'Ya eres amigo de este usuario.'); // Redirecciona si el usuario ya es amigo de la persona a la que se le está enviando la solicitud
        }
    
        $friendship = new Friendship();
        $friendship->user_id = $user->id;
        $friendship->friend_id = $friend->id;
        $friendship->save();
    
        return redirect()->back()->with('success', 'Solicitud de amistad enviada.'); // Redirecciona con un mensaje de éxito si la solicitud se envió correctamente
    }
    
    public function show()
    {
        $user = Auth::user(); // Obtén el usuario autenticado
        $friendRequests = Friendship::pendingRequests($user->id)->get();; // Obtén todas las solicitudes de amistad recibidas por el usuario
        
        return view('friendship/show', compact('friendRequests'));
    }

    public function accepted($friendshipId)
    {
        $friendship = Friendship::find($friendshipId);

        $friendship->accepted = true;
        $friendship->save();

        $friend = new Friendship;
        $friend->user_id = $friendship->friend_id;
        $friend->friend_id = $friendship->user_id;
        $friend->accepted = true;
        $friend->save();

        return redirect()->route('friend.show');
    }

    public function deny($friendshipId)
    {
        $friendship = Friendship::find($friendshipId);

        $friendship->delete();

        return redirect()->back()->with('success', 'Solicitud de amistad denegada.');
    }


    public function destroy($friendshipId)
    {

        $user = Auth::user();

        $friendship = Friendship::where('user_id', $user->id)
        ->where('friend_id', $friendshipId)
        ->first();

        $friend = Friendship::where('user_id', $friendshipId)
        ->where('friend_id', $user->id)
        ->first();

        $friend->delete();

        $friendship->delete();

        return redirect()->back()->with('success', 'Amigo eliminado correctamente.');
    }

}
