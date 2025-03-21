<?php

namespace App\Services;

use App\Contracts\ResourceRepositoryInterface;

class ResourceService
{
    public function __construct(protected ResourceRepositoryInterface $resourceRepository)
    {
        $this->resourceRepository = $resourceRepository;
    }

    public function getAll()
    {
        return $this->resourceRepository->all();
    }

    public function create(array $data)
    {
        return $this->resourceRepository->create($data);
    }

    public function update(string $id, array $data)
    {
        return $this->resourceRepository->update($id, $data);
    }

    public function delete(string $id)
    {
        return $this->resourceRepository->delete($id);
    }
}
