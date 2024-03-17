<?php

namespace App\Traits;

use App\Models\Seqno;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

trait GeneralTrait
{
    public $result;
    public function Seqno($param)
    {

        if ($param == 'batchno') {
            $number = Seqno::where('description', 'batchno')->orderBy('id', 'DESC')->first();
            $this->result = ($number == null) ? 'OR-1' : 'OR-' . preg_replace("/[^0-9]/", "", $number->original_code) + 1;
        }

        return $this->result;
    }
    protected function currentNow()
    {
        $datetime = Carbon::now()->format('Y-m-d H:i:s'); // Current datetime
        return $datetime;
    }
}
