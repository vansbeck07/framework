<?php

namespace Splash\Console\Commands;

use Splash\Console\Commands\FrameworkCommand as Wow;
use Splash\Jobs\Scheduler;

class ScheduleRunCommand extends Wow
{
    public function configure()
    {
        $this->setName('schedule:run')
            ->setDescription('Run the scheduler');
    }

    public function fire()
    {
        $scheduler = new Scheduler();
        $scheduler->setSchedulerCommand($this);

        $jobClass = $this->config('app.jobs_class');
        $jobs = new $jobClass();

        $jobs->schedule($scheduler);

        $scheduler->run();

        return Wow::SUCCESS;
    }
}
