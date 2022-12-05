<?php namespace App\CTF\Repositories;

use App\CTF\Contracts\Repositories;
use App\CTF\Contracts\Repositories\Repository as RepositoryContract;

class Repository implements RepositoryContract
{
    public function member(): Repositories\MemberRepository
    {
        return app(Repositories\MemberRepository::class);
    }

    public function task(): Repositories\TaskRepository
    {
        return app(Repositories\TaskRepository::class);
    }

    public function team(): Repositories\TeamRepository
    {
        return app(Repositories\TeamRepository::class);
    }
}
