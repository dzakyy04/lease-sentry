{{-- {{ dd($documents) }} --}}
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
    <script>
        $(document).ready(function() {
            const datatableWrap = $(".datatable-wrap");
            const wrappingDiv = $("<div>").addClass("w-100").css("overflow-x", "scroll");
            datatableWrap.children().appendTo(wrappingDiv);
            datatableWrap.append(wrappingDiv);
        });
        $(document).on('show.bs.modal', '#deleteDocument2020Modal', function(event) {
            const button = $(event.relatedTarget);
            const id = button.data('id');
            const satker = button.data('satker');
            const modal = $(this);
            const deleteForm = $('#deleteDocument2020Form');
            const deleteMessage = $('#deleteMessage');

            deleteMessage.html(`Apakah anda yakin ingin menghapus dokumen <strong>${satker}</strong>`);
            deleteForm.attr('action', '{{ route('document2020.delete', ':id') }}'.replace(':id', id));
        });
    </script>
@endpush

@section('content')
    <div class="components-preview wide-xl mx-auto">
        <div class="nk-block nk-block-lg">
            <div class="nk-block-head">
                <div class="nk-block-head-content">
                    <h4 class="nk-block-title">Dokumen Penghapusan 2020</h4>
                </div>
            </div>
            <div class="card card-bordered card-preview">
                <div class="card-inner">
                    @can(['admin-pkn-super-admin'])
                        <div class="d-flex">
                            <a href="{{ route('document2020.penghapusan.create') }}" class="btn btn-primary mb-2 me-2">
                                <em class="icon ni ni-plus me-1"></em> Tambah Dokumen</span>
                            </a>
                            <button type="button" class="btn btn-secondary mb-2" data-bs-toggle="modal"
                                data-bs-target="#uploadModal">
                                <em class="icon ni ni-upload me-1"></em> Import Dokumen
                            </button>

                        </div>
                    @endcan
                    <table
                        class="datatable-init-export nk-tb-list nk-tb-ulist table table-hover table-bordered table-responsive-md"
                        data-auto-responsive="false" data-export-title="Export">
                        <thead>
                            <tr class="table-light nk-tb-item nk-tb-head">
                                <th class="text-nowrap text-center align-middle">No</th>
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
                                    Konseptor Pkn
                                </th>
                                <th class="text-nowrap text-center align-middle">
                                    Konseptor Penilai
                                </th>
                                <th class="text-nowrap text-center align-middle">
                                    Nomor Whatsapp <br class="break">Satker
                                </th>
                                <th class="text-nowrap text-center align-middle">Nomor ND <br class="break">Permohonan
                                    Penilaian</th>
                                <th class="text-nowrap text-center align-middle">Tanggal ND <br class="break">Permohonan
                                    Penilaian</th>
                                <th class="text-nowrap text-center align-middle">Nomor NDR <br class="break">Penyampaian
                                    Penilaian</th>
                                <th class="text-nowrap text-center align-middle">Tanggal NDR <br class="break">Penyampaian
                                    Penilaian</th>
                                <th class="text-nowrap text-center align-middle">Nomor Surat <br class="break">Persetujuan
                                </th>
                                <th class="text-nowrap text-center align-middle">Tanggal Surat <br
                                        class="break">Persetujuan</th>
                                <th class="text-nowrap text-center align-middle">Nilai Proporsional <br class="break">Harga
                                    Perolehan</th>
                                <th class="text-nowrap text-center align-middle">Nilai <br class="break">Persetujuan</th>
                                <th class="text-nowrap text-center align-middle">Total <br class="break">Hari</th>
                                <th class="text-nowrap text-center no-export align-middle">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($documents as $index => $document)
                                <tr class="text-center align-middle">
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $document->satker }}</td>
                                    <td>{{ $document->nomor_surat_masuk }}</td>
                                    <td>{{ $document->formatted_tanggal_surat_masuk }}</td>
                                    <td>{{ $document->formatted_tanggal_surat_diterima }}</td>
                                    <td>{{ $document->jenis_persetujuan }}</td>
                                    <td class="text-center">
                                        <span
                                            class="badge badge-dot {{ $document->status_progress == 'Diproses' ? 'bg-warning' : 'bg-success' }} rounded-pill px-2 ">
                                            {{ $document->status_progress }}
                                        </span>
                                    </td>
                                    <td>
                                        <span>{{ $document->user_pkn->name }}</span>
                                    </td>
                                    <td>
                                        <span>{{ $document->user_penilai->name }}</span>
                                    </td>
                                    <td>{{ $document->nomor_whatsapp_satker }}</td>
                                    <td>{{ $document->nomor_nd_permohonan_penilaian ? $document->nomor_nd_permohonan_penilaian : '-' }}
                                    </td>
                                    <td>
                                        {{ $document->formatted_tanggal_nd_permohonan_penilaian_formatted ? $document->formatted_tanggal_nd_permohonan_penilaian_formatted : '-' }}
                                    </td>
                                    <td>{{ $document->nomor_ndr_penilaian ? $document->nomor_ndr_penilaian : '-' }}</td>
                                    <td>
                                        {{ $document->formatted_tanggal_ndr_diterima_penilaian ? $document->formatted_tanggal_ndr_diterima_penilaian : '-' }}
                                    </td>
                                    <td>{{ $document->nomor_surat_persetujuan_penolakan ? $document->nomor_surat_persetujuan_penolakan : '-' }}
                                    </td>
                                    <td>
                                        {{ $document->formatted_tanggal_surat_persetujuan_penolakan ? $document->formatted_tanggal_surat_persetujuan_penolakan : '-' }}
                                    </td>
                                    <td>
                                        {{ $document->nilai_proporsional_harga_perolehan_nilai_bmn ? $document->nilai_proporsional_harga_perolehan_nilai_bmn : '-' }}
                                    </td>
                                    <td>{{ $document->nilai_persetujuan ? $document->nilai_persetujuan : '-' }}</td>
                                    <td>{{ $document->total_hari ? $document->total_hari : '-' }}</td>
                                    <td class="text-nowrap">
                                        <a href="{{ route('document2020.edit', $document->id) }}"
                                            class="btn btn-warning btn-xs rounded-pill">
                                            <em class="ni ni-edit"></em>
                                        </a>
                                        <button class="btn btn-danger btn-xs rounded-pill" data-bs-toggle="modal"
                                            data-bs-target="#deleteDocument2020Modal" data-id="{{ $document->id }}"
                                            data-satker="{{ $document->satker }}">
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

    {{-- Upload Modal --}}
    <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadModalLabel">Upload File Excel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('document2020.import') }}" class="form-validate is-alter" method="post"
                    enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <div class="mb-3">
                            <label for="file" class="form-label">Pilih file Excel</label>
                            <input type="file" class="form-control" id="file" name="file">
                            <div id="fileHelp" class="form-text">File Excel harus berformat .xlsx</div>
                        </div>
                        <div>
                            <a href="{{ asset('assets/template-file/Template-Import.xlsx') }}"
                                class="btn btn-outline-success btn-dim"><em class="icon ni ni-file-xls me-1"></em>
                                Download Template
                                Excel</a>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-secondary">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Delete Modal --}}
    <div class="modal fade" id="deleteDocument2020Modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Dokumen 2020</h5>
                    <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <em class="icon ni ni-cross"></em>
                    </a>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" class="form-validate is-alter" id="deleteDocument2020Form">
                        @csrf
                        @method('delete')
                        <div class="mb-3" id="deleteMessage"></div>
                        <div class="form-group text-end">
                            <button type="submit" class="btn btn-lg btn-danger">Hapus</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
