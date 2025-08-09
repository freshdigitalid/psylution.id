@props(['variant' => 'green'])

<button {{ $attributes->merge(['type' => 'button', 'class' => "text-$variant-500 bg-$variant-100 btn hover:text-white hover:bg-$variant-600 focus:text-white focus:bg-$variant-600 focus:ring focus:ring-$variant-100 active:text-white active:bg-$variant-600 active:ring active:ring-$variant-100 dark:bg-$variant-500/20 dark:text-$variant-400 dark:hover:bg-$variant-500 dark:hover:text-white dark:focus:bg-$variant-500 dark:focus:text-white dark:active:bg-$variant-500 dark:active:text-white dark:ring-$variant-400/20"]) }}>
    {{ $slot }}
</button>