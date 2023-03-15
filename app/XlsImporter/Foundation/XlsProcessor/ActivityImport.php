<?php

declare(strict_types=1);

namespace App\Imports;

use App\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ActivityImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            User::create([
                'name' => $row[0],
            ]);
        }
    }
}
