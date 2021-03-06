<?php

use App\Models\Hobby;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert(['name' => 'Administrator', 'password' => bcrypt('admin'), 'role' => 'Admin', 'email' => 'admin@gmail.com']);
        $hobbies = ["Reading","Watching TV","Family Time","Going to Movies","Fishing","Computer","Gardening","Renting Movies","Walking","Exercise","Listening to Music","Entertaining","Hunting","Team Sports","Shopping","Traveling","Sleeping","Socializing","Sewing","Golf","Church Activities","Relaxing","Playing Music","Housework","Crafts","Watching Sports","Bicycling","Playing Cards","Hiking","Cooking","Eating Out","Dating Online","Swimming","Camping","Skiing","Working on Cars","Writing","Boating","Motorcycling","Animal Care","Bowling","Painting","Running","Dancing","Horseback Riding","Tennis","Theater","Billiards","Beach","Volunteer Work"];
        foreach ($hobbies as $hobby){
            Hobby::create([
                'name' => $hobby
            ]);
        }


    }
}
