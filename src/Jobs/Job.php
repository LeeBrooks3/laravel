<?php

namespace LeeBrooks3\Laravel\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;

abstract class Job implements JobInterface
{
    use InteractsWithQueue, Queueable, SerializesModels;
}
