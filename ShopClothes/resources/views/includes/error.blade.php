@if ($errors->has('{{ $name }}'))
    <p id="name-error" style="color: red">
        <strong>{{ $errors->first('{{ $name }}') }}</strong>
    </p>
@endif