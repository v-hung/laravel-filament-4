<?php

namespace App\Data;

use Illuminate\Http\Request;

class SearchParams
{
    public int $perPage = 15;
    public int $page = 1;
    public string $sortBy = 'id';
    public string $sortDirection = 'desc';

    public function __construct(array $data = [])
    {
        $this->perPage = isset($data['per_page']) ? (int) $data['per_page'] : 15;
        $this->page = isset($data['page']) ? (int) $data['page'] : 1;
        $this->sortBy = $data['sort_by'] ?? 'id';
        $this->sortDirection = strtolower($data['sort_direction'] ?? 'desc');
    }

    public static function fromRequest(Request $request): static
    {
        return new static($request->all());
    }
}
