<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // システムID (AUTO_INCREMENT)
            $table->integer('country_id')->default(0)->comment('国ID: 0は管理ユーザー');
            $table->string('email', 100)->nullable(false)->comment('メールアドレス');
            $table->string('password', 100)->nullable(false)->comment('パスワード（ハッシュ化を行う）');
            $table->integer('role')->default(0)->comment('ロール: 0=管理ユーザー, 1=一般ユーザー');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
