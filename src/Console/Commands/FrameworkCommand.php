<?php

namespace Splash\Console\Commands;

use Splash\Foundation\Kernel as Splash;

/**
 * Base class for all Splash command.
 * Provides some helpers method to interact more easyly with the application.
 *
 * @author Evans Owusu Ofori <vansbeck07@gmail.com>
 */
class FrameworkCommand extends SmileCommand
{
    /**
     * Instance of Splash.
     *
     * @var \Splash\Foundation\Kernel
     */
    protected $splash;

    protected $stubVariableDelimiter = ':';

    /**
     * @var \Splash\Foundation\Path
     */
    protected $paths;

    /**
     * @var \Vansbeck07\Config
     */
    protected $config;

    public function getSplash()
    {
        return $this->splash;
    }

    public function setSplash(Splash $splash)
    {
        $this->splash = $splash;

        return $this;
    }

    /**
     * Get a configuration variable from the config.
     *
     * Returns the config object instance if no parameter passed.
     *
     *
     *
     * @param string $key
     * @param mixed  $default The default to return if the configuration is not found
     * @param bool   $silent  If true, will shutdown the exception throwing if configuration variable not found and no default was passed.
     *
     * @throws \RuntimeException
     *
     * @return Config|mixed
     */
    public function config($key = null, $default = null, $silent = false)
    {
        return $this->getSplash()->config(...(func_get_args()));
    }

    /**
     * Return a path to a file or a folder.
     *
     *
     *
     * @param string|null $name
     *
     * @throws \RuntimeException
     *
     * @return string|\Splash\Foundation\Path
     */
    public function path($name = null)
    {
        return $this->getSplash()->path($name);
    }

    public function generateTemplateFromStub(string $stubPath, array $parameters)
    {
        $template = file_get_contents($stubPath);

        foreach ($parameters as $name => $value) {
            $delimiter = $this->stubVariableDelimiter();
            $numberOfsides = 2;
            $length = strlen($name) + $numberOfsides * strlen($delimiter);
            $variableReference = str_pad($name, $length, $delimiter, STR_PAD_BOTH);

            $template = str_replace($variableReference, $value, $template);
        }

        return $template;
    }

    public function stubVariableDelimiter()
    {
        return $this->config('app.stub_variable_delimiter', $this->stubVariableDelimiter);
    }
}
