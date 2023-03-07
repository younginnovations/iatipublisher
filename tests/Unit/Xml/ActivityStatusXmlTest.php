<?php

namespace Tests\Unit\Xml;

class ActivityStatusXmlTest extends XmlBaseTest
{
    /**
     * @return void
     * @test
     */
    public function check_throws_validation_if_invalid_data(): void
    {
        $rows = $this->activity_status_invalid_data();
        $flattenErrors = $this->getErrors($rows);
        $this->assertContains('The activity status does not exist.', $flattenErrors);
        $this->assertContains('The activity status must be 1 characters.', $flattenErrors);
    }

    /**
     * @return array
     */
    public function activity_status_invalid_data(): array
    {
        $data = $this->completeXml;
        $data[0]['activity_status'] = 'Invalid Status';
        $data[1]['activity_status'] = ['1', '1'];

        return $data;
    }
}
