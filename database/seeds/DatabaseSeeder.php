<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\User;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();
	    $this->call('UserTableSeeder');
	}

}

class UserTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
    {
        //DB::table('users')->delete();
        $user = [
            'name'     => '同行小叶',
            'email'    => 'tongxinglvyou@163.com',    
            'password' => bcrypt('tongxing123'),
        ];
        User::create($user);
	}

}
