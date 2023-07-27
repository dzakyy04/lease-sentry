@extends('layouts.app')

@push('js')
    <script src="{{ asset('assets/js/libs/datatable-btns.js?ver=3.0.3') }}"></script>
    <script src="{{ asset('assets/js/example-toastr.js?ver=3.0.3') }}"></script>

    <script>
        const conceptorForm = $('#conceptorForm');
        const conceptorModal = $('#conceptorModal');
        const nameInput = conceptorModal.find('#name');
        const whatsappNumberInput = conceptorModal.find('#whatsapp_number');
        const modalTitle = conceptorModal.find('#modalTitle');

        async function fetchData(id) {
            try {
                const response = await fetch('{{ route('conceptor.get', ':id') }}'.replace(':id', id));
                if (!response.ok) {
                    throw new Error('Data tidak ditemukan');
                }
                const data = await response.json();
                nameInput.val(data.name);
                whatsappNumberInput.val(data.whatsapp_number);
            } catch (error) {
                alert(error.message);
            }
        }

        function clearModalForm() {
            nameInput.val('');
            whatsappNumberInput.val('');
        }

        $(document).ready(function() {
            // Add and Edit Modal
            $(document).on('show.bs.modal', '#conceptorModal', function(event) {
                const button = $(event.relatedTarget);
                const id = button.data('id');
                const modalTitleText = button.data('modal-title');

                modalTitle.text(modalTitleText);

                if (id) {
                    fetchData(id);
                    conceptorForm.attr('action', '{{ route('conceptor.update', ':id') }}'.replace(':id', id));
                } else {
                    clearModalForm();
                    conceptorForm.attr('action', '{{ route('conceptor.store') }}');
                }
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
                    <h4 class="nk-block-title">Konseptor</h4>
                </div>
            </div>
            <div class="card card-bordered card-preview">
                <div class="card-inner">
                    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#conceptorModal"
                        data-modal-title="Tambah Konseptor">
                        <span class="ni ni-plus"></span>
                        <span class="ms-1">Tambah Konseptor</span>
                    </button>
                    <table class="datatable-init-export table-responsive table-bordered nowrap table"
                        data-export-title="Export">
                        <thead>
                            <tr class="table-light">
                                <th class="text-center">No</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center">Nomor Whatsapp</th>
                                <th class="text-center no-export">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($conceptors as $index => $conceptor)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>{{ $conceptor->name }}</td>
                                    <td>{{ $conceptor->whatsapp_number }}</td>
                                    <td class="text-center">
                                        <button class="btn btn-warning btn-xs rounded-pill" data-bs-toggle="modal"
                                            data-bs-target="#conceptorModal" data-modal-title="Edit Konseptor"
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

    {{-- Add and Edit Modal --}}
    <div class="modal fade" id="conceptorModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle"></h5>
                    <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <em class="icon ni ni-cross"></em>
                    </a>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" class="form-validate is-alter" id="conceptorForm">
                        @csrf
                        <div class="form-group">
                            <label class="form-label" for="name">Nama</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Contoh: Aldi Taher" required>
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
                    <form action="" method="POST" class="form-validate is-alter" id="deleteConceptorForm">
                        @csrf
                        @method('delete')
                        <div id="deleteMessage"></div>
                        <div class="form-group text-end">
                            <button type="submit" class="btn btn-lg btn-danger">Hapus</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
