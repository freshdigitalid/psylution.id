@props(['value'])

<label {{ $attributes->merge(['class' => 'inline-block mb-2 text-base font-medium']) }}>
    {{ $value ?? $slot }} <span class="text-sm text-red-600">*</span>
</label>
