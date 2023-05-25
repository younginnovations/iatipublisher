<?php

namespace App\Http\Controllers\Admin\Organization;

use Maatwebsite\Excel\Concerns\ToArray;

class OrganizationRegistrationImport implements ToArray
{
    /**
     * @param array $row
     *
     * @return array|null
     */
    public function array(array $rows): array
    {
        $orgData = [];

        foreach ($rows as $row) {
            $tempData = [
                'code' => $row[0],
                'category' => $row[10],
                'url' => $row[45],
                'name' => $row[23],
                'description' => $row[1],
                'public-database' => $row[8],
                'status' => $row[16],
            ];

            $orgData[] = $tempData;
        }

        file_put_contents(storage_path('test.json'), json_encode($orgData));

        return $orgData;
    }
}
