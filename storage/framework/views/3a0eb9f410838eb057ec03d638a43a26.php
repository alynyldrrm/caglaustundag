<?php
    $contactSettings = getContact();
    $currentLanguage = session('defaultDatas')['currentLanguage'] ?? null;
    
    // Captcha kodu üret
    $captchaCode = \App\Http\Controllers\ClientController::generateCaptcha();
?>



<?php $__env->startSection('title', __('İletişim')); ?>

<?php $__env->startSection('content'); ?>
<section class="page-header">
    <div class="container">
        <div class="breadcrumb">
            <a href="/<?php echo e(App::getLocale()); ?>"><?php echo e(__('Ana Sayfa')); ?></a>
            <span>/</span>
            <span><?php echo e(__('İletişim')); ?></span>
        </div>
        <h1 class="page-title"><?php echo e(__('İletişim')); ?></h1>
    </div>
</section>

<section class="contact-section">
    <div class="container">
        <div class="contact-grid">
            <!-- Sol: İletişim Bilgileri -->
            <div class="contact-info">
                <h2 class="section-title"><?php echo e(__('Bize Ulaşın')); ?></h2>

                <?php if($contactSettings && count($contactSettings) > 0): ?>
                    <?php $__currentLoopData = $contactSettings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="contact-card">
                        <h3 class="contact-branch"><?php echo e($item['name'] ?? 'MERKEZ'); ?></h3>

                        <div class="contact-items">
                            <?php if(!empty($item['address'])): ?>
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="contact-detail">
                                    <span class="label"><?php echo e(__('Adres')); ?></span>
                                    <p><?php echo e($item['address']); ?></p>
                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if(!empty($item['phone'])): ?>
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div class="contact-detail">
                                    <span class="label"><?php echo e(__('Telefon')); ?></span>
                                    <a href="tel:<?php echo e(str_replace(' ', '', $item['phone'])); ?>"><?php echo e($item['phone']); ?></a>
                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if(!empty($item['email'])): ?>
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="contact-detail">
                                    <span class="label"><?php echo e(__('E-Posta')); ?></span>
                                    <a href="mailto:<?php echo e($item['email']); ?>"><?php echo e($item['email']); ?></a>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <!-- Varsayılan İletişim Bilgileri -->
                    <div class="contact-card">
                        <h3 class="contact-branch">MERKEZ</h3>
                        <div class="contact-items">
                            <div class="contact-item">
                                <div class="contact-icon"><i class="fas fa-map-marker-alt"></i></div>
                                <div class="contact-detail">
                                    <span class="label"><?php echo e(__('Adres')); ?></span>
                                    <p>Anittepe Mahallesi Turgutreis Caddesi 21/A Çankaya ANKARA</p>
                                </div>
                            </div>
                            <div class="contact-item">
                                <div class="contact-icon"><i class="fas fa-phone"></i></div>
                                <div class="contact-detail">
                                    <span class="label"><?php echo e(__('Telefon')); ?></span>
                                    <a href="tel:03122319628">0312 231 96 28</a>
                                </div>
                            </div>
                            <div class="contact-item">
                                <div class="contact-icon"><i class="fas fa-envelope"></i></div>
                                <div class="contact-detail">
                                    <span class="label"><?php echo e(__('E-Posta')); ?></span>
                                    <a href="mailto:info@reformdanismanlik.com.tr">info@reformdanismanlik.com.tr</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Orta: Harita -->
            <div class="contact-map">
                <?php if($contactSettings && count($contactSettings) > 0 && !empty($contactSettings[0]['map_code'])): ?>
                    <div class="map-container">
                        <?php echo $contactSettings[0]['map_code']; ?>

                    </div>
                <?php else: ?>
                    <div class="map-container">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3059.4!2d32.835758!3d39.9323919!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMznCsDU1JzU2LjYiTiAzMsKwNTAnMDguNyJF!5e0!3m2!1str!2str!4v1609459200000!5m2!1str!2str" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Sağ: İletişim Formu -->
            <div class="contact-form-wrapper">
                <h2 class="section-title"><?php echo e(__('Mesaj Gönderin')); ?></h2>
                
                <?php if(session('success') || session('userSuccess')): ?>
                    <div class="alert alert-success"><?php echo e(session('success') ?? session('userSuccess')); ?></div>
                <?php endif; ?>
                
                <?php if(session('userError')): ?>
                    <div class="alert alert-danger"><?php echo e(session('userError')); ?></div>
                <?php endif; ?>
                
                <?php if($errors->any()): ?>
                    <div class="alert alert-danger">
                        <ul>
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form action="<?php echo e(route('contact.send', ['language_key' => App::getLocale()])); ?>" method="POST" class="contact-form">
                    <?php echo csrf_field(); ?>
                    
                    <div class="form-group">
                        <label for="name"><?php echo e(__('Ad Soyad')); ?> *</label>
                        <input type="text" id="name" name="name" value="<?php echo e(old('name')); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email"><?php echo e(__('E-Posta')); ?> *</label>
                        <input type="email" id="email" name="email" value="<?php echo e(old('email')); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="subject"><?php echo e(__('Konu')); ?> *</label>
                        <input type="text" id="subject" name="subject" value="<?php echo e(old('subject')); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="message"><?php echo e(__('Mesaj')); ?> *</label>
                        <textarea id="message" name="message" rows="5" required><?php echo e(old('message')); ?></textarea>
                    </div>
                    
                    <!-- Captcha -->
                    <div class="form-group captcha-group">
                        <label for="captcha"><?php echo e(__('Güvenlik Kodu')); ?> *</label>
                        <div class="captcha-box">
                            <span class="captcha-code"><?php echo e($captchaCode); ?></span>
                            <button type="button" class="captcha-refresh" onclick="location.reload()">
                                <i class="fas fa-sync-alt"></i>
                            </button>
                        </div>
                        <input type="text" id="captcha" name="captcha" placeholder="<?php echo e(__('Yukarıdaki kodu girin')); ?>" required>
                    </div>
                    
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-paper-plane"></i>
                        <?php echo e(__('Gönder')); ?>

                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<style>
.page-header {
    background: #1a1a1a;
    padding: 80px 0 40px 0;
    color: #fff;
    margin-bottom: 0;  /* Ekledim */
}

.breadcrumb {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 20px;
    font-size: 0.9rem;
    color: rgba(255,255,255,0.7);
}

.breadcrumb a {
    color: #fff;
    text-decoration: none;
}

.page-title {
    font-size: 2.8rem;
    font-weight: 700;
    color: #fff;
    margin: 0;  /* Tüm margin'leri sıfırladım */
}

.contact-section {
    padding: 0 0 80px 0;  /* Üst padding'i tamamen sıfırladım */
    background: #f8f9fa;
    margin-top: 0;  /* Ekledim */
}

.contact-grid {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 30px;
}

@media (max-width: 1200px) {
    .contact-grid {
        grid-template-columns: 1fr 1fr;
    }
}

.section-title {
    font-size: 1.8rem;
    font-weight: 600;
    color: #1a1a1a;
    margin: 0 0 30px 0;  /* Sadece alt margin bıraktım */
    padding-top: 0;  /* Ekledim */
}

.contact-info {
    margin-top: 0;  /* Ekledim */
    padding-top: 0;  /* Ekledim */
}

.contact-card {
    background: #fff;
    border-radius: 8px;
    padding: 30px;
    margin-bottom: 20px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.contact-branch {
    font-size: 1.2rem;
    font-weight: 600;
    color: #1a1a1a;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 2px solid #1a1a1a;
}

.contact-items {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.contact-item {
    display: flex;
    align-items: flex-start;
    gap: 15px;
}

.contact-icon {
    width: 44px;
    height: 44px;
    background: #1a1a1a;
    color: #fff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    flex-shrink: 0;
}

.contact-detail {
    flex: 1;
}

.contact-detail .label {
    display: block;
    font-size: 0.8rem;
    color: #888;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 5px;
}

.contact-detail p,
.contact-detail a {
    font-size: 1rem;
    color: #333;
    line-height: 1.5;
    text-decoration: none;
}

.contact-detail a:hover {
    color: #000;
    text-decoration: underline;
}

.contact-map {
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    height: 100%;
    min-height: 450px;
}

.map-container {
    width: 100%;
    height: 100%;
    min-height: 450px;
}

.map-container iframe {
    display: block;
    width: 100%;
    height: 100%;
    min-height: 450px;
    border: 0;
}

/* İletişim Formu Stilleri */
.contact-form-wrapper {
    background: #fff;
    border-radius: 8px;
    padding: 30px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.contact-form .form-group {
    margin-bottom: 20px;
}

.contact-form label {
    display: block;
    font-size: 0.9rem;
    font-weight: 500;
    color: #333;
    margin-bottom: 8px;
}

.contact-form input,
.contact-form textarea {
    width: 100%;
    padding: 12px 15px;
    border: 1px solid #ddd;
    border-radius: 6px;
    font-size: 1rem;
    transition: border-color 0.3s;
}

.contact-form input:focus,
.contact-form textarea:focus {
    outline: none;
    border-color: #1a1a1a;
}

.captcha-group {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 6px;
}

.captcha-box {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 10px;
}

.captcha-code {
    background: #1a1a1a;
    color: #fff;
    padding: 10px 20px;
    border-radius: 4px;
    font-family: monospace;
    font-size: 1.2rem;
    letter-spacing: 3px;
    flex: 1;
    text-align: center;
}

.captcha-refresh {
    background: #fff;
    border: 1px solid #ddd;
    padding: 10px 15px;
    border-radius: 4px;
    cursor: pointer;
    transition: all 0.3s;
}

.captcha-refresh:hover {
    background: #f0f0f0;
}

.btn-submit {
    width: 100%;
    padding: 15px;
    background: #1a1a1a;
    color: #fff;
    border: none;
    border-radius: 6px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}

.btn-submit:hover {
    background: #333;
}

.alert {
    padding: 15px;
    border-radius: 6px;
    margin-bottom: 20px;
}

.alert-success {
    background: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.alert-danger {
    background: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.alert-danger ul {
    margin: 0;
    padding-left: 20px;
}

@media (max-width: 1200px) {
    .contact-grid {
        grid-template-columns: 1fr 1fr;
    }
    .contact-map {
        grid-column: span 2;
        min-height: 300px;
    }
}

@media (max-width: 768px) {
    .contact-grid {
        grid-template-columns: 1fr;
    }
    .contact-map {
        grid-column: span 1;
        min-height: 300px;
    }
}

@media (max-width: 768px) {
    .page-title {
        font-size: 2rem;
    }

    .contact-section {
        padding: 0 0 50px 0;
    }
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('client.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Lenovo\danismanlik\danismanlik\resources\views/client/iletisim.blade.php ENDPATH**/ ?>