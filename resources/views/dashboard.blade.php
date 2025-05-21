<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <h2>Crear Coordinador</h2>

        <form method="POST" action="{{ route('coordinators.store') }}" enctype="multipart/form-data">
            @csrf

            <input type="text" name="name" placeholder="Nombre" required>
            <input type="text" name="username" placeholder="Nombre de usuario" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <input type="password" name="password_confirmation" placeholder="Confirmar contraseña" required>

            <input type="email" name="email" placeholder="Correo (opcional)">
            <input type="text" name="phone" placeholder="Teléfono (opcional)">

            <select name="state" required>
                <option value="">Seleccionar estado</option>
                @foreach(['Aguascalientes', 'Baja California', 'Chiapas', 'Jalisco', 'Yucatán'] as $state)
                    <option value="{{ $state }}">{{ $state }}</option>
                @endforeach
            </select>

            <input type="text" name="municipality" placeholder="Municipio (opcional)">
            <input type="file" name="photo" accept="image/*">

            <button type="submit">Crear</button>
        </form>
    </div>
</x-layouts.app>
