@php
    $videolar = getTypeValues('Medyalar', 20);

@endphp

@foreach ($videolar as $video)
    @php
        $tip = getValue('tip', $video);
    @endphp

    @if ($tip == "Tanıtım Videosu")


        <div class="container">
            <div class="row">
                <div class="col-lg-6 mx-auto">
                    <div class="site-heading text-center">
                        <h2 class="site-title">{{_('İMPASK PLASTİK')}}</h2>
                    </div>
                </div>
            </div>
            <div class="video-content" style="background-image: url({{isset(getValue('gorsel', $video)[0]['path']) ? getValue('gorsel', $video)[0]['path'] : '/assets/client/images/default.jpg' }});">

                <div class="row align-items-center">
                    <div class="col-lg-12">
                        <div class="video-wrapper">
                            <a class="play-btn popup-youtube" href="{{ getValue('video_url', $video) }}">
                                <i class="fa fa-play"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach
