<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('title', 255)->nullable(false);
            $table->date('due_date')->nullable(true);
            $table->boolean('is_done')->default(false);
            $table->softDeletes('deleted_at', 0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}

/*
The sql for this table is approximately:
    CREATE TABLE `tasks` (
        `id` bigint unsigned not null auto_increment primary key,
        `title` char(255) not null,
        `due_date` date null,
        `is_done` tinyint(1) not null default '0',
        `deleted_at` timestamp null,
        `created_at` timestamp null,
        `updated_at` timestamp null)
    default character set utf8mb4 collate 'utf8mb4_unicode_ci';

So an example SELECT would be:
    SELECT id, title FROM tasks 
    WHERE deleted_at IS NULL;

An example INSERT would be:
    INSERT INTO tasks (title, due_date, is_done)
    VALUES ('My Title', '2020-12-12 10:55:11', true);
*/