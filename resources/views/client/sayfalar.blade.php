@extends('client.layout')
@section('title', getSelectedMenus()->last() ? getSelectedMenus()->last()->name : __('Sayfa'))
@php

$page = isset($list[0]) ? $list[0] : null;


    $secili_menu = getSelectedMenus()->last();
    $ustmenu = getSelectedMenus()->first();
    $gorselVarmi= isset(getValue('gorsel', $page)[0]) ? getValue('gorsel', $page)[0]: null;
   if(!null){
    $class="col-md-7";

   }
   else{
    $class="col-md-12";
   }

@endphp



@section('content')
    @if ($page)

        @include('client.partials.page-title', ['main_title' => $secili_menu ? $secili_menu->name : __('Sayfa')])
<div class="container pt-5">

					<div class="row py-4 mb-2">

						<div class="{{ $class }} order-2">
							<div class="overflow-hidden">
								<h2 class="text-color-dark font-weight-bold text-12 mb-2 pt-0 mt-0 appear-animation animated maskUp appear-animation-visible" data-appear-animation="maskUp" data-appear-animation-delay="300" style="animation-delay: 300ms;">{!! getValue('baslik', $page ) !!}</h2>
							</div>
							<div class="overflow-hidden mb-3">
								<p class="font-weight-bold text-primary text-uppercase mb-0 appear-animation animated maskUp appear-animation-visible" data-appear-animation="maskUp" data-appear-animation-delay="500" style="animation-delay: 500ms;">{!! $ustmenu ? $ustmenu->name : '' !!}</p>
							</div>

							<p class="pb-3 appear-animation animated fadeInUpShorter appear-animation-visible" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="800" style="animation-delay: 800ms;">{!! getValue('icerik', $page )  !!}</p>
							<hr class="solid my-4 appear-animation animated fadeInUpShorter appear-animation-visible" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="900" style="animation-delay: 900ms;">
							<div class="row align-items-center appear-animation animated fadeInUpShorter appear-animation-visible" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="1000" style="animation-delay: 1000ms;">


							</div>
						</div>
                        @if(isset(getValue('gorsel', $page)[0]))
						<div class="col-md-5 order-md-2 mb-4 mb-lg-0 appear-animation animated fadeInRightShorter appear-animation-visible" data-appear-animation="fadeInRightShorter" style="animation-delay: 100ms;">
							<img src="{{ getValue('gorsel', $page)[0]['path'] }}" class="img-fluid mb-2" alt="">
						</div>
                        @endif
					</div>
				</div>

    @else
        @include('client.partials.page-title', ['main_title' => __('İçerik Bulunamadı')])
        <section>
            <div class="container">
                <div class="heading-text heading-section text-center">
                    <h2>{{ __('İçerik Bulunamadı') }}</h2>
                </div>
            </div>
        </section>
    @endif



@endsection
