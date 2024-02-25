@props(['type'])

<?php
    $class = 'alert alert-'.$type;
?>

@if (session()->has($type))
    <div {{ $attributes->merge(['class' => $class]) }} role="alert">{{{ Str::ucfirst(session()->get($type)) }}} </div>
@endif
