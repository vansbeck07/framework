<?php

namespace Splash\Console\Commands;

use Splash\Console\Commands\FrameworkCommand as Wow;
use Symfony\Component\Finder\Finder;

class ClearSessionCommand extends Wow
{
    public function configure()
    {
        $this->setName('session:clear')
            ->setDescription('Clear the sessions.');
    }

    public function fire()
    {
        try {
            $finder = (new Finder())->files()->in(storage_path('sessions'));

            foreach ($finder as $file) {
                unlink($file->getPathname());
            }
        } catch (\Throwable $th) {
            $this->error('Error!');
            $this->write($th->getMessage().' in '.$th->getFile().' at line '.$th->getLine());

            return Wow::FAILURE;
        }

        $this->info('Session cleared successfully!');

        return Wow::SUCCESS;
    }
}
