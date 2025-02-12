<?php

declare(strict_types=1);

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class NoLeadingWhiteSpace implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function passes($attribute, $value) : bool
    {
        $loggedInOrganisation = auth()->user()->organization;
        $organisationIdentifier = $loggedInOrganisation->identifier;

        $activityIdentifier = $value;

        $iatiIdentifierTextFromForm = (request()->get('iati_identifier_text'));
        $iatiIdentifierTextReal = $organisationIdentifier . '-' . $activityIdentifier;

        return $iatiIdentifierTextFromForm === $iatiIdentifierTextReal;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message() : string
    {
        return 'The activity-identifier must not start with space.';
    }
}
