<?php 

require_once __DIR__ . '/extra.php';

class MigrationManager extends ExtraManager
{
    const MIGRATION_EXECUTED_FILE = __DIR__ . '/migrations_executed.log';

    private $dbConnect;
    private $dbPrefix;

    public function __construct()
    {
        parent::__construct();

        $this->dbConnect = $this->helper->getDbConnect();
        $this->dbPrefix = $this->helper->getDbPrefix();
    }

    private function getMigrationsFiles($path)
    {
        $files = scandir(__DIR__ . '/migrations');

        $result = [];

        foreach ($files as $file) {
            if ($file != '.' && $file != '..') {
                $result[] = $file;
            }
        }

        return $result;
    }

    private function getMigrationsExecuted()
    {
        if (!file_exists(self::MIGRATION_EXECUTED_FILE)) {
            file_put_contents(self::MIGRATION_EXECUTED_FILE, '');
            return [];
        }

        $items = array_filter(array_map(function($item) {
            return trim($item);
        }, explode(PHP_EOL, file_get_contents(self::MIGRATION_EXECUTED_FILE))));

        return $items;
    }

    private function addMigrationExecuted($migration)
    {
        file_put_contents(self::MIGRATION_EXECUTED_FILE, $migration . PHP_EOL, FILE_APPEND);
    }

    public function run()
    {
        $path = __DIR__ . '/migrations';
        $migrations = $this->getMigrationsFiles($path);
        $migrations_executed = $this->getMigrationsExecuted();

        foreach ($migrations as $migration) {
            $migrationPath = $path . '/' . $migration;
            if (!in_array($migration, $migrations_executed)) {
                echo $migration . PHP_EOL;

                $filePath = '../installed-db/' . $migration;
                setSqlWithDbPrefix($migrationPath, $filePath, $this->dbPrefix);
            
                $res = importSql($this->dbConnect, $filePath);
                if ($res) {
                    $this->addMigrationExecuted($migration);
                }
            }
        }
    }
}

$is_console = PHP_SAPI == 'cli';

if (!$is_console) {
    header("HTTP/1.0 404 Not Found");
}

$migrationManager = new MigrationManager();
$migrationManager->run();