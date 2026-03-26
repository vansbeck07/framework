<?php

namespace Splash\Console\Traits;

use Splash\Console\Table;
use Splash\Console\TableDivider;

/**
 * Console Table rendering related methods.
 *
 * @author Evans Owusu Ofori <vansbeck07@gmail.com>
 */
trait TableTrait
{
    public function createTable()
    {
        return new Table($this->getOutput());
    }

    public function tableLine()
    {
        return new TableDivider;
    }
}
