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
            'name' => $faker->name,
            'email' => $faker->email,
            'password' => bcrypt('secret'),
            'created_at' => $faker->dateTimeThisMonth($max = 'now')
          ]);

          if($index == 20) {
            DB::table('users')->insert([
              'name' => 'Test',
              'email' => 'test@test.com',
              'password' => bcrypt('test'),
              'created_at' => $faker->dateTimeThisMonth($max = 'now')
            ]);
          }
        }
    }
}

class RoomsTableSeeder extends Seeder
{
    private function returnRandomRoomType($number) {
      $rooms = ['Spreekkamer', 'Onderzoekkamer'];
      return $rooms[$number];
    }

    private function returnRandomColor($number) {
      $colors = ['Paars', 'Groen', 'Oranje'];
      return $colors[$number];
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
             'color' => $this->returnRandomColor(rand(0, 2)),
             'type' => $this->returnRandomRoomType(rand(0,1)),
             'invalid' => $faker->boolean(25),
             'is_reserved_now' => 0,
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
              'email' => $faker->email,
              'user_id' => $faker->randomElement($users),
              'created_at' => $faker->dateTimeThisMonth($max = 'now')
            ]);
          }
      }

}


class ReservationsTableSeeder extends Seeder
{
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

         foreach(range(0,15) as $index) {
           $startDateTime = date('Y-m-d H:i:s', strtotime( '+'.mt_rand(0,3).' days'));
           $lengthMinutes = rand(1,180);
           $endDateTime = date('Y-m-d H:i:s', strtotime('+'.$lengthMinutes.' minutes', strtotime($startDateTime)));
           DB::table('reservations')->insert([
             'start_date_time' => $startDateTime,
             'length_minutes' => $lengthMinutes,
             'end_date_time' => $endDateTime,
             'activity' => $faker->sentence($nbWords = 3, $variableNbWords = true),
             'is_active_now' => 0,
             'number_persons' => rand(1,7),
             'has_passed' => 0,
             'room_id' => $faker->randomElement($rooms),
             'user_id' => $faker->randomElement($users),
             'customer_id' => $faker->randomElement($customers),
             'created_at' => $faker->dateTimeThisMonth($max = 'now')
           ]);
         }
     }
}
