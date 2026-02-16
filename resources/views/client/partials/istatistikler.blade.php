@php
    $istatistik = getTypeValues('İstatistikler', 10);

@endphp
<section>
    <div class="ttm-row zero_padding-section z-index-1 clearfix">
        <div class="container">
            <!-- row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="ttm-bg ttm-col-bgcolor-yes ttm-bgcolor-white mt_90 res-991-mt-0">
                        <div class="ttm-col-wrapper-bg-layer ttm-bg-layer"></div>
                        <div class="layer-content">

                            <div class="row ttm-vertical_sep">
                                @if(count($istatistik))

                                    @foreach ($istatistik as $item)
                                        @php
                                            $ikonlar = getValue('ikon', $item);
                                            $ikonPath = isset($ikonlar[0]['path']) ? $ikonlar[0]['path'] : null;
                                            $deger = getValue('deger', $item);
                                            $metin = getValue('metin', $item);


                                        @endphp
                                        <div class="col-lg-3 col-md-6 col-sm-6">
                                            <!-- ttm-fid -->
                                            <div class="ttm-fid inside ttm-fid-with-icon ttm-fid-view-lefticon style2">
                                                <div class="ttm-fid-icon-wrapper ttm-textcolor-skincolor">
                                                    @php
                                                        $svgContent = null;

                                                        if (!empty($ikonPath)) {
                                                            $svgContent = file_get_contents(public_path($ikonPath));

                                                            // Tüm fill'leri temizle
                                                            $svgContent = preg_replace('/fill=".*?"/', '', $svgContent);

                                                            // SVG tagine fill ekle
                                                            $svgContent = str_replace('<svg', '<svg width="50px" height="50px" fill="#3368c6"', $svgContent);
                                                        }
                                                    @endphp

                                                    @if ($svgContent)
                                                        <div class="w-25 text-primary">
                                                            {!! $svgContent !!}
                                                        </div>
                                                    @else
                                                        <i class="ti ti-cup text-primary"></i>
                                                    @endif
                                                </div>
                                                <div class="ttm-fid-contents">
                                                    <h4 class="ttm-fid-inner">
                                                        <span data-appear-animation="animateDigits" data-from="0"
                                                            data-to="{{ $deger ?? '' }}" data-interval="1"
                                                            data-before="" data-before-style="sup" data-after=""
                                                            data-after-style="sub"
                                                            class="numinate">{{ $deger ?? '' }}</span>
                                                        <sub>+</sub>
                                                    </h4>
                                                    <h3 class="ttm-fid-title">{{ $metin ?? '' }}</h3>
                                                </div>
                                            </div>
                                            <!-- ttm-fid end -->
                                        </div>
                                    @endforeach
                                @else
                                    <p>Şu anda istatistik verisi bulunmamaktadır.</p>
                                @endif
                            </div>
                            <!-- row end -->
                        </div>
                        <!-- ttm-client end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

