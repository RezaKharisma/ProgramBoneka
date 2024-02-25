@props(['value', 'require' => null])

<label {{ $attributes->merge(['class' => '']) }}>
    {{ $value ?? $slot }}  @if ($require) <span style="color: red">*</span> @endif
</label>
