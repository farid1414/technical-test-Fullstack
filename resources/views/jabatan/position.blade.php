@extends('layout.app')

@section('css')
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection
@section('breadcrumb')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Jabatan</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Jabatan</li>
        </ol>
    </div>
@endsection
@section('content')
    <div class="card sm mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" id="addPosition">
                Tambah Jabatan
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive p-3">
                <table class="table align-items-center table-flush" id="tabel-position">
                    <thead class="thead-light">
                        <tr>
                            <th>No.</th>
                            <th>Jabatan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('modal')
    <div class="modal fade" id="modal-position" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data Jabatan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="ecampleName">Nama jabatan</label>
                        <input type="text" class="form-control" id="name" name="name"
                            placeholder="Masukkan Jabatan">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-jabatan"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Close</button>
                    <button type="button" id="add-position" class="btn btn-success">Simpan</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@include('jabatan.modal-jabatan')

@push('js')
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @yield('js-modal')
    <script>
        $('body').on('click', '#addPosition', function() {
            $('#modal-position').modal('show');
        });

        $('#add-position').click(function(e) {
            e.preventDefault();

            //define variable
            let nama_position = $('#name').val();
            let token = $("meta[name='csrf-token']").attr("content");

            //ajax
            $.ajax({

                url: `/position`,
                type: "POST",
                cache: false,
                data: {
                    "name": nama_position,
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
                    $('#modal-position').modal('hide');
                    $('#tabel-position').DataTable().ajax.reload();

                },
                error: function(error) {
                    if (error.responseJSON.name) {
                        $('#alert-jabatan').removeClass('d-none');
                        $('#alert-jabatan').addClass('d-block');
                        $('#alert-jabatan').html(error.responseJSON.name[0]);
                    } else {
                        $('#alert-jabatan').removeClass('d-block');
                        $('#alert-jabatan').addClass('d-none');
                    }

                }

            });
        });
    </script>

    <script>
        $('body').on('click', '#btn-hapus', function() {
            let position_id = $(this).data('id');
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

                        url: `/position/${position_id}`,
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
                            $('#tabel-position').DataTable().ajax.reload();
                        }
                    });
                }
            });
        });
    </script>

    <script>
        $('#tabel-position').DataTable({
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
                    name: 'name'
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
