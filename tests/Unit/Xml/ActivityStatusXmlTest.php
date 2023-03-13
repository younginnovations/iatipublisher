<?php

namespace Tests\Unit\Xml;

/**
 * Class ActivityStatusXmlTest.
 */
class ActivityStatusXmlTest extends XmlBaseTest
{
    /**
     * Throws validation messages for all invalid data.
     *
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
     * Invalid activity status data.
     *
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
