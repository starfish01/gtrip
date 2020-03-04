<?php

namespace App\Console\Commands;

use App\Http\Controllers\testTableController;
use Illuminate\Console\Command;
use App\testtable;

class scrapeSearch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:scrapeSearch';
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        testTableController::store();
        echo 'hi';
    }
}
