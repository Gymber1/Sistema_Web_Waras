@extends('layouts.admin')

@section('section', 'Usuarios y Roles')

@section('content')
<div class="max-w-[1400px] mx-auto">

    @if(session('success'))
    <div class="mb-5 flex items-center gap-3 px-5 py-3.5 bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 text-emerald-700 dark:text-emerald-400 rounded-xl text-sm font-medium">
        <i data-lucide="check-circle" class="w-4 h-4 shrink-0"></i>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="mb-5 flex items-center gap-3 px-5 py-3.5 bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 text-red-700 dark:text-red-400 rounded-xl text-sm font-medium">
        <i data-lucide="alert-circle" class="w-4 h-4 shrink-0"></i>
        {{ session('error') }}
    </div>
    @endif

    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Gestión de Usuarios</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Administra todos los usuarios del sistema y sus permisos de acceso.</p>
        </div>
        <button onclick="openModal('modal-create')"
            class="inline-flex items-center gap-2 bg-brand-500 hover:bg-brand-600 text-white px-4 py-2.5 rounded-lg text-sm font-medium transition-colors shadow-lg shadow-brand-500/30">
            <i data-lucide="plus" class="w-4 h-4"></i>
            Agregar Usuario
        </button>
    </div>

    <div class="bulk-wrapper bg-white dark:bg-dark-surface rounded-xl shadow-premium dark:shadow-premium-dark border border-slate-200/50 dark:border-dark-border overflow-hidden">
        <div class="bulk-bar"></div>
        <div class="p-5 border-b border-slate-100 dark:border-dark-border flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="relative w-full sm:w-80">
                <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                <input type="text" id="searchUsers" placeholder="Buscar usuarios..."
                    class="w-full pl-9 pr-4 py-2 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 text-slate-800 dark:text-white transition-all">
            </div>
            <span class="text-sm text-slate-500 dark:text-slate-400">{{ $users->total() }} registros</span>
        </div>

        <div class="overflow-x-auto">
            <table id="table-users" class="w-full text-left text-sm">
                <thead class="bg-slate-50/80 dark:bg-slate-800/40 border-b border-slate-200 dark:border-dark-border">
                    <tr>
                        <th class="px-4 py-4 w-10"><input type="checkbox" class="row-check check-all"></th>
                        <th class="px-6 py-4 font-semibold text-[11px] text-slate-500 dark:text-slate-400 uppercase tracking-wider">Nombre</th>
                        <th class="px-6 py-4 font-semibold text-[11px] text-slate-500 dark:text-slate-400 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-4 font-semibold text-[11px] text-slate-500 dark:text-slate-400 uppercase tracking-wider">Rol</th>
                        <th class="px-6 py-4 font-semibold text-[11px] text-slate-500 dark:text-slate-400 uppercase tracking-wider">Módulos Accesibles</th>
                        <th class="px-6 py-4 font-semibold text-[11px] text-slate-500 dark:text-slate-400 uppercase tracking-wider">Creado</th>
                        <th class="px-6 py-4 font-semibold text-[11px] text-slate-500 dark:text-slate-400 uppercase tracking-wider text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-dark-border" id="usersTableBody">
                    @forelse($users as $u)
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/20 transition-colors group user-row"
                        data-name="{{ strtolower($u->name) }}" data-email="{{ strtolower($u->email) }}">
                        <td class="px-4 py-4"><input type="checkbox" class="row-check" value="{{ $u->id }}"></td>
                        <td class="px-6 py-4 font-medium text-slate-800 dark:text-white">{{ $u->name }}</td>
                        <td class="px-6 py-4 text-slate-500 dark:text-slate-400">{{ $u->email }}</td>
                        <td class="px-6 py-4">
                            @if($u->is_admin_global)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[11px] font-medium bg-brand-50 text-brand-700 dark:bg-brand-500/10 dark:text-brand-400 border border-brand-100 dark:border-brand-500/20">
                                    <i data-lucide="key" class="w-3 h-3"></i> Admin Global
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[11px] font-medium bg-amber-50 text-amber-700 dark:bg-amber-500/10 dark:text-amber-400 border border-amber-100 dark:border-amber-500/20">
                                    <i data-lucide="shield" class="w-3 h-3"></i> Moderador
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($u->is_admin_global)
                                <span class="text-[11px] text-brand-600 dark:text-brand-400 font-medium">Todos los módulos</span>
                            @else
                                <div class="flex flex-wrap gap-1">
                                    @forelse($u->modules as $mod)
                                        <span class="text-[11px] bg-slate-100 dark:bg-slate-700/50 text-slate-700 dark:text-slate-300 px-2 py-0.5 rounded-md">{{ $mod->name }}</span>
                                    @empty
                                        <span class="text-[11px] text-slate-400 dark:text-slate-500">Sin módulos</span>
                                    @endforelse
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-slate-400 dark:text-slate-500">{{ $u->created_at->diffForHumans() }}</td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-1">
                                <button onclick="openResetModal({{ $u->id }}, '{{ addslashes($u->name) }}')"
                                    class="p-2 text-slate-400 hover:text-amber-600 dark:hover:text-amber-400 hover:bg-amber-50 dark:hover:bg-amber-500/10 rounded-lg transition-colors" title="Cambiar Contraseña">
                                    <i data-lucide="lock" class="w-4 h-4"></i>
                                </button>
                                <a href="{{ route('admin.usuarios.edit', $u) }}"
                                    class="p-2 text-slate-400 hover:text-brand-600 dark:hover:text-brand-400 hover:bg-brand-50 dark:hover:bg-brand-500/10 rounded-lg transition-colors" title="Editar">
                                    <i data-lucide="edit" class="w-4 h-4"></i>
                                </a>
                                @if($u->is_deletable)
                                <form action="{{ route('admin.usuarios.destroy', $u) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        onclick="confirmDelete(this.closest('form'), '¿Eliminar al usuario {{ addslashes($u->name) }}? Esta acción no se puede deshacer.'); return false;"
                                        class="p-2 text-slate-400 hover:text-red-600 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-500/10 rounded-lg transition-colors" title="Eliminar">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                                @else
                                <button disabled title="Administrador principal protegido"
                                    class="p-2 text-slate-200 dark:text-slate-700 rounded-lg cursor-not-allowed">
                                    <i data-lucide="lock" class="w-4 h-4"></i>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center gap-3 text-slate-400 dark:text-slate-500">
                                <i data-lucide="users" class="w-10 h-10 opacity-30"></i>
                                <p class="text-sm font-medium">No hay usuarios registrados</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <x-admin-pagination :paginator="$users" />
    </div>
</div>

@endsection

@push('modals')
{{-- ===== MODAL CREAR USUARIO ===== --}}
<div id="modal-create" class="hidden fixed inset-0 z-[9998] overflow-y-auto">
    <div class="flex min-h-full items-center justify-center p-4">
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeModal('modal-create')"></div>
    <div class="relative bg-white dark:bg-dark-surface rounded-2xl shadow-2xl w-full max-w-2xl flex flex-col border border-slate-200/50 dark:border-dark-border">
        <div class="flex items-center justify-between px-8 py-5 border-b border-slate-100 dark:border-dark-border">
            <div>
                <h2 class="text-xl font-bold text-slate-800 dark:text-white">Agregar Usuario</h2>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">Completa los campos requeridos a continuación.</p>
            </div>
            <button onclick="closeModal('modal-create')" class="p-2 text-slate-400 hover:text-slate-700 dark:hover:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-lg transition-colors">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        <div class="p-8 overflow-y-auto">
            @if($errors->any())
            <div class="mb-5 flex items-start gap-3 px-4 py-3.5 bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 text-red-700 dark:text-red-400 rounded-xl text-sm">
                <i data-lucide="alert-circle" class="w-4 h-4 shrink-0 mt-0.5"></i>
                <ul class="space-y-1">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
            @endif
            <form action="{{ route('admin.usuarios.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-5">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Nombre Completo <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all"
                        placeholder="Ingrese el nombre">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all"
                        placeholder="correo@ejemplo.com">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Contraseña <span class="text-red-500">*</span></label>
                    <input type="password" name="password" required
                        class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all"
                        placeholder="Mínimo 8 caracteres">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Rol <span class="text-red-500">*</span></label>
                    <select name="role" required
                        class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all">
                        <option value="moderator" {{ old('role') === 'admin' ? '' : 'selected' }}>Moderador</option>
                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin Global</option>
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Módulos Accesibles</label>
                    <div class="space-y-2 p-4 bg-slate-50 dark:bg-slate-800/30 border border-slate-200 dark:border-slate-700 rounded-lg">
                        @foreach($modules as $module)
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" name="modules[]" value="{{ $module->id }}"
                                {{ in_array($module->id, old('modules', [])) ? 'checked' : '' }}
                                class="w-4 h-4 rounded border-slate-300 dark:border-slate-600 text-brand-500 focus:ring-brand-500/50">
                            <span class="text-sm text-slate-700 dark:text-slate-300">{{ $module->name }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
                <div class="md:col-span-2 flex justify-end gap-3 pt-2">
                    <button type="button" onclick="closeModal('modal-create')"
                        class="px-5 py-2.5 text-sm font-medium text-slate-600 dark:text-slate-300 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 rounded-lg transition-colors">
                        Cancelar
                    </button>
                    <button type="submit"
                        class="px-5 py-2.5 text-sm font-medium text-white bg-brand-500 hover:bg-brand-600 shadow-lg shadow-brand-500/30 rounded-lg transition-all flex items-center gap-2">
                        <i data-lucide="check" class="w-4 h-4"></i>
                        Guardar Usuario
                    </button>
                </div>
            </form>
        </div>
    </div>
    </div>{{-- /flex min-h-full --}}
</div>

{{-- ===== MODAL RESETEAR CONTRASEÑA ===== --}}
<div id="modal-reset" class="hidden fixed inset-0 z-[9998] overflow-y-auto">
    <div class="flex min-h-full items-center justify-center p-4">
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeModal('modal-reset')"></div>
    <div class="relative bg-white dark:bg-dark-surface rounded-2xl shadow-2xl w-full max-w-md border border-slate-200/50 dark:border-dark-border">
        <div class="flex items-center justify-between px-8 py-5 border-b border-slate-100 dark:border-dark-border">
            <div>
                <h2 class="text-xl font-bold text-slate-800 dark:text-white">Cambiar Contraseña</h2>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5" id="resetModalSubtitle">Usuario</p>
            </div>
            <button onclick="closeModal('modal-reset')" class="p-2 text-slate-400 hover:text-slate-700 dark:hover:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-lg transition-colors">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        <form id="resetForm" method="POST" class="p-8 space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Nueva Contraseña <span class="text-red-500">*</span></label>
                <input type="password" name="password" required
                    class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500 outline-none transition-all"
                    placeholder="Mínimo 8 caracteres">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Confirmar Contraseña <span class="text-red-500">*</span></label>
                <input type="password" name="password_confirmation" required
                    class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500 outline-none transition-all"
                    placeholder="Repite la contraseña">
            </div>
            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="closeModal('modal-reset')"
                    class="px-5 py-2.5 text-sm font-medium text-slate-600 dark:text-slate-300 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 rounded-lg transition-colors">
                    Cancelar
                </button>
                <button type="submit"
                    class="px-5 py-2.5 text-sm font-medium text-white bg-amber-500 hover:bg-amber-600 shadow-lg shadow-amber-500/30 rounded-lg transition-all">
                    Actualizar Contraseña
                </button>
            </div>
        </form>
    </div>
    </div>{{-- /flex min-h-full --}}
</div>

<script>
function openModal(id) { document.getElementById(id).classList.remove('hidden'); }
function closeModal(id) { document.getElementById(id).classList.add('hidden'); }

function openResetModal(userId, userName) {
    document.getElementById('resetModalSubtitle').textContent = userName;
    document.getElementById('resetForm').action = `/admin/usuarios/${userId}/reset-password`;
    openModal('modal-reset');
}

@if($errors->any())
    openModal('modal-create');
@endif

document.getElementById('searchUsers').addEventListener('input', function() {
    const q = this.value.toLowerCase();
    document.querySelectorAll('.user-row').forEach(row => {
        const match = row.dataset.name.includes(q) || row.dataset.email.includes(q);
        row.style.display = match ? '' : 'none';
    });
});
</script>
@endpush
