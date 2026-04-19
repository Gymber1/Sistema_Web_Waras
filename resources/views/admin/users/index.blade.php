@extends('layouts.admin')

@section('section', 'Usuarios y Roles')

@section('content')
<div class="p-6 md:p-10 max-w-[1600px] mx-auto">

    @if(session('success'))
    <div class="mb-6 px-5 py-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm font-medium flex items-center gap-2">
        <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="mb-6 px-5 py-3 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm font-medium flex items-center gap-2">
        <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
        {{ session('error') }}
    </div>
    @endif

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Gestión de Usuarios</h1>
            <p class="text-slate-500 mt-1">Administra todos los usuarios del sistema y sus permisos de acceso.</p>
        </div>
        <button onclick="openModal('modal-create')"
            class="flex items-center gap-2 bg-violet-600 hover:bg-violet-700 text-white px-6 py-3 rounded-xl font-bold shadow-lg shadow-violet-200 transition-all transform hover:-translate-y-0.5">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Agregar Usuario
        </button>
    </div>

    <div class="bg-white rounded-2xl shadow-sm overflow-hidden flex flex-col border-t-4 border-violet-500">
        <div class="p-5 border-b border-slate-100 flex flex-wrap justify-between items-center bg-white gap-4">
            <div class="relative w-full sm:w-80">
                <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <input type="text" id="searchUsers" placeholder="Buscar usuarios..."
                    class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-violet-500 focus:bg-white transition-all">
            </div>
            <span class="text-sm font-bold bg-violet-50 text-violet-700 px-4 py-2 rounded-lg">{{ $users->count() }} Registros</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-200">
                        <th class="py-4 px-6 text-xs font-bold text-slate-500 uppercase tracking-widest">Nombre</th>
                        <th class="py-4 px-6 text-xs font-bold text-slate-500 uppercase tracking-widest">Email</th>
                        <th class="py-4 px-6 text-xs font-bold text-slate-500 uppercase tracking-widest">Rol</th>
                        <th class="py-4 px-6 text-xs font-bold text-slate-500 uppercase tracking-widest">Módulos Accesibles</th>
                        <th class="py-4 px-6 text-xs font-bold text-slate-500 uppercase tracking-widest">Creado</th>
                        <th class="py-4 px-6 text-xs font-bold text-slate-500 uppercase tracking-widest text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100" id="usersTableBody">
                    @forelse($users as $u)
                    <tr class="hover:bg-slate-50 transition-colors group user-row" data-name="{{ strtolower($u->name) }}" data-email="{{ strtolower($u->email) }}">
                        <td class="py-4 px-6 text-sm text-slate-700 font-medium">{{ $u->name }}</td>
                        <td class="py-4 px-6 text-sm text-slate-500">{{ $u->email }}</td>
                        <td class="py-4 px-6">
                            <span class="px-3 py-1.5 {{ $u->is_admin_global ? 'bg-indigo-100 text-indigo-700' : 'bg-amber-100 text-amber-700' }} rounded-lg text-xs font-bold">
                                {{ $u->is_admin_global ? '🔑 Admin Global' : '🛡️ Moderador' }}
                            </span>
                        </td>
                        <td class="py-4 px-6">
                            @if($u->is_admin_global)
                                <span class="text-[11px] bg-indigo-50 text-indigo-600 px-2 py-1 rounded font-medium">Todos los módulos</span>
                            @else
                                <div class="flex flex-wrap gap-1">
                                    @forelse($u->modules as $mod)
                                        <span class="text-[11px] bg-slate-100 text-slate-700 px-2 py-1 rounded">{{ $mod->name }}</span>
                                    @empty
                                        <span class="text-[11px] text-slate-400">Sin módulos</span>
                                    @endforelse
                                </div>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-sm text-slate-400">{{ $u->created_at->diffForHumans() }}</td>
                        <td class="py-4 px-6 text-right">
                            <div class="flex items-center justify-end gap-2 opacity-60 group-hover:opacity-100 transition-opacity">
                                {{-- Cambiar contraseña --}}
                                <button onclick="openResetModal({{ $u->id }}, '{{ addslashes($u->name) }}')"
                                    class="p-2 text-slate-500 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors bg-white border border-slate-100 shadow-sm" title="Cambiar Contraseña">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                </button>
                                {{-- Editar --}}
                                <a href="{{ route('admin.usuarios.edit', $u) }}"
                                    class="p-2 text-slate-500 hover:text-violet-600 hover:bg-violet-50 rounded-lg transition-colors bg-white border border-slate-100 shadow-sm" title="Editar">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                {{-- Eliminar: oculto si is_deletable = false --}}
                                @if($u->is_deletable)
                                <form action="{{ route('admin.usuarios.destroy', $u) }}" method="POST"
                                    onsubmit="return confirm('¿Eliminar al usuario {{ addslashes($u->name) }}? Esta acción no se puede deshacer.')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="p-2 text-slate-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors bg-white border border-slate-100 shadow-sm" title="Eliminar">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                                @else
                                <button disabled title="Administrador principal protegido"
                                    class="p-2 text-slate-300 rounded-lg bg-white border border-slate-100 shadow-sm cursor-not-allowed" >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-16 text-center">
                            <div class="inline-flex flex-col items-center">
                                <div class="w-16 h-16 rounded-full bg-violet-50 flex items-center justify-center mb-4">
                                    <svg class="w-8 h-8 text-violet-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.768-.231-1.48-.634-2.072M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.768.231-1.48.634-2.072m0 0a4 4 0 117.732 0"></path></svg>
                                </div>
                                <h3 class="text-lg font-bold text-slate-700 mb-1">No hay usuarios</h3>
                                <p class="text-sm text-slate-500">Comienza agregando un nuevo usuario al sistema.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- ===== MODAL CREAR USUARIO ===== --}}
<div id="modal-create" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeModal('modal-create')"></div>
    <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-2xl max-h-[90vh] flex flex-col">
        <div class="flex items-center justify-between px-10 py-6 border-b border-slate-100">
            <div>
                <h2 class="text-2xl font-black text-slate-900">Agregar Usuario</h2>
                <p class="text-sm text-slate-500 mt-1">Completa los campos requeridos a continuación.</p>
            </div>
            <button onclick="closeModal('modal-create')" class="p-3 text-slate-400 hover:text-slate-700 hover:bg-slate-100 rounded-full transition-colors">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
            </button>
        </div>
        <div class="p-10 overflow-y-auto custom-scrollbar">
            <form action="{{ route('admin.usuarios.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @csrf
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Nombre Completo <span class="text-red-500">*</span></label>
                    <input type="text" name="name" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-violet-500 outline-none transition-all shadow-sm" placeholder="Ingrese el nombre">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-violet-500 outline-none transition-all shadow-sm" placeholder="correo@ejemplo.com">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Contraseña <span class="text-red-500">*</span></label>
                    <input type="password" name="password" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-violet-500 outline-none transition-all shadow-sm" placeholder="Mínimo 8 caracteres">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Rol <span class="text-red-500">*</span></label>
                    <select name="role" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-violet-500 outline-none transition-all shadow-sm">
                        <option value="moderator">🛡️ Moderador</option>
                        <option value="admin">🔑 Admin Global</option>
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Módulos Accesibles</label>
                    <div class="space-y-2 p-4 bg-slate-50 border border-slate-200 rounded-xl">
                        @foreach($modules as $module)
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" name="modules[]" value="{{ $module->id }}" class="w-4 h-4 rounded border-slate-300 text-violet-600 focus:ring-violet-500">
                            <span class="text-sm font-medium text-slate-700">{{ $module->name }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
                <div class="md:col-span-2 flex justify-end gap-4 pt-2">
                    <button type="button" onclick="closeModal('modal-create')" class="px-6 py-3 text-sm font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">Cancelar</button>
                    <button type="submit" class="px-8 py-3 text-sm font-bold text-white bg-violet-600 hover:bg-violet-700 shadow-lg shadow-violet-200 rounded-xl transition-all flex items-center gap-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        Guardar Usuario
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ===== MODAL RESETEAR CONTRASEÑA ===== --}}
<div id="modal-reset" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeModal('modal-reset')"></div>
    <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-md">
        <div class="flex items-center justify-between px-8 py-6 border-b border-slate-100">
            <div>
                <h2 class="text-xl font-black text-slate-900">Cambiar Contraseña</h2>
                <p class="text-sm text-slate-500 mt-1" id="resetModalSubtitle">Usuario</p>
            </div>
            <button onclick="closeModal('modal-reset')" class="p-3 text-slate-400 hover:text-slate-700 hover:bg-slate-100 rounded-full transition-colors">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
            </button>
        </div>
        <form id="resetForm" method="POST" class="p-8 space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Nueva Contraseña <span class="text-red-500">*</span></label>
                <input type="password" name="password" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-amber-500 outline-none shadow-sm" placeholder="Mínimo 8 caracteres">
            </div>
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Confirmar Contraseña <span class="text-red-500">*</span></label>
                <input type="password" name="password_confirmation" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-amber-500 outline-none shadow-sm" placeholder="Repite la contraseña">
            </div>
            <div class="flex justify-end gap-4 pt-2">
                <button type="button" onclick="closeModal('modal-reset')" class="px-6 py-3 text-sm font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">Cancelar</button>
                <button type="submit" class="px-6 py-3 text-sm font-bold text-white bg-amber-500 hover:bg-amber-600 rounded-xl shadow-lg shadow-amber-200 transition-all">
                    Actualizar Contraseña
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openModal(id) { document.getElementById(id).classList.remove('hidden'); }
function closeModal(id) { document.getElementById(id).classList.add('hidden'); }

function openResetModal(userId, userName) {
    document.getElementById('resetModalSubtitle').textContent = userName;
    document.getElementById('resetForm').action = `/admin/usuarios/${userId}/reset-password`;
    openModal('modal-reset');
}

// Búsqueda en tiempo real
document.getElementById('searchUsers').addEventListener('input', function() {
    const q = this.value.toLowerCase();
    document.querySelectorAll('.user-row').forEach(row => {
        const match = row.dataset.name.includes(q) || row.dataset.email.includes(q);
        row.style.display = match ? '' : 'none';
    });
});
</script>
@endsection
