
@extends('templates.base')

<?php
	$loggedIn = false;
	if (Session::has('loggedInUser'))
		$loggedIn = true;
	$pendingReqURL = URL::to('pendingRequests');
	$returnForm = URL::to('returnForm');
	$tMsg = ["",""];
	if (Session::has('TransactionMessage'))
	{
		$tMsg = Session::get('TransactionMessage');
		//if (($tMsg[0] == 'LendBook') || ($tMsg[0] == 'ReturnBook'))
		//{
			Session::forget('TransactionMessage');	
		//}
	}
	if ($currentLanguage == 'all')
		$currentLanguageLinkValue = 'all';
	else
		$currentLanguageLinkValue = $currentLanguage->LanguageEnglish;

	if ($currentLocation == 'all')
		$currentLocationLinkValue = 'all';
	else
		$currentLocationLinkValue = $currentLocation->Location;

	if ($currentCategory == 'all')
		$currentCategoryLinkValue = 'all';
	else
		$currentCategoryLinkValue = $currentCategory->Category;

	$bookCount = $books->count();
?>

@section('title', 'Full Collection: ')

@section('content')

<!-- --- BROWSE FILTER SECTION --- -->
<div class="filterSection">

<!-- === MODE : ALL / BORROW / TAKE-AWAY === -->
@if ($currentMode == 'all')
	<b>all</b>
@else
	<a href={{ URL::route('browse', array('all',$currentLocationLinkValue,$currentLanguageLinkValue,$currentCategoryLinkValue))}}>all</a>
@endif
 | 
@if ($currentMode == 'borrow')
	<b>To Borrow</b>
@else
	<a href={{ URL::route('browse', array('borrow',$currentLocationLinkValue,$currentLanguageLinkValue,$currentCategoryLinkValue))}}>To Borrow</a>
@endif
 | 
@if ($currentMode == 'take-away')
	<b>To Take Away</b>
@else
	<a href={{ URL::route('browse', array('take-away',$currentLocationLinkValue,$currentLanguageLinkValue,$currentCategoryLinkValue))}}>To Take Away</a>
@endif

<!-- === LOCATION === -->
@if ($locations)
<br/>
Location: 
	@if ($currentLocation != 'all')
		<a href={{ URL::route('browse', array($currentMode,'all',$currentLanguageLinkValue,$currentCategoryLinkValue))}}>
			all
		</a>
	@else
		<b>all</b>
	@endif
	@foreach($locations as $location)
			| 
		@if (($currentLocation == 'all') || ($currentLocation->ID != $location->ID))
			<a href={{ URL::route('browse', array($currentMode,$location->Location,$currentLanguageLinkValue,$currentCategoryLinkValue))}}>
				{{{ $location->Location}}}
			</a>
		@else
			<b>{{{ $location->Location }}}</b>
		@endif
	@endforeach
@endif
<!--<br/>
Showing: <b>{{{ $currentLocation }}}</b><br/>-->

<!-- --- LANGUAGE --- -->
@if ($languages)
<br/>
Language: 
	@if ($currentLanguage != 'all')
		<a href={{ URL::route('browse', array($currentMode,$currentLocationLinkValue,'all',$currentCategoryLinkValue))}}>
			all
		</a>
	@else
		<b>all</b>
	@endif
	@foreach($languages as $language)
			| 
		@if (($currentLanguage == 'all') || ($currentLanguage->ID != $language->ID))
			<a href={{ URL::route('browse', array($currentMode,$currentLocationLinkValue,$language->LanguageEnglish,$currentCategoryLinkValue))}}>
				{{{ $language->LanguageEnglish}}}
			</a>
		@else
			<b>{{{ $language->LanguageEnglish }}}</b>
		@endif
	@endforeach
@endif

<!-- --- CATEGORY --- -->
<br/>
@if ($categories)
Category: 
	@if ($currentCategory != 'all')
		<a href={{ URL::route('browse', array($currentMode,$currentLocationLinkValue,$currentLanguageLinkValue,'all'))}}>
			all
		</a>
	@else
		<b>all</b>
	@endif
	@foreach($categories as $category)
			| 
		@if (($currentCategory == 'all') || ($currentCategory->ID != $category->ID))
			<a href={{ URL::route('browse', array($currentMode,$currentLocationLinkValue,$currentLanguageLinkValue,$category->Category))}}>
				{{{ $category->Category}}}
			</a>
		@else
			<b>{{{ $category->Category }}}</b>
		@endif
	@endforeach
@endif
</div>
<!-- --- END BROWSE FILTER SECTION --- -->

<!--
@if (!$loggedIn)
	<form action={{URL::to('/signup-or-login')}}>
		{{ Form::submit('Become a Member', 
			array('class' => 'richButton',
			'name'=>'btnMember')); }}
		{{ Form::submit('Login', 
			array('class' => 'normalButton',
			'name'=>'btnLogin')); }} to request books to borrow, to add your own books to lend.
	</form>	
@endif
-->

@if ($tMsg[1]!="")
	<p align='center'>
		<span style="border:2px solid blue;padding:4px;background-color:LemonChiffon">
			{{{$tMsg[1][1] }}}
		</span>
	</p>
@endif

<!-- --- BOOK LISTING --- -->

@if ($bookCount > 0)
	{{ $books->links() }}
	<br/>
		@foreach($books as $book)
			<div class="bookMat">
				<a href={{  URL::route('single-book', array($book->ID))}}>
				@if (strlen($book->CoverFilename)>0)
				{{ HTML::image('images/book-covers/'.$book->CoverFilename, 'a picture', array('height' => '150')) }}<br/>
				@endif
				{{{ $book->Title }}}
				@if ($book->SubTitle)
					<div class="bookMatSubTitle">
					{{-- @if (strlen($book->SubTitle)>30)
						{{{ substr($book->SubTitle,0,30).'...' }}}
					@else --}}
						{{{ $book->SubTitle }}}
					{{-- @endif --}}
					</div>
				@endif
				</a>
				@if ($book->Author1)
					<div class="bookMatAuthor">
					{{{ $book->Author1 }}}
					@if ($book->Author2)
						{{{ ", ".$book->Author2 }}}
					@endif
					</div>
				@endif
			</div>
			<!-- 
			{{{ $book->Title }}}
			@if ($book->SubTitle)
				{{{ ": ".$book->SubTitle }}}
			@endif
			</a>
			@if ($book->Author1)
				{{{ "&nbsp;by ".$book->Author1 }}}
			@endif
			@if ($book->Author2)
				{{{ ", ".$book->Author2 }}}
			@endif -->
		@endforeach
	<br/>
	<br/>
	{{ $books->links() }}
	<br/>
@else
		No books found in Location <b>{{$currentLocationLinkValue}}</b> in Language <b>{{$currentLanguageLinkValue}}</b> of Category <b>{{$currentCategoryLinkValue}}</b>
@endif

@if (Session::has('loggedInUser'))
	@include('templates.addBooks')
@endif

@stop