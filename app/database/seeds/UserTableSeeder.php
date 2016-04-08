<?php


class UserTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User;
        $user->name = 'admin';
        $user->email = 'admin@localhost.com';
        $user->password = Hash::make('123456');
        $user->save();
    }

}