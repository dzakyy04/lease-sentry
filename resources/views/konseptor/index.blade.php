@extends('layouts.app')

@push('js')
    <script src="{{ asset('assets/js/libs/datatable-btns.js?ver=3.0.3') }}"></script>
    <script src="{{ asset('assets/js/example-toastr.js?ver=3.0.3') }}"></script>

    <script>
        $(document).ready(function() {
            $(document).on('show.bs.modal', '#editConceptorModal', async function(event) {
                const button = $(event.relatedTarget);
                const id = button.data('id');
                const modal = $(this);
                const form = modal.find('#editForm');

                $.ajax({
                    url: '{{ route('conceptor.get', ':id') }}'.replace(':id', id),
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        form.find('#name').val(data.name);
                        form.find('#email').val(data.email);
                        form.find('#whatsapp_number').val(data.whatsapp_number);
                        form.find('#role option').prop('selected', false);
                    },
                    error: function(xhr, status, error) {
                        alert('Data tidak ditemukan');
                    }
                });

                form.attr('action', '{{ route('conceptor.update', ':id') }}'.replace(':id', id));
            });

            $(document).on('show.bs.modal', '#deleteConceptorModal', async function(event) {
                const button = $(event.relatedTarget);
                const id = button.data('id');
                const modal = $(this);
                const form = modal.find('#deleteForm');

                $.ajax({
                    url: '{{ route('conceptor.get', ':id') }}'.replace(':id', id),
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        form.find('#deleteMessage').html(
                            `Apakah anda yakin ingin menghapus <strong>${data.name}</strong> sebagai <strong>${data.role}</strong>?`
                            );
                    },
                    error: function(xhr, status, error) {
                        alert('Data tidak ditemukan');
                    }
                });

                form.attr('action', '{{ route('conceptor.delete', ':id') }}'.replace(':id', id));
            });
        });
    </script>
    @if (session()->has('success'))
        <script>
            let message = @json(session('success'));
            NioApp.Toast(`<h5>Berhasil</h5><p>${message}</p>`, 'success', {
                position: 'top-right',
            });
        </script>
    @endif
@endpush

@section('content')
    <div class="components-preview wide-md mx-auto">
        <div class="nk-block nk-block-lg">
            <div class="nk-block-head">
                <div class="nk-block-head-content">
                    <h4 class="nk-block-title">Konseptor
                        {{ Auth::user()->role == 'Admin Pkn' ? 'Pkn' : (Auth::user()->role == 'Admin Penilai' ? 'Penilai' : '') }}
                    </h4>
                </div>
            </div>
            <div class="card card-bordered card-preview">
                <div class="card-inner">
                    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal"
                        data-bs-target="#addConceptorModal" data-modal-title="Tambah Konseptor">
                        <span class="ni ni-plus"></span>
                        <span class="ms-1">Tambah Konseptor</span>
                    </button>
                    <table class="datatable-init-export table-responsive table-bordered nowrap table"
                        data-export-title="Export">
                        <thead>
                            <tr class="table-light">
                                <th class="text-center">No</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Nomor Whatsapp</th>
                                <th class="text-center">Peran</th>
                                <th class="text-center no-export">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($conceptors as $index => $conceptor)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>{{ $conceptor->name }}</td>
                                    <td>{{ $conceptor->email }}</td>
                                    <td>{{ $conceptor->whatsapp_number }}</td>
                                    <td>{{ $conceptor->role }}</td>
                                    <td class="text-center">
                                        <button class="btn btn-warning btn-xs rounded-pill" data-bs-toggle="modal"
                                            data-bs-target="#editConceptorModal" data-modal-title="Edit Konseptor"
                                            data-id="{{ $conceptor->id }}">
                                            <em class="ni ni-edit"></em>
                                        </button>
                                        <button class="btn btn-danger btn-xs rounded-pill" data-bs-toggle="modal"
                                            data-bs-target="#deleteConceptorModal" data-id="{{ $conceptor->id }}">
                                            <em class="ni ni-trash"></em>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Add Modal --}}
    <div class="modal fade" id="addConceptorModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Konseptor</h5>
                    <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <em class="icon ni ni-cross"></em>
                    </a>
                </div>
                <div class="modal-body">
                    <form action="{{ route('conceptor.store') }}" method="POST" class="form-validate is-alter">
                        @csrf
                        <div class="form-group">
                            <label class="form-label" for="add_name">Nama</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="add_name" name="name"
                                    placeholder="Contoh: Aldi Taher" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="add_email">Email</label>
                            <div class="form-control-wrap">
                                <input type="email" class="form-control" id="add_email" name="email"
                                    placeholder="Contoh: myemail123@gmail.com" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="whatsapp_number">Nomor whatsapp</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="add_whatsapp_number" name="whatsapp_number"
                                    placeholder="Contoh: 08139384183" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="password">Password</label>
                            <div class="form-control-wrap">
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Masukkan password untuk konseptor baru" required>
                            </div>
                        </div>
                        @can('super-admin')
                            <div class="form-group">
                                <div class="form-label" for="add_role">Peran</div>
                                <div class="form-control-wrap">
                                    <select id="add_role" class="form-select js-select2 @error('role') is-invalid @enderror"
                                        name="role" aria-label="State" required>
                                        <option selected disabled>Pilih Peran Konseptor</option>
                                        <option value="Admin Pkn">Admin Penilai</option>
                                        <option value="Admin Penilai">Admin Pkn</option>
                                    </select>
                                </div>
                            </div>
                        @endcan
                        <div class="form-group text-end">
                            <button type="submit" class="btn btn-lg btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Edit Modal --}}
    <div class="modal fade" id="editConceptorModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Konseptor</h5>
                    <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <em class="icon ni ni-cross"></em>
                    </a>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" class="form-validate is-alter" id="editForm">
                        @csrf
                        <div class="form-group">
                            <label class="form-label" for="name">Nama</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Contoh: Aldi Taher" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="email">Email</label>
                            <div class="form-control-wrap">
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Contoh: myemail123@gmail.com" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="whatsapp_number">Nomor whatsapp</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="whatsapp_number" name="whatsapp_number"
                                    placeholder="Contoh: 08139384183" required>
                            </div>
                        </div>
                        <div class="form-group text-end">
                            <button type="submit" class="btn btn-lg btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Delete Modal --}}
    <div class="modal fade" id="deleteConceptorModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Konseptor</h5>
                    <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <em class="icon ni ni-cross"></em>
                    </a>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" class="form-validate is-alter" id="deleteForm">
                        @csrf
                        @method('delete')
                        <div id="deleteMessage"></div>
                        <div class="form-group text-end mt-3">
                            <button type="submit" class="btn btn-lg btn-danger">Hapus</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
