<?php

declare(strict_types=1);

namespace App\CsvImporter\Entities\Activity\Components;

/**
 * Class Grouping.
 */
class Grouping
{
    /**
     * Stores grouped period rows.
     * @var array
     */
    protected array $grouped = [];

    /**
     * Stores raw data to be grouped.
     *
     * @var array
     */
    protected array $fields;

    /**
     * Period keys.
     *
     * @var array
     */
    protected array $keys;

    /**
     * Grouping constructor.
     * @param array $fields
     * @param array $keys
     */
    public function __construct(array $fields, array $keys)
    {
        $this->fields = $fields;
        $this->keys = $keys;
    }

    /**
     * Group rows into single Activities.
     *
     * @return array
     */
    public function groupValues(): array
    {
        $index = -1;

        foreach ($this->fields[$this->keys[0]] as $i => $row) {
            if (!$this->isSameEntity($index, $i)) {
                $index++;
            }

            if ($index >= 0) {
                $this->setValue($index, $i);
            }
        }

        return $this->grouped;
    }

    /**
     * @param $index
     * @param $i
     *
     * @return bool
     */
    protected function isSameEntity($index, $i): bool
    {
        if ((is_null($this->fields[$this->keys[0]][$i]) || $this->fields[$this->keys[0]][$i] === '')
            && (is_null($this->fields[$this->keys[1]][$i]) || $this->fields[$this->keys[1]][$i] === '')
        ) {
            return true;
        }

        return false;
    }

    /**
     * Set the provided value to the provided key/index.
     *
     * @param $index
     * @param $i
     *
     * @return void
     */
    protected function setValue($index, $i): void
    {
        foreach ($this->fields as $row => $value) {
            if (array_key_exists($row, array_flip($this->keys))) {
                $this->grouped[$index][$row][] = $value[$i];
            }
        }
    }
}
