@extends('layouts.app')

@push('js')
    <script src="{{ asset('assets/js/libs/datatable-btns.js?ver=3.0.3') }}"></script>
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
                    <h4 class="nk-block-title">Hari Libur</h4>
                </div>
            </div>
            <div class="card card-bordered card-preview">
                <div class="card-inner">
                    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addHoliday">
                        <span class="ni ni-plus"></span>
                        <span class="ms-1">Tambah Hari Libur</span>
                    </button>
                    <table class="datatable-init-export table-responsive table-bordered nowrap table"
                        data-export-title="Export">
                        <thead>
                            <tr class="table-primary">
                                <th class="text-center">No</th>
                                <th class="text-center">Tanggal</th>
                                <th class="text-center">Memperingati</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($holidays as $index => $holiday)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>{{ $holiday->formatted_date }}</td>
                                    <td>{{ $holiday->name }}</td>
                                    <td class="text-center">
                                        <button class="btn btn-warning btn-xs rounded-pill">
                                            <em class="ni ni-edit"></em>
                                        </button>
                                        <span class="btn btn-danger btn-xs rounded-pill">
                                            <em class="ni ni-trash"></em>
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal --}}
    <div class="modal fade" id="addHoliday">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Hari Libur</h5>
                    <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <em class="icon ni ni-cross"></em>
                    </a>
                </div>
                <div class="modal-body">
                    <form action="{{ route('holiday.store') }}" method="POST" class="form-validate is-alter">
                        @csrf
                        <div class="form-group">
                            <label class="form-label" for="date">Tanggal</label>
                            <div class="form-control-wrap">
                                <input type="date" class="form-control" id="date" name="date" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="name">Memperingati</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Contoh: Hari Pancasila" required>
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
