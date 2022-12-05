<?php namespace App\CTF\Contracts\Repositories;

use App\CTF\Contracts\Repositories;

interface Repository
{
    public function member(): Repositories\MemberRepository;

    public function team(): Repositories\TeamRepository;

    public function task(): Repositories\TaskRepository;
}
