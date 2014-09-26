{{ Form::open(array('action' => 'UserController@login')) }}
	@if (isset($msg))
		{{ Form::hidden('fromURL', $msg['fromURL']) }}
	@else
		{{ Form::hidden('fromURL', '') }}
	@endif
	{{ Form::label('user_name', 'Username'); }}
	{{ Form::text('user_name', 'username or email'); }}<br/>
	{{ Form::label('user_password', 'Password'); }}
	{{ Form::password('user_password'); }}<br/>
	{{ Form::submit('Login'); }}
{{ Form::close() }}