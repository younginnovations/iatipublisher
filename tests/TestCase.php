<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    /**
     * Prints memory used by any test functions.
     *
     * @param string $fx_name
     * @return void
     */
    public function showMemory(string $fx_name = ''): void
    {
        echo $fx_name . ' : ' . round(memory_get_usage() / 1048576, 2) . " MB\n";
    }

    /**
     * Clears properties to free up memory.
     * Code fetched from https://kriswallsmith.net/post/18029585104/faster-phpunit.
     *
     * @return void
     */
    protected function clearProperties(): void
    {
        $refl = new \ReflectionObject($this);

        foreach ($refl->getProperties() as $prop) {
            if (!$prop->isStatic()
                && 0 !== strpos($prop->getDeclaringClass()->getName(), 'PHPUnit_')
                && $prop->getType()?->allowsNull() !== false
            ) {
                $prop->setAccessible(true);
                $prop->setValue($this, null);
            }
        }
    }

    /**
     * Tears down the unused properties.
     *
     * @return void
     */
    public function tearDown(): void
    {
        parent::tearDown();
        $this->clearProperties();
        // $this->showMemory($this->getName());
    }
}
