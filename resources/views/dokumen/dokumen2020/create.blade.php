@extends('layouts.app')

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/libs/bootstrap-icons.min.css') }}">
@endpush

@push('js')
    <script>
        const currentRoute = window.location.pathname;
        const routeSewa = "/sewa";
        const routePenjualan = "/penjualan";
        const routePenghapusan = "/penghapusan";
        const jenisPersetujuanSelect = document.getElementById("jenis_persetujuan");

        function showOptionsBasedOnRoute(route, optionValue) {
            if (currentRoute.includes(route)) {
                const option = document.createElement("option");
                option.value = optionValue;
                option.text = optionValue;
                jenisPersetujuanSelect.appendChild(option);
            }
        }
        jenisPersetujuanSelect.innerHTML = "";
        showOptionsBasedOnRoute("/sewa", "Sewa");
        showOptionsBasedOnRoute("/penjualan", "Penjualan");
        showOptionsBasedOnRoute("/penghapusan", "Penghapusan");
    </script>
@endpush

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-5">
                <div class="steps">
                    <div class="steps-header">
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="40"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="steps-body">
                        {{-- Dokumen masuk --}}
                        <div class="step">
                            <span class="step-icon">
                                <em class="bi bi-1-circle fs-2"></em>
                            </span>
                            <div class="mt-4">Dokumen masuk</div>
                        </div>
                        {{-- Dokumen dinilai --}}
                        <div class="step">
                            <span class="step-icon">
                                <em class="bi bi-2-circle fs-2"></em>
                            </span>
                            <div class="mt-4">Dokumen dinilai</div>
                        </div>
                        {{-- Dokumen selesai --}}
                        <div class="step">
                            <span class="step-icon">
                                <em class="bi bi-3-circle fs-2"></em>
                            </span>
                            <div class="mt-4">Dokumen selesai</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-bordered card-preview">
            <div class="card-inner">
                <div class="preview-block">
                    <span class="preview-title-lg overline-title">Masukkan Data Surat Masuk</span>
                    <form method="post" action="{{ route('document2020.store') }}"
                        class="is-alter form-validate form-control-wrap">
                        @csrf
                        <div class="row gy-4">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label" for="satker">Satker</label>
                                    <div class="form-control-wrap">
                                        <input type="text" id="satker"
                                            class="form-control @error('satker') is-invalid @enderror" name="satker"
                                            placeholder="Contoh: Universitas Sriwijaya" value="{{ old('satker') }}"
                                            required>
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
                                            name="nomor_whatsapp_satker" placeholder="Contoh: 081368687789"
                                            value="{{ old('nomor_whatsapp_satker') }}" required>
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
                                            name="nomor_surat_masuk" placeholder="Contoh: B/735-11/02/01/Smh"
                                            value="{{ old('nomor_surat_masuk') }}" required>
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
                                            name="tanggal_surat_masuk" value="{{ old('tanggal_surat_masuk') }}" required>
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
                                            name="tanggal_surat_diterima" value="{{ old('tanggal_surat_diterima') }}"
                                            required>
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
                                            name="jenis_persetujuan" id="floatingSelect" aria-label="State" required>
                                            <option selected disabled>Pilih Jenis Persetujuan</option>
                                            <option value="Sewa">Sewa</option>
                                            <option value="Penjualan">Penjualan</option>
                                            <option value="Penghapusan">Penghapusan</option>
                                        </select>
                                        @error('jenis_persetujuan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label" for="conceptor">Konseptor</label>
                                    <div class="form-control-wrap">
                                        <select id="conceptor"
                                            class="form-select js-select2 @error('conceptor_id') is-invalid @enderror"
                                            name="conceptor_id" id="floatingSelect" aria-label="State"
                                            value="{{ old('conceptor_id') }}" required>
                                            <option selected disabled>Pilih Konseptor</option>
                                            @foreach ($conceptors as $conceptor)
                                                <option value="{{ $conceptor->id }}">{{ $conceptor->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('conceptor_id')
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
                                            value="{{ old('nomor_nd_permohonan_penilaian') }}">
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
                                            name="tanggal_nd_permohonan_penilaian" placeholder=" "
                                            value="{{ old('tanggal_nd_permohonan_penilaian') }}">
                                        @error('tanggal_nd_permohonan_penilaian')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary"><em class="ni ni-save me-1"></em>
                                    Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
