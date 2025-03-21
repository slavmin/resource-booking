<?php

namespace App\Contracts;

interface ResourceRepositoryInterface
{
    public function all();

    public function create(array $data);

    public function update(string $id, array $data);

    public function delete(string $id);
}
