@php
    $contact      = getContact() ? getContact()->first() : null;
    $menus        = getMenus();
    $homeSections = getTypeValues('sayfalar', 1);
    $homeSection  = count($homeSections) > 0 ? $homeSections[0] : null;
    $settings     = getWebsiteSettings();
@endphp

<footer id="footer">

    <div class="ft-main">
        <div class="container">
            <div class="ft-grid">

                <!-- Marka -->
                <div class="ft-brand">
                    <a href="/" class="ft-brand__logo">
                        <img src="/files/logo/cagla-ustundag-logo-text.png" alt="Çağla Üstündağ Logo">
                    </a>
                    <p class="ft-brand__tag">{{ __('Profesyonel danışmanlık hizmetleri') }}</p>
                </div>

                <!-- İletişim -->
                <div class="ft-col">
                    <p class="ft-col__label">{{ __('İletişim') }}</p>
                    @if($contact)
                    <ul class="ft-contact">
                        @if($contact->address)
                        <li>
                            <span class="ft-contact__ico"><i class="fas fa-map-marker-alt"></i></span>
                            <span>{!! $contact->address !!}</span>
                        </li>
                        @endif
                        @if($contact->phone)
                        <li>
                            <span class="ft-contact__ico"><i class="fas fa-phone"></i></span>
                            <a href="tel:{{ $contact->phone }}">{!! $contact->phone !!}</a>
                        </li>
                        @endif
                        @if($contact->email)
                        <li>
                            <span class="ft-contact__ico"><i class="fas fa-envelope"></i></span>
                            <a href="mailto:{{ $contact->email }}">{!! $contact->email !!}</a>
                        </li>
                        @endif
                    </ul>
                    @endif
                </div>

                <!-- Hızlı Linkler -->
                <div class="ft-col">
                    <p class="ft-col__label">{{ __('Hızlı Linkler') }}</p>
                    <ul class="ft-links">
                        @foreach ($menus->take(5) as $menu)
                        <li>
                            <a href="{{ $menu['url'] == '' ? route('showPage', [$menu['language']['key'], $menu['permalink']]) : $menu['url'] }}">
                                <i class="fas fa-chevron-right"></i>
                                {!! $menu->name !!}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>

            </div>
        </div>
    </div>

    <div class="ft-bottom">
        <div class="container">
            <div class="ft-bottom__inner">
                <p class="ft-bottom__copy">{{ __('© 2026 Tüm Hakları Saklıdır.') }}</p>
                <div class="ft-social">
                    @foreach (['facebook' => 'facebook-f', 'twitter' => 'twitter', 'instagram' => 'instagram', 'linkedin' => 'linkedin-in'] as $key => $icon)
                        @if (!empty($settings->$key))
                            <a href="{{ $settings->$key }}" target="_blank" class="ft-social__link">
                                <i class="fab fa-{{ $icon }}"></i>
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>

</footer>

<style>
#footer {
    font-family: 'Nunito', sans-serif;
    -webkit-font-smoothing: antialiased;
    background: var(--white, #fff);
    border-top: 1px solid #e2e0d8;
}

#footer .container { width: min(1160px, 92vw); margin-inline: auto; }

/* ── Main ── */
.ft-main { padding: 56px 0 44px; }

.ft-grid {
    display: grid;
    grid-template-columns: 1.3fr 1fr 1fr;
    gap: 52px;
}

/* Brand */
.ft-brand__logo img {
    height: 42px;
    width: auto;
    display: block;
    margin-bottom: 14px;
}

.ft-brand__tag {
    font-size: .97rem;
    color: #9a9891;
    font-weight: 400;
    line-height: 1.65;
    max-width: 230px;
}

/* Columns */
.ft-col__label {
    font-size: .72rem;
    font-weight: 700;
    letter-spacing: .16em;
    text-transform: uppercase;
    color: #b5904a;
    margin-bottom: 18px;
}

/* Contact list */
.ft-contact {
    list-style: none;
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.ft-contact li {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    font-size: .96rem;
    color: #4a4a45;
    font-weight: 400;
    line-height: 1.55;
}

.ft-contact__ico {
    width: 28px; height: 28px;
    background: rgba(30,58,79,.07);
    border-radius: 5px;
    display: flex; align-items: center; justify-content: center;
    color: #1e3a4f;
    font-size: .7rem;
    flex-shrink: 0;
    margin-top: 2px;
}

.ft-contact a { color: inherit; text-decoration: none; transition: color .2s; }
.ft-contact a:hover { color: #1e3a4f; }

/* Links */
.ft-links {
    list-style: none;
    display: flex;
    flex-direction: column;
    gap: 0;
}

.ft-links a {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 9px 0;
    font-size: .96rem;
    color: #4a4a45;
    font-weight: 400;
    text-decoration: none;
    border-bottom: 1px solid #e2e0d8;
    transition: color .18s, padding-left .18s;
}

.ft-links li:last-child a { border-bottom: none; }

.ft-links a i { font-size: .5rem; color: #c8c5ba; transition: color .18s; }
.ft-links a:hover { color: #1e3a4f; padding-left: 4px; }
.ft-links a:hover i { color: #1e3a4f; }

/* ── Bottom ── */
.ft-bottom {
    border-top: 1px solid #e2e0d8;
    padding: 18px 0;
    background: #f8f7f3;
}

.ft-bottom__inner {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 18px;
}

.ft-bottom__copy {
    font-size: .88rem;
    color: #9a9891;
    font-weight: 400;
}

.ft-social { display: flex; gap: 8px; }

.ft-social__link {
    width: 34px; height: 34px;
    border: 1px solid #e2e0d8;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    color: #9a9891;
    font-size: .75rem;
    text-decoration: none;
    transition: all .2s;
}

.ft-social__link:hover {
    border-color: #1e3a4f;
    color: #1e3a4f;
    transform: translateY(-2px);
}

/* ── Responsive ── */
@media (max-width: 900px) {
    .ft-grid { grid-template-columns: 1fr 1fr; gap: 36px; }
    .ft-brand { grid-column: 1 / -1; }
}

@media (max-width: 600px) {
    .ft-grid { grid-template-columns: 1fr; gap: 30px; }
    .ft-bottom__inner { flex-direction: column; text-align: center; }
}
</style>
