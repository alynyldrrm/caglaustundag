@extends('client.layout')
@php
    $secili_menu = getSelectedMenus()->last();
@endphp
@section('content')
    @include('client.partials.page-title', ['main_title' => $secili_menu->name])

    <div class="sort-destination-loader mt-4 pt-2 sort-destination-loader-loaded container">
        <div class="row portfolio-list sort-destination" data-sort-id="portfolio" data-filter="*" style="position: relative;">

            @foreach ($list as $item)
                @php
                    $resim = isset(getValue('gorsel', $item)[0]) ? getValue('gorsel', $item)[0]['path'] : '';
                   
                @endphp
                <div class="col-12 col-sm-6 col-lg-2">
                    <div class="portfolio-item">

                            <span class="thumb-info thumb-info-lighten border-radius-0">
                                <span class="thumb-info-wrapper border-radius-0">
                                    <img src="{{ $resim }}" class="img-fluid border-radius-0"
                                        alt="">


                                </span>
                            </span>

                    </div>
                </div>
            @endforeach


        </div>

    </div>
@endsection
