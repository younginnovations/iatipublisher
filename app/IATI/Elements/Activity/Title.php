<?php

namespace App\IATI\Elements\Activity;

use App\IATI\Elements\BaseElement;

/**
 * Class Title
 * contains the function that returns the title form and title repository.
 */
class Title extends BaseElement
{
    /**
     * @return title form
     */
    public function getForm()
    {
        return 'App\IATI\Forms\Activity\Title';
    }

    /**
     * @return \Illuminate\Foundation\Application|mixed
     */
    public function getRepository()
    {
        return App('App\IATI\Repositories\Activity\TitleRepository');
    }
}
