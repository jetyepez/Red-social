<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupMember;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class GroupController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'name' => ['required', 'min:3', 'max:255'],
            'description' => ['required', 'min:3', 'max:1000'],
            'type' => ['required', 'min:3', 'max:255'],
            'icon' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'thumbnail' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'location' => ['required', 'min:3', 'max:255'],
        ]);

        DB::beginTransaction();
        try {
            // Crear directorios si no existen
            $iconPath = 'squads';
            $thumbnailPath = 'squads/thumbnails';
            
            if (!Storage::disk('public')->exists($iconPath)) {
                Storage::disk('public')->makeDirectory($iconPath);
            }
            if (!Storage::disk('public')->exists($thumbnailPath)) {
                Storage::disk('public')->makeDirectory($thumbnailPath);
            }

            // Guardar imágenes
            $iconName = time() . '_' . uniqid() . '.' . $request->icon->extension();
            $thumbnailName = time() . '_' . uniqid() . '.' . $request->thumbnail->extension();

            // Guardar las imágenes en el disco público
            $request->icon->storeAs("public/{$iconPath}", $iconName);
            $request->thumbnail->storeAs("public/{$thumbnailPath}", $thumbnailName);

            // Crear el grupo
            $group = Group::create([
                'uuid' => Str::uuid(),
                'user_id' => auth()->id(),
                'name' => $request->name,
                'description' => $request->description,
                'type' => $request->type,
                'location' => $request->location,
                'icon' => $iconName,
                'thumbnail' => $thumbnailName,
                'members' => 1,
                'is_private' => false,
            ]);

            // Crear el registro de miembro para el creador
            GroupMember::create([
                'group_id' => $group->id,
                'user_id' => auth()->id(),
            ]);

            DB::commit();
            return redirect()->route('my-squads')->with('success', 'Grupo creado exitosamente');
        } catch (\Exception $e) {
            DB::rollback();
            // Si hay un error, eliminar las imágenes si se subieron
            if (isset($iconName) && Storage::disk('public')->exists("{$iconPath}/{$iconName}")) {
                Storage::disk('public')->delete("{$iconPath}/{$iconName}");
            }
            if (isset($thumbnailName) && Storage::disk('public')->exists("{$thumbnailPath}/{$thumbnailName}")) {
                Storage::disk('public')->delete("{$thumbnailPath}/{$thumbnailName}");
            }
            return back()->with('error', 'Error al crear el grupo: ' . $e->getMessage())->withInput();
        }
    }
} 