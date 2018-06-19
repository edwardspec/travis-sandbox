<?php

class ShellExecTest extends Maintenance {
	public function execute() {
		$cmd = wfEscapeShellArg(
			PHP_BINARY,
			"maintenance/runScript.php",
			__DIR__ . "/subprocess.php"
		);

		echo "Executing [$cmd]...\n";
		var_dump( wfShellExec( $cmd ) );
	}
}

$maintClass = ShellExecTest::class;
require_once RUN_MAINTENANCE_IF_MAIN;
