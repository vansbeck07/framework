<?php

/*
 * This file is part of the Splash package.
 *
 * (c) Evans Owusu Ofori <vansbeck07@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Splash\Foundation;

/**
 * Create an instance instance of the application.
 *
 * @author Evans Owusu Ofori <vansbeck07@gmail.com>
 */
class App
{
    public static function start($appName = '')
    {
        $app = new Kernel($appName);
        $app->run();
    }

    public static function mock()
    {
        return new Kernel;
    }
}
