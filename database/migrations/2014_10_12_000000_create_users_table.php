<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('user_role');

        Schema::create('user_role', function (Blueprint $table) {
            $table->id();
            $table->string('displayName')->unique();
        });

        DB::table('user_role')->insert([
        	'id'=> '1',
            'displayName'=> 'Admin'
        ]);

        DB::table('user_role')->insert([
        	'id'=> '2',
            'displayName'=> 'Customer'
        ]);

        DB::table('user_role')->insert([
        	'id'=> '3',
            'displayName'=> 'Cashier'
        ]);

        DB::table('user_role')->insert([
        	'id'=> '4',
            'displayName'=> 'Waiter'
        ]);

        DB::table('user_role')->insert([
        	'id'=> '5',
            'displayName'=> 'Tenant'
        ]);

        DB::table('user_role')->insert([
        	'id'=> '6',
            'displayName'=> 'Owner'
        ]);

        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('phone')->unique();
            $table->string('password');
            $table->unsignedBigInteger('roleId')->default(2);
            $table->string('appVersion')->default('0');
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('roleId')->references('id')->on('user_role');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('user_role');
    }
}
