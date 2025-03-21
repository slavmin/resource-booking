<?php

namespace App\Contracts;

interface BookingRepositoryInterface
{
    public function all(array $relations = []);

    public function create(array $data);

    public function update(string $id, array $data);

    public function delete(string $id);
}
