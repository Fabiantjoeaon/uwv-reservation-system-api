<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DeleteRoomLogs extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dorsia:delete-room-logs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes log for room reservations';

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
      $thisFile = dirname(__FILE__);
      $pathToLog = "${thisFile}/../../../storage/logs/room_output.log";
      $realPath = realpath($pathToLog);

      if($realPath && is_writable($realPath)) {
        unlink($realPath);
        error_log("File deleted: ${realPath}");
      } else {
        error_log('The log is not writeable or the path isn\'t correct!');
      }
    }
}
