<?php

namespace App\Repositories\Interfaces;

interface RepositoryInterface
{
    public function all();

    public function create(array $data);

    public function update(array $data, int $id);

    public function delete(int $id);

    public function show(int $id);
}
