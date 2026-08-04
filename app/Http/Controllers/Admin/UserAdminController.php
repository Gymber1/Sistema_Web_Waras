<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\HasSortableColumns;
use App\Models\User;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserAdminController extends Controller
{
    use HasSortableColumns;

    public function index(Request $request)
    {
        $q = trim((string) $request->input('search', ''));

        $query = User::with('modules')
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('name', 'like', "%{$q}%")
                        ->orWhere('email', 'like', "%{$q}%");
                });
            });

        $query = $this->applySort($query, $request, ['name', 'email', 'is_admin_global', 'created_at'], 'name', 'asc');

        $users = $query->paginate(10)->withQueryString();
        $modules = Module::orderBy('name')->get();
        return view('admin.users.index', compact('users', 'modules', 'q'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email',
            'password'   => ['required', 'string', 'min:1'],
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
            'password'  => ['nullable', 'string', 'min:1'],
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
        // Bag propio para que el error se muestre en el modal de contraseña (no en el de crear)
        $validator = Validator::make($request->all(), [
            'password' => ['required', 'confirmed', 'string', 'min:1'],
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator, 'resetPassword')
                ->with('reset_user_id', $user->id)
                ->with('reset_user_name', $user->name);
        }

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
