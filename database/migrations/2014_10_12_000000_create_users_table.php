<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('type')->default('user');
            $table->mediumText('bio')->nullable();
            $table->string('photo')->default('profile.png')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        DB::table('users')->insert([
            ['name' => 'Ricardo Fernandes', 'email' => 'rfdragon@gmail.com', 'password' => '$2y$10$0QmHZh00yeKY7j7FUUzmRea3NER7QiKezFlPv4j6tTB4FxpuUOA5i', 'type' => 'admin', 'bio' => 'PHP Developer | Full Stack', 'photo' => '1555695470.jpeg', 'created_at' => '2019-04-20 11:20:30', 'updated_at' => '2019-04-20 11:20:30'],
            ['name' => 'Administrator', 'email' => 'admin@demo.pt', 'password' => '$2y$10$HKWpYXMeme277Px53n/MTezYRLlML2pdbhjuVU/61d0eVASNJQzqO', 'type' => 'admin', 'bio' => 'Administrator Demo', 'photo' => '1555693760.jpeg', 'created_at' => '2019-04-20 11:20:30', 'updated_at' => '2019-04-20 11:20:30'],
            ['name' => 'Author', 'email' => 'author@demo.pt', 'password' => '$2y$10$a41luHiF4gJd4MCRp5.TRukejCkuHlJgLZ3t71Su1EPvIXIh0ulS2', 'type' => 'author', 'bio' => 'Author Demo', 'photo' => '1555695520.jpeg', 'created_at' => '2019-04-20 11:20:30', 'updated_at' => '2019-04-20 11:20:30'],
            ['name' => 'User', 'email' => 'user@demo.pt', 'password' => '$2y$10$PwJJqJIREbnOtKe9GeUaV.iQEIG3JzvF8CYZyVS8kcOtWNnEqqdNa', 'type' => 'user', 'bio' => 'User Demo', 'photo' => 'profile.png', 'created_at' => '2019-04-20 11:20:30', 'updated_at' => '2019-04-20 11:20:30'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
