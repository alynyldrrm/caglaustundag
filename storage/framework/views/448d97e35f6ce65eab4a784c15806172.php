<?php
    $currentLanguage = session('defaultDatas')['currentLanguage'] ?? null;

    if(!isset($list) || !is_array($list) || count($list) == 0) {
        $list = getTypeValues('referanslar', 100);
    }
?>



<?php $__env->startSection('title', $menu->name ?? __('Referanslar')); ?>

<?php $__env->startSection('content'); ?>

<div class="rp">

    <!-- Hero -->
    <section class="rp-hero">
        <div class="container">
            <div class="rp-hero__inner">
                <span class="rp-hero__eyebrow"><?php echo e(__('Referanslar')); ?></span>
                <h1 class="rp-hero__title"><?php echo $menu->name ?? __('Referanslar'); ?></h1>
                <p class="rp-hero__sub"><?php echo e(__('Başarı projelerimiz ve iş ortaklarımız')); ?></p>
            </div>
        </div>
    </section>

    <!-- Grid -->
    <section class="rp-main">
        <div class="container">
            <?php if($list && count($list) > 0): ?>
                <div class="rp-grid">
                    <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $referans): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="rp-card" onclick="openReferenceModal(<?php echo e($referans['id']); ?>)">
                            <div class="rp-card__img">
                                <?php if(isset($referans['fields']['resim'][0])): ?>
                                    <img src="<?php echo e(getImageLink($referans['fields']['resim'][0]['path'], ['w' => 300, 'h' => 200, 'q' => 90, 'fit' => 'contain'])); ?>"
                                         alt="<?php echo $referans['name']; ?>" loading="lazy">
                                <?php elseif(isset($referans['fields']['logo'][0])): ?>
                                    <img src="<?php echo e(getImageLink($referans['fields']['logo'][0]['path'], ['w' => 300, 'h' => 200, 'q' => 90, 'fit' => 'contain'])); ?>"
                                         alt="<?php echo $referans['name']; ?>" loading="lazy">
                                <?php else: ?>
                                    <div class="rp-card__initials">
                                        <span><?php echo mb_substr(strip_tags($referans['name']), 0, 2); ?></span>
                                    </div>
                                <?php endif; ?>
                                <div class="rp-card__overlay">
                                    <span><i class="fas fa-eye"></i></span>
                                </div>
                            </div>
                            <div class="rp-card__body">
                                <h3 class="rp-card__name"><?php echo e($referans['name']); ?></h3>
                                <?php if(getValue('sektor', $referans)): ?>
                                    <span class="rp-card__tag"><?php echo getValue('sektor', $referans); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Modal -->
                        <div id="reference-modal-<?php echo e($referans['id']); ?>" class="ref-modal-page">
                            <div class="ref-overlay-page" onclick="closeReferenceModal(<?php echo e($referans['id']); ?>)"></div>
                            <div class="ref-content-page">
                                <button class="ref-close-page" onclick="closeReferenceModal(<?php echo e($referans['id']); ?>)">
                                    <i class="fas fa-times"></i>
                                </button>
                                <h3><?php echo $referans['name']; ?></h3>
                                <?php
                                    $detay = getValue('Detay', $referans) ?: getValue('detay', $referans);
                                ?>
                                <?php if($detay): ?>
                                    <p><?php echo $detay; ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <div class="rp-empty">
                    <i class="fas fa-folder-open"></i>
                    <p><?php echo e(__('Henüz referans eklenmemiş.')); ?></p>
                </div>
            <?php endif; ?>
        </div>
    </section>

</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;1,400&family=Nunito:wght@400;500;600;700&display=swap" rel="stylesheet">

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

.rp {
    font-family: 'Nunito', sans-serif;
    background: var(--bg);
    color: var(--ink);
    -webkit-font-smoothing: antialiased;
}

.container { width: min(1200px, 92vw); margin-inline: auto; }

/* ══════════════════════════
   HERO — kompakt
══════════════════════════ */
.rp-hero {
    background: var(--white);
    padding: 48px 0 40px;
    border-bottom: 1px solid var(--border);
}

.rp-hero__inner {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.rp-hero__eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: .75rem;
    font-weight: 700;
    letter-spacing: .18em;
    text-transform: uppercase;
    color: var(--gold);
}

.rp-hero__eyebrow::before {
    content: '';
    display: block;
    width: 20px; height: 1px;
    background: var(--gold);
}

.rp-hero__title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(2.2rem, 4.5vw, 3.4rem);
    font-weight: 500;
    line-height: 1.12;
    color: var(--ink);
    letter-spacing: -.015em;
}

.rp-hero__sub {
    font-size: 1rem;
    color: var(--ink-2);
    font-weight: 400;
    margin-top: 4px;
}

/* ══════════════════════════
   MAIN
══════════════════════════ */
.rp-main { padding: 52px 0 80px; }

/* ══════════════════════════
   GRID
══════════════════════════ */
.rp-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 20px;
}

/* ══════════════════════════
   CARD
══════════════════════════ */
.rp-card {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 10px;
    overflow: hidden;
    cursor: pointer;
    transition: transform .26s ease, box-shadow .26s ease, border-color .26s ease;
}

.rp-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 16px 44px rgba(30,58,79,.12);
    border-color: var(--border-2);
}

/* Image */
.rp-card__img {
    position: relative;
    height: 148px;
    background: var(--bg);
    display: flex; align-items: center; justify-content: center;
    padding: 22px;
    overflow: hidden;
    border-bottom: 1px solid var(--border);
}

.rp-card__img img {
    max-width: 100%; max-height: 100%;
    object-fit: contain;
    filter: opacity(.85);
    transition: filter .3s ease, transform .3s ease;
}

.rp-card:hover .rp-card__img img {
    filter: opacity(1);
    transform: scale(1.05);
}

/* Initials fallback */
.rp-card__initials {
    width: 60px; height: 60px;
    border-radius: 10px;
    background: var(--accent-m);
    display: flex; align-items: center; justify-content: center;
    font-family: 'Playfair Display', serif;
    font-size: 1.4rem;
    font-weight: 500;
    color: var(--accent);
    letter-spacing: .04em;
}

/* Hover overlay */
.rp-card__overlay {
    position: absolute; inset: 0;
    background: var(--accent);
    display: flex; align-items: center; justify-content: center;
    opacity: 0;
    transition: opacity .26s ease;
}

.rp-card:hover .rp-card__overlay { opacity: .85; }

.rp-card__overlay span {
    width: 42px; height: 42px;
    border-radius: 50%;
    border: 1px solid rgba(255,255,255,.4);
    display: flex; align-items: center; justify-content: center;
    color: #fff;
    font-size: .88rem;
}

/* Body */
.rp-card__body {
    padding: 16px 18px;
}

.rp-card__name {
    font-size: 1rem;
    font-weight: 600;
    color: var(--ink);
    margin-bottom: 7px;
    line-height: 1.4;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.rp-card__tag {
    display: inline-block;
    font-size: .72rem;
    font-weight: 600;
    letter-spacing: .06em;
    color: var(--accent);
    background: var(--accent-l);
    border: 1px solid var(--accent-m);
    border-radius: 4px;
    padding: 3px 10px;
}

/* ══════════════════════════
   MODAL
══════════════════════════ */
.ref-modal-page {
    display: none;
    position: fixed; inset: 0;
    z-index: 1000;
    align-items: center; justify-content: center;
}

.ref-modal-page.active { display: flex; }

.ref-overlay-page {
    position: absolute; inset: 0;
    background: rgba(24,24,24,.55);
    backdrop-filter: blur(5px);
}

.ref-content-page {
    position: relative;
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 38px;
    max-width: 500px; width: 90%;
    z-index: 1001;
    box-shadow: 0 28px 70px rgba(24,24,24,.15);
}

.ref-close-page {
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

.ref-close-page:hover { border-color: var(--accent); color: var(--accent); }

.ref-content-page h3 {
    font-family: 'Playfair Display', serif;
    font-size: 1.85rem;
    font-weight: 500;
    color: var(--ink);
    margin-bottom: 16px;
    padding-bottom: 16px;
    border-bottom: 1px solid var(--border);
    line-height: 1.2;
}

.ref-content-page p {
    font-size: 1rem;
    color: var(--ink-2);
    line-height: 1.8;
    font-weight: 400;
}

/* ══════════════════════════
   EMPTY
══════════════════════════ */
.rp-empty {
    text-align: center;
    padding: 80px 20px;
    color: var(--ink-3);
}

.rp-empty i {
    font-size: 3rem;
    margin-bottom: 16px;
    display: block;
    opacity: .3;
}

.rp-empty p { font-size: 1rem; font-weight: 400; }

/* ══════════════════════════
   RESPONSIVE
══════════════════════════ */
@media (max-width: 768px) {
    .rp-hero { padding: 36px 0 30px; }
    .rp-main { padding: 36px 0 60px; }
    .rp-grid { grid-template-columns: repeat(2, 1fr); gap: 14px; }
    .rp-card__img { height: 120px; padding: 16px; }
    .ref-content-page { padding: 28px 20px; }
}

@media (max-width: 480px) {
    .rp-grid { grid-template-columns: 1fr; }
}
</style>
<?php $__env->stopSection(); ?>

<script>
function openReferenceModal(id) {
    const modal = document.getElementById('reference-modal-' + id);
    if (modal) {
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
}

function closeReferenceModal(id) {
    const modal = document.getElementById('reference-modal-' + id);
    if (modal) {
        modal.classList.remove('active');
        document.body.style.overflow = '';
    }
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        document.querySelectorAll('.ref-modal-page.active').forEach(function(modal) {
            modal.classList.remove('active');
            document.body.style.overflow = '';
        });
    }
});
</script>

<?php echo $__env->make('client.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Lenovo\danismanlik\danismanlik\resources\views/client/referanslar.blade.php ENDPATH**/ ?>