<?php

class UserAccessSeeder extends Seeder {

    public function run()
    {
        //DB::table('users')->delete();

        UserAccess::create(array('UserID' => 'OZJM1549672278',
        					'Username' => 'vanimurarka',
        					'EMail' => 'vani.murarka@gmail.com',
        					'Pwd' => '$5$02f6f58c97279$RAulmQCXggcZwm9YIfr.Ne.ASgViMormith8ULKGxvA',
        					'Active' => 1,
        	));
    }

}