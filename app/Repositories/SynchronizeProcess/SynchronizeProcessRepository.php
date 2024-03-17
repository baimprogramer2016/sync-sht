<?php

namespace App\Repositories\SynchronizeProcess;

use App\Models\SynchronizeProcess;

class SynchronizeProcessRepository implements SynchronizeProcessInterface
{

    private $synchronize_process_model;
    public function __construct(
        SynchronizeProcess $synchronizeProcess
    ) {
        $this->synchronize_process_model = $synchronizeProcess;
    }

    public function checkSynchronizeAlreadyRunning($code)
    {
        return $this->synchronize_process_model->where('code_synchronize', $code)->where('status', 'Process')->get()->count();
    }

    public function insertSynchronizeProcess($param = [])
    {
        $result = $this->synchronize_process_model->create([
            'code_synchronize' => $param['code'],
            'status' => $param['status'],
            'start_date' => $param['start_date']
        ]);
        return $result;
    }
    public function updateSyncronizeProcess($param = [])
    {
        $result = $this->synchronize_process_model->find($param['last_id']);
        $result->status = $param['status'];
        $result->end_date = $param['end_date'];
        $result->error_message = $param['error_message'];
        $result->update();

        return $result;
    }
}
