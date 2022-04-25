<?php

namespace App\IATI;

/**
 * Class IatiActivity.
 */
class IatiActivity
{
    /**
     * Returns the element file responsible for getting the title form and repository.
     * @return \Illuminate\Contracts\Foundation\Application|mixed
     */
    public function getTitle()
    {
        return app('App\IATI\Elements\Activity\Title');
    }
}
