<?php

namespace App\Repositories;

use App\Contracts\ResourceRepositoryInterface;
use App\Models\Resource;
use Illuminate\Database\Eloquent\Collection;

class ResourceRepository implements ResourceRepositoryInterface
{
    public function all(): Collection
    {
        return Resource::all();
    }

    public function create(array $data)
    {
        return Resource::query()->create($data);
    }

    public function update(string $id, array $data): bool
    {
        $resource = Resource::query()->findOrFail($id);

        return $resource->update($data);
    }

    public function delete(string $id): ?bool
    {
        $resource = Resource::query()->findOrFail($id);

        return $resource->delete();
    }
}
