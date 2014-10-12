<?php

class FlatBook extends Eloquent {

	protected $table = 'books_flat';
	protected $primaryKey = 'ID';

	public function Copies()
	{
		return $this->hasMany('BookCopy', 'BookID', 'ID');
	}

	public static function addBook($bookDetails)
	{
		if (!Session::has('loggedInUser'))
            return array(false,'No user logged in.');

        $user = Session::get('loggedInUser');
        $userID = $user->UserID;
        $userLocation = $user->LocationID;

		$rules = array(
            'Title' => 'required',
            'Author1' => 'required'
        );
        $validator = Validator::make($bookDetails, $rules);
        if ($validator->fails()) 
        {
            return array(false,$validator->messages());
        }

        $book = new FlatBook;
        $book->Title = $bookDetails['Title'];
        $book->Author1 = $bookDetails['Author1'];
        if (isset($bookDetails['Author2']))
        	$book->Author2 = $bookDetails['Author2'];
        if (isset($bookDetails['Language1']))
	        $book->Language1 = $bookDetails['Language1'];
        if (isset($bookDetails['Language2']))
        	$book->Language2 = $bookDetails['Language2'];
        if (isset($bookDetails['SubTitle']))
        	$book->SubTitle = $bookDetails['SubTitle'];

        $result = $book->save();
        if ($result)
        {
        	$bookCopy = new BookCopy;
        	$bookCopy->BookID = $book->ID;
        	$bookCopy->UserID = $userID;
        	$bookCopy->LocationID = $userLocation;
        	$result = $bookCopy->save();
        	if ($result)
        	{
        		if (!Session::has('AddBookAdminMail'))
				{
				    $body = array('body'=>'New Book Added ' . $userID);

					Mail::send(array('text' => 'emails.raw'), $body, function($message)
					{
						$message->to(Config::get('mail.admin'))
								->subject('New ' . Config::get('app.name') . ' Book');
					});
					Session::put('AddBookAdminMail','sent');
				}     		
	        	return array(true,$book->ID);
        	}
        	return array(false,'Book not saved. DB save error 2.');
        }
        return array(false,'Book not saved. DB save error 1.');
	}

	public static function myBooks($userID)
	{
		$booksIDs = DB::table('bookcopies')
					->select('BookID')
					->distinct()
					->where('UserID', '=', $userID)
					->lists('BookID');
		if (!empty($booksIDs))
		{
			$books = FlatBook::whereIn('ID',$booksIDs)
						->orderBy('Title', 'asc')
						->with('Copies')
						->get();
			return $books;
		}
		else
		{
			return false;
		}
	}

	public static function myBorrowedBooks($borrowerID)
	{
		$booksIDs = DB::table('transactions_active')
						->select('ItemID')
						->distinct()
						->where('Borrower','=',$borrowerID)
						->where('Status','=',Transaction::tStatusByKey('T_STATUS_LENT'))
						->lists('ItemID');
		if (!empty($booksIDs))
		{
			$books = FlatBook::whereIn('ID',$booksIDs)
						->orderBy('Title', 'asc')
						->with('Copies')
						->get();
			return $books;
		}
		else
			return false;
	}

	public function FullTitle()
	{
		$title = $this->Title;
		if (strlen($this->SubTitle)>0)
			$title .= ' : ' . $this->SubTitle;
		return $title;
	}

	public static function byLocation($LocationID)
	{
		/*DB::table('books_flat')
            ->join('bookcopies', 'books_flat.ID', '=', 'bookcopies.BookID')
            ->join('users', 'bookcopies.UserID', '=', 'orders.user_id')
            ->select('users.id', 'contacts.phone', 'orders.price')
            ->get();*/

		$books = FlatBook::with('Copies')
			->whereHas('Copies', function($q) use($LocationID)
						{
						    $q->where('LocationID', '=', $LocationID);
						}
					)
			->orderBy('Title', 'asc')
            ->orderBy('Author1', 'asc')
			->get();
		return $books;
	}
}

?>