<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

use App\User;
use App\Room;
use App\Customer;

class DatabaseSeeder extends Seeder
{
    /**
     * Tables to be seeded
     * @var string
     */
    private $tables = [
      'users',
      'rooms',
      'customers',
      'reservations'
    ];

    /**
     * Run the database seeds.
     * @return void
     */
    public function run()
    {
        $this->cleanDatabase();
        Eloquent::unguard();
        $this->call(UsersTableSeeder::class);
        $this->call(RoomsTableSeeder::class);
        $this->call(CustomersTableSeeder::class);
        $this->call(ReservationsTableSeeder::class);
    }

    /**
     * Empty database according to set tables
     * @return void
     */
    private function cleanDatabase() {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        foreach($this->tables as $tableName) {
          DB::table($tableName)->truncate();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
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
        $faker = Faker\Factory::create();

        foreach(range(0,20) as $index) {
          DB::table('users')->insert([
            'first_name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'email' => $faker->email,
            'password' => bcrypt('secret'),
            'created_at' => $faker->dateTimeThisMonth($max = 'now')
          ]);
        }
    }
}

class RoomsTableSeeder extends Seeder
{
    private function returnRandomRoomType($number) {
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
         $faker = Faker\Factory::create();

         foreach(range(0,20) as $index) {
           DB::table('rooms')->insert([
             'location' => $faker->city,
             'floor' => rand(0,1),
             'number' => rand(1,50),
             'capacity' => rand(1, 5),
             'color' => $faker->colorName,
             'type' => $this->returnRandomRoomType(rand(0,1)),
             'has_pc' => $faker->boolean(25),
             'created_at' => $faker->dateTimeThisMonth($max = 'now')
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
          $faker = Faker\Factory::create();
          $users = User::pluck('id')->all();

          foreach(range(0,20) as $index) {
            DB::table('customers')->insert([
              'BSN' => rand(1, 600),
              'first_name' => $faker->firstName,
              'last_name' => $faker->lastName,
              'user_id' => $faker->randomElement($users),
              'created_at' => $faker->dateTimeThisMonth($max = 'now')
            ]);
          }
      }

}


class ReservationsTableSeeder extends Seeder
{
    private function returnRandomStatusType($number) {
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
         $faker = Faker\Factory::create();
         $rooms = Room::pluck('id')->all();
         $users = User::pluck('id')->all();
         $customers = Customer::pluck('id')->all();

         foreach(range(0,10) as $index) {
           DB::table('reservations')->insert([
             'date_time' => $faker->dateTimeThisMonth($max = 'now'),
             'length_minutes' => rand(1,180),
             'activity' => str_random(10),
             'status' => $this->returnRandomStatusType(rand(0,1)),
             'number_persons' => rand(1,7),
             'room_id' => $faker->randomElement($rooms),
             'user_id' => $faker->randomElement($users),
             'customer_id' => $faker->randomElement($customers),
             'created_at' => $faker->dateTimeThisMonth($max = 'now')
           ]);
         }
     }
}
