<?php $__env->startSection('title', __('Anasayfa')); ?>

<?php
    $homeSections = getTypeValues('sayfalar', 1);
    $homeSection  = count($homeSections) > 0 ? $homeSections[0] : null;

    if ($homeSection) {
        $resim = isset($homeSection['fields']['gorsel'][0])
            ? getImageLink($homeSection['fields']['gorsel'][0]['path'], ['w' => 800, 'h' => 600, 'fit' => 'cover'])
            : '/assets/client/img/style-switcher.png';
    }

    $hizmetler   = getTypeValues('hizmetler', 100);
    $referanslar = getTypeValues('referanslar', 5);

    $customSections = getTypeValues('anasayfa-section', 10);
    if (empty($customSections)) {
        $customSections = getTypeValues('anasayfa-sectionlar', 10);
    }

    $hizmetlerMenuUrl   = '';
    $referanslarMenuUrl = '';
    $langKey            = App::getLocale();

    foreach(getMenus() as $menuItem) {
        if(empty($menuItem['parent_id'])) {
            $name = strtolower(strip_tags($menuItem['name'] ?? ''));
            $perm = $menuItem['permalink'] ?? '';
            $lang = $menuItem['language']['key'] ?? $langKey;

            if(stripos($name, 'hizmet') !== false || stripos($perm, 'hizmet') !== false) {
                $hizmetlerMenuUrl = route('showPage', [$lang, $perm]);
            }
            if(stripos($name, 'referans') !== false || stripos($perm, 'referans') !== false) {
                $referanslarMenuUrl = route('showPage', [$lang, $perm]);
            }
        }
    }
?>

<?php $__env->startSection('content'); ?>

    <?php echo $__env->make('client.partials.slider', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    
    <?php if($homeSection): ?>
    <section class="ha-about">
        <div class="container">
            <div class="ha-about__grid">
                <div class="ha-about__content">
                    <span class="ha-eyebrow"><?php echo e(__('Hakkımızda')); ?></span>
                    <h2 class="ha-title"><?php echo getValue('baslik', $homeSection); ?></h2>
                    <div class="ha-about__text">
                        <?php echo substr(getValue('icerik', $homeSection), 0, 400); ?>...
                    </div>
                    <a href="/<?php echo e(App::getLocale()); ?>/hakkimizda" class="ha-btn ha-btn--dark">
                        <?php echo e(__('Devamını Gör')); ?>

                        <span class="ha-btn__arr"><i class="fas fa-arrow-right"></i></span>
                    </a>
                </div>
                <div class="ha-about__img">
                    <img src="<?php echo e($resim); ?>" alt="<?php echo getValue('baslik', $homeSection); ?>">
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    
    <?php if(count($hizmetler) > 0): ?>
    <section class="ha-services">
        <div class="container">
            <div class="ha-section-head">
                <div>
                    <span class="ha-eyebrow"><?php echo e(__('Hizmetlerimiz')); ?></span>
                    <h2 class="ha-title"><?php echo e(__('Profesyonel Çözümler')); ?></h2>
                </div>
                <?php if($hizmetlerMenuUrl): ?>
                <a href="<?php echo e($hizmetlerMenuUrl); ?>" class="ha-btn ha-btn--outline ha-btn--sm">
                    <?php echo e(__('Tüm Hizmetleri Gör')); ?>

                    <span class="ha-btn__arr"><i class="fas fa-arrow-right"></i></span>
                </a>
                <?php endif; ?>
            </div>
            <div class="ha-services__grid">
                <?php $__currentLoopData = array_slice($hizmetler, 0, 4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $hizmet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $hMenuPermalink = $hizmet['menu']['permalink'] ?? '';
                    $hLangKey       = $hizmet['language']['key'] ?? App::getLocale();
                ?>
                <a href="<?php echo e(route('showPage', [$hLangKey, $hMenuPermalink, $hizmet['permalink']])); ?>" class="ha-scard">
                    <span class="ha-scard__num"><?php echo e(sprintf('%02d', $index + 1)); ?></span>
                    <div class="ha-scard__ico">
                        <?php if(isset($hizmet['fields']['icon'][0])): ?>
                            <img src="<?php echo e(getImageLink($hizmet['fields']['icon'][0]['path'], ['w' => 60, 'h' => 60, 'fit' => 'contain'])); ?>" alt="">
                        <?php else: ?>
                            <i class="fas fa-briefcase"></i>
                        <?php endif; ?>
                    </div>
                    <h3 class="ha-scard__name"><?php echo $hizmet['name']; ?></h3>
                    <?php if(getValue('kisa_aciklama', $hizmet)): ?>
                        <p class="ha-scard__desc"><?php echo substr(getValue('kisa_aciklama', $hizmet), 0, 100); ?>...</p>
                    <?php endif; ?>
                    <span class="ha-scard__link"><?php echo e(__('Detay')); ?> <i class="fas fa-arrow-right"></i></span>
                </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>
    <?php endif; ?>


    
    <?php if(count($customSections) > 0): ?>
    <section class="ha-custom-sections">
        <div class="container">
            <div class="ha-section-head">
                <div>
                    <span class="ha-eyebrow"><?php echo e(__('Neden Biz')); ?></span>
                    <h2 class="ha-title"><?php echo e(__('Fark Yaratıyoruz')); ?></h2>
                </div>
            </div>
            <div class="ha-cs-list">
                <?php $__currentLoopData = $customSections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $sResim = isset($section['fields']['resim'][0])
                        ? getImageLink($section['fields']['resim'][0]['path'], ['w' => 700, 'h' => 500, 'fit' => 'cover'])
                        : null;
                    $sBaslik = $section['name'] ?? '';
                    $sAciklama = getValue('aciklama', $section) ?: getValue('Aciklama', $section) ?: '';
                    $sButonVar = getValue('buton_var_mi', $section) ?: getValue('Buton Var Mi', $section) ?: '';
                    $sButonMetni = getValue('buton_metni', $section) ?: getValue('Buton Metni', $section) ?: __('Detaylı Bilgi');
                    $sButonLinki = getValue('buton_linki', $section) ?: getValue('Buton Linki', $section) ?: '#';
                    $imgPosition = ($index % 2 == 0) ? 'left' : 'right';
                ?>
                <div class="ha-cs-item ha-cs-item--<?php echo e($imgPosition); ?>" data-aos="fade-up">
                    <?php if($sResim): ?>
                    <div class="ha-cs-item__img">
                        <img src="<?php echo e($sResim); ?>" alt="<?php echo $sBaslik; ?>" loading="lazy">
                    </div>
                    <?php endif; ?>
                    <div class="ha-cs-item__content">
                        <h3 class="ha-cs-item__title"><?php echo $sBaslik; ?></h3>
                        <p class="ha-cs-item__desc"><?php echo $sAciklama; ?></p>
                        <?php if($sButonVar == 'Evet' || $sButonVar == '1'): ?>
                        <a href="<?php echo e($sButonLinki); ?>" class="ha-cs-item__link">
                            <?php echo e($sButonMetni); ?>

                            <i class="fas fa-arrow-right"></i>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>
    <?php endif; ?>


    
    <?php if(count($referanslar) > 0): ?>
    <section class="ha-refs">
        <div class="container">
            <div class="ha-section-head">
                <div>
                    <span class="ha-eyebrow"><?php echo e(__('Referanslar')); ?></span>
                    <h2 class="ha-title"><?php echo e(__('İş Ortaklarımız')); ?></h2>
                </div>
                <?php if($referanslarMenuUrl): ?>
                <a href="<?php echo e($referanslarMenuUrl); ?>" class="ha-btn ha-btn--outline ha-btn--sm">
                    <?php echo e(__('Tüm Referansları Gör')); ?>

                    <span class="ha-btn__arr"><i class="fas fa-arrow-right"></i></span>
                </a>
                <?php endif; ?>
            </div>
            <div class="ha-refs__grid">
                <?php $__currentLoopData = $referanslar; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $referans): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="ha-ref" onclick="openRefModal(<?php echo e($referans['id']); ?>)">
                    <?php if(isset($referans['fields']['resim'][0])): ?>
                        <img src="<?php echo e(getImageLink($referans['fields']['resim'][0]['path'], ['w' => 200, 'h' => 120, 'q' => 90, 'fit' => 'contain'])); ?>"
                             alt="<?php echo $referans['name']; ?>">
                    <?php else: ?>
                        <div class="ha-ref__name"><?php echo $referans['name']; ?></div>
                    <?php endif; ?>
                    <div class="ha-ref__overlay"><i class="fas fa-eye"></i></div>
                </div>

                <div id="ref-modal-<?php echo e($referans['id']); ?>" class="ref-modal">
                    <div class="ref-overlay" onclick="closeRefModal(<?php echo e($referans['id']); ?>)"></div>
                    <div class="ref-content">
                        <button class="ref-close" onclick="closeRefModal(<?php echo e($referans['id']); ?>)">
                            <i class="fas fa-times"></i>
                        </button>
                        <h3><?php echo $referans['name']; ?></h3>
                        <?php $detay = getValue('Detay', $referans) ?: getValue('detay', $referans); ?>
                        <?php if($detay): ?><p><?php echo $detay; ?></p><?php endif; ?>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>
    <?php endif; ?>



    
    <section class="ha-stats">
        <div class="container">
            <div class="ha-stats__grid">
                <div class="ha-stat">
                    <span class="ha-stat__num">10+</span>
                    <span class="ha-stat__lbl"><?php echo e(__('Yıllık Tecrübe')); ?></span>
                </div>
                <div class="ha-stat">
                    <span class="ha-stat__num">500+</span>
                    <span class="ha-stat__lbl"><?php echo e(__('Mutlu Müşteri')); ?></span>
                </div>
                <div class="ha-stat">
                    <span class="ha-stat__num">50+</span>
                    <span class="ha-stat__lbl"><?php echo e(__('Uzman Kadro')); ?></span>
                </div>
                <div class="ha-stat">
                    <span class="ha-stat__num">1000+</span>
                    <span class="ha-stat__lbl"><?php echo e(__('Tamamlanan Proje')); ?></span>
                </div>
            </div>
        </div>
    </section>

    <script>
    function openRefModal(id) {
        const m = document.getElementById('ref-modal-' + id);
        if(m) { m.style.display = 'flex'; document.body.style.overflow = 'hidden'; }
    }
    function closeRefModal(id) {
        const m = document.getElementById('ref-modal-' + id);
        if(m) { m.style.display = 'none'; document.body.style.overflow = ''; }
    }
    document.addEventListener('keydown', e => {
        if(e.key === 'Escape') {
            document.querySelectorAll('.ref-modal').forEach(m => { m.style.display = 'none'; });
            document.body.style.overflow = '';
        }
    });
    </script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;1,400&family=Nunito:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

:root {
    --bg:       #f5f4f0;
    --white:    #ffffff;
    --ink:      #181818;
    --ink-2:    #4a4a45;
    --ink-3:    #9a9891;
    --border:   #e2e0d8;
    --border-2: #c8c5ba;
    --accent:   #1e3a4f;
    --accent-l: rgba(30,58,79,0.06);
    --accent-m: rgba(30,58,79,0.13);
    --gold:     #b5904a;
}

.ha-about, .ha-services, .ha-refs, .ha-stats, .ha-custom-sections,
.ha-about *, .ha-services *, .ha-refs *, .ha-stats *, .ha-custom-sections * {
    font-family: 'Nunito', sans-serif;
    -webkit-font-smoothing: antialiased;
}

.container { width: min(1160px, 92vw); margin-inline: auto; }

/* ── Eyebrow ── */
.ha-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: .78rem;
    font-weight: 600;
    letter-spacing: .18em;
    text-transform: uppercase;
    color: var(--gold);
    margin-bottom: 12px;
}

.ha-eyebrow::before {
    content: '';
    display: block;
    width: 20px; height: 1px;
    background: var(--gold);
}

/* ── Title ── */
.ha-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(2.1rem, 3.8vw, 3rem);
    font-weight: 500;
    line-height: 1.18;
    color: var(--ink);
    letter-spacing: -.01em;
}

/* ── Section Head ── */
.ha-section-head {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 20px;
    margin-bottom: 36px;
    padding-bottom: 22px;
    border-bottom: 1px solid var(--border);
}

/* ── Buttons ── */
.ha-btn {
    display: inline-flex;
    align-items: center;
    gap: 9px;
    padding: 13px 26px;
    border-radius: 6px;
    font-size: .95rem;
    font-weight: 600;
    text-decoration: none;
    transition: all .2s;
    white-space: nowrap;
    letter-spacing: .01em;
}

.ha-btn--dark {
    background: var(--accent);
    color: #fff;
    border: 1px solid var(--accent);
}

.ha-btn--dark:hover {
    background: #142a3a;
    box-shadow: 0 6px 22px var(--accent-m);
    transform: translateY(-2px);
    color: #fff;
    text-decoration: none;
}

.ha-btn--outline {
    background: transparent;
    color: var(--accent);
    border: 1px solid var(--border-2);
}

.ha-btn--outline:hover {
    background: var(--accent);
    color: #fff;
    border-color: var(--accent);
    text-decoration: none;
}

.ha-btn--sm { padding: 10px 20px; font-size: .85rem; }

.ha-btn__arr {
    width: 22px; height: 22px;
    border-radius: 4px;
    display: flex; align-items: center; justify-content: center;
    font-size: .65rem;
    transition: transform .2s;
}

.ha-btn--dark .ha-btn__arr   { background: rgba(255,255,255,.13); }
.ha-btn--outline .ha-btn__arr { background: var(--accent-l); }
.ha-btn:hover .ha-btn__arr   { transform: translateX(4px); }
.ha-btn--outline:hover .ha-btn__arr { background: rgba(255,255,255,.13); }


/* ══════════════════════════
   HAKKIMIZDA
══════════════════════════ */
.ha-about {
    padding: 72px 0;
    background: var(--white);
    border-bottom: 1px solid var(--border);
}

.ha-about__grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 64px;
    align-items: center;
}

.ha-about__content {
    display: flex;
    flex-direction: column;
    gap: 0;
}

.ha-about__content .ha-title { margin: 0 0 18px; }

.ha-about__text {
    font-size: 1.05rem;
    color: var(--ink-2);
    line-height: 1.85;
    font-weight: 400;
    margin-bottom: 28px;
}

.ha-about__img {
    position: relative;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(30,58,79,.12);
}

.ha-about__img::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, transparent 60%, rgba(30,58,79,.08));
    z-index: 1;
    pointer-events: none;
}

.ha-about__img img {
    width: 100%;
    display: block;
    border-radius: 10px;
}


/* ══════════════════════════
   HİZMETLER
══════════════════════════ */
.ha-services {
    padding: 72px 0;
    background: var(--bg);
    border-bottom: 1px solid var(--border);
}

.ha-services__grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
}

.ha-scard {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 10px;
    padding: 24px 22px;
    display: flex;
    flex-direction: column;
    text-decoration: none;
    color: inherit;
    transition: transform .24s ease, box-shadow .24s ease, border-color .24s ease;
    position: relative;
    overflow: hidden;
}

.ha-scard::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 2px;
    background: linear-gradient(90deg, var(--gold), var(--accent));
    transform: scaleX(0);
    transform-origin: left;
    transition: transform .3s ease;
}

.ha-scard:hover {
    transform: translateY(-4px);
    box-shadow: 0 14px 40px rgba(30,58,79,.1);
    border-color: var(--border-2);
    text-decoration: none;
    color: inherit;
}

.ha-scard:hover::before { transform: scaleX(1); }

.ha-scard__num {
    font-family: 'Playfair Display', serif;
    font-size: 1.1rem;
    font-weight: 400;
    color: var(--gold);
    opacity: .5;
    margin-bottom: 14px;
    line-height: 1;
}

.ha-scard__ico {
    width: 40px; height: 40px;
    background: var(--accent-l);
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    color: var(--accent);
    font-size: 1rem;
    margin-bottom: 14px;
    transition: background .2s;
}

.ha-scard:hover .ha-scard__ico { background: var(--accent-m); }
.ha-scard__ico img { max-width: 20px; max-height: 20px; }

.ha-scard__name {
    font-size: 1.05rem;
    font-weight: 600;
    color: var(--ink);
    margin-bottom: 10px;
    line-height: 1.35;
}

.ha-scard__desc {
    font-size: .93rem;
    color: var(--ink-2);
    line-height: 1.7;
    font-weight: 400;
    flex: 1;
    margin-bottom: 18px;
}

.ha-scard__link {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: .8rem;
    font-weight: 600;
    letter-spacing: .08em;
    text-transform: uppercase;
    color: var(--accent);
    margin-top: auto;
    transition: gap .2s;
}

.ha-scard:hover .ha-scard__link { gap: 10px; }


/* ══════════════════════════
   REFERANSLAR
══════════════════════════ */
.ha-refs {
    padding: 72px 0;
    background: var(--white);
    border-bottom: 1px solid var(--border);
}

.ha-refs__grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 14px;
}

.ha-ref {
    position: relative;
    height: 88px;
    background: var(--bg);
    border: 1px solid var(--border);
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    padding: 16px;
    cursor: pointer;
    overflow: hidden;
    transition: border-color .2s, box-shadow .2s;
}

.ha-ref:hover {
    border-color: var(--border-2);
    box-shadow: 0 6px 20px rgba(30,58,79,.08);
}

.ha-ref img {
    max-width: 100%; max-height: 100%;
    object-fit: contain;
    filter: grayscale(1) opacity(.55);
    transition: filter .28s;
}

.ha-ref:hover img { filter: grayscale(0) opacity(1); }

.ha-ref__name {
    font-size: .82rem;
    font-weight: 500;
    color: var(--ink-2);
    text-align: center;
}

.ha-ref__overlay {
    position: absolute; inset: 0;
    background: var(--accent);
    display: flex; align-items: center; justify-content: center;
    color: #fff;
    font-size: .85rem;
    opacity: 0;
    transition: opacity .22s;
}

.ha-ref:hover .ha-ref__overlay { opacity: .88; }

/* Modal */
.ref-modal {
    display: none;
    position: fixed; inset: 0;
    z-index: 1000;
    align-items: center; justify-content: center;
}

.ref-overlay {
    position: absolute; inset: 0;
    background: rgba(24,24,24,.5);
    backdrop-filter: blur(5px);
}

.ref-content {
    position: relative;
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 38px;
    max-width: 500px; width: 90%;
    z-index: 1001;
    box-shadow: 0 28px 70px rgba(24,24,24,.15);
}

.ref-close {
    position: absolute; top: 16px; right: 16px;
    width: 32px; height: 32px;
    border: 1px solid var(--border);
    background: var(--bg);
    border-radius: 50%;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    color: var(--ink-3); font-size: .7rem;
    transition: all .2s;
}

.ref-close:hover { border-color: var(--accent); color: var(--accent); }

.ref-content h3 {
    font-family: 'Playfair Display', serif;
    font-size: 1.9rem; font-weight: 500;
    color: var(--ink); margin-bottom: 16px;
    padding-bottom: 16px; border-bottom: 1px solid var(--border);
    line-height: 1.2;
}

.ref-content p {
    font-size: 1rem; color: var(--ink-2);
    line-height: 1.8; font-weight: 400;
}


/* ══════════════════════════
   ANASAYFA SECTIONLARI
══════════════════════════ */
.ha-custom-sections {
    padding: 72px 0;
    background: var(--bg);
    border-bottom: 1px solid var(--border);
}

.ha-cs-list {
    display: flex;
    flex-direction: column;
    gap: 60px;
}

.ha-cs-item {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 52px;
    align-items: center;
}

.ha-cs-item--left  { direction: ltr; }
.ha-cs-item--right { direction: rtl; }
.ha-cs-item--right > * { direction: ltr; }

.ha-cs-item__img {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
    aspect-ratio: 4/3;
    box-shadow: 0 16px 50px rgba(30,58,79,.1);
}

.ha-cs-item__img img {
    width: 100%; height: 100%;
    object-fit: cover;
    transition: transform .55s ease;
}

.ha-cs-item:hover .ha-cs-item__img img { transform: scale(1.04); }

.ha-cs-item__content { padding: 12px 0; }

.ha-cs-item__title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(1.7rem, 2.8vw, 2.3rem);
    font-weight: 500;
    color: var(--ink);
    margin-bottom: 16px;
    line-height: 1.22;
}

.ha-cs-item__desc {
    font-size: 1rem;
    color: var(--ink-2);
    line-height: 1.85;
    font-weight: 400;
    margin-bottom: 24px;
}

.ha-cs-item__link {
    display: inline-flex;
    align-items: center;
    gap: 9px;
    padding: 13px 26px;
    background: var(--accent);
    color: #fff;
    font-size: .93rem;
    font-weight: 600;
    text-decoration: none;
    border-radius: 6px;
    transition: all .22s ease;
}

.ha-cs-item__link:hover {
    background: #142a3a;
    box-shadow: 0 6px 22px rgba(30,58,79,.22);
    transform: translateY(-2px);
    text-decoration: none;
    color: #fff;
}

.ha-cs-item__link i { font-size: .7rem; transition: transform .2s; }
.ha-cs-item__link:hover i { transform: translateX(4px); }

@media (max-width: 900px) {
    .ha-cs-item { grid-template-columns: 1fr; gap: 26px; }
    .ha-cs-item__img { aspect-ratio: 16/9; }
    .ha-cs-list { gap: 48px; }
}


/* ══════════════════════════
   İSTATİSTİKLER
══════════════════════════ */
.ha-stats {
    padding: 60px 0;
    background: var(--accent);
    border-bottom: 1px solid rgba(255,255,255,.07);
}

.ha-stats__grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
}

.ha-stat {
    display: flex; flex-direction: column; align-items: center;
    padding: 8px 20px;
    border-right: 1px solid rgba(255,255,255,.1);
    text-align: center;
}

.ha-stat:last-child { border-right: none; }

.ha-stat__num {
    display: block;
    font-family: 'Playfair Display', serif;
    font-size: clamp(2.4rem, 3.5vw, 3.4rem);
    font-weight: 400;
    color: #fff;
    line-height: 1;
    margin-bottom: 8px;
    letter-spacing: -.02em;
}

.ha-stat__lbl {
    font-size: .78rem;
    font-weight: 500;
    letter-spacing: .14em;
    text-transform: uppercase;
    color: rgba(255,255,255,.55);
}


/* ── Responsive ── */
@media (max-width: 1100px) {
    .ha-services__grid { grid-template-columns: repeat(2, 1fr); }
}

@media (max-width: 1024px) {
    .ha-about__grid { grid-template-columns: 1fr; gap: 40px; }
    .ha-about__img  { order: -1; }
    .ha-refs__grid  { grid-template-columns: repeat(3, 1fr); }
    .ha-stats__grid { grid-template-columns: repeat(2, 1fr); }
    .ha-stat        { border-bottom: 1px solid rgba(255,255,255,.1); padding: 24px 20px; }
    .ha-stat:nth-child(2), .ha-stat:last-child { border-right: none; }
}

@media (max-width: 768px) {
    .ha-about, .ha-services, .ha-refs, .ha-custom-sections { padding: 52px 0; }
    .ha-section-head { flex-direction: column; align-items: flex-start; gap: 14px; }
    .ha-services__grid { grid-template-columns: 1fr; }
    .ha-refs__grid  { grid-template-columns: repeat(2, 1fr); }
    .ha-stats__grid { grid-template-columns: 1fr; }
    .ha-stat        { border-right: none; }
    .ref-content    { padding: 26px 20px; }
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('client.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Lenovo\danismanlik\danismanlik\resources\views/client/home.blade.php ENDPATH**/ ?>