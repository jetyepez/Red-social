<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\Notification;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

class ProfileEdit extends Component
{
    use WithFileUploads;

    public $profile;
    public $first_name;
    public $last_name;
    public $username;
    public $email;
    public $description;
    public $school;
    public $college;
    public $university;
    public $work;
    public $address;
    public $website;
    public $gender;
    public $trayecto;

    public function mount(User $user)
    {
        // Verificar que el usuario autenticado sea el propietario del perfil
        if ($user->id !== Auth::id()) {
            abort(403, 'No tienes permiso para editar este perfil.');
        }

        $this->profile = $user->profile;
        $this->first_name = $user->first_name;
        $this->last_name = $user->last_name;
        $this->username = $user->username;
        $this->email = $user->email;
        $this->description = $user->description;
        $this->school = $user->school;
        $this->college = $user->college;
        $this->university = $user->university;
        $this->work = $user->work;
        $this->address = $user->address;
        $this->website = $user->website;
        $this->gender = $user->gender;
        $this->trayecto = $user->trayecto;
    }

    public function render()
    {
        return view('livewire.profile-edit')
            ->extends('layouts.app')
            ->section('content');
    }

    public function profileEdit()
    {
        $this->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . Auth::id(),
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'description' => 'nullable|string|max:1000',
            'school' => 'nullable|string|max:255',
            'college' => 'nullable|string|max:255',
            'university' => 'nullable|string|max:255',
            'work' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'gender' => 'required|in:male,female',
            'profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'trayecto' => 'required|in:1,2,3,4',
        ]);

        $user = User::findOrFail(Auth::id());

        DB::beginTransaction();
        try {
            $this->updateUser($user);
            DB::commit();
            session()->flash('success', 'Tu perfil ha sido actualizado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Hubo un error al actualizar tu perfil.');
            throw $e;
        }

        $this->updateProfilePicture($user);

        return redirect()->route('profile.show', $user->username);
    }

    private function updateUser(User $user)
    {
        $user->update([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'username' => $this->username,
            'email' => $this->email,
            'description' => $this->description,
            'school' => $this->school,
            'college' => $this->college,
            'university' => $this->university,
            'work' => $this->work,
            'address' => $this->address,
            'website' => $this->website,
            'gender' => $this->gender,
            'trayecto' => $this->trayecto,
        ]);
    }

    private function updateProfilePicture(User $user)
    {
        if ($this->profile && $this->profile instanceof \Illuminate\Http\UploadedFile) {
            // Eliminar la imagen anterior si existe
            if ($user->profile) {
                $oldPath = storage_path('app/public/images/profiles/' . $user->profile);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            // Generar nombre único para la nueva imagen
            $profileName = time() . '.' . $this->profile->getClientOriginalExtension();
            
            // Guardar la nueva imagen
            $this->profile->storeAs('images/profiles', $profileName, 'public');
            
            // Actualizar el perfil del usuario
            $user->profile = $profileName;
            $user->save();
        }
    }
}
