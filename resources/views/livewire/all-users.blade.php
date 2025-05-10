{{-- If your happiness depends on money, you will never be happy with yourself. --}}
@php
    $users = App\Models\User::all()->where('username', '!=', 'snpoc_admin');
    $posts = App\Models\Post::all();
    $channels = App\Models\Page::all();
    $squads = App\Models\Group::all();
    $comments = App\Models\Comment::all();

    // function to banned user or not
    function isBanned($user)
    {
        if ($user->banned_to != null && $user->banned_to > now('Asia/Yangon')) {
            return true;
        }
        return false;
    }

    // function to lock user or not
    function isLocked($user)
    {
        if ($user->is_private == 1) {
            return true;
        }
        return false;
    }

    // function to count
    function counting($user_id, $types)
    {
        $count = 0;
        foreach ($types as $type) {
            if ($type->user_id == $user_id) {
                $count++;
            }
        }
        return $count;
    }

    // function to get line number
    function lineNumber()
    {
        static $line = 1;
        return $line++;
    }

@endphp
<div class="container px-2 mx-auto">
    <div class="w-full my-4 overflow-hidden rounded-lg shadow-xs">
        <div class="w-full overflow-x-auto">
            <h1 class="text-lg font-bold text-gray-800 dark:text-gray-200">Todos los Usuarios</h1>
            <table class="w-full whitespace-no-wrap text-xs">
                <thead>
                    <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-2 py-2"></th>
                        <th class="px-2 py-2">Usuario</th>
                        <th class="px-2 py-2">Canales</th>
                        <th class="px-2 py-2">Grupos</th>
                        <th class="px-2 py-2">Publicaciones</th>
                        <th class="px-2 py-2">Comentarios</th>
                        <th class="px-2 py-2">Estado</th>
                        <th class="px-2 py-2">Bloqueado</th>
                        <th class="px-2 py-2">Rol</th>
                        <th class="px-2 py-2">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @foreach ($users as $user)
                        <tr class="text-gray-700 dark:text-gray-400 text-xs">
                            <td class="px-2 py-2">
                                {{ lineNumber() }}
                            </td>
                            <td class="px-2 py-2">
                                <div class="flex items-center text-xs">
                                    <div class="relative hidden w-6 h-6 mr-2 rounded-full md:block">
                                        <img class="object-cover w-full h-full rounded-full"
                                            src="{{ asset('images/profiles/' . $user->profile) }}" alt=""
                                            loading="lazy" />
                                        <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true">
                                        </div>
                                    </div>
                                    <div>
                                        <p class="font-semibold">{{ $user->first_name . ' ' . $user->last_name }}
                                        </p>
                                        <a href="{{ route('profile.show', $user->username) }}"
                                            class="text-xs text-gray-600 dark:text-gray-400">
                                            {{ '@' . $user->username }}
                                        </a>
                                    </div>
                                </div>
                            </td>
                            <td class="px-2 py-2 text-xs">{{ counting($user->id, $channels) }}</td>
                            <td class="px-2 py-2 text-xs">{{ counting($user->id, $squads) }}</td>
                            <td class="px-2 py-2 text-xs">{{ counting($user->id, $posts) }}</td>
                            <td class="px-2 py-2 text-xs">{{ counting($user->id, $comments) }}</td>
                            <td class="px-2 py-2 text-xs">
                                @if (isLocked($user))
                                    <span
                                        class="px-1 py-0.5 font-semibold leading-tight text-red-700 bg-red-100 rounded-lg dark:bg-red-700 dark:text-red-100">
                                        Bloqueado
                                    </span>
                                @else
                                    @if (isBanned($user))
                                        <span
                                            class="px-1 py-0.5 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100">
                                            Bloqueado
                                        </span>
                                    @else
                                        <span
                                            class="px-1 py-0.5 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                            Activo
                                        </span>
                                    @endif
                                @endif
                            </td>
                            <td class="px-2 py-2 text-xs">{{ $user->is_banned }}</td>
                            <td class="px-2 py-2 text-xs">
                                <span class="px-1 py-0.5 font-semibold leading-tight {{ $user->role === 'admin' ? 'text-purple-700 bg-purple-100' : 'text-blue-700 bg-blue-100' }} rounded-full dark:bg-gray-700 dark:text-gray-100">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="px-2 py-2 text-xs">
                                <div class="flex flex-col space-y-2">
                                    @if (isLocked($user))
                                        <a href="{{ route('admin.unlock', $user->id) }}"
                                            class="px-2 py-1 text-sm font-semibold leading-tight text-green-700 bg-green-100 rounded-lg dark:bg-green-700 dark:text-green-100">
                                            Unlock
                                        </a>
                                    @else
                                        @if (isBanned($user))
                                            <a href="{{ route('admin.unban', $user->id) }}"
                                                class="px-2 py-1 text-sm font-semibold leading-tight text-green-700 bg-green-100 rounded-lg dark:bg-green-700 dark:text-green-100">
                                                Desbloquear
                                            </a>
                                        @else
                                            <a href="{{ route('admin.ban', $user->id) }}"
                                                class="px-2 py-1 text-sm font-semibold leading-tight text-red-700 bg-red-100 rounded-lg dark:bg-red-700 dark:text-red-100">
                                                Bloquear
                                            </a>
                                        @endif
                                    @endif
                                    
                                    @if($user->role === 'admin')
                                        <a href="{{ route('admin.change-role', ['user' => $user->id, 'role' => 'user']) }}"
                                            class="px-2 py-1 text-sm font-semibold leading-tight text-blue-700 bg-blue-100 rounded-lg dark:bg-blue-700 dark:text-blue-100">
                                            Quitar Admin
                                        </a>
                                    @else
                                        <a href="{{ route('admin.change-role', ['user' => $user->id, 'role' => 'admin']) }}"
                                            class="px-2 py-1 text-sm font-semibold leading-tight text-purple-700 bg-purple-100 rounded-lg dark:bg-purple-700 dark:text-purple-100">
                                            Hacer Admin
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
