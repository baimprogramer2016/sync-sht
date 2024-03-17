@extends('app')
@section('content')
<div class="content-wrapper">

    <div class="col-12 grid-margin">
        <div class="page-header">
            <h3 class="page-title"> Error </h3>

        </div>
        <div class="card mb-3">
            <div class="card-body">
                <h4 class="card-title">Filter</h4>
                <form class="form-inline">
                    <label class="sr-only" for="code">Code</label>
                    <input type="text" class="form-control form-control-sm mb-2 mr-sm-2" name="code" id="code"
                        placeholder="Code">
                    <label class="sr-only" for="start_date">Date</label>
                    <input type="text" class="form-control form-control-sm mb-2 mr-sm-2" name="start_date"
                        id="start_date" placeholder="Start : 2023/01/28">
                    <input type="text" class="form-control form-control-sm mb-2 mr-sm-2" name="start_date"
                        id="start_date" placeholder="End : 2023/01/28">

                    <button type="submit" class="btn btn-sm btn-inverse-info mb-2">Search</button>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>UUID</th>
                                <th>Connection</th>
                                <th>Queue</th>
                                <th>Payload</th>
                                <th>Exception</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>employee_sync</td>
                                <td>0002345</td>
                                <td>2023-12-01 07:30</td>
                                <td>2023-12-01 08:30</td>
                                <td></td>
                                <td><button class="btn btn-sm btn-inverse-success">Success</button></td>

                            </tr>
                            <tr>
                                <td>employee_sync</td>
                                <td>0002345</td>
                                <td>2023-12-01 07:30</td>
                                <td>2023-12-01 08:30</td>
                                <td>Faled : Your SQL ....</td>
                                <td><button class="btn btn-sm btn-inverse-danger">Failed</button></td>

                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection