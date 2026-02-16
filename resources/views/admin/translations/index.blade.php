@extends('admin.layout')
@section('title', 'Çeviriler')
@section('content-title')
    <div class="col">
        <h2 class="page-title">
            Çeviriler
        </h2>
    </div>
    <div class="col-auto ms-auto d-print-none">
        <a href="{{ route('admin.translation.scan') }}" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-scan" width="24" height="24"
                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M4 7v-1a2 2 0 0 1 2 -2h2"></path>
                <path d="M4 17v1a2 2 0 0 0 2 2h2"></path>
                <path d="M16 4h2a2 2 0 0 1 2 2v1"></path>
                <path d="M16 20h2a2 2 0 0 0 2 -2v-1"></path>
                <path d="M5 12l14 0"></path>
            </svg>
            Çevirileri Tara
        </a>
    </div>
@endsection
@section('content')
    <form class="card" method="POST" action="{{ route('admin.translation.update') }}">
        @csrf
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-vcenter table-mobile-md card-table table-striped">
                    <thead>
                        <tr>
                            <th>Anahtar</th>
                            @foreach (session('defaultDatas')['languages'] as $language)
                                <th>{{ $language->text }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $forableKey = null;
                            $count = null;
                        @endphp
                        @foreach ($data as $key => $trans)
                            @php
                                if ($count < count($trans)) {
                                    $count = count($trans);
                                    $forableKey = $key;
                                }
                            @endphp
                        @endforeach
                        @if ($forableKey != null)
                            @foreach ($data[$forableKey] as $key => $trans)
                                <tr>
                                    <td>
                                        <input type="text" value="{{ $key }}" readonly disabled
                                            class="form-control">
                                    </td>
                                    @foreach (session('defaultDatas')['languages'] as $language)
                                        @php
                                            $name = $language->key . '[' . $key . ']';
                                        @endphp
                                        <td>
                                            <input name="{{ $name }}" class="form-control" type="text"
                                                value="{{ isset($data[$language->key][$key]) ? $data[$language->key][$key] : '' }}">
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="2">
                                    <h4 class="text-center m-0">Kayıt Bulunamadı!</h4>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer text-end">
            <button class="btn btn-primary">Kaydet</button>
        </div>
    </form>
@endsection
