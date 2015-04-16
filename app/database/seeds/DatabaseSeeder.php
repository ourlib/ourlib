<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('UserSeeder');
		$this->call('BookSeeder');
		$this->call('TransactionSeeder');
		$this->call('BlogSeeder');
	}

}
