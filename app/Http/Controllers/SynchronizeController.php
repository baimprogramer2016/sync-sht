<?php

namespace App\Http\Controllers;

use App\Jobs\SynchronizeJob;
use App\Repositories\Synchronize\SynchronizeInterface;
use App\Repositories\SynchronizeProcess\SynchronizeProcessInterface;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use RealRashid\SweetAlert\Facades\Alert;
use Throwable;


class SynchronizeController extends Controller
{
    use GeneralTrait;
    private $synchronize_repo;
    private $synchronize_process_repo;

    private $last_id;
    public function __construct(
        SynchronizeInterface $synchronizeInterface,
        SynchronizeProcessInterface  $synchronizeProcessInterface
    ) {
        $this->synchronize_repo = $synchronizeInterface;
        $this->synchronize_process_repo = $synchronizeProcessInterface;
    }

    public function index()
    {
        try {
            $data_synchronize = $this->synchronize_repo->getAll();
            return view('pages.synchronize', [
                "data_synchronize" => $data_synchronize
            ]);
        } catch (Throwable $e) {
            toast("Error : " . $e->getMessage(), 'danger');
            return redirect('synchronize');
        }
    }
    public function add()
    {
        try {
            return view('pages.synchronize-add');
        } catch (Throwable $e) {
            toast("Error : " . $e->getMessage(), 'danger');
            return redirect('synchronize');
        }
    }
    public function save(Request $request)
    {
        $request->validate([
            'code' => ['required'],
            'description' => ['required'],
            'source_connection' => ['required'],
            'target_connection' => ['required'],
            'target_table' => ['required'],
            'cron' => ['required'],
            'query' => ['required'],
        ]);

        try {

            $this->synchronize_repo->insertSynchronize($request->all());
            toast('Saved', 'success');

            return redirect('synchronize');
        } catch (Throwable $e) {
            toast("Error : " . $e->getMessage(), 'danger');
            return redirect('synchronize');
        }
    }
    public function edit($id)
    {
        try {
            $data_synchronize = $this->synchronize_repo->getId($id);
            return view('pages.synchronize-edit', [
                "data_synchronize" => $data_synchronize
            ]);
        } catch (Throwable $e) {
            toast("Error : " . $e->getMessage(), 'danger');
            return redirect('synchronize');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'code' => ['required'],
            'description' => ['required'],
            'source_connection' => ['required'],
            'target_connection' => ['required'],
            'target_table' => ['required'],
            'cron' => ['required'],
            'query' => ['required'],
        ]);

        try {

            $this->synchronize_repo->updateSynchronize($request->all(), $id);
            toast('Updated', 'success');
            return redirect('synchronize');
        } catch (Throwable $e) {
            toast("Error : " . $e->getMessage(), 'danger');
            return redirect('synchronize');
        }
    }

    public function query(Request $request)
    {
        try {
            $connection_query = $request->connection_query;
            $text_query = $request->text_query;

            $result =  DB::connection($connection_query)->select($text_query);
            // Print the keys

            if (count($result) > env('LIMIT_QUERY_TEST')) {
                return "Batas Limit Query Test : 5 Row";
            } else {
                return view('pages.synchronize-table', [
                    "data_query" => $result,

                ]);
            }
        } catch (Throwable $e) {
            return $e->getMessage();
        }
    }

    public function delete(Request $request)
    {
        try {
            $this->synchronize_repo->deleteSynchronize($request->id_delete);
            toast('Deleted', 'success');
            return redirect('synchronize')
                ->with("pesan", "Deleted")
                ->with('warna', 'success');
        } catch (Throwable $e) {
            toast("Error : " . $e->getMessage(), 'danger');
            return redirect('synchronize');
        }
    }

    //RUN JOB
    public function runSynchronize(Request $request, $id_synchronize)
    {

        try {



            // // Hitung jumlah halaman yang diperlukan berdasarkan jumlah total data dan ukuran batch
            // // $count_data =  DB::connection($source_connection)->select($text_query);
            // $totalData = 2000000;

            // $batchSize = round(($totalData * env('BATCH_SIZE')) / 100);

            // $totalPages = ceil($totalData / $batchSize);



            // // membuat array penampung
            // $result_query = [];
            // for ($page = 1; $page <= $totalPages; $page++) {
            //     $offset = ($page - 1) * $batchSize;
            //     //ambil data kecil kecil
            //     $data_db = DB::connection('pgsql_self')
            //         ->select("SELECT nama,alamat, id as angka FROM tes LIMIT $batchSize OFFSET $offset");

            //     array_push($result_query, $data_db);
            // }


            // foreach (array_chunk($result_query, 100) as $data_chunk) {
            //     $insertData = [];

            //     foreach ($data_chunk as $item_result) {
            //         $object_properties = get_object_vars((object)$item_result);

            //         // Iterasi melalui setiap properti dan mengganti tanda petik dalam nilai properti
            //         foreach ($object_properties as $property => $value) {
            //             // menghilangkan tanda karakter tidak dikenal
            //             $object_properties[$property] = str_replace('?', ' ', mb_convert_encoding((array)$value, "UTF-8"));
            //             $insertData = (array)  $object_properties;
            //             DB::connection('con_target')->table('tes')->insert((array)$object_properties);
            //         }
            //     }
            // }




            // Sudah masing2 sinkronisasinya
            $data_synchronize = $this->synchronize_repo->getId(Crypt::decrypt($id_synchronize));

            # membuat Log status start job, job_report variable untuk mengambil last Id
            # jika tidak ada data,tidak usah insert job log
            if (!empty($data_synchronize)) {
                # Jalankan Job
                $param_start['start_date'] = $this->currentNow(); //dari APITrait
                $param_start['code'] = $data_synchronize->code; //id
                $param_start['status'] = 'Process'; //status awal process , lalu ada Completed
                # jika sudah ada data yang lagi antri gk ush dijlankan di job log
                if ($this->synchronize_process_repo->checkSynchronizeAlreadyRunning($param_start['code']) > 0) {
                    return "Gagal - Job Sudah ada dalam Proses Antrian";
                } else {

                    //cek dahulu hasil data yang keluar
                    $data_count =  DB::connection($data_synchronize->source_connection)->select($data_synchronize->query);

                    if (count($data_count) <= env('MAX_DATA_SYNC')) {
                        $synchronize_process_report = $this->synchronize_process_repo->insertSynchronizeProcess($param_start);
                        $this->last_id = $synchronize_process_report->id;
                        SynchronizeJob::dispatch(
                            count($data_count),
                            $data_synchronize, #data sinkronisasi ini sudah masing2
                            $this->synchronize_process_repo, #data job_logs
                            $this->last_id, #id untuk update status job logs
                        );
                        return 'Job Telah Dijalankan';
                    } else {
                        return "Maksimal " . env('MAX_DATA_SYNC') . " data yang di proses";
                    }
                }
            } else {
                return 'Tidak jadwal Synchronize';
            }
        } catch (Throwable $e) {
            // Log::info("Schedule Message : " . $e->getMessage());
            return $e->getMessage();
        }
    }
}
