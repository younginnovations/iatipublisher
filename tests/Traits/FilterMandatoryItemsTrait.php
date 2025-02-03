<?php

declare(strict_types=1);

namespace Tests\Traits;

/**
 * @trait FilterMandatoryItemsTrait
 */
trait FilterMandatoryItemsTrait
{
    public function unsetMandatorySubelements(array &$mandatoryItemsInSchema): void
    {
        foreach ($this->mandatorySubelements as $unsetableKey => $valueDoesNotMatterHere) {
            unset($mandatoryItemsInSchema[$unsetableKey]);
        }
    }

    public function unsetMandatoryAttributes(array &$mandatorySubelementsInSchema): void
    {
        foreach ($this->mandatoryAttributes as $unsetableKey => $valueDoesNotMatterHere) {
            unset($mandatorySubelementsInSchema[$unsetableKey]);
        }
    }
}
