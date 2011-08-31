<?php
/* Test front-end for the background task mechanism. Load this page
 * and it will launch a background task.
 */

/* Launches the given PHP script as a background process, passing it
 * the given arguments and returning the process ID of the launched
 * task. The caller is responsible for sanitizing the script name.
 */
function runInBackground($script) {
    $pid = shell_exec("nohup $script >>log.txt 2>>&1 & echo $!");
    return $pid;
}

echo "Launching background task...";

runInBackground("php background-task.php foo bar");

echo "Success!";
?>
