<?php 

require_once __DIR__ . '/extra.php';

class MigrationManager extends ExtraManager
{
    private $dbConnect;
    private $dbPrefix;

    public function __construct()
    {
        parent::__construct();

        $this->dbConnect = $this->helper->getDbConnect();
        $this->dbPrefix = $this->helper->getDbPrefix();
    }

    private function getMigrationsFiles($path = '')
    {
        $path = $path ? $path : __DIR__ . '/migrations';
        $files = scandir(__DIR__ . '/migrations');

        $result = [];

        foreach ($files as $file) {
            if ($file != '.' && $file != '..') {
                $result[] = $file;
            }
        }

        return $result;
    }

    public function run()
    {
        $path = __DIR__ . '/migrations';
        $migrations = $this->getMigrationsFiles($path);

        foreach ($migrations as $migration) {
            $migrationPath = $path . '/' . $migration;
            $filePath = '../installed-db/' . $migration;
        
            setSqlWithDbPrefix($migrationPath, $filePath, $this->dbPrefix);
        
            return importSql($this->dbConnect, $filePath);
        }
    }
}

$migrationManager = new MigrationManager();
$migrationManager->run();