<div class="modal fade " id="modalDelete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color:#191c24;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('synchronize-delete') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row p-5">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Code</label>
                            <div class="col-sm-9">
                                <input type="hidden" class="form-control text-white" readonly name="id_delete"
                                    id="id_delete" required />
                                <input type="text" class="form-control bg-dark text-white" readonly name="code_delete"
                                    id="code_delete" required />
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Delete</button>
                    <button type="button" class="btn btn-inverse-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
