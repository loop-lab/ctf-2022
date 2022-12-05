<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Team;
use App\Models\Member;

class CTFController extends Controller
{
    public function data()
    {
        return response()->json([
            'tasks' => Task::get(),
            'teams' => Team::get(),
            'members' => Member::get(),
        ]);
    }
}
