@props(['id' => null, 'maxWidth' => null])

<x-modal :id="$id" :maxWidth="$maxWidth" {{ $attributes }}>
    <div class="px-6 py-4">
        <h5>
            {{ $title }}
        </h5>

        <div class="mt-4 text-sm text-gray-600 dark:text-slate-400">
            {{ $content }}
        </div>
    </div>

    <div class="flex flex-row justify-end px-6 py-4 bg-slate-50 dark:bg-zink-600 text-end">
        {{ $footer }}
    </div>
</x-modal>
