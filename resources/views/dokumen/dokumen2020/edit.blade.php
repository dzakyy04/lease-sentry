@extends('layouts.app')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/libs/bootstrap-icons.min.css') }}">
@endpush

@push('js')
    <script>
        $(document).ready(function() {
            $("#submitButton").click(function(event) {
                event.preventDefault();

                $("#editForm input[disabled]").removeAttr("disabled");
                $("#editForm select[disabled]").removeAttr("disabled");

                $("#editForm").submit();
            });
        });
    </script>
    <script>
        const formatNumberWithDots = (input) => input.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".");

        const updateFormattedValue = (inputId) => {
            const inputElement = document.getElementById(inputId);
            const formattedValue = formatNumberWithDots(inputElement.value);
            inputElement.value = formattedValue;
        };

        const formatInputWithDots = (inputId) => {
            document.getElementById(inputId).addEventListener("input", () => updateFormattedValue(inputId));
        };

        formatInputWithDots("nilai_proporsional_harga_perolehan_nilai_bmn");
        formatInputWithDots("nilai_persetujuan");
    </script>
@endpush

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-5">
                <div class="steps">
                    <div class="steps-header">
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100"
                                style="width: {{ $progress->selesai->isCompleted ? 100 : ($progress->dinilai->isCompleted ? 66.7 : ($progress->masuk->isCompleted ? 33.3 : 0)) }}%;">
                            </div>
                        </div>
                    </div>
                    <div class="steps-body">

                        {{-- Dokumen masuk --}}
                        <div class="step {{ $progress->masuk->isCompleted ? 'step-completed' : '' }}">
                            @if ($progress->masuk->isCompleted)
                                <span class="step-indicator">
                                    <em class="bi bi-check-lg"></em>
                                </span>
                            @endif
                            <span class="step-icon">
                                <em class="bi bi-1-circle fs-3"></em>
                            </span>
                            <div class="mt-4">Dokumen masuk</div>
                        </div>

                        {{-- Dokumen dinilai --}}
                        <div class="step {{ $progress->dinilai->isCompleted ? 'step-completed' : '' }}">
                            @if ($progress->dinilai->isCompleted)
                                <span class="step-indicator">
                                    <em class="bi bi-check-lg"></em>
                                </span>
                            @endif
                            <span class="step-icon">
                                <em class="bi bi-2-circle fs-3"></em>
                            </span>
                            <div class="mt-4">Dokumen dinilai</div>
                        </div>

                        {{-- Dokumen selesai --}}
                        <div class="step {{ $progress->selesai->isCompleted ? 'step-completed' : '' }}">
                            @if ($progress->selesai->isCompleted)
                                <span class="step-indicator">
                                    <em class="bi bi-check-lg"></em>
                                </span>
                            @endif
                            <span class="step-icon">
                                <em class="bi bi-3-circle fs-3"></em>
                            </span>
                            <div class="mt-4">Dokumen selesai</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        @canany(['admin-pkn-super-admin'])
            @if ($document->tanggal_nd_permohonan_penilaian == null || $document->nomor_nd_permohonan_penilaian == null)
                <div class="col-lg-12 mb-3">
                    <div class="alert alert-pro alert-primary alert-dismissible fade show" role="alert">
                        <em class="bi bi-info-circle me-1"></em><strong>{{ Auth::user()->role }}</strong> silahkan
                        lengkapi data pokok terlebih dahulu 😄
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif
        @endcanany

        <form method="post" action="{{ route('document2020.update', $document->id) }}" id="editForm">
            @csrf
            {{-- Data surat masuk --}}
            <div class="card card-bordered card-preview">
                <div class="card-inner">
                    <div class="preview-block">
                        <span class="preview-title-lg overline-title">Masukkan Data Surat Masuk</span>
                        <div class="row gy-4">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label" for="satker">Satker</label>
                                    <div class="form-control-wrap">
                                        <input type="text" id="satker"
                                            class="form-control @error('satker') is-invalid @enderror" name="satker"
                                            value="{{ $document->satker }}" required
                                            @can('admin-penilai')
                                            disabled
                                        @endcan>
                                        @error('satker')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label" for="nomor_whatsapp_satker">Nomor Whatsapp Satker</label>
                                    <div class="form-control-wrap">
                                        <div class="form-icon form-icon-right">
                                            <em class="icon ni ni-whatsapp"></em>
                                        </div>
                                        <input type="text" id="nomor_whatsapp_satker"
                                            class="form-control @error('nomor_whatsapp_satker') is-invalid @enderror"
                                            name="nomor_whatsapp_satker" value="{{ $document->nomor_whatsapp_satker }}"
                                            required
                                            @can('admin-penilai')
                                            disabled
                                        @endcan>
                                        @error('nomor_whatsapp_satker')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label" for="nomor_surat_masuk">Nomor Surat Masuk</label>
                                    <div class="form-control-wrap">
                                        <input type="text" id="nomor_surat_masuk"
                                            class="form-control @error('nomor_surat_masuk') is-invalid @enderror"
                                            name="nomor_surat_masuk" value="{{ $document->nomor_surat_masuk }}" required
                                            @can('admin-penilai')
                                            disabled
                                        @endcan>
                                        @error('nomor_surat_masuk')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label" for="tanggal_surat_masuk">Tanggal Surat Masuk</label>
                                    <div class="form-control-wrap">
                                        <input type="date" id="tanggal_surat_masuk"
                                            class="form-control @error('tanggal_surat_masuk') is-invalid @enderror"
                                            name="tanggal_surat_masuk" value="{{ $document->tanggal_surat_masuk }}"
                                            required
                                            @can('admin-penilai')
                                            disabled
                                        @endcan>
                                        @error('tanggal_surat_masuk')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label" for="tanggal_surat_diterima">Tanggal Surat Diterima</label>
                                    <div class="form-control-wrap">
                                        <input type="date" id="tanggal_surat_diterima"
                                            class="form-control @error('tanggal_surat_diterima') is-invalid @enderror"
                                            name="tanggal_surat_diterima" value="{{ $document->tanggal_surat_diterima }}"
                                            required
                                            @can('admin-penilai')
                                            disabled
                                        @endcan>
                                        @error('tanggal_surat_diterima')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label" for="jenis_persetujuan">Jenis Persetujuan</label>
                                    <div class="form-control-wrap">
                                        <select id="jenis_persetujuan"
                                            class="form-select js-select2 @error('jenis_persetujuan') is-invalid @enderror"
                                            name="jenis_persetujuan" aria-label="State" required
                                            @can('admin-penilai')
                                            disabled
                                        @endcan>
                                            <option disabled selected>Pilih Jenis Persetujuan</option>
                                            <option value="Sewa"
                                                {{ $document->jenis_persetujuan === 'Sewa' ? 'selected' : '' }}>
                                                Sewa
                                            </option>
                                            <option value="Penjualan"
                                                {{ $document->jenis_persetujuan === 'Penjualan' ? 'selected' : '' }}>
                                                Penjualan
                                            </option>
                                            <option value="Penghapusan"
                                                {{ $document->jenis_persetujuan === 'Penghapusan' ? 'selected' : '' }}>
                                                Penghapusan
                                            </option>
                                        </select>
                                        @error('jenis_persetujuan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label" for="user_id_pkn">Konseptor Pkn</label>
                                    <div class="form-control-wrap">
                                        <select id="user_id_pkn"
                                            class="form-select js-select2 @error('user_id_pkn') is-invalid @enderror"
                                            name="user_id_pkn" aria-label="State" required
                                            @can('admin-penilai')
                                            disabled
                                        @endcan>
                                            <option disabled>Pilih Konseptor Pkn</option>
                                            @foreach ($pkn_conceptors as $pkn)
                                                <option value="{{ $pkn->id }}" @selected($pkn->id == $document->user_pkn->id)>
                                                    {{ $pkn->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('user_id_pkn')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label" for="user_id_penilai">Konseptor Penilai</label>
                                    <div class="form-control-wrap">
                                        <select id="user_id_penilai"
                                            class="form-select js-select2 @error('user_id_penilai') is-invalid @enderror"
                                            name="user_id_penilai" aria-label="State" required
                                            @can('admin-penilai')
                                            disabled
                                        @endcan>
                                            <option disabled>Pilih Konseptor Penilai</option>
                                            @foreach ($penilai_conceptors as $penilai)
                                                <option value="{{ $penilai->id }}" @selected($penilai->id == $document->user_penilai->id)>
                                                    {{ $penilai->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('user_id_penilai')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label" for="nomor_nd_permohonan_penilaian">Nomor ND Permohonan
                                        Penilaian</label>
                                    <div class="form-control-wrap">
                                        <input type="text" id="nomor_nd_permohonan_penilaian"
                                            class="form-control @error('nomor_nd_permohonan_penilaian') is-invalid @enderror"
                                            name="nomor_nd_permohonan_penilaian"
                                            placeholder="Contoh: ND-775/KNL.0402/2022"
                                            value="{{ $document->nomor_nd_permohonan_penilaian }}"
                                            @can('admin-penilai')
                                            disabled
                                        @endcan>
                                        @error('nomor_nd_permohonan_penilaian')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label" for="tanggal_nd_permohonan_penilaian">Tanggal ND Permohonan
                                        Penilaian</label>
                                    <div class="form-control-wrap">
                                        <input type="date" id="tanggal_nd_permohonan_penilaian"
                                            class="form-control @error('tanggal_nd_permohonan_penilaian') is-invalid @enderror"
                                            name="tanggal_nd_permohonan_penilaian"
                                            value="{{ $document->tanggal_nd_permohonan_penilaian }}"
                                            @can('admin-penilai')
                                            disabled
                                        @endcan>
                                        @error('tanggal_nd_permohonan_penilaian')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Data penyampaian penilaian --}}
            <div class="card card-bordered card-preview">
                <div class="card-inner">
                    <div class="preview-block">
                        <span class="preview-title-lg overline-title">Masukkan data penyampaian penilaian</span>
                        <div class="row gy-4">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label" for="nomor_ndr_penilaian">Nomor NDR Penyampaian
                                        Penilaian</label>
                                    <div class="form-control-wrap">
                                        <input type="text" id="nomor_ndr_penilaian"
                                            class="form-control @error('nomor_ndr_penilaian') is-invalid @enderror"
                                            name="nomor_ndr_penilaian" value="{{ $document->nomor_ndr_penilaian }}"
                                            placeholder="Contoh: ND-126/KNL.0402/2023"
                                            @can('admin-pkn')
                                            disabled
                                        @endcan>
                                        @error('nomor_ndr_penilaian')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label" for="tanggal_ndr_diterima_penilaian">Tanggal NDR Penyampaian
                                        Penilaian</label>
                                    <div class="form-control-wrap">
                                        <input type="date" id="tanggal_ndr_diterima_penilaian"
                                            class="form-control @error('tanggal_ndr_diterima_penilaian') is-invalid @enderror"
                                            name="tanggal_ndr_diterima_penilaian"
                                            value="{{ $document->tanggal_ndr_diterima_penilaian }}"
                                            @can('admin-pkn')
                                            disabled
                                        @endcan>
                                        @error('tanggal_ndr_diterima_penilaian')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Data penyelesaian dokumen --}}
            <div class="card card-bordered card-preview">
                <div class="card-inner">
                    <div class="preview-block">
                        <span class="preview-title-lg overline-title">Masukkan data penyelesaian dokumen</span>
                        <div class="row gy-4">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label" for="nomor_surat_persetujuan_penolakan">Nomor Surat
                                        Persetujuan</label>
                                    <div class="form-control-wrap">
                                        <input type="text" id="nomor_surat_persetujuan_penolakan"
                                            class="form-control @error('nomor_surat_persetujuan_penolakan') is-invalid @enderror"
                                            name="nomor_surat_persetujuan_penolakan"
                                            placeholder="Contoh: S-21/MK.6/KNl.04/2023"
                                            value="{{ $document->nomor_surat_persetujuan_penolakan }}"
                                            @if (Auth::user()->role != 'Admin Penilai' && !$progress->dinilai->isCompleted) disabled @endif
                                            @can('admin-penilai')
                                            disabled
                                            @endcan>
                                        @error('nomor_surat_persetujuan_penolakan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label" for="tanggal_surat_persetujuan_penolakan">Tanggal Surat
                                        Persetujuan</label>
                                    <div class="form-control-wrap">
                                        <input type="date" id="tanggal_surat_persetujuan_penolakan"
                                            class="form-control @error('tanggal_surat_persetujuan_penolakan') is-invalid @enderror"
                                            name="tanggal_surat_persetujuan_penolakan"
                                            value="{{ $document->tanggal_surat_persetujuan_penolakan }}"
                                            @if (Auth::user()->role != 'Admin Penilai' && !$progress->dinilai->isCompleted) disabled @endif
                                            @can('admin-penilai')
                                            disabled
                                        @endcan>
                                        @error('tanggal_surat_persetujuan_penolakan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label" for="nilai_proporsional_harga_perolehan_nilai_bmn">Nilai
                                        Proporsional Harga Perolahan</label>
                                    <div class="form-control-wrap">
                                        <input type="text" id="nilai_proporsional_harga_perolehan_nilai_bmn"
                                            class="form-control @error('nilai_proporsional_harga_perolehan_nilai_bmn') is-invalid @enderror"
                                            name="nilai_proporsional_harga_perolehan_nilai_bmn"
                                            oninput="formatInputWithDots('nilai_proporsional_harga_perolehan_nilai_bmn')"
                                            placeholder="Contoh: 447.172.400"
                                            value="{{ $document->nilai_proporsional_harga_perolehan_nilai_bmn }}"
                                            @if (Auth::user()->role != 'Admin Penilai' && !$progress->dinilai->isCompleted) disabled @endif
                                            @can('admin-penilai')
                                            disabled
                                        @endcan>
                                        @error('nilai_proporsional_harga_perolehan_nilai_bmn')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label" for="nilai_persetujuan">Nilai Persetujuan</label>
                                    <div class="form-control-wrap">
                                        <input type="text" id="nilai_persetujuan"
                                            class="form-control @error('nilai_persetujuan') is-invalid @enderror"
                                            name="nilai_persetujuan" placeholder="Contoh: 450.000.000"
                                            value="{{ $document->nilai_persetujuan }}"
                                            oninput="formatInputWithDots('nilai_persetujuan')"
                                            @if (Auth::user()->role != 'Admin Penilai' && !$progress->dinilai->isCompleted) disabled @endif
                                            @can('admin-penilai')
                                            disabled
                                        @endcan>
                                        @error('nilai_persetujuan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            @if ($document->jenis_persetujuan == 'Sewa')
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label" for="periode_sewa">Periode Sewa</label>
                                        <div qclass="form-control-wrap">
                                            <input type="number" id="periode_sewa"
                                                class="form-control @error('periode_sewa') is-invalid @enderror"
                                                name="periode_sewa" placeholder="Contoh: 3"
                                                value="{{ $document->periode_sewa }}"
                                                @if (Auth::user()->role != 'Admin Penilai' && !$progress->dinilai->isCompleted) disabled @endif
                                                @can('admin-penilai')
                                            disabled
                                        @endcan>
                                            @error('periode_sewa')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-end mt-4">
                <button type="submit" class="btn btn-primary" id="submitButton"> <em class="ni ni-save me-1"></em>
                    Simpan</button>
            </div>
        </form>
    </div>
@endsection
