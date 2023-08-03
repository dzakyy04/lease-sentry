@extends('layouts.app')

@push('js')
    <script src="{{ asset('assets/js/example-toastr.js?ver=3.0.3') }}"></script>

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
                    <h4 class="nk-block-title">
                        Device
                    </h4>
                </div>
            </div>
            <div class="card card-bordered card-preview">
                <div class="card-inner">
                    <table class="datatable-init table-responsive table-bordered nowrap table" data-export-title="Export">
                        <thead>
                            <tr class="table-light">
                                <th class="text-center">Device ID</th>
                                <th class="text-center">Nomor Whatsapp</th>
                                <th class="text-center">Status</th>
                                <th class="text-center no-export">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">{{ $device_id }}</td>
                                <td class="text-center">{{ $detail->data ? $detail->data->nomor : '-' }}</td>
                                <td class="text-center">
                                    <span
                                        class="badge badge-dim rounded-pill {{ $detail->data->status == 'CONNECTED' ? 'bg-success' : 'bg-danger' }}">{{ $detail->data->status }}</span>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-warning btn-xs rounded-pill" data-bs-toggle="modal"
                                        data-bs-target="#editConceptorModal" data-modal-title="Edit Konseptor"
                                        data-id="">
                                        <em class="ni ni-edit"></em>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
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
                    <form action="{{ route('device.update') }}" method="POST" class="form-validate is-alter"
                        id="editForm">
                        @csrf
                        <div class="form-group">
                            <label class="form-label" for="device_id">Device Id</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="device_id" name="device_id"
                                    value="{{ $device_id }}" placeholder="Contoh: 421ff5c63e4491d94dw9l64849eed1e3"
                                    required>
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
@endsection
