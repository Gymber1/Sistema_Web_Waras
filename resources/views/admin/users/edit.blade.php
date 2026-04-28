@extends('layouts.admin')

@section('section', 'Usuarios y Roles > Editar')

@section('content')
<div class="max-w-[720px] mx-auto">

    <div class="mb-6 flex items-start gap-4">
        <a href="{{ route('admin.usuarios.index') }}"
            class="mt-0.5 p-2 rounded-lg bg-white dark:bg-dark-surface border border-slate-200 dark:border-dark-border hover:bg-slate-50 dark:hover:bg-slate-800/50 text-slate-500 dark:text-slate-400 transition-colors shadow-premium dark:shadow-premium-dark">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
        </a>
        <div>
            <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Editar Usuario</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Modifica los datos de <span class="font-semibold text-slate-700 dark:text-slate-200">{{ $user->name }}</span>.</p>
        </div>
    </div>

    @if($errors->any())
    <div class="mb-5 flex items-start gap-3 px-5 py-3.5 bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 text-red-700 dark:text-red-400 rounded-xl text-sm">
        <i data-lucide="alert-circle" class="w-4 h-4 shrink-0 mt-0.5"></i>
        <ul class="space-y-1">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    <form action="{{ route('admin.usuarios.update', $user) }}" method="POST">
        @csrf @method('PUT')
        <div class="bg-white dark:bg-dark-surface rounded-xl shadow-premium dark:shadow-premium-dark border border-slate-200/50 dark:border-dark-border p-6 md:p-8 space-y-6">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Nombre Completo <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                        class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all"
                        placeholder="Nombre completo">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                        class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all"
                        placeholder="correo@ejemplo.com">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">
                    Nueva Contraseña
                    <span class="text-slate-400 dark:text-slate-500 font-normal text-xs ml-1">(dejar en blanco para no cambiar)</span>
                </label>
                <input type="password" name="password"
                    class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all"
                    placeholder="Mínimo 8 caracteres">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Rol <span class="text-red-500">*</span></label>
                <select name="role" required
                    class="w-full px-4 py-2.5 bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 outline-none transition-all">
                    <option value="moderator" {{ !$user->is_admin_global ? 'selected' : '' }}>Moderador</option>
                    <option value="admin"     {{ $user->is_admin_global  ? 'selected' : '' }}>Admin Global</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Módulos Accesibles</label>
                <div class="space-y-2 p-4 bg-slate-50 dark:bg-slate-800/30 border border-slate-200 dark:border-slate-700 rounded-lg">
                    @foreach($modules as $module)
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="modules[]" value="{{ $module->id }}"
                            {{ in_array($module->id, $user->modules->pluck('id')->toArray()) ? 'checked' : '' }}
                            class="w-4 h-4 rounded border-slate-300 dark:border-slate-600 text-brand-500 focus:ring-brand-500/50">
                        <span class="text-sm text-slate-700 dark:text-slate-300">{{ $module->name }}</span>
                    </label>
                    @endforeach
                    @if($modules->isEmpty())
                        <p class="text-sm text-slate-400 dark:text-slate-500">No hay módulos configurados.</p>
                    @endif
                </div>
                <p class="mt-2 text-xs text-slate-400 dark:text-slate-500">Los módulos solo aplican a usuarios con rol Moderador.</p>
            </div>

        </div>

        <div class="mt-5 flex gap-3 justify-end">
            <a href="{{ route('admin.usuarios.index') }}"
                class="px-5 py-2.5 bg-red-500 hover:bg-red-600 text-white rounded-lg text-sm font-medium transition-colors">Cancelar</a>
            <button type="submit"
                class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-sm font-medium shadow-lg shadow-emerald-500/20 transition-all flex items-center gap-2">
                <i data-lucide="check" class="w-4 h-4"></i>
                Guardar Cambios
            </button>
        </div>
    </form>
</div>
@endsection
