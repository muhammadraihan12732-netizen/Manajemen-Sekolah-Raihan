@props(['name', 'label', 'type' => 'text', 'value' => null, 'required' => false, 'placeholder' => ''])
<label for="{{ $name }}" class="form-label">{{ $label }} @if($required)<span class="text-danger">*</span>@endif</label>
<input type="{{ $type }}" id="{{ $name }}" name="{{ $name }}" value="{{ old($name, $value) }}" placeholder="{{ $placeholder }}"
    {{ $attributes->class(['form-control', 'is-invalid' => $errors->has($name)]) }}>
@error($name)<div class="invalid-feedback">{{ $message }}</div>@enderror
