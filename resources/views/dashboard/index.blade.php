@extends('layouts.app')

@section('content')
    <div class="row">
        <a href="{{ route('document2020.index') }}" class="col-md-4 card">
            <div class="nk-ecwg nk-ecwg6">
                <div class="card-inner">
                    <div class="card-title-group">
                        <div class="card-title">
                            <h6 class="title">Dokumen 2020</h6>
                        </div>
                    </div>
                    <div class="data">
                        <div class="data-group">
                            <div class="amount">{{ $documents }}</div>
                        </div>
                        <div class="info">
                            <div class="d-flex justify-content-between">
                                <strong class="text-secondary">Penjualan</strong>
                                <strong class="text-success">{{ $penjualan }}</strong>
                            </div>
                            <div class="d-flex justify-content-between">
                                <strong class="text-secondary">Penghapusan</strong>
                                <strong class="text-danger">{{ $penghapusan }}</strong>
                            </div>
                            <div class="d-flex justify-content-between">
                                <strong class="text-secondary">Sewa</strong>
                                <strong class="text-warning">{{ $sewa }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
@endsection
