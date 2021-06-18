<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$user = \App\Models\User::create([
			'email'		=> 'gabohs92@gmail.com',
			'password'	=> bcrypt('Qwerty!23456'),
			'name'		=> 'Gabriel Herrera',
		]);
	}
}
