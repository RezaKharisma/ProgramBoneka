@props(['disabled' => false,'for' => false])

<?php
    $class = "form-control";
    if ($errors->has($for)) {
        $class .= " is-invalid";
    }
?>

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => $class]) !!}>
