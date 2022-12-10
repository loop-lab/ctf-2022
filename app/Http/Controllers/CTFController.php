<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Team;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Events\StatusTasksUpdated;


class CTFController extends Controller
{
    private $keys = ["x-api-key", "team_name", "task_name", "user_name", "user_real_name", "points"];
    private $secretKey = "88927f3d-1039-4c9c-b8c7-e4e10c834";

    public function data()
    {
        return response()->json([
            'tasks' => Task::get(),
            'teams' => Team::get(),
            'members' => Member::get(),
        ]);
    }

    public function set(Request $request)
    {
        $data = $request->only($this->keys);

        if ($data['x-api-key'] != $this->secretKey) {
            return response()->json(['success' => false]);
        }

        Task::where('name', $data['task_name'])->update(['is_solved' => true]);
        Member::where('user_name', $data['user_name'])->update(['is_winner' => true]);

        StatusTasksUpdated::dispatch([
            'tasks' => Task::get(),
            'teams' => Team::get(),
            'members' => Member::get(),
        ]);

        return response()->json(['success' => true]);
    }
}
