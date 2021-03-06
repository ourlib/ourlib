<?php

class MessagesTest extends TestCase 
{
	public function testReplyBeingPosted()
	{
		// 1 is the book copy id as per the book seeder
		$msg = 'May I borrow this book please? When and where can I meet you?';
		$tranID = Transaction::request($this->borrower->UserID,1,$msg);
		$transaction = Transaction::findOrFail($tranID);
		$msg = 'Sure. Come over any time to my house. Have some sattu too.';
		$msgID = $transaction->reply($this->owner->UserID,$this->borrower->UserID,$msg);
		$this->assertGreaterThan(0, $msgID);
	}

	// when no specific transaction id is specified
	// calling Messages in UI must return all unread message threads
	// if any exist
	public function testGeneralMessagesDisplayed()
	{
		// post a request for a book, that should create a message
		$msg = 'May I borrow this book please? When and where can I meet you?';
		$tranID = Transaction::request($this->borrower->UserID,1,$msg);

		Session::start();
		Session::put('loggedInUser',$this->owner);
		$response = $this->action('GET', 'TransactionController@messages');
		$this->assertViewHas('msgTransactions');
		$transactions = $response->original->getData()['msgTransactions'];
		$msgs = $response->original->getData()['msgs'];
		$this->assertInstanceOf($this->eloquentCollectionType, $transactions);
		
	}
}