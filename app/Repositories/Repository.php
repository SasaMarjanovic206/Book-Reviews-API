<?php

namespace App\Repositories;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Interfaces\RepositoryInterface;

class Repository implements RepositoryInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function find(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(array $data, int $id)
    {
        $entity = $this->model->find($id);

        return $entity->update($data);
    }

    public function delete(int $id)
    {
        $this->model->destroy($id);
    }
}