@if (session()->has('flash_notification.message'))
<div class="callout callout-{{ session()->get('flash_notification.level') }}">
	{{ session()->get('flash_notification.message') }}
</div>
@endif
@if (count($errors) > 0)
<div class="callout callout-danger" role="alert">
	<strong>Errors:</strong>
	<ul>
		@foreach ($errors->all() as $e)
		<li>{{ $e }}</li>
		@endforeach
	</ul>
</div>
@endif