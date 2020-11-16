<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFirstUser extends Migration
{
    public function up()
    {
        DB::table('users')->insert(
            array(
                'name' => 'testUser',
                'phone' => '8912345678',
                'password' => '$2y$12$JZX7bNyaNr3QARKXaNzofONB/oRZkSri.RRenFR6MGVX29bDlI3c6',
                'roleId' => '1',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            )
        );
    }

    public function down()
    {
        DB::table('users')
            ->where('phone', '8912345678')
            ->delete();
    }
}
