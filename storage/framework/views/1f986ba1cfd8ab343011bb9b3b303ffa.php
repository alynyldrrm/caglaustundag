<?php
    $currentLanguage = session('defaultDatas')['currentLanguage'] ?? null;

    $hakkimizdaList = getTypeValues('sayfalar', 1);
    $hakkimizda     = count($hakkimizdaList) > 0 ? $hakkimizdaList[0] : null;
?>



<?php $__env->startSection('title', $menu->name ?? __('Hakkımızda')); ?>

<?php $__env->startSection('content'); ?>

<div class="hk">

    <!-- Hero -->
    <section class="hk-hero">
        <div class="container">
            <div class="hk-hero__inner">
                <span class="hk-eyebrow"><?php echo e(__('Biz Kimiz')); ?></span>
                <h1 class="hk-hero__title"><?php echo $menu->name ?? __('Hakkımızda'); ?></h1>
            </div>
        </div>
    </section>

    <!-- Content -->
    <section class="hk-main">
        <div class="container">
            <?php if($hakkimizda): ?>
                <div class="hk-grid">

                    <!-- Görsel -->
                    <div class="hk-img-wrap">
                        <?php if(isset($hakkimizda['fields']['gorsel'][0])): ?>
                            <img src="<?php echo e(getImageLink($hakkimizda['fields']['gorsel'][0]['path'], ['w' => 800, 'h' => 600, 'fit' => 'cover'])); ?>"
                                 alt="<?php echo getValue('baslik', $hakkimizda); ?>">
                        <?php endif; ?>
                    </div>

                    <!-- Yazı -->
                    <div class="hk-content">
                        <h2 class="hk-content__title"><?php echo getValue('baslik', $hakkimizda); ?></h2>
                        <div class="hk-content__divider"></div>
                        <div class="hk-content__text">
                            <?php echo getValue('icerik', $hakkimizda); ?>

                        </div>
                    </div>

                </div>
            <?php else: ?>
                <div class="hk-empty">
                    <p><?php echo e(__('İçerik bulunamadı.')); ?></p>
                </div>
            <?php endif; ?>
        </div>
    </section>

</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;1,400&family=Nunito:wght@400;500;600&display=swap" rel="stylesheet">

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
    --gold:     #b5904a;
}

.hk {
    font-family: 'Nunito', sans-serif;
    background: var(--bg);
    color: var(--ink);
    -webkit-font-smoothing: antialiased;
}

.container { width: min(1120px, 92vw); margin-inline: auto; }

/* ══════════════════
   HERO — sıkı, kompakt
══════════════════ */
.hk-hero {
    background: var(--white);
    padding: 52px 0 44px;
    border-bottom: 1px solid var(--border);
}

.hk-hero__inner {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.hk-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: .75rem;
    font-weight: 600;
    letter-spacing: .2em;
    text-transform: uppercase;
    color: var(--gold);
}

.hk-eyebrow::before {
    content: '';
    display: block;
    width: 22px; height: 1px;
    background: var(--gold);
}

.hk-hero__title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(2.2rem, 4.5vw, 3.6rem);
    font-weight: 500;
    line-height: 1.12;
    color: var(--ink);
    letter-spacing: -.015em;
}

/* ══════════════════
   MAIN CONTENT
══════════════════ */
.hk-main {
    padding: 60px 0 80px;
}

.hk-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 64px;
    align-items: start;
}

/* Görsel */
.hk-img-wrap {
    border-radius: 12px;
    overflow: hidden;
    position: relative;
    box-shadow: 0 16px 50px rgba(30,58,79,.12);
}

.hk-img-wrap img {
    width: 100%;
    display: block;
    border-radius: 12px;
}

/* İçerik */
.hk-content__title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(1.6rem, 2.8vw, 2.2rem);
    font-weight: 500;
    line-height: 1.2;
    color: var(--ink);
    letter-spacing: -.01em;
    margin-bottom: 18px;
}

.hk-content__divider {
    width: 40px; height: 2px;
    background: var(--gold);
    margin-bottom: 22px;
    border-radius: 2px;
}

.hk-content__text {
    font-size: 1.02rem;
    color: var(--ink-2);
    line-height: 1.85;
    font-weight: 400;
}

.hk-content__text p {
    margin-bottom: 16px;
}

.hk-content__text p:last-child { margin-bottom: 0; }

.hk-content__text h2,
.hk-content__text h3,
.hk-content__text h4 {
    font-family: 'Playfair Display', serif;
    font-weight: 500;
    color: var(--ink);
    margin: 26px 0 10px;
}

.hk-content__text h2 { font-size: 1.65rem; }
.hk-content__text h3 { font-size: 1.3rem; }
.hk-content__text h4 { font-size: 1.1rem; font-family: 'Nunito', sans-serif; font-weight: 600; }

.hk-content__text ul,
.hk-content__text ol {
    padding-left: 0;
    list-style: none;
    margin-bottom: 16px;
    display: flex;
    flex-direction: column;
    gap: 9px;
}

.hk-content__text li {
    display: flex;
    align-items: flex-start;
    gap: 11px;
    font-size: 1rem;
    color: var(--ink-2);
    line-height: 1.65;
}

.hk-content__text li::before {
    content: '';
    width: 5px; height: 5px;
    border-radius: 50%;
    background: var(--gold);
    flex-shrink: 0;
    margin-top: 8px;
}

.hk-content__text a {
    color: var(--accent);
    text-decoration: underline;
    text-underline-offset: 3px;
}

.hk-content__text strong { font-weight: 700; color: var(--ink); }

/* Empty */
.hk-empty {
    text-align: center;
    padding: 80px 20px;
    color: var(--ink-3);
    font-size: 1rem;
}

/* ── Responsive ── */
@media (max-width: 960px) {
    .hk-grid { grid-template-columns: 1fr; gap: 36px; }
    .hk-img-wrap { order: -1; }
}

@media (max-width: 640px) {
    .hk-hero { padding: 36px 0 30px; }
    .hk-main { padding: 40px 0 60px; }
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('client.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Lenovo\danismanlik\danismanlik\resources\views/client/hakkimizda.blade.php ENDPATH**/ ?>