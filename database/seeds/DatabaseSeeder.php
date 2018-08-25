<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        \Illuminate\Database\Eloquent\Model::unguard();
        $this->call('PostTableSeeder');
    }
}
class PostTableSeeder extends Seeder{
    public function run(){
        App\Post::truncate();
        factory(App\Post::class,50)->create();
    }
}
