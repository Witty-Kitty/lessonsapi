<?php 

class UsersTableSeeder extends Seeder{
		public function run(){
			DB::table('users')->delete();

			$users = array(
					array(
						'id' => 1,
						'email' => 'myemail@gmail.com',
						'password' => Hash::make('kathleen')
						)
				);
			DB::table('users')->insert($users);
		}
}