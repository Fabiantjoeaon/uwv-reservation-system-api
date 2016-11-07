<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(RoomsTableSeeder::class);
        $this->call(CustomersTableSeeder::class);
        $this->call(ReservationsTableSeeder::class);
    }
}

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();
        $faker = Faker\Factory::create();

        for($i = 0; $i < 20; $i++) {
          DB::table('users')->insert([
            'first_name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'email' => $faker->email,
            'password' => bcrypt('secret'),
            'created_at' => $faker->dateTime($max = 'now')
          ]);
        }
    }
}

class RoomsTableSeeder extends Seeder
{
    static function returnRandomRoomType($number) {
      $rooms = ['Spreekkamer', 'Onderzoekkamer'];
      return $rooms[$number];
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
     public function run()
     {
         DB::table('rooms')->delete();
         $faker = Faker\Factory::create();

         for($i = 0; $i < 20; $i++) {
           DB::table('rooms')->insert([
             'location' => $faker->city,
             'floor' => rand(0,1),
             'number' => rand(1,50),
             'capacity' => rand(1, 5),
             'color' => $faker->colorName,
             'type' => self::returnRandomRoomType(rand(0,1)),
             'has_pc' => $faker->boolean(25),
             'created_at' => $faker->dateTime($max = 'now')
           ]);
         }
     }
}

class CustomersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
      public function run()
      {
          DB::table('customers')->delete();
          $faker = Faker\Factory::create();

          for($i = 0; $i < 20; $i++) {
            DB::table('customers')->insert([
              'BSN' => rand(1, 600),
              'first_name' => $faker->firstName,
              'last_name' => $faker->lastName,
              'user_id' => rand(1,20),
              'created_at' => $faker->dateTime($max = 'now')
            ]);
          }
      }

}


class ReservationsTableSeeder extends Seeder
{
    static function returnRandomStatusType($number) {
      $status = ['Aanvaard', 'Bezig'];
      return $status[$number];
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
     public function run()
     {
         DB::table('reservations')->delete();
         $faker = Faker\Factory::create();

         for($i = 0; $i < 10; $i++) {
           DB::table('reservations')->insert([
             'date_time' => $faker->dateTime($max = 'now'),
             'length_minutes' => rand(1,180),
             'activity' => str_random(10),
             'status' => self::returnRandomStatusType(rand(0,1)),
             'number_persons' => rand(1,7),
             'room_id' => rand(1,20),
             'user_id' => rand(1,20),
             'customer_id' => rand(1,20),
             'created_at' => $faker->dateTime($max = 'now')
           ]);
         }
     }
}
