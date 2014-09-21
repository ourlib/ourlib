<?php

class RequestBookTest extends TestCase 
{
	public function testRequestPostedSuccessfully()
	{
		// 1 is the book copy id as per the book seeder
		$msg = 'May I borrow this book please? When and where can I meet you?';
		$result = Transaction::request($this->borrowerUser->UserID,1,$msg);
		$this->assertInternalType("int", $result);
		$this->assertGreaterThan(0, $result);
		// more detailed testing for each table required
	}

	/*public function testRequestSuccessFromController()
	{
		Session::put('loggedInUser',$this->borrowerUser);
		$response = $this->action('POST', 'TransactionController@request');
		$successMsg = ['RequestBook','Request Sent.'];
		$this->assertSessionHas('TransactionMessage',$successMsg);
	}*/
}