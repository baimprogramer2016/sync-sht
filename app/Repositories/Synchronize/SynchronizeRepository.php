<?php

namespace App\Repositories\Synchronize;

use App\Models\Synchronize;

class SynchronizeRepository implements SynchronizeInterface
{

    private $syncrhonize_model;
    public function __construct(
        Synchronize $synchronize
    ) {
        $this->syncrhonize_model = $synchronize;
    }

    public function insertSynchronize($request = [])
    {
        if (array_key_exists('active', $request)) {
            $act = 1;
        } else {
            $act = 0;
        }
        if (array_key_exists('target_truncate', $request)) {
            $tr_table = 1;
        } else {
            $tr_table = 0;
        }
        $input = [
            "code" => $request['code'],
            "description" => $request['description'],
            "source_connection" => $request['source_connection'],
            "target_connection" => $request['target_connection'],
            "active" => $act,
            "target_truncate" => $tr_table,
            "command" => $request['command'],
            "target_table" => $request['target_table'],
            "cron" => $request['cron'],
            "additional_query" => $request['additional_query'],
            "query" => $request['query'],
            "limit_record" => $request['limit_record'],
        ];

        $this->syncrhonize_model->create($input);
        return  $this->syncrhonize_model;
    }

    public function getAll()
    {
        return $this->syncrhonize_model->paginate(20);
    }

    public function getId($id)
    {
        return $this->syncrhonize_model->find($id);
    }

    public function updateSynchronize($request = [], $id)
    {
        if (array_key_exists('active', $request)) {
            $act = 1;
        } else {
            $act = 0;
        }
        if (array_key_exists('target_truncate', $request)) {
            $tr_table = 1;
        } else {
            $tr_table = 0;
        }
        $data = $this->getId($id);

        $data->code = $request['code'];
        $data->description = $request['description'];
        $data->source_connection = $request['source_connection'];
        $data->target_connection = $request['target_connection'];
        $data->active = $act;
        $data->target_truncate = $tr_table;
        $data->command = $request['command'];
        $data->target_table = $request['target_table'];
        $data->cron = $request['cron'];
        $data->additional_query = $request['additional_query'];
        $data->query = $request['query'];
        $data->limit_record =  $request['limit_record'];
        $data->update();

        return  $data;
    }

    public function deleteSynchronize($id)
    {
        $data = $this->syncrhonize_model->find($id);
        $data->delete();
        return $data;
    }
}
