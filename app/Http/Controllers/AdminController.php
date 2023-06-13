<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Comment;
use App\Models\Message;
use App\Models\Friendship;
use App\Models\Route;



class AdminController extends Controller
{
    public function index()
    {
        $users = User::all();

        return view('admin/index', ['users' => $users]);
    }

    public function acceptReport($id)
{
    $route = Route::find($id);

            // Obtener el propietario de la ruta
            $owner = $route->user;

                // Incrementar el número de denuncias (strikes) del propietario
                $owner->strike += 1;
                $owner->save();

                // Verificar si el propietario alcanza 5 strikes para eliminar su perfil
                if ($owner->strike >= 5) {
                    $owner->delete();
                }

                $route->delete();

    return redirect()->back();
}

public function acceptCommentReport($id)
{
    $comment = Comment::find($id);

            // Obtener el propietario de la ruta
            $owner = $comment->user;

                // Incrementar el número de denuncias (strikes) del propietario
                $owner->strike += 1;
                $owner->save();

                // Verificar si el propietario alcanza 5 strikes para eliminar su perfil
                if ($owner->strike >= 5) {
                    $owner->delete();
                }

                $comment->delete();

    return redirect()->back();
}

public function denyCommentReport($id)
{
    $comment = Comment::find($id);

    $comment->is_report = 0;
    $comment->save();

    return redirect()->back();
}

public function denyReport($id)
{
    $route = Route::find($id);

    $route->is_report = 0;
    $route->save();

    return redirect()->back();
}

    public function makeAdmin($userId)
    {
        $user = User::findOrFail($userId);
        $user->is_admin = '1';
        $user->save();

        return redirect()->back();
    }

    public function RemoveAdmin($userId)
    {
        $user = User::findOrFail($userId);
        $user->is_admin = '0';
        $user->save();

        return redirect()->back();
    }

    public function getReportedRoutes()
    {
        $reportedRoutes = Route::where('is_report', 1)
                        ->paginate(10); // Cambia el número 10 por el número de rutas que deseas mostrar por página

        return view('admin/route_report', compact('reportedRoutes'));
    }
    public function getReportedComments()
    {
        $reportedComments = Comment::where('is_report', 1)
                        ->paginate(10); // Cambia el número 10 por el número de rutas que deseas mostrar por página

        return view('admin/comment_report', compact('reportedComments'));
    }
}
