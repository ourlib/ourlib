<div class="loginFormH">
{{ Form::open(array('action' => 'UserController@login')) }}
	@if (isset($fromURL))
		{{ Form::hidden('fromURL', $fromURL) }}
	@else
		{{ Form::hidden('fromURL', '') }}
	@endif
	<div class="loginFormHUname" style="display:inline-block;padding-left:2px;">
		{{ Form::label('user_name', 'Username'); }}
		{{ Form::text('user_name', 'username or email'); }} 
	</div>
	<div class="loginFormHPwd" style="display:inline-block;padding-left:2px;">
		{{ Form::label('user_password', 'Password'); }}
		{{ Form::password('user_password'); }}
		{{ Form::submit('Login', array('class' => 'normalButton')); }}
	</div>
{{ Form::close() }}
</div>