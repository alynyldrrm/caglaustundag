<?php
    $contactSettings = getContact();
    $currentLanguage = session('defaultDatas')['currentLanguage'] ?? null;
    $captchaCode = \App\Http\Controllers\ClientController::generateCaptcha();
?>



<?php $__env->startSection('title', __('İletişim')); ?>

<?php $__env->startSection('content'); ?>

<div class="cp">

    <!-- Hero -->
    <section class="cp-hero">
        <div class="container">
            <div class="cp-hero__inner">
                <span class="cp-hero__eyebrow"><?php echo e(__('İletişim')); ?></span>
                <h1 class="cp-hero__title"><?php echo e(__('Nasıl yardımcı')); ?> <em><?php echo e(__('olabiliriz?')); ?></em></h1>
                <p class="cp-hero__sub"><?php echo e(__('Sorularınız için bize ulaşın')); ?></p>
            </div>
        </div>
    </section>

    <!-- Info Bar -->
    <div class="cp-bar">
        <div class="container">
            <div class="cp-bar__inner">
                <?php if($contactSettings && count($contactSettings) > 0): ?>
                    <?php $__currentLoopData = $contactSettings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(!empty($item['address'])): ?>
                        <div class="cp-bar__item">
                            <span class="cp-bar__ico"><i class="fas fa-map-marker-alt"></i></span>
                            <div>
                                <p class="cp-bar__lbl"><?php echo e(__('Adres')); ?></p>
                                <p class="cp-bar__val"><?php echo $item['address']; ?></p>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if(!empty($item['phone'])): ?>
                        <div class="cp-bar__item">
                            <span class="cp-bar__ico"><i class="fas fa-phone-alt"></i></span>
                            <div>
                                <p class="cp-bar__lbl"><?php echo e(__('Telefon')); ?></p>
                                <p class="cp-bar__val"><a href="tel:<?php echo e(str_replace(' ', '', $item['phone'])); ?>"><?php echo $item['phone']; ?></a></p>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if(!empty($item['email'])): ?>
                        <div class="cp-bar__item">
                            <span class="cp-bar__ico"><i class="fas fa-envelope"></i></span>
                            <div>
                                <p class="cp-bar__lbl"><?php echo e(__('E-Posta')); ?></p>
                                <p class="cp-bar__val"><a href="mailto:<?php echo e($item['email']); ?>"><?php echo $item['email']; ?></a></p>
                            </div>
                        </div>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <div class="cp-bar__item">
                        <span class="cp-bar__ico"><i class="fas fa-map-marker-alt"></i></span>
                        <div>
                            <p class="cp-bar__lbl"><?php echo e(__('Adres')); ?></p>
                            <p class="cp-bar__val">Anittepe Mahallesi Turgutreis Caddesi 21/A Çankaya ANKARA</p>
                        </div>
                    </div>
                    <div class="cp-bar__item">
                        <span class="cp-bar__ico"><i class="fas fa-phone-alt"></i></span>
                        <div>
                            <p class="cp-bar__lbl"><?php echo e(__('Telefon')); ?></p>
                            <p class="cp-bar__val"><a href="tel:03122319628">0312 231 96 28</a></p>
                        </div>
                    </div>
                    <div class="cp-bar__item">
                        <span class="cp-bar__ico"><i class="fas fa-envelope"></i></span>
                        <div>
                            <p class="cp-bar__lbl"><?php echo e(__('E-Posta')); ?></p>
                            <p class="cp-bar__val"><a href="mailto:info@reformdanismanlik.com.tr">info@reformdanismanlik.com.tr</a></p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Main -->
    <section class="cp-main">
        <div class="container">
            <div class="cp-main__grid">

                <!-- Form -->
                <div class="cp-form">
                    <div class="cp-form__head">
                        <h2><?php echo e(__('Mesaj Gönderin')); ?></h2>
                        <p><?php echo e(__('Formu doldurun, en kısa sürede size dönüş yapalım')); ?></p>
                    </div>

                    <?php if(session('success') || session('userSuccess')): ?>
                        <div class="cp-alert cp-alert--ok">
                            <i class="fas fa-check-circle"></i>
                            <span><?php echo e(session('success') ?? session('userSuccess')); ?></span>
                        </div>
                    <?php endif; ?>
                    <?php if(session('userError')): ?>
                        <div class="cp-alert cp-alert--err">
                            <i class="fas fa-exclamation-circle"></i>
                            <span><?php echo e(session('userError')); ?></span>
                        </div>
                    <?php endif; ?>
                    <?php if($errors->any()): ?>
                        <div class="cp-alert cp-alert--err">
                            <i class="fas fa-exclamation-circle"></i>
                            <ul><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($error); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
                        </div>
                    <?php endif; ?>

                    <form action="<?php echo e(route('contact.send', ['language_key' => App::getLocale()])); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="cp-row">
                            <div class="cp-field">
                                <label for="name"><?php echo e(__('Ad Soyad')); ?> <sup>*</sup></label>
                                <input type="text" id="name" name="name" value="<?php echo e(old('name')); ?>" placeholder="<?php echo e(__('Adınız ve soyadınız')); ?>" required>
                            </div>
                            <div class="cp-field">
                                <label for="email"><?php echo e(__('E-Posta')); ?> <sup>*</sup></label>
                                <input type="email" id="email" name="email" value="<?php echo e(old('email')); ?>" placeholder="<?php echo e(__('E-posta adresiniz')); ?>" required>
                            </div>
                        </div>
                        <div class="cp-field">
                            <label for="subject"><?php echo e(__('Konu')); ?> <sup>*</sup></label>
                            <input type="text" id="subject" name="subject" value="<?php echo e(old('subject')); ?>" placeholder="<?php echo e(__('Mesajınızın konusu')); ?>" required>
                        </div>
                        <div class="cp-field">
                            <label for="message"><?php echo e(__('Mesaj')); ?> <sup>*</sup></label>
                            <textarea id="message" name="message" rows="5" placeholder="<?php echo e(__('Mesajınızı buraya yazın...')); ?>" required><?php echo e(old('message')); ?></textarea>
                        </div>
                        <div class="cp-field">
                            <label for="captcha"><?php echo e(__('Güvenlik Kodu')); ?> <sup>*</sup></label>
                            <div class="cp-captcha">
                                <div class="cp-captcha__row">
                                    <span class="cp-captcha__code"><?php echo e($captchaCode); ?></span>
                                    <button type="button" class="cp-captcha__btn" onclick="location.reload()" title="<?php echo e(__('Yenile')); ?>">
                                        <i class="fas fa-sync-alt"></i>
                                    </button>
                                </div>
                                <input type="text" id="captcha" name="captcha" placeholder="<?php echo e(__('Güvenlik kodunu girin')); ?>" required>
                            </div>
                        </div>
                        <button type="submit" class="cp-submit">
                            <span><?php echo e(__('Gönder')); ?></span>
                            <span class="cp-submit__arr"><i class="fas fa-arrow-right"></i></span>
                        </button>
                    </form>
                </div>

                <!-- Map -->
                <div class="cp-map">
                    <p class="cp-map__lbl"><?php echo e(__('Konumumuz')); ?></p>
                    <div class="cp-map__frame">
                        <?php if($contactSettings && count($contactSettings) > 0 && !empty($contactSettings[0]['map_code'])): ?>
                            <?php echo $contactSettings[0]['map_code']; ?>

                        <?php else: ?>
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3059.4!2d32.835758!3d39.9323919!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMznCsDU1JzU2LjYiTiAzMsKwNTAnMDguNyJF!5e0!3m2!1str!2str!4v1609459200000!5m2!1str!2str" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
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
    --gold:     #b5904a;
}

.cp {
    font-family: 'Nunito', sans-serif;
    background: var(--bg);
    color: var(--ink);
    -webkit-font-smoothing: antialiased;
}

.container { width: min(1120px, 92vw); margin-inline: auto; }

/* ══════════════════════════
   HERO — sıkı ve kompakt
══════════════════════════ */
.cp-hero {
    background: var(--white);
    padding: 48px 0 40px;
    border-bottom: 1px solid var(--border);
}

.cp-hero__inner {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.cp-hero__eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: .75rem;
    font-weight: 700;
    letter-spacing: .18em;
    text-transform: uppercase;
    color: var(--gold);
}

.cp-hero__eyebrow::before {
    content: '';
    display: block;
    width: 20px; height: 1px;
    background: var(--gold);
}

.cp-hero__title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(2.2rem, 4.5vw, 3.4rem);
    font-weight: 500;
    line-height: 1.15;
    color: var(--ink);
    letter-spacing: -.015em;
}

.cp-hero__title em {
    font-style: italic;
    color: var(--accent);
}

.cp-hero__sub {
    font-size: 1rem;
    color: var(--ink-2);
    font-weight: 400;
    margin-top: 4px;
}

/* ══════════════════════════
   INFO BAR
══════════════════════════ */
.cp-bar {
    background: var(--white);
    border-bottom: 1px solid var(--border);
}

.cp-bar__inner { display: flex; }

.cp-bar__item {
    flex: 1;
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 22px 28px;
    border-right: 1px solid var(--border);
    transition: background .2s;
}

.cp-bar__item:last-child { border-right: none; }
.cp-bar__item:hover { background: var(--accent-l); }

.cp-bar__ico {
    width: 38px; height: 38px;
    border: 1px solid var(--border-2);
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    color: var(--accent);
    font-size: .82rem;
    flex-shrink: 0;
    transition: all .2s;
}

.cp-bar__item:hover .cp-bar__ico {
    background: var(--accent);
    border-color: var(--accent);
    color: #fff;
}

.cp-bar__lbl {
    font-size: .68rem;
    font-weight: 700;
    letter-spacing: .12em;
    text-transform: uppercase;
    color: var(--ink-3);
    margin-bottom: 3px;
}

.cp-bar__val {
    font-size: .97rem;
    color: var(--ink);
    font-weight: 500;
    line-height: 1.5;
}

.cp-bar__val a { color: inherit; text-decoration: none; transition: color .2s; }
.cp-bar__val a:hover { color: var(--accent); }

/* ══════════════════════════
   MAIN
══════════════════════════ */
.cp-main { padding: 52px 0 80px; }

.cp-main__grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 40px;
    align-items: start;
}

/* ══════════════════════════
   FORM
══════════════════════════ */
.cp-form {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 36px;
}

.cp-form__head {
    margin-bottom: 26px;
    padding-bottom: 20px;
    border-bottom: 1px solid var(--border);
}

.cp-form__head h2 {
    font-family: 'Playfair Display', serif;
    font-size: 1.75rem;
    font-weight: 500;
    color: var(--ink);
    margin-bottom: 5px;
    letter-spacing: -.01em;
}

.cp-form__head p {
    font-size: .97rem;
    color: var(--ink-2);
    font-weight: 400;
}

/* Alerts */
.cp-alert {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    padding: 12px 15px;
    border-radius: 8px;
    font-size: .95rem;
    margin-bottom: 20px;
    line-height: 1.5;
    font-weight: 500;
}

.cp-alert--ok  { background: #f0faf5; border: 1px solid #b5dfc9; color: #1d6342; }
.cp-alert--err { background: #fff5f5; border: 1px solid #f5c6c6; color: #9b1c1c; }
.cp-alert ul   { padding-left: 16px; margin: 0; }

/* Fields */
.cp-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
}

.cp-field { margin-bottom: 14px; }

.cp-field label {
    display: block;
    font-size: .72rem;
    font-weight: 700;
    letter-spacing: .1em;
    text-transform: uppercase;
    color: var(--ink-2);
    margin-bottom: 6px;
}

.cp-field label sup { color: var(--gold); font-size: .85em; }

.cp-field input,
.cp-field textarea {
    width: 100%;
    padding: 11px 14px;
    background: var(--bg);
    border: 1px solid var(--border);
    border-radius: 8px;
    font-family: 'Nunito', sans-serif;
    font-size: .97rem;
    font-weight: 400;
    color: var(--ink);
    outline: none;
    transition: border-color .2s, background .2s, box-shadow .2s;
    -webkit-appearance: none;
}

.cp-field textarea {
    resize: vertical;
    min-height: 130px;
    line-height: 1.65;
}

.cp-field input:focus,
.cp-field textarea:focus {
    border-color: var(--accent);
    background: var(--white);
    box-shadow: 0 0 0 3px rgba(30,58,79,.08);
}

.cp-field input::placeholder,
.cp-field textarea::placeholder {
    color: var(--ink-3);
    font-weight: 400;
}

/* Captcha */
.cp-captcha { display: flex; flex-direction: column; gap: 9px; }

.cp-captcha__row { display: flex; align-items: center; gap: 10px; }

.cp-captcha__code {
    flex: 1;
    padding: 11px 18px;
    background: var(--accent);
    color: #fff;
    border-radius: 8px;
    font-family: 'Courier New', monospace;
    font-size: 1.15rem;
    font-weight: 700;
    letter-spacing: 7px;
    text-align: center;
    user-select: none;
}

.cp-captcha__btn {
    width: 42px; height: 42px;
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 8px;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    color: var(--ink-3);
    font-size: .82rem;
    transition: all .25s;
}

.cp-captcha__btn:hover {
    border-color: var(--accent);
    color: var(--accent);
    rotate: 180deg;
}

/* Submit */
.cp-submit {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    padding: 13px 20px;
    background: var(--accent);
    color: #fff;
    border: none;
    border-radius: 8px;
    font-family: 'Nunito', sans-serif;
    font-size: 1rem;
    font-weight: 700;
    cursor: pointer;
    transition: all .2s;
    margin-top: 4px;
    letter-spacing: .02em;
}

.cp-submit:hover {
    background: #142a3a;
    box-shadow: 0 6px 22px rgba(30,58,79,.22);
    transform: translateY(-2px);
}

.cp-submit__arr {
    width: 28px; height: 28px;
    background: rgba(255,255,255,.15);
    border-radius: 5px;
    display: flex; align-items: center; justify-content: center;
    font-size: .75rem;
    transition: transform .2s;
}

.cp-submit:hover .cp-submit__arr { transform: translateX(4px); }

/* ══════════════════════════
   MAP
══════════════════════════ */
.cp-map { position: sticky; top: 90px; }

.cp-map__lbl {
    font-size: .7rem;
    font-weight: 700;
    letter-spacing: .14em;
    text-transform: uppercase;
    color: var(--gold);
    margin-bottom: 12px;
}

.cp-map__frame {
    border-radius: 12px;
    overflow: hidden;
    border: 1px solid var(--border);
    aspect-ratio: 4/3;
    box-shadow: 0 16px 44px rgba(0,0,0,.08);
}

.cp-map__frame iframe {
    width: 100%; height: 100%;
    border: 0; display: block;
}

/* ══════════════════════════
   RESPONSIVE
══════════════════════════ */
@media (max-width: 960px) {
    .cp-bar__inner  { flex-direction: column; }
    .cp-bar__item   { border-right: none; border-bottom: 1px solid var(--border); }
    .cp-bar__item:last-child { border-bottom: none; }
    .cp-main__grid  { grid-template-columns: 1fr; gap: 30px; }
    .cp-map         { position: static; }
}

@media (max-width: 640px) {
    .cp-hero  { padding: 36px 0 30px; }
    .cp-form  { padding: 24px 18px; }
    .cp-row   { grid-template-columns: 1fr; }
    .cp-bar__item { padding: 18px 20px; }
    .cp-main  { padding: 36px 0 60px; }
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('client.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Lenovo\danismanlik\danismanlik\resources\views/client/iletisim.blade.php ENDPATH**/ ?>