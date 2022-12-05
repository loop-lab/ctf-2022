<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $tables = [
        'teams',
        'members',
        'tasks',
    ];

    private function up_teams()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->timestamps();
        });
    }

    private function up_members()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('last_name', 50)->default('');
            $table->unsignedInteger('team_id');
            $table->unsignedInteger('task_id');
            $table->unsignedInteger('helper_id')->nullable();
            $table->boolean('is_winner');
            $table->timestamps();
        });
    }

    private function up_tasks()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->boolean('is_solved');
            $table->timestamps();
        });
    }

    public function up()
    {
        foreach ($this->tables as $table) {
            if (Schema::hasTable($table)) {
                continue;
            }

            if (method_exists($this, $method = "up_{$table}")) {
                $this->{$method}();
            }
        }
    }

    public function down()
    {
        foreach ($this->tables as $table) {
            Schema::dropIfExists($table);
        }
    }
};
