<div class="modal fade" id="modal-edit" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Data</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <input type="hidden" id="position_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="ecampleName">Jabatan</label>
                        <input type="text" class="form-control" id="name-edit" name="name">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-name-edit"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Close</button>
                    <button type="button" id="update-jabatan" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

@section('js-modal')
    <script>
        $('body').on('click', '#btn-edit', function() {
            console.log("buka");
            let id = $(this).data('id');
            $.ajax({
                url: `/position/${id}`,
                type: "GET",
                cache: false,
                success: function(response) {
                    $('#position_id').val(response.data.id);
                    $('#name-edit').val(response.data.name);
                    //open modal
                    $('#modal-edit').modal('show');
                }
            });
        });

         $('#update-jabatan').click(function(e)  {
            e.preventDefault();

            let position_id = $('#position_id').val();
            let name = $('#name-edit').val();
            let token = $("meta[name='csrf-token']").attr("content");

            //ajax
            $.ajax({

                url: `/position/${position_id}`,
                type: "PUT",
                cache: false,
                data: {
                    "name": name,
                    "_token": token
                },
                success: function(response) {

                    //show success message
                    Swal.fire({
                        type: 'success',
                        icon: 'success',
                        title: `${response.message}`,
                        showConfirmButton: false,
                        timer: 3000
                    });


                    $('#tabel-position').DataTable().ajax.reload();
                    //close modal
                    $('#modal-edit').modal('hide');


                },
                error: function(error) {

                    if (error.responseJSON.name) {
                        $('#alert-name-edit').removeClass('d-none');
                        $('#alert-name-edit').addClass('d-block');
                        $('#alert-name-edit').html(error.responseJSON.name[0]);
                    }else{
                      $('#alert-name-edit').removeClass('d-block');
                      $('#alert-name-edit').addClass('d-none');
                      
                    }

                }

            });

        });
    </script>
@endsection
