<?php

namespace App\Jobs;

use App\Traits\GeneralTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class SynchronizeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, GeneralTrait;

    /**
     * Create a new job instance.
     */
    public $synchronize_repo, $synchronize_process_repo, $last_id;
    public function __construct(
        $synchronize_repo,
        $synchronize_process_repo,
        $last_id,
    ) {
        $this->synchronize_repo = $synchronize_repo;
        $this->synchronize_process_repo = $synchronize_process_repo;
        $this->last_id = $last_id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        # cek lagi jika ada
        if (!empty($this->synchronize_repo)) {

            # proses migrasi
            # source data
            $source_connection = $this->synchronize_repo->source_connection;
            $target_connection = $this->synchronize_repo->target_connection;
            $text_query = $this->synchronize_repo->query;
            $text_query_no_limit = preg_replace('/\sLIMIT\s+\d+(?:\s*,\s*\d+)?\s*/i', '', $text_query);
            $additional_query = $this->synchronize_repo->additional_query;
            $truncate_table = $this->synchronize_repo->target_truncate;
            $target_table = $this->synchronize_repo->target_table;

            # jika ada truncate dikosong kan dahulu ..
            if ($truncate_table == 1) {
                DB::connection($target_connection)->table($target_table)->truncate();
            }


            #VERSI 3. MYSQL, POSTGRESQL diatas 500.000 , SYBASE DAN MSSQL TIDAK BISA dan hanya bisa menggunakan LIMIT

            $batchSize = env('BATCH_SIZE');

            // Hitung jumlah halaman yang diperlukan berdasarkan jumlah total data dan ukuran batch
            $count_data =  DB::connection($source_connection)->select($text_query);
            $totalData = count($count_data);
            $totalPages = ceil($totalData / $batchSize);

            // membuat array penampung
            $result_query = [];
            for ($page = 1; $page <= $totalPages; $page++) {
                $offset = ($page - 1) * $batchSize;
                //ambil data kecil kecil
                $data_db = DB::connection($source_connection)
                    ->select("$text_query_no_limit LIMIT $batchSize OFFSET $offset");

                array_push($result_query, $data_db);
            }


            foreach (array_chunk($result_query, 1000) as $data_chunk) {
                $insertData = [];

                foreach ($data_chunk as $item_result) {
                    $object_properties = get_object_vars((object)$item_result);

                    // Iterasi melalui setiap properti dan mengganti tanda petik dalam nilai properti
                    foreach ($object_properties as $property => $value) {
                        // menghilangkan tanda karakter tidak dikenal
                        $object_properties[$property] = str_replace('?', ' ', mb_convert_encoding((array)$value, "UTF-8"));
                    }

                    $insertData = (array)  $object_properties;
                    DB::connection($target_connection)->table($target_table)->insert($insertData);
                }
            }



            # -----------------------------------------------------------------------------------------------------


            # VERSI 2. MSSQL ,SYBASE, POSTGRESQL, MYSQL - data dibawah 500.000
            // $result_query =  DB::connection($source_connection)->select($text_query);
            // foreach (array_chunk($result_query, 1000) as $chunk) {
            //     $insertData = [];

            //     foreach ($chunk as $item_result) {
            //         $object_properties = get_object_vars($item_result);

            //         // Iterasi melalui setiap properti dan mengganti tanda petik dalam nilai properti
            //         foreach ($object_properties as $property => $value) {
            //             // menghilangkan tanda karakter tidak dikenal
            //             $object_properties[$property] = str_replace('?', ' ', mb_convert_encoding($value, "UTF-8"));
            //         }

            //         $insertData[] = (array) $object_properties;
            //     }

            //     DB::connection($target_connection)->table($target_table)->insert($insertData);
            // }
            # -----------------------------------------------------------------------------------------------------

            # VERSI 1. MSSQL ,SYBASE, POSTGRESQL, MYSQL - OLD data dibawah 500.000
            // $result_query =  DB::connection($source_connection)->select($text_query);
            // foreach ($result_query as $item_result) {
            //     $object_properties = get_object_vars($item_result);

            //     // Iterasi melalui setiap properti dan mengganti tanda petik dalam nilai properti
            //     foreach ($object_properties as $property => $value) {
            //         // menghilangkan tanda karakter tidak dikenal
            //         $object_properties[$property] = str_replace('?', ' ', mb_convert_encoding($value, "UTF-8"));
            //     }
            //     DB::connection($target_connection)->table($target_table)->insert((array) $object_properties);
            // }


            # jalan kan SP jika ada dan setelah query di jalankan
            if (!empty($additional_query)) {
                # jika ada sp lebih dari 1
                if (strpos($additional_query, "#")) {
                    $sp_result = explode("#", $additional_query);
                    foreach ($sp_result as $index => $item_result) {
                        // echo $item_result[$index];
                        DB::connection($target_connection)->select($item_result[$index]);
                    }
                } else {

                    DB::connection($target_connection)->select($additional_query);
                }
            }
        }
        $param_end['last_id'] = $this->last_id;
        $param_end['end_date'] =  $this->currentNow();
        $param_end['status'] =  'Completed';
        $param_end['error_message'] =  null;
        $this->synchronize_process_repo->updateSyncronizeProcess($param_end);
    }
    public function failed(Throwable $e)
    {
        Log::info($e);
        // Called when the job is failing...
        $param_end['last_id'] = $this->last_id;
        $param_end['end_date'] =  $this->currentNow();
        $param_end['status'] =  'Failed';
        $param_end['error_message'] = $e->getMessage();
        $this->synchronize_process_repo->updateSyncronizeProcess($param_end);
    }
}
