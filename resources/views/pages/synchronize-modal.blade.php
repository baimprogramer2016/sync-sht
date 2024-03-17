<div class="modal fade " id="modalQueryTest" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-xl ">
        <div class="modal-content" style="background-color:#191c24;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Query Test</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <textarea class="form-control text-white bg-dark text-warning" id="query_text" name="query_text"
                            rows="6"></textarea>
                    </div>

                    <div class="col-sm-3" id="connection_element">
                        <input type="text" placeholder="Connection" class="form-control text-secondary "
                            name="connection" id="connection_query" />
                    </div>

                </div>

            </div>
            <div class="modal-footer">
                <span class="btn btn-inverse-success" onclick="return execQuery()">Execute</span>
                <button type="button" class="btn btn-inverse-secondary" data-dismiss="modal">Close</button>
            </div>
            <div class="col-sm-12 mt-1 p-3">
                <p>Result :</p>
                <div class="result-table overflow-auto">

                </div>
            </div>
        </div>
    </div>
</div>
