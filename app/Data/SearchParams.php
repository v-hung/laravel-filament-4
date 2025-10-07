<?php

namespace App\Data;

use Illuminate\Http\Request;

class SearchParams
{
    public int $perPage = 15;
    public int $page = 1;
    public string $sortBy = 'id';
    public string $sortDirection = 'desc';

    public static function fromRequest(Request $request): static
    {
        $instance = new static();
        foreach ($instance->toArray() as $key => $_) {
            if ($request->has($key)) {
                $instance->$key = $request->input($key);
            }
        }
        return $instance;
    }

    public static function fromArray(array $data): static
    {
        $instance = new static();
        foreach ($data as $key => $value) {
            if (property_exists($instance, $key)) {
                $instance->$key = $value;
            }
        }
        return $instance;
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
