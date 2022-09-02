<?php

namespace App\Interfaces;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

interface RepositoryInterface {

    public function all();

    public function find(int $id);

    public function create(array $data);

    public function update(array $data, int $id);

    public function delete(int $id);
}