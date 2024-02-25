<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-lg btn-primary']) }}>
    {{ $slot }}
</button>
