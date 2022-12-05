<?php

namespace App\CTF\Repositories;

use App\Traits\Cache\Cache;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

abstract class AbstractRepository
{
    private $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @return Model
     */
    protected function getModel(): Model
    {
        return $this->model;
    }

    /**
     * @return Collection
     */
    protected function getCollection(): Collection
    {
        return $this->getModel()->newCollection();
    }
}
