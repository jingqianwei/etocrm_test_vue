<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class BackupDatabase extends Command
{
    protected $process; //进度
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:backup {connection=mysql}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '备份数据库';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        if (!file_exists(storage_path('backups'))) {
            mkdir(storage_path('backups'), 0777);
        }

        //选择备份那个数据库，默认为mysql
        $dbConnection = $this->argument('connection');

        $this->process = new Process(sprintf(
            'mysqldump -u%s -p%s %s > %s',
            config("database.connections.{$dbConnection}.username"),
            config("database.connections.{$dbConnection}.password"),
            config("database.connections.{$dbConnection}.database"),
            storage_path('backups') . DIRECTORY_SEPARATOR . 'backup_' . date('Ymd') . '.sql'
        ));
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $this->process->mustRun();
            $this->info('The backup has been proceed successfully.');
        } catch (ProcessFailedException $e) {
            $this->error('The backup process has been failed, reason' . $e->getMessage());
        }
    }
}
