<?php

namespace LeeBrooks3\Laravel\Console\Commands;

use Illuminate\Contracts\Foundation\Application;

interface CommandInterface
{
    /**
     * Execute the console command.
     *
     * @param Application $app
     * @return void
     */
    public function handle(Application $app) : void;
}

