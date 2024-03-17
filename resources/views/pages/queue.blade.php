@extends('app')
@section('content')
<div class="content-wrapper">

    <div class="col-12 grid-margin">
        <div class="page-header">
            <h3 class="page-title"> Queue </h3>

        </div>

        <div class="card">
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Queue</th>
                                <th>Payload</th>
                                <th>Attemps</th>
                                <th>Reserved</th>
                                <th>Available</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>employee_sync</td>
                                <td>0002345</td>
                                <td>2023-12-01 07:30</td>
                                <td>2023-12-01 08:30</td>
                                <td>Yes</td>
                                <td>2023-12-01</td>

                            </tr>
                            <tr>
                                <td>employee_sync</td>
                                <td>0002345</td>
                                <td>2023-12-01 07:30</td>
                                <td>2023-12-01 08:30</td>
                                <td>Yes</td>
                                <td>2023-12-01</td>

                            </tr>


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection