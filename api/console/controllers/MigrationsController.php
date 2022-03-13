<?php
	
namespace console\controllers;

use Yii;
use yii\base\Exception;
use yii\helpers\Console;
use yii\console\ExitCode;

class MigrationsController extends \yii\console\controllers\MigrateController
{
	public $defaultAction = 'run';
	
	public function actionRun($confirm = false)
	{
		$this->migrationPath = Yii::getAlias('@app_root').'\database_migrations';

		$result = ExitCode::UNSPECIFIED_ERROR; // By default assume that the migration fails.
		
		try {

			$result = $this->actionUp(0, $confirm);
			$this->db->close();
			
		} catch(Exception $e) {
			echo "Rolling back failed migration.  *-*-*-* {$e->getMessage()}  *-*-*-* " . time();
			$this->actionDown();
		}
		
		echo PHP_EOL . PHP_EOL;
		
		return $result;
	}
	
	public function actionUp($limit = 0, $confirm = false)
	{
		$migrations = $this->getNewMigrations();
		if(empty($migrations)){
			$this->stdout("No new migration found. Your system is up-to-date.\n", Console::FG_GREEN);
			$this->db->close();
			
			return ExitCode::OK;
		}
		
		$total = count($migrations);
		$limit = (int)$limit;
		if($limit > 0){
			$migrations = array_slice($migrations, 0, $limit);
		}
		
		$n = count($migrations);
		if($n === $total){
			$this->stdout("Total $n new " . ($n === 1 ? 'migration' : 'migrations') . " to be applied:\n",
				Console::FG_YELLOW);
		}
		else{
			$this->stdout("Total $n out of $total new "
						  . ($total === 1 ? 'migration' : 'migrations')
						  . " to be applied:\n",
				Console::FG_YELLOW);
		}
		
		foreach($migrations as $migration){
			$this->stdout("\t$migration\n");
		}
		$this->stdout("\n");
		
		$migrate = true;
		if($confirm)
			$migrate = $this->confirm('Apply the above ' . ($n === 1 ? 'migration' : 'migrations') . "?");
		
		if($migrate){
			foreach($migrations as $migration){
				if(!$this->migrateUp($migration)){
					$this->stdout("\nMigration failed. The rest of the migrations are canceled.\n",
						Console::FG_RED);
					
					$this->db->close();
					
					return ExitCode::UNSPECIFIED_ERROR;
				}
			}
			$this->db->close();
			$this->stdout("\nMigrated up successfully.\n", Console::FG_GREEN);
		}
		$this->db->close();
	}
	
}