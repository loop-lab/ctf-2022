<?php namespace App\Facades;

use Illuminate\Support\Facades\Facade;
use App\CTF\Contracts\Repositories;
use App\CTF\Contracts\Repositories\Repository as RepositoryContract;

/**
 * @method static Repositories\ModelRepository member()
 */

class Repository extends Facade
{
    protected static function getFacadeAccessor()
    {
        return RepositoryContract::class;
    }
}
