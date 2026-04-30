<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class UserAdminController extends Controller
{
    public function index()
    {
        $users = User::with('modules')->paginate(10);
        $modules = Module::orderBy('name')->get();
        return view('admin.users.index', compact('users', 'modules'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email',
            'password'   => ['required', Password::min(8)],
            'role'       => 'required|in:admin,moderator',
            'modules'    => 'nullable|array',
            'modules.*'  => 'exists:modules,id',
        ]);

        $user = User::create([
            'name'            => $validated['name'],
            'email'           => $validated['email'],
            'password'        => $validated['password'],
            'is_admin_global' => $validated['role'] === 'admin',
            'is_deletable'    => true,
        ]);

        if (!$user->is_admin_global && !empty($validated['modules'])) {
            $user->modules()->sync($validated['modules']);
        }

        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuario creado correctamente.');
    }

    public function edit(User $user)
    {
        $modules = Module::orderBy('name')->get();
        return view('admin.users.edit', compact('user', 'modules'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email,' . $user->id,
            'password'  => ['nullable', Password::min(8)],
            'role'      => 'required|in:admin,moderator',
            'modules'   => 'nullable|array',
            'modules.*' => 'exists:modules,id',
        ]);

        $user->name            = $validated['name'];
        $user->email           = $validated['email'];
        $user->is_admin_global = $validated['role'] === 'admin';

        if (!empty($validated['password'])) {
            $user->password = $validated['password'];
        }

        $user->save();

        if (!$user->is_admin_global) {
            $user->modules()->sync($validated['modules'] ?? []);
        } else {
            $user->modules()->detach();
        }

        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy(User $user)
    {
        if (!$user->is_deletable) {
            return redirect()->route('admin.usuarios.index')
                ->with('error', 'Este usuario no puede ser eliminado.');
        }

        $user->modules()->detach();
        $user->delete();

        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuario eliminado correctamente.');
    }

    public function resetPassword(Request $request, User $user)
    {
        $request->validate([
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user->update(['password' => $request->password]);

        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Contraseña actualizada correctamente.');
    }

    public function bulkDestroy(Request $request)
    {
        $ids = array_filter(explode(',', $request->input('ids', '')));
        if (empty($ids)) return back()->with('error', 'No se seleccionaron elementos.');
        $deleted = 0;
        foreach ($ids as $id) {
            $user = User::find($id);
            if ($user && $user->is_deletable) {
                $user->modules()->detach();
                $user->delete();
                $deleted++;
            }
        }
        return back()->with('success', $deleted . ' usuario(s) eliminado(s).');
    }
}
