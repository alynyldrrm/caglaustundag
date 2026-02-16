@php
    $sections = getTypeValues('anasayfa-sectionlar', 10);
@endphp
{{-- @if (count($sections) > 0)
    <style>
        .heading-text p {
            margin-bottom: 0 !important;
        }
    </style>
@foreach ($sections as $key => $section)
        @php
            $baslik = getValue('baslik', $section);
            $aciklama = getValue('acikmala', $section);
            $buton_varmi = getValue('buton_varmi', $section) == 'Evet' ? true : false;
            $buton_metin = getValue('buton_metin', $section);
            $buton_link = getValue('buton_link', $section);
            $resim = isset($section['fields']['resim'][0]) ? $section['fields']['resim'][0] : false;
            if ($resim) {
                $resim = getImageLink($resim['path'], ['q' => 100]);
            } else {
                $resim = getImageLink('/assets/client/static/default.jpg', ['q' => 100]);
            }
        @endphp
        {{-- @if ($key % 2)
            <section class="ttm-row grid-section clearfix">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-4">
                            <div class="row align-items-center">
                                <div>
                                    <h5 class="m-0 p-0">{{ $baslik }}</h5>
                                    <h3>{{ _('Homepage section yazı') }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <p class="m-0">{!! $aciklama !!}</p>
                        </div>
                        <div class="col-lg-4 p-3 bg-light" style="border-radius: 20%">
                            <img style="border-radius: 20%; height:300px" src="{{ $resim }}" class="w-100" />
                        </div>
                    </div>
                </div>

            </section>
        @else
            {{-- <section class="p-b-0">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-5">
                            <img alt="{{ $baslik }}" src="{{ $resim }}" class="img-fluid">
                        </div>
                        <div class="col-lg-7">
                            <div class="heading-text heading-section mt-5">
                                <h1 style="font-size:45px;">{{ $baslik }}</h1>
                                <p>{!! $aciklama !!}</p>
                                @if ($buton_varmi)
                                    <a class="btn btn-primary mt-1" href="{{ $buton_link }}">
                                        {{ $buton_metin }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif
    @endforeach
@endif --}}
@foreach ($sections as $key => $section)
    @php
        $baslik = getValue('baslik', $section);
        $aciklama = getValue('acikmala', $section);
        $buton_varmi = getValue('buton_varmi', $section) == 'Evet' ? true : false;
        $buton_metin = getValue('buton_metin', $section);
        $buton_link = getValue('buton_link', $section);
        $resim = isset($section['fields']['resim'][0]) ? $section['fields']['resim'][0] : false;
        if ($resim) {
            $resim = getImageLink($resim['path'], ['q' => 100]);
        } else {
            $resim = getImageLink('/assets/client/img/style-switcher.png', ['q' => 100]);
        }
    @endphp
    @if ($key % 2)
        <section class="call-to-action call-to-action-default with-button-arrow content-align-center mt-3">
            <div class="container">
                <div class="row">
                    <div class="col-md-9 col-lg-9">
                        <div class="call-to-action-content">
                            <h2 class="font-weight-normal text-6 mb-0"><strong
                                    class="font-weight-extra-bold">{{ $baslik }} </strong></h2>
                            {!! $aciklama !!}
                        </div>
                    </div>
                    <div class="col-md-3 col-lg-3">
                        <div class="call-to-action-btn">
                            @if ($buton_varmi)
                                <a class="btn btn-dark btn-lg text-3 font-weight-semibold px-4 py-3"
                                    href="{{ $buton_link }}">
                                    {{ $buton_metin }}
                                </a><span
                                    class="arrow hlb d-none d-md-block appear-animation animated rotateInUpLeft appear-animation-visible"
                                    data-appear-animation="rotateInUpLeft"
                                    style="top: -40px; left: 70%; animation-delay: 100ms;"></span>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </section>
    @else
    <section class="section section-dark border-0 py-0 m-0 appear-animation animated fadeIn appear-animation-visible" data-appear-animation="fadeIn" style="animation-delay: 100ms;">
					<div class="container">
						<div class="row align-items-center justify-content-center justify-content-lg-between pb-5 pb-lg-0">
							<div class="col-lg-5 order-2 order-lg-1 pt-4 pt-lg-0 pb-5 pb-lg-0 mt-5 mt-lg-0 appear-animation animated fadeInRightShorter appear-animation-visible" data-appear-animation="fadeInRightShorter" data-appear-animation-delay="200" style="animation-delay: 200ms;">
								<h2 class="font-weight-bold text-color-light text-7 mb-2">{{ $baslik }}</h2>
								<p class="lead font-weight-light text-color-light text-3">{!! $aciklama !!}</p>

                                 @if ($buton_varmi)
                            <a class="btn btn-primary btn-px-5 btn-py-2 text-2" href="{{ $buton_link }}">
                                {{ $buton_metin }}
                            </a>
                        @endif

							</div>
							<a href="{{ _("/tr/patentler") }}" class="col-9 offset-lg-1 col-lg-5 order-1 order-lg-2 scale-2">
								<img class="img-fluid box-shadow-3 my-2 border-radius" src="{{$resim}}" alt="">
							</a>
						</div>
					</div>
				</section>

    @endif
@endforeach
