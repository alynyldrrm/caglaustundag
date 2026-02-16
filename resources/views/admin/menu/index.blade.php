@extends('admin.layout')
@section('title', 'Menüler')
@section('css')
    <link rel="stylesheet" href="/assets/admin/dist/custom-css/nestable.css">
@endsection
@section('content-title')
    @can('Menü Yönetimi')
        <div class="col">
            <h2 class="page-title">
                Menüler
            </h2>
        </div>
        <div class="col-auto ms-auto d-print-none">
            <a href="{{ route('admin.menu.create') }}" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                    stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M12 5l0 14"></path>
                    <path d="M5 12l14 0"></path>
                </svg>
                Menü Ekle
            </a>
        </div>
    @endcan
@endsection

@section('content')
    <div class="card">
        @can('Menü Yönetimi')
            <div class="card-header py-0 d-flex flex-column flex-lg-row justify-center justify-content-lg-between">
                <menu id="nestable-menu">
                    <button class="btn btn-secondary" type="button" data-action="expand-all">Tümünü Aç</button>
                    <button class="btn btn-secondary" type="button" data-action="collapse-all">Tümünü Kapat</button>
                </menu>
                <form class="form-group" id="langForm" method="GET" action="{{ route('admin.menu.index') }}">
                    <label for="lang" class="form-label">Dil</label>
                    <select name="lang" id="langSelect" class="form-select">
                        @foreach ($langs as $lang)
                            <option {{ request('lang') == $lang->id ? 'selected' : '' }} value="{{ $lang->id }}">
                                {{ $lang->text }}</option>
                        @endforeach
                    </select>
                </form>
            </div>
            <div class="card-body">
                <div class="cf nestable-lists">
                    <div class="dd w-100" id="nestable">
                        @if (count($menus) > 0)
                            {!! createAdminMenuList($menus) !!}
                        @else
                            <h2 class="text-center">Menü Bulunamadı</h3>
                        @endif
                    </div>
                </div>
            </div>
        @endcan
        @cannot('Menü Yönetimi')
            <div class="card-header">
                <div class="card-body">
                    <h4>Admin Paneline Hoşgelidiniz,</h4> <br>
                    <p>Sol taraftafi menü üzerinden yetkinizin bulunduğu işlemleri
                        gerçekleştirebilirsiniz.</p>
                </div>
            </div>
        @endcannot
    </div>
@endsection


@section('js')
    <script src="/assets/admin/dist/custom-js/nestable.js"></script>
    <script>
        const langSelect = document.getElementById('langSelect');
        const langForm = document.getElementById('langForm');
        langSelect.addEventListener('change', () => {
            langForm.submit();
        });
    </script>
    <script>
        $(document).ready(function() {

            var updateOutput = function(e) {
                var list = e.length ? e : $(e.target),
                    output = list.data('output');
                if (window.JSON) {
                    let data = window.JSON.stringify(list.nestable('serialize'));
                    $.ajax({
                        type: "GET",
                        url: "{{ route('admin.menu.sort') }}",
                        data: {
                            data
                        },
                        success: function(res) {
                            console.log(res);
                        },
                        error: function(err) {
                            console.log(err);
                        }
                    });
                } else {

                }
            };
            $('#nestable').nestable({
                //group: 1
            }).on('change', updateOutput);

            $('#nestable-menu').on('click', function(e) {
                var target = $(e.target),
                    action = target.data('action');
                if (action === 'expand-all') {
                    $('.dd').nestable('expandAll');
                }
                if (action === 'collapse-all') {
                    $('.dd').nestable('collapseAll');
                }
            });
        });
    </script>
@endsection
