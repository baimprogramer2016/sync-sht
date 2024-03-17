<?php

namespace App\Repositories\Synchronize;

interface SynchronizeInterface
{
    public function insertSynchronize($request = []);

    public function getAll();
    public function getId($id);
    public function updateSynchronize($request = [], $id);
    public function deleteSynchronize($id);
}
