<?php

/*
 * This file is part of the Splash package.
 *
 * (c) Evans Owusu Ofori <vansbeck07@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Splash\Console;

use Splash\Console\Commands\FrameworkCommand;
use Splash\Foundation\App as Splash;
use Splash\Foundation\Path;
use Symfony\Component\Console\Application as Console;

/**
 * Create an instance instance of the application.
 *
 * @author Evans Owusu Ofori <vansbeck07@gmail.com>
 */
class Application
{
    protected static $splash;

    public function run()
    {
        $this->startSplash();

        $app = new Console('Splash Console', 'v1.0.0');

        $this->loadCommandsInto($app);

        $app->run();
    }

    public function loadCommandsInto($app)
    {
        $commands = $this->retrieveCommands();

        foreach ($commands as $command) {
            $newCommand = new $command;

            if ($newCommand instanceof FrameworkCommand) {
                $newCommand->setSplash($this->getSplash());
            }

            $app->add($newCommand);
        }
    }

    /**
     * Get the instance of the app for the console session.
     *
     * @return \Splash\Foundation\Kernel
     */
    public function getSplash()
    {
        return static::$splash;
    }

    public function startSplash()
    {
        static::$splash = Splash::mock();

        return $this;
    }

    public function retrieveCommands()
    {
        $paths = new Path;

        $commands = require $paths->get('app_command_file');
        $frameworkCommands = require $paths->get('framework_command_file');

        return array_merge($commands, $frameworkCommands);
    }
}
