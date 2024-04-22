@extends('app')
@section('content')
<div class="content-wrapper">

    <div class="col-12 grid-margin">
        <div class="page-header">
            <h3 class="page-title"> Synchronize </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('synchronize') }}">List</a></li>
                    <li class="breadcrumb-item active" aria-current="page">New Synchronize</li>
                </ol>
            </nav>
        </div>
        @if($errors->any())
        <div class="alert alert-danger py-2">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <div class="card">
            <div class="card-body">
                {{-- <h4 class="card-title">Synchronize</h4> --}}
                <form class="form-sample" action="{{ route('synchronize-update', $data_synchronize->id) }}"
                    method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Code</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control text-white" name="code"
                                        value="{{ old('code',$data_synchronize->code) }}" required />
                                    <input type="hidden" class="form-control text-white"
                                        value="{{ $data_synchronize->command }}" name="command"
                                        value="{{ config('constan.command') }}" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Description</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control text-white" name="description"
                                        value="{{ old('description',$data_synchronize->description) }}" required />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Src Connection</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control text-white" name="source_connection"
                                        id="source_connection"
                                        value="{{ old('source_connection',$data_synchronize->source_connection) }}"
                                        required />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Tgt Connection</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control text-white" name="target_connection"
                                        id="target_connection"
                                        value="{{ old('target_connection',$data_synchronize->target_connection) }}"
                                        required />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Target Table</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control text-white" name="target_table"
                                        value="{{ old('target_table',$data_synchronize->target_table) }}" required />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Cronjob</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control text-white" name="cron"
                                        value="{{ old('cron',$data_synchronize->cron) }}" required />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Additional Query</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control text-white" name="additional_query"
                                        value="{{ old('additional_query',$data_synchronize->additional_query) }}" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check form-check-danger">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" name="target_truncate" {{
                                                ($data_synchronize->target_truncate==1) ? 'checked':''}}>
                                            Truncate Target </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check form-check-primary">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" name="active" {{
                                                ($data_synchronize->active==1) ? 'checked':''}}>
                                            Active </label>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-sm-12 col-form-label">Query</label>
                                <div class="col-sm-12">
                                    <textarea class="form-control text-white bg-dark text-warning" id="query"
                                        name="query" rows="4"
                                        required>{{ old('query',$data_synchronize->query) }} </textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                {{-- <label class="col-sm-3 col-form-label">Limit</label> --}}
                                <div class="col-sm-9">
                                    <input type="hidden" readonly class="form-control text-warning bg-dark"
                                        name="limit_record" value="{{ old('limit_record',env('MAX_DATA_SYNC')) }}" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-sm btn-inverse-success mr-2">Update</button>
                    <a href="{{ route('synchronize') }}" class="btn btn-sm btn-inverse-danger">Cancel</a>
                    <span class="btn btn-sm btn-inverse-primary" data-toggle="modal" data-target="#modalQueryTest">Query
                        Test</span>

                </form>

            </div>

        </div>
    </div>
</div>
@include('pages.synchronize-modal')
@endsection
@push('script')
<script>
    function execQuery()
    {

        connection_query = $("#connection_query").val();
        query = $("#query_text").val();

        $(".result-table").html("<h5>Load Data...</h5>");

        var url     = '{{ route("synchronize-query") }}';
        $.ajax({
            type:"POST",
            url:url,
            data:  {
                connection_query : connection_query,
                text_query :query,
                _token: "{{ csrf_token() }}",
            },
            success: function(response)
            {
                $(".result-table").html("");
                $(".result-table").html(response);
            }
        })
    }
</script>
@endpush