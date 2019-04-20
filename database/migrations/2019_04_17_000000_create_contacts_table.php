<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->mediumText('address')->nullable();
            $table->string('photo')->default('profile.png')->nullable();
            $table->integer('phone')->nullable();
            $table->integer('mobile')->nullable();
            $table->integer('fax')->nullable();
            $table->timestamps();
        });

        DB::table('contacts')->insert([
            ['name' => 'Ricardo Fernandes', 'email' => 'rfdragon@gmail.com', 'address' => 'Morada do Ricardo', 'photo' => '1555695470.jpeg', 'phone' => '223456789', 'mobile' => '913456789', 'fax' => '223456780', 'created_at' => '2019-04-20 11:20:30'],
            ['name' => 'Daniel Ferreira', 'email' => 'danielferreira@demo.pt', 'address' => 'Morada do Daniel', 'photo' => '1555695520.jpeg', 'phone' => '229876543', 'mobile' => null, 'fax' => null, 'created_at' => '2019-04-20 11:20:30'],
            ['name' => 'João Carvalho', 'email' => 'joaocarvalho@demo.pt', 'address' => 'Morada do João', 'photo' => '1555695520.jpeg', 'phone' => '229876543', 'mobile' => null, 'fax' => null, 'created_at' => '2019-04-20 11:20:30'],
            ['name' => 'João Santos', 'email' => 'joaosantos@demo.pt', 'address' => 'Morada do João Santos', 'photo' => '1555695521.jpeg', 'phone' => null, 'mobile' => '918765432', 'fax' => null, 'created_at' => '2019-04-20 11:20:30'],
            ['name' => 'Rui Nogueira', 'email' => 'ruinogueira@demo.pt', 'address' => 'Morada do Rui', 'photo' => '1555695472.jpeg', 'phone' => null, 'mobile' => null, 'fax' => '223454480', 'created_at' => '2019-04-20 11:20:30'],
            ['name' => 'Fernando Madureira', 'email' => 'fernandomadureira@demo.pt', 'address' => 'Morada do Fernando', 'photo' => '1555695522.jpeg', 'phone' => null, 'mobile' => '913477789', 'fax' => '223456789', 'created_at' => '2019-04-20 11:20:30'],
            ['name' => 'Mario Rodrigues', 'email' => 'mariorodrigues@demo.pt', 'address' => 'Morada do Mario', 'photo' => 'profile.png', 'phone' => null, 'mobile' => null, 'fax' => '223456789', 'created_at' => '2019-04-20 11:20:30'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts');
    }
}
