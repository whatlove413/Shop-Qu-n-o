@if ($errors->has($name))
 <div class="alert alert-danger register-error">
   {{ $errors->first($name) }}.
 </div>
@endif