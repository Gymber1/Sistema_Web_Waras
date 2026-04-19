@extends('layouts.admin')

@section('section', 'Editar Usuario')

@section('content')
<div class="p-6 md:p-10 max-w-2xl mx-auto">

    @if($errors->any())
    <div class="mb-6 px-5 py-4 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm">
        <p class="font-bold mb-1">Por favor corrige los siguientes errores:</p>
        <ul class="list-disc list-inside space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('admin.usuarios.index') }}"
            class="p-2 text-slate-400 hover:text-slate-700 hover:bg-slate-100 rounded-xl transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Editar Usuario</h1>
            <p class="text-slate-500 mt-1">Modifica los datos de <span class="font-semibold text-slate-700">{{ $user->name }}</span>.</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-8 py-5 border-b border-slate-100 bg-slate-50/50">
            <h2 class="text-lg font-bold text-slate-800">Información del usuario</h2>
        </div>

        <form action="{{ route('admin.usuarios.update', $user) }}" method="POST" class="p-8 space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">
                        Nombre Completo <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-violet-500 outline-none transition-all shadow-sm"
                        placeholder="Nombre completo">
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-violet-500 outline-none transition-all shadow-sm"
                        placeholder="correo@ejemplo.com">
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">
                    Nueva Contraseña
                    <span class="text-slate-400 font-normal text-xs ml-1">(dejar en blanco para no cambiar)</span>
                </label>
                <input type="password" name="password"
                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-violet-500 outline-none transition-all shadow-sm"
                    placeholder="Mínimo 8 caracteres">
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">
                    Rol <span class="text-red-500">*</span>
                </label>
                <select name="role" required
                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-violet-500 outline-none transition-all shadow-sm">
                    <option value="moderator" {{ !$user->is_admin_global ? 'selected' : '' }}>🛡️ Moderador</option>
                    <option value="admin"     {{ $user->is_admin_global  ? 'selected' : '' }}>🔑 Admin Global</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-3">Módulos Accesibles</label>
                <div class="space-y-2 p-4 bg-slate-50 border border-slate-200 rounded-xl">
                    @foreach($modules as $module)
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="modules[]" value="{{ $module->id }}"
                            {{ in_array($module->id, $user->modules->pluck('id')->toArray()) ? 'checked' : '' }}
                            class="w-4 h-4 rounded border-slate-300 text-violet-600 focus:ring-violet-500">
                        <span class="text-sm font-medium text-slate-700">{{ $module->name }}</span>
                    </label>
                    @endforeach
                    @if($modules->isEmpty())
                        <p class="text-sm text-slate-400">No hay módulos configurados.</p>
                    @endif
                </div>
                <p class="mt-2 text-xs text-slate-400">Los módulos sólo aplican a usuarios con rol Moderador.</p>
            </div>

            <div class="flex justify-end gap-4 pt-2 border-t border-slate-100">
                <a href="{{ route('admin.usuarios.index') }}"
                    class="px-6 py-3 text-sm font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">
                    Cancelar
                </a>
                <button type="submit"
                    class="px-8 py-3 text-sm font-bold text-white bg-violet-600 hover:bg-violet-700 shadow-lg shadow-violet-200 rounded-xl transition-all flex items-center gap-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
