@extends('app')
@section('content')
<div class="content-wrapper">

    <div class="col-12 grid-margin">
        <div class="page-header">
            <h3 class="page-title"> Synchronize </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active">List</li>
                    <li class="breadcrumb-item " aria-current="page"><a href="{{ route('synchronize-add') }}">New
                            Synchronize</a></li>
                </ol>
            </nav>
        </div>
        <div class="card">
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Source</th>
                                <th>Target</th>
                                <th>Record</th>
                                <th>Cronjob</th>
                                <th>Truncate</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($data_synchronize as $item_synchronize)
                            <tr>
                                <td>{{ $item_synchronize['code'] }}</td>
                                <td>{{ $item_synchronize['source_connection'] }}</td>
                                <td>{{ $item_synchronize['target_connection'] }}</td>
                                <td>{{ $item_synchronize['record'] }}</td>
                                <td>{{ $item_synchronize['cron'] }}</td>
                                <td>
                                    <button
                                        class="btn btn-sm btn-inverse-{{ ($item_synchronize->target_truncate == 1) ? 'danger' : 'secondary'  }}">Truncate</button>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-inverse-{{ ($item_synchronize->active == " 1")
                                        ? 'success' : 'secondary' }}">Active</button>
                                </td>
                                <td>
                                    <a class="btn btn-sm btn-primary"
                                        href="{{ route('synchronize-edit', $item_synchronize->id) }}">Edit</a>
                                    <span class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modalDelete"
                                        onclick="return deleteModel('{{ $item_synchronize->id }}','{{ $item_synchronize->code }}')">Delete</span>
                                    <span class="btn btn-sm btn-success"
                                        onClick="return modalSinkron('{{ Crypt::encrypt($item_synchronize->id) }}')">
                                        Run</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-3 pagination-custom">
                        {{ $data_synchronize->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('pages.synchronize-delete')
@endsection

@push('script')
<script src="{{ asset('assets/js/sweetalert2@11.js') }}"></script>
<script>
    function deleteModel(id,code)
    {
        $("#id_delete").val(id);
        $("#code_delete").val(code);
    }

    function modalSinkron(id)
    {

        Swal.fire({
                    title: 'Konfirmasi',
                    text: "Synchronization will be Executed",
                    showCancelButton: true,
                    confirmButtonColor: "#2c3782",
                    confirmButtonText: 'Run',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.value) {
                        var url     = '{{ route("synchronize-run", ":id_synchronize") }}';
                        url         = url.replace(':id_synchronize',id);

                        $.ajax({
                            type:"POST",
                            url:url,
                            data: {
                                _token : "{{csrf_token()}}"
                            },
                            success: function(response)
                            {
                                console.log(JSON.stringify(response));
                                toastMessage(response);
                            }
                        })
                    }
                });
    }

    function toastMessage(message){
        Swal.fire({
        icon: 'success',
        title: 'Notification',
        text: message,
        toast: true,
        position: 'top-end', // Posisi toast (top-start, top-end, bottom-start, bottom-end)
        showConfirmButton: false,
        timer: 3000 // Durasi pesan toast (ms)
        });
    }
</script>
@endpush