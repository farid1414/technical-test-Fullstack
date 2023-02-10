@extends('layout.app')

@section('css')
    <style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
        }

        .text-upload {
            font-size: 13px;
            margin-top: 15px
        }
    </style>
    <link href="{{ asset('vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>
@endsection
@section('breadcrumb')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Karyawan</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Karyawan</li>
        </ol>
    </div>
@endsection
@section('content')
    <div class="card sm mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" id="addEmployee">
                Tambah Karyawan
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive p-3">
                <table class="table align-items-center table-flush" id="tabel-employee">
                    <thead class="thead-light">
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>NIP</th>
                            <th>Jabatan</th>
                            <th>Departemen</th>
                            <th>Tanggal lahir</th>
                            <th>Alamat</th>
                            <th>Agama</th>
                            <th>No telephone</th>
                            <th>Status</th>
                            <th>Foto</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('modal')
    <div class="modal fade" id="modalEmployee" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data Karyawan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" id="saveEmployee" enctype="multipart/form-data">
                    @csrf

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="ecampleName">Nama Lengkap</label>
                            <input type="text" class="form-control" id="name" name="name"
                                aria-describedby="emailHelp" placeholder="Masukkan Nama">
                            <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-name"></div>
                        </div>
                        <div class="form-group">
                            <label for="nip">NIP</label>
                            <input type="number" class="form-control" id="nip" name="nip"
                                placeholder="Masukkan NIP">
                            <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-nip"></div>
                        </div>
                        <div class="form-group">
                            <label for="departemen">Departemen</label>
                            <input type="text" class="form-control" id="departemen" name="departemen"
                                placeholder="Nama Departemen">
                            <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-departemen"></div>
                        </div>
                        <div class="form-group">
                            <label for="position">Jabatan</label>
                            <select class="form-control" name="position" id="position">
                                <option>==== Pilih Jabatan ====</option>
                                @foreach ($position as $jabatan)
                                    <option value="{{ $jabatan->id }}">{{ $jabatan->name }}</option>
                                @endforeach
                            </select>
                            <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-jabatan"></div>
                        </div>
                        <div class="form-group" id="simple-date2">
                            <label for="date_birth">Tanggal Lahir</label>
                            <div class="input-group date">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                </div>
                                <input type="text" class="form-control" value="" id="date_birth" name="date_birth">
                            </div>
                            <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-date-birth"></div>
                        </div>
                        <div class="form-group">
                            <label for="address">Alamat</label>
                            <textarea class="form-control" id="address" rows="3"></textarea>
                            <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-address"></div>
                        </div>
                        <div class="form-group">
                            <label for="no_telp">No Telepon</label>
                            <input type="number" class="form-control" id="no_telp" name="no_telp"
                                placeholder="Masukkan No Telephone">
                            <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-no-telp"></div>
                        </div>
                        <div class="form-group">
                            <label>Agama</label>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="islam" name="religion" value="islam"
                                    class="custom-control-input">
                                <label class="custom-control-label" for="islam">Islam</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="kristen" name="religion" value="kristen"
                                    class="custom-control-input">
                                <label class="custom-control-label" for="kristen">Kristen</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="hindu" name="religion" value="hindu"
                                    class="custom-control-input">
                                <label class="custom-control-label" for="hindu">Hindu</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="budha" name="religion" value="budha"
                                    class="custom-control-input">
                                <label class="custom-control-label" for="budha">Budha</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="konghucu" name="religion" value="konghucu"
                                    class="custom-control-input">
                                <label class="custom-control-label" for="konghucu">Konghucu</label>
                            </div>
                            <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-religion"></div>
                        </div>
                        <div class="form-group">
                            <label for="image">Foto KTP</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="image" name="image">
                                <label class="custom-file-label" for="customFile">Choose file</label>
                                <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-image"></div>
                            </div>
                            <span class="text-upload"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @include('employee.modal-employee');
@endsection
@push('js')
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @yield('js-modal')
    <script>
        const inputImage = document.querySelector("#image");
        const choseImage = document.querySelector(".text-upload");

        inputImage.addEventListener("change", () => {
            let reader = new FileReader();
            reader.readAsDataURL(inputImage.files[0]);
            choseImage.textContent = inputImage.files[0].name;

        });
    </script>
    <script>
        $('#simple-date2 .input-group.date').datepicker({
            startView: 1,
            format: 'yyyy/mm/dd',
            autoclose: true,
            todayHighlight: true,
            todayBtn: 'linked',
        });
    </script>

    <script>
        $('body').on('click', '#addEmployee', function() {
            $('#modalEmployee').modal('show');
        });

        $('#saveEmployee').on('submit', function(e) {
            let religionValue = $('input[name="religion"]:checked').val();

            e.preventDefault();
            //define variable
            let name = $('#name').val();
            let departemen = $('#departemen').val();
            let nip = $('#nip').val();
            let position = $('#position').val();
            let date_birth = $('#date_birth').val();
            let address = $('#address').val();
            let no_telp = $('#no_telp').val();
            let religion = religionValue;
            let image = $('#image').val();
            let file_baru = image.replace("C:\\fakepath\\", "");
            let token = $("meta[name='csrf-token']").attr("content");
            //ajax
            $.ajax({

                url: "{{ url('employee') }}",
                method: "POST",
                cache: false,
                data: {
                    "name": name,
                    "nip": nip,
                    "departemen": departemen,
                    "position": position,
                    "date_birth": date_birth,
                    "address": address,
                    "no_telp": no_telp,
                    "religion": religion,
                    "image": file_baru,
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
                    })

                    //close modal
                    $('#modalEmployee').modal('hide');
                    $('#tabel-employee').DataTable().ajax.reload();

                },
                error: function(error) {
                    if (error.responseJSON.name) {
                        $('#alert-name').removeClass('d-none');
                        $('#alert-name').addClass('d-block');
                        $('#alert-name').html(error.responseJSON.name[0]);
                    }
                    if (error.responseJSON.nip) {
                        $('#alert-nip').removeClass('d-none');
                        $('#alert-nip').addClass('d-block');
                        $('#alert-nip').html(error.responseJSON.nip[0]);
                    }
                    if (error.responseJSON.departemen) {
                        $('#alert-departemen').removeClass('d-none');
                        $('#alert-departemen').addClass('d-block');
                        $('#alert-departemen').html(error.responseJSON.departemen[0]);
                    }
                    if (error.responseJSON.date_birth) {
                        $('#alert-date-birth').removeClass('d-none');
                        $('#alert-date-birth').addClass('d-block');
                        $('#alert-date-birth').html(error.responseJSON.date_birth[0]);
                    }
                    if (error.responseJSON.no_telp) {
                        $('#alert-no-telp').removeClass('d-none');
                        $('#alert-no-telp').addClass('d-block');
                        $('#alert-no-telp').html(error.responseJSON.no_telp[0]);
                    }
                    if (error.responseJSON.address) {
                        $('#alert-address').removeClass('d-none');
                        $('#alert-address').addClass('d-block');
                        $('#alert-address').html(error.responseJSON.address[0]);
                    }
                    if (error.responseJSON.religion) {
                        $('#alert-religion').removeClass('d-none');
                        $('#alert-religion').addClass('d-block');
                        $('#alert-religion').html(error.responseJSON.religion[0]);
                    }
                    if (error.responseJSON.image) {
                        $('#alert-image').removeClass('d-none');
                        $('#alert-image').addClass('d-block');
                        $('#alert-image').html(error.responseJSON.image[0]);
                    } else {
                        $('#alert-name').removeClass('d-block');
                        $('#alert-name').addClass('d-none');
                        $('#alert-nip').removeClass('d-block');
                        $('#alert-nip').addClass('d-none');
                        $('#alert-departemen').removeClass('d-block');
                        $('#alert-departemen').addClass('d-none');
                        $('#alert-date-birth').removeClass('d-block');
                        $('#alert-date-birth').addClass('d-none');
                        $('#alert-no-telp').removeClass('d-block');
                        $('#alert-no-telp').addClass('d-none');
                        $('#alert-address').removeClass('d-block');
                        $('#alert-address').addClass('d-none');
                        $('#alert-religion').removeClass('d-block');
                        $('#alert-religion').addClass('d-none');
                        $('#alert-image').removeClass('d-block');
                        $('#alert-image').addClass('d-none');
                    }

                }

            });
        });
    </script>
    <script>
        $('body').on('click', '#btn-hapus', function() {
            let id = $(this).data('id');
            let token = $("meta[name='csrf-token']").attr("content");

            Swal.fire({
                title: 'Apakah Kamu Yakin?',
                text: "ingin menghapus data ini!",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'TIDAK',
                confirmButtonText: 'YA, HAPUS!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({

                        url: `/employee/${id}`,
                        type: "DELETE",
                        cache: false,
                        data: {
                            "_token": token
                        },
                        success: function(response) {
                            Swal.fire({
                                type: 'success',
                                icon: 'success',
                                title: `${response.message}`,
                                showConfirmButton: false,
                                timer: 3000
                            });
                            $('#tabel-employee').DataTable().ajax.reload();
                        }
                    });
                }
            });
        });
    </script>
    <script>
        $('#tabel-employee').DataTable({
            processing: true,
            serverSide: true,
            ordering: true,
            ajax: {
                url: '{!! url()->current() !!}',
            },
            columns: [{
                    "data": null,
                    "sortable": false,
                    "searcable": false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'name',
                    name: 'name',
                    width: '50%'
                },
                {
                    data: 'nip',
                    name: 'nip'
                },
                {
                    data: 'position.name',
                    name: 'position.name'
                },
                {
                    data: 'departemen',
                    name: 'departemen'
                },
                {
                    data: 'date_birth',
                    name: 'date_birth'
                },
                {
                    data: 'address',
                    name: 'address'
                },
                {
                    data: 'religion',
                    name: 'religion'
                },
                {
                    data: 'no_telp',
                    name: 'no_telp'
                },
                {
                    data: 'status-condition',
                    name: 'status-condition'
                },
                {
                    data: 'image',
                    name: 'image'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searcable: false,
                    width: '15%'
                },
            ]
        })
    </script>
@endpush
