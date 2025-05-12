<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\PageMember;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ChannelController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'name' => ['required', 'min:3', 'max:255'],
            'description' => ['required', 'min:3', 'max:1000'],
            'type' => ['required', 'in:educacion,noticias,entretenimiento,tutoriales,otros'],
            'thumbnail' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'location' => ['required', 'min:3', 'max:255'],
        ]);

        DB::beginTransaction();
        try {
            // Crear directorio si no existe
            $thumbnailPath = 'pages/thumbnails';

            if (!Storage::disk('public')->exists($thumbnailPath)) {
                Storage::disk('public')->makeDirectory($thumbnailPath);
            }

            // Guardar imagen
            $thumbnailName = time() . '_' . uniqid() . '.' . $request->thumbnail->extension();

            // Guardar la imagen en el disco público
            $request->thumbnail->storeAs("public/{$thumbnailPath}", $thumbnailName);

            // Crear el canal
            $page = Page::create([
                'uuid' => Str::uuid(),
                'user_id' => auth()->id(),
                'name' => $request->name,
                'description' => $request->description,
                'type' => $request->type,
                'location' => $request->location,
                'thumbnail' => $thumbnailName,
                'members' => 1, // Inicialmente solo el creador
                'is_private' => false, // Los canales son públicos por defecto
                'is_channel' => true, // Marcar como canal
                'can_members_post' => false, // Solo el creador puede publicar
            ]);



            // Crear el registro del creador como administrador
            PageMember::create([
                'page_id' => $page->id,
                'user_id' => auth()->id(),
                'role' => 'admin', // El creador es administrador
                'can_post' => true, // Solo el creador puede publicar
            ]);

            DB::commit();
            return redirect()->route('my-channels')->with('success', 'Canal creado exitosamente');
        } catch (\Exception $e) {
            DB::rollback();
            // Si hay un error, eliminar la imagen si se subió
            if (isset($thumbnailName) && Storage::disk('public')->exists("{$thumbnailPath}/{$thumbnailName}")) {
                Storage::disk('public')->delete("{$thumbnailPath}/{$thumbnailName}");
            }
            return back()->with('error', 'Error al crear el canal: ' . $e->getMessage())->withInput();
        }
    }
    public function unfollow($channelId)
    {
        $channel = Page::findOrFail($channelId); // Buscar el canal por ID

        // Verificar si el usuario ya sigue el canal
        $followed = DB::table('page_likes') // Usamos la tabla page_likes para verificar el seguimiento
            ->where('user_id', auth()->id())
            ->where('page_id', $channel->id)
            ->first();

        if ($followed)
        {
            // Si el usuario sigue el canal, eliminar el registro de seguimiento
            DB::table('page_likes')
                ->where('user_id', auth()->id())
                ->where('page_id', $channel->id)
                ->delete();

            // Actualizar el número de seguidores en el canal
            $channel->decrement('members'); // Restamos un seguidor

            return redirect()->route('channel.show', $channel->id)
                ->with('success', 'Has dejado de seguir este canal.');
        }

        return redirect()->route('channel.show', $channel->id)
            ->with('info', 'No estabas siguiendo este canal.');
    }
}
