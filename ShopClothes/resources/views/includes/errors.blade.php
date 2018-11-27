@if( $errors->any() )
<textarea id="msgAdmin" type-msg="danger" time-msg="15000" hidden>
    @foreach ($errors->all() as $error)
        {{ $error }}
    @endforeach
    <br>
</textarea>
@endif