@props(['name', 'label', 'value' => null, 'required' => false, 'rows' => 4])
<label for="{{ $name }}" class="form-label">{{ $label }} @if($required)<span class="text-danger">*</span>@endif</label>
<textarea id="{{ $name }}" name="{{ $name }}" rows="{{ $rows }}"
    {{ $attributes->class(['form-control', 'is-invalid' => $errors->has($name)]) }}>{{ old($name, $value) }}</textarea>
@error($name)<div class="invalid-feedback">{{ $message }}</div>@enderror
