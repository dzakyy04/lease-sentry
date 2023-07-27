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
                    <h4 class="nk-block-title">Dokumen 2020</h4>
                </div>
            </div>
            <div class="card card-bordered card-preview">
                <div class="card-inner">
                    <button type="button" class="btn btn-primary mb-3">
                        <span class="ni ni-plus"></span>
                        <span class="ms-1">Tambah Dokumen</span>
                    </button>
                    <table class="datatable-init-export table-responsive table-bordered nowrap table"
                        data-export-title="Export">
                        <thead>
                            <tr class="table-light">
                                <th class="text-nowrap text-center align-middle">Satker</th>
                                <th class="text-nowrap text-center align-middle">
                                    Nomor <br class="break">Surat Masuk
                                </th>
                                <th class="text-nowrap text-center align-middle">
                                    Tanggal <br class="break">Surat Masuk
                                </th>
                                <th class="text-nowrap text-center align-middle">
                                    Tanggal <br class="break">Surat Diterima
                                </th>
                                
                                <th class="text-nowrap text-center align-middle">
                                    Jenis <br class="break">Persetujuan
                                </th>
                                <th class="text-nowrap text-center align-middle">Status <br class="break">Progress</th>
                                <th class="text-nowrap text-center align-middle">
                                    Konseptor
                                </th>
                                <th class="text-nowrap text-center align-middle">Nomor ND Permohonan Penilaian</th>
                                <th class="text-nowrap text-center align-middle">Tanggal ND Permohonan Penilaian</th>
                                <th class="text-nowrap text-center align-middle">Nomor NDR Penyampaian Penilaian</th>
                                <th class="text-nowrap text-center align-middle">Tanggal NDR Penyampaian Penilaian</th>
                                <th class="text-nowrap text-center align-middle">Nomor Surat Persetujuan</th>
                                <th class="text-nowrap text-center align-middle">Tanggal Surat Persetujuan</th>
                                <th class="text-nowrap text-center align-middle">Nilai Proporsional Harga Perolehan</th>
                                <th class="text-nowrap text-center align-middle">Nilai Persetujuan</th>
                                <th class="text-nowrap text-center align-middle">Periode Sewa</th>
                                <th class="text-nowrap text-center align-middle">Total Hari</th>
                                <th class="text-nowrap text-center align-middle">Status Masa Aktif</th>
                                <th class="text-nowrap text-center no-export align-middle">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($documents as $index => $document)
                                <tr>
                                    <td>{{ $document->satker }}</td>
                                    <td>{{ $document->nomor_surat_masuk }}</td>
                                    <td>{{ $document->surat_masuk_date_formatted }}</td>
                                    <td>{{ $document->surat_diterima_date_formatted }}</td>
                                    <td>{{ $document->jenis_persetujuan }}</td>
                                    <td class="text-center">
                                        <span
                                            class="badge badge-dot {{ $document->status_progress == 'Diproses' ? 'bg-warning' : 'bg-success' }} rounded-pill px-2 ">
                                            {{ $document->status_progress }}
                                        </span>
                                    </td>
                                    <td>{{ $document->conceptor->name }}</td>
                                    <td>{{ $document->nomor_nd_permohonan_penilaian }}</td>
                                    <td>{{ $document->tanggal_nd_permohonan_penilaian }}</td>
                                    <td>{{ $document->nomor_ndr_penilaian }}</td>
                                    <td>{{ $document->tanggal_ndr_diterima_penilaian }}</td>
                                    <td>{{ $document->nomor_surat_persetujuan_penolakan }}</td>
                                    <td>{{ $document->tanggal_surat_persetujuan_penolakan }}</td>
                                    <td>{{ $document->nilai_proporsional_harga_perolehan_nilai_bmn }}</td>
                                    <td>{{ $document->nilai_persetujuan }}</td>
                                    <td>{{ $document->periode_sewa }}</td>

                                    <td>{{ $document->total_hari }}</td>
                                    <td>{{ $document->status_masa_aktif }}</td>
                                    
                                    <td class="text-nowrap text-center">
                                        <a href="" class="btn btn-warning btn-xs rounded-pill">
                                            <em class="ni ni-edit"></em>
                                        </a>
                                        <a href="" class="btn btn-danger btn-xs rounded-pill">
                                            <em class="ni ni-trash"></em>
                                        </a>
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
