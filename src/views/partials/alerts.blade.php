@if(Session::has('success'))
<div class="alert alert-success">{{ Session::get('success') }}</div>
@endif
@if(Session::has('info'))
<div class="alert alert-info">{{ Session::get('info') }}</div>
@endif
@if (Session::has('flash_error'))
<div id="flash_error" class="alert alert-danger">{{ Session::get('flash_error') }}</div>
@endif
@if(!empty($error))
<div class="alert alert-danger">{{ $error }}</div>
@endif
@if (Session::has('error'))
<div class="alert alert-danger">{{ Session::get('error') }}</div>
@endif