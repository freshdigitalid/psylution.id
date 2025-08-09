@props(['variant' => 'slate'])

<button {{ $attributes->merge(['type' => 'submit', 'class' => "text-white bg-$variant-500 border-$variant-500 btn hover:text-white hover:bg-$variant-600 hover:border-$variant-600 focus:text-white focus:bg-$variant-600 focus:border-$variant-600 focus:ring focus:ring-$variant-100 active:text-white active:bg-$variant-600 active:border-$variant-600 active:ring active:ring-$variant-100 dark:ring-$variant-400/10"]) }}>
    {{ $slot }}
</button>
