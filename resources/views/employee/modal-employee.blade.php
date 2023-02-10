<div class="modal fade" id="modal-edit" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Data</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <input type="hidden" id="employee_id">
            <form method="POST" id="editEmployee" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="ecampleName">Nama Lengkap</label>
                        <input type="text" class="form-control" id="name-edit" name="name">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-name-edit"></div>
                    </div>
                    <div class="form-group">
                        <label for="nip">NIP</label>
                        <input type="number" class="form-control" id="nip-edit" name="nip">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-nip-edit"></div>
                    </div>
                    <div class="form-group">
                        <label for="departemen">Departemen</label>
                        <input type="text" class="form-control" id="departemen-edit" name="departemen">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-departemen-edit"></div>
                    </div>
                    <div class="form-group">
                        <label for="position">Jabatan</label>
                        <select class="form-control" name="position" id="position-edit">
                            <option>3</option>
                            <option>4</option>
                        </select>
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-jabatan-edit"></div>
                    </div>
                    <div class="form-group" id="simple-date2">
                        <label for="date_birth">Tanggal Lahir</label>
                        <div class="input-group date">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                            </div>
                            <input type="text" class="form-control" id="date_birth-edit" name="date_birth">
                        </div>
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-date-birth-edit"></div>
                    </div>
                    <div class="form-group">
                        <label for="address">Alamat</label>
                        <textarea class="form-control" id="address-edit" rows="3"></textarea>
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-address-edit"></div>
                    </div>
                    <div class="form-group">
                        <label for="no_telp">No Telepon</label>
                        <input type="number" class="form-control" id="no_telp-edit" name="no_telp">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-no-telp-edit"></div>
                    </div>
                    <div class="form-group">
                        <label>Agama</label>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="islam-edit" name="religion" value="islam"
                                class="custom-control-input">
                            <label class="custom-control-label" for="islam-edit">Islam</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="kristen-edit" name="religion" value="kristen"
                                class="custom-control-input">
                            <label class="custom-control-label" for="kristen-edit">Kristen</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="hindu-edit" name="religion" value="hindu"
                                class="custom-control-input">
                            <label class="custom-control-label" for="hindu-edit">Hindu</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="budha-edit" name="religion" value="budha"
                                class="custom-control-input">
                            <label class="custom-control-label" for="budha-edit">Budha</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="konghucu-edit" name="religion" value="konghucu"
                                class="custom-control-input">
                            <label class="custom-control-label" for="konghucu-edit">Konghucu</label>
                        </div>
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-religion-edit"></div>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" value="1" name="status" class="custom-control-input"
                                id="status-edit">
                            <label class="custom-control-label" for="status-edit">Status Karyawan</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="image">Foto KTP</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="image-edit" name="image">
                            <label class="custom-file-label" for="customFile">Choose file</label>
                            <input type="hidden" id="image-old" name="image-old">
                            <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-image-edit"></div>
                        </div>
                        <span class="text-upload-old"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

@section('js-modal')
    <script>
        const oldImage = document.querySelector("#image-edit");
        const textImage = document.querySelector(".text-upload-old");

        oldImage.addEventListener("change", () => {
            let reader = new FileReader();
            reader.readAsDataURL(oldImage.files[0]);
            textImage.textContent = oldImage.files[0].name;

        });
    </script>
    <script>
        $('body').on('click', '#btn-edit', function() {

            let id = $(this).data('id');
            $.ajax({
                url: `/employee/${id}`,
                type: "GET",
                cache: false,
                success: function(response) {
                    $('#employee_id').val(response.data.id);
                    $('#image-old').val(response.data.image);
                    $('#name-edit').val(response.data.name);
                    $('#departemen-edit').val(response.data.departemen);
                    $('#nip-edit').val(response.data.nip);
                    $('#date_birth-edit').val(response.data.date_birth);
                    $('#address-edit').val(response.data.address);
                    $('#no_telp-edit').val(response.data.no_telp);
                    $("input[name='religion']").each(function() {
                        if ($(this).val() == response.data.religion) {
                            $(this).prop("checked", true);
                        }
                    });
                    if (response.data.status == 1) {
                        $("input[name='status']").prop("checked", true);
                    } else {
                        $("input[name='status']").prop("checked", false);
                    }
                    let select = $("#position-edit");
                    var option = $("<option></option>").attr("value", response.data.position_id).text(
                        response.data.name);
                    if (response.data.position_id == response.data.position_id) {
                        option.attr("selected", "selected");
                    }
                    select.append(option);
                    //open modal
                    $('#modal-edit').modal('show');
                }
            });
        });

        $('#editEmployee').on('submit', function(e) {
            e.preventDefault();
            let religionValue = $('input[name="religion"]:checked').val();
            let statusValue = $('input[name="status"]:checked').val();
            //define variable
            let employee_id = $('#employee_id').val();
            let name = $('#name-edit').val();
            let departemen = $('#departemen-edit').val();
            let nip = $('#nip-edit').val();
            let status
            if (statusValue == 1) {
                status = 1;
            } else {
                status = 0;
            }
            let position = $('#position-edit').val();
            let date_birth = $('#date_birth-edit').val();
            let address = $('#address-edit').val();
            let no_telp = $('#no_telp-edit').val();
            let religion = religionValue;
            let image = $('#image-edit').val();
            if (image == "") {
                image = $('#image-old').val();
            } else {
                let imageOld = $('#image-edit').val()
                image = imageOld.replace("C:\\fakepath\\", "");
            }
            let token = $("meta[name='csrf-token']").attr("content");


            //ajax
            $.ajax({

                url: `/employee/${employee_id}`,
                type: "PUT",
                cache: false,
                data: {
                    "name": name,
                    "nip": nip,
                    "departemen": departemen,
                    "position": position,
                    "date_birth": date_birth,
                    "address": address,
                    "status": status,
                    "no_telp": no_telp,
                    "religion": religion,
                    "image": image,
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


                    $('#tabel-employee').DataTable().ajax.reload();
                    //close modal
                    $('#modal-edit').modal('hide');


                },
                error: function(error) {

                    if (error.responseJSON.name) {
                        $('#alert-name-edit').removeClass('d-none');
                        $('#alert-name-edit').addClass('d-block');
                        $('#alert-name-edit').html(error.responseJSON.name[0]);
                    }
                    if (error.responseJSON.nip) {
                        $('#alert-nip-edit').removeClass('d-none');
                        $('#alert-nip-edit').addClass('d-block');
                        $('#alert-nip-edit').html(error.responseJSON.nip[0]);
                    }
                    if (error.responseJSON.departemen) {
                        $('#alert-departemen-edit').removeClass('d-none');
                        $('#alert-departemen-edit').addClass('d-block');
                        $('#alert-departemen-edit').html(error.responseJSON.departemen[0]);
                    }
                    if (error.responseJSON.date_birth) {
                        $('#alert-date-birth-edit').removeClass('d-none');
                        $('#alert-date-birth-edit').addClass('d-block');
                        $('#alert-date-birth-edit').html(error.responseJSON.date_birth[0]);
                    }
                    if (error.responseJSON.no_telp) {
                        $('#alert-no-telp-edit').removeClass('d-none');
                        $('#alert-no-telp-edit').addClass('d-block');
                        $('#alert-no-telp-edit').html(error.responseJSON.no_telp[0]);
                    }
                    if (error.responseJSON.address) {
                        $('#alert-address-edit').removeClass('d-none');
                        $('#alert-address-edit').addClass('d-block');
                        $('#alert-address-edit').html(error.responseJSON.address[0]);
                    }
                    if (error.responseJSON.religion) {
                        $('#alert-religion-edit').removeClass('d-none');
                        $('#alert-religion-edit').addClass('d-block');
                        $('#alert-religion-edit').html(error.responseJSON.religion[0]);
                    }
                    if (error.responseJSON.image) {
                        $('#alert-image-edit').removeClass('d-none');
                        $('#alert-image-edit').addClass('d-block');
                        $('#alert-image-edit').html(error.responseJSON.image[0]);
                    } else {
                        $('#alert-name-edit').removeClass('d-block');
                        $('#alert-name-edit').addClass('d-none');
                        $('#alert-nip-edit').removeClass('d-block');
                        $('#alert-nip-edit').addClass('d-none');
                        $('#alert-departemen-edit').removeClass('d-block');
                        $('#alert-departemen-edit').addClass('d-none');
                        $('#alert-date-birth-edit').removeClass('d-block');
                        $('#alert-date-birth-edit').addClass('d-none');
                        $('#alert-no-telp-edit').removeClass('d-block');
                        $('#alert-no-telp-edit').addClass('d-none');
                        $('#alert-address-edit').removeClass('d-block');
                        $('#alert-address-edit').addClass('d-none');
                        $('#alert-religion-edit').removeClass('d-block');
                        $('#alert-religion-edit').addClass('d-none');
                        $('#alert-image-edit').removeClass('d-block');
                        $('#alert-image-edit').addClass('d-none');
                    }

                }

            });

        });
    </script>
@endsection
