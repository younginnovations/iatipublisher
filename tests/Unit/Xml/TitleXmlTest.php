<?php

namespace Tests\Unit\Xml;

use App\XmlImporter\Foundation\Support\Factory\XmlValidator;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Arr;

class TitleXmlTest extends XmlBaseTest
{
    /**
     * A basic unit test example.
     *
     * @return void
     * @throws BindingResolutionException
     */
    public function test_example()
    {
        $rows = $this->valid_data();
        $errors = [];
        $xmlValidator = new XmlValidator($this->validation);
        foreach ($rows as $row) {
            $errors[] = $xmlValidator->init($row)->validateActivity(false, false);
        }
        $flattenErrors = Arr::flatten($errors);
        dd($flattenErrors);
        $this->assertTrue(true);
    }

    /**
     * @return array
     * @throws BindingResolutionException
     */
    public function valid_data(): array
    {
        $data = $this->getXmlActivity();
        $data[0]['title'] = [
            [
                'narrative' => 'custom narrative',
                'language' => 'custom language',
            ],
            [
                'narrative' => 'custom narrative two',
                'language' => 'custom language two',
            ],
        ];

        return $data;
    }
}
