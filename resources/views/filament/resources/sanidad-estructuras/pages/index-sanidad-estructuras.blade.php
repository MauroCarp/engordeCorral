<x-filament-panels::page>
    <div class="mb-6">
        <label for="selectedModeloId" class="mb-2 block text-sm font-medium text-gray-950 dark:text-white">
            Modelo
        </label>
        <select
            id="selectedModeloId"
            wire:model.live="selectedModeloId"
            class="fi-select-input block w-full max-w-md rounded-lg border-none bg-white py-1.5 ps-3 pe-3 text-base text-gray-950 shadow-sm ring-1 ring-gray-950/10 transition duration-75 focus:ring-2 focus:ring-primary-600 dark:bg-white/5 dark:text-white dark:ring-white/10 dark:focus:ring-primary-500 sm:text-sm sm:leading-6"
        >
            @foreach ($this->modeloOptions as $id => $nombre)
                <option value="{{ $id }}">{{ $nombre }}</option>
            @endforeach
        </select>
    </div>
</x-filament-panels::page>
