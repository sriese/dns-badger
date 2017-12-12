<?php
/* FIFO enqueuer, keeps caches hot */

require_once "deps/queues/ConcurrentFIFO.php";
require_once "deps/vendor/autoload.php";
require_once "inc/fileIO.php";
require_once "inc/dnstrace.php";

$q = new ConcurrentFIFO('fqdns.fifo');
$maxThru = intval(basicRead(getcwd() . "/maxThroughput"));

while(true) {
	if($q->count() < ($maxThru * 30)) {
		
	}
	
	sleep(1);
	
	$doReload = intval(basicRead(getcwd() . "/status/reload"));

	if($doReload != 0) {
		while(true) {
			if($q->count() == 0) {
				exec("ps ax", $psOut);
				$psCtr = 0;
				foreach($psOut as $process) {
					if(strpos($process, "php dequeue.php") != false) {
						$psCtr++;
					}
				}
				if($psCtr == 0) {
					basicWrite(getcwd() . "/status/enqueue", "1");
					exit;
				}
			}
			sleep(10);
		}
	}
}