<div class="formDiv">
	<a name="AddBooks"></a>
	<span class="formTitle">
		@if (isset($addMoreBooks) && ($addMoreBooks))
			Add More Books
		@else
			Add Books That You Are Willing To Lend
		@endif
		</span><br/>
	<br/>
	{{ Form::open(array('action' => 'BookController@addBook')) }}
	Title<br/>
	{{ Form::text('Title', '', ['required','size'=>40,'maxlength'=>100]) }}<br/>
	Sub Title<br/>
	{{ Form::text('SubTitle', '', ['size'=>40,'maxlength'=>100]) }}<br/>
	Author (or editor or series name)<br/>
	{{ Form::text('Author1', '', ['required','size'=>40,'maxlength'=>100]) }}<br/>
	Any other authors?<br/>
	{{ Form::text('Author2', '', ['size'=>40,'maxlength'=>100]) }}<br/>
	Language<br/>
	{{ Form::text('Language1', 'English', ['required','maxlength'=>50]) }}<br/>
	Any other language? (for multi-lingual books)<br/>
	{{ Form::text('Language2', '', ['maxlength'=>50]) }}<br/>
	{{ Form::submit('Yes, Add', array('class' => 'richButton')); }}
	{{ Form::close() }}
</div>