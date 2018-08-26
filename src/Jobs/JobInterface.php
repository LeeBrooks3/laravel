<?php

namespace LeeBrooks3\Laravel\Jobs;

use Illuminate\Contracts\Foundation\Application;

interface JobInterface
{
    /**
     * Execute the job.
     *
     * @param Application $app
     * @return void
     */
    public function handle(Application $app) : void;
}
