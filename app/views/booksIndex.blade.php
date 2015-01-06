
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
?>

@section('content')

<!-- --- BROWSE FILTER SECTION --- -->
<div class="filterSection">

<!-- --- LOCATION --- -->
@if ($locations)
Location: 
	@if ($currentLocation != 'all')
		<a href={{ URL::action('BookController@showAll', array('all',$currentLanguageLinkValue,$currentCategoryLinkValue))}}>
			all
		</a>
	@else
		<b>all</b>
	@endif
	@foreach($locations as $location)
			| 
		@if (($currentLocation == 'all') || ($currentLocation->ID != $location->ID))
			<a href={{ URL::action('BookController@showAll', array($location->Location,$currentLanguageLinkValue,$currentCategoryLinkValue))}}>
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
		<a href={{ URL::action('BookController@showAll', array($currentLocationLinkValue,'all',$currentCategoryLinkValue))}}>
			all
		</a>
	@else
		<b>all</b>
	@endif
	@foreach($languages as $language)
			| 
		@if (($currentLanguage == 'all') || ($currentLanguage->ID != $language->ID))
			<a href={{ URL::action('BookController@showAll', array($currentLocationLinkValue,$language->LanguageEnglish,$currentCategoryLinkValue))}}>
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
	@if ($currentLanguage != 'all')
		<a href={{ URL::action('BookController@showAll', array($currentLocationLinkValue,$currentLanguageLinkValue,'all'))}}>
			all
		</a>
	@else
		<b>all</b>
	@endif
	@foreach($categories as $category)
			| 
		@if (($currentCategory == 'all') || ($currentCategory->ID != $category->ID))
			<a href={{ URL::action('BookController@showAll', array($currentLocationLinkValue,$currentLanguageLinkValue,$category->Category))}}>
				{{{ $category->Category}}}
			</a>
		@else
			<b>{{{ $category->Category }}}</b>
		@endif
	@endforeach
@endif
</div>
<!-- --- END BROWSE FILTER SECTION --- -->

@if (!$loggedIn)
	Join / Login to request books, to add your own books to lend.
@endif

@if ($tMsg[1]!="")
	<p align='center'>
		<span style="border:2px solid blue;padding:4px;background-color:LemonChiffon">
			{{{$tMsg[1][1] }}}
			@if ($tMsg[1][0] && ($tMsg[0] == 'AddBook'))
				<a href="#AddBooks">Add More Books</a>
			@endif
		</span>
	</p>
@endif

<!-- --- BOOK LISTING --- -->

<ul>
@if ($books)
{{ $books->links() }}
<br/>
	@foreach($books as $book)
		<li>
			<a href={{  URL::action('BookController@showSingle', array($book->ID))}}>
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
			@endif
		</li>	
	@endforeach
<br/>
{{ $books->links() }}
@endif
</ul>

@if (Session::has('loggedInUser'))
	@include('templates.addBooks')
@endif

@stop