<?php

namespace App\Repositories\SynchronizeProcess;

interface SynchronizeProcessInterface
{
    public function checkSynchronizeAlreadyRunning($code);

    public function insertSynchronizeProcess($param = []);
    public function updateSyncronizeProcess($param = []);
}
