@props(['record'])

@error($record)
    <div class="invalid-feedback text-left">
        {{ $message }}
    </div>
@enderror
