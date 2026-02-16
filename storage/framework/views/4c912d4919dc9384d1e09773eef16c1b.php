
<?php $__env->startSection('title', __('Anasayfa')); ?>

<?php
    $homeSections = getTypeValues('sayfalar', 1);
    $homeSection = count($homeSections) > 0 ? $homeSections[0] : null;

    if ($homeSection) {
        $resim = isset($homeSection['fields']['gorsel'][0])
            ? getImageLink($homeSection['fields']['gorsel'][0]['path'], ['w' => 800, 'h' => 600, 'fit' => 'cover'])
            : '/assets/client/img/style-switcher.png';
    }

    // Hizmetler (ilk 4) - Tip permalink'i ile çek
    $hizmetler = getTypeValues('hizmetler', 4);

    // Referanslar (ilk 5) - Tip permalink'i ile çek
    $referanslar = getTypeValues('referanslar', 5);
?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('client.partials.slider', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    
    <?php if($homeSection): ?>
    <section class="home-about">
        <div class="container">
            <div class="about-grid">
                <div class="about-content">
                    <span class="section-label"><?php echo e(__('Hakkımızda')); ?></span>
                    <h2 class="section-title"><?php echo getValue('baslik', $homeSection); ?></h2>
                    <div class="about-text">
                        <?php echo substr(getValue('icerik', $homeSection), 0, 400); ?>...
                    </div>
                    <a href="/<?php echo e(App::getLocale()); ?>/hakkimizda" class="btn btn-primary">
                        <?php echo e(__('Devamını Gör')); ?>

                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                <div class="about-image">
                    <img src="<?php echo e($resim); ?>" alt="<?php echo getValue('baslik', $homeSection); ?>">
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    
    <?php if(count($hizmetler) > 0): ?>
    <section class="home-services">
        <div class="container">
            <div class="section-header">
                <span class="section-label"><?php echo e(__('Hizmetlerimiz')); ?></span>
                <h2 class="section-title"><?php echo e(__('Profesyonel Çözümler')); ?></h2>
            </div>

            <div class="services-grid">
                <?php $__currentLoopData = $hizmetler; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hizmet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="/<?php echo e(App::getLocale()); ?>/hizmetlerimiz/<?php echo e($hizmet['permalink']); ?>" class="service-card">
                    <div class="service-icon">
                        <?php if(isset($hizmet['fields']['icon'][0])): ?>
                            <img src="<?php echo e(getImageLink($hizmet['fields']['icon'][0]['path'], ['w' => 60, 'h' => 60, 'fit' => 'contain'])); ?>" alt="">
                        <?php else: ?>
                            <i class="fas fa-briefcase"></i>
                        <?php endif; ?>
                    </div>
                    <h3 class="service-name"><?php echo $hizmet['name']; ?></h3>
                    <?php if(getValue('kisa_aciklama', $hizmet)): ?>
                        <p class="service-desc"><?php echo substr(getValue('kisa_aciklama', $hizmet), 0, 100); ?>...</p>
                    <?php endif; ?>
                </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <div class="section-footer">
                <a href="/<?php echo e(App::getLocale()); ?>/hizmetlerimiz" class="btn btn-outline">
                    <?php echo e(__('Tüm Hizmetleri Gör')); ?>

                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>
    <?php endif; ?>

    
    <?php if(count($referanslar) > 0): ?>
    <section class="home-references">
        <div class="container">
            <div class="section-header">
                <span class="section-label"><?php echo e(__('Referanslar')); ?></span>
                <h2 class="section-title"><?php echo e(__('İş Ortaklarımız')); ?></h2>
            </div>

            <div class="references-grid">
                <?php $__currentLoopData = $referanslar; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $referans): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="reference-item" onclick="openRefModal(<?php echo e($referans['id']); ?>)">
                    <?php if(isset($referans['fields']['resim'][0])): ?>
                        <img src="<?php echo e(getImageLink($referans['fields']['resim'][0]['path'], ['w' => 200, 'h' => 120, 'q' => 90, 'fit' => 'contain'])); ?>"
                             alt="<?php echo $referans['name']; ?>">
                    <?php else: ?>
                        <div class="reference-name">
                            <?php echo $referans['name']; ?>

                        </div>
                    <?php endif; ?>
                </div>

                
                <div id="ref-modal-<?php echo e($referans['id']); ?>" class="ref-modal">
                    <div class="ref-overlay" onclick="closeRefModal(<?php echo e($referans['id']); ?>)"></div>
                    <div class="ref-content">
                        <button class="ref-close" onclick="closeRefModal(<?php echo e($referans['id']); ?>)">
                            <i class="fas fa-times"></i>
                        </button>
                        <h3><?php echo $referans['name']; ?></h3>
                        <?php $detay = getValue('Detay', $referans) ?: getValue('detay', $referans); ?>
                        <?php if($detay): ?>
                            <p><?php echo $detay; ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <div class="section-footer">
                <a href="/<?php echo e(App::getLocale()); ?>/referanslar" class="btn btn-outline">
                    <?php echo e(__('Tüm Referansları Gör')); ?>

                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>
    <?php endif; ?>

    
    <section class="home-stats">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-box">
                    <span class="stat-number">10+</span>
                    <span class="stat-text"><?php echo e(__('Yıllık Tecrübe')); ?></span>
                </div>
                <div class="stat-box">
                    <span class="stat-number">500+</span>
                    <span class="stat-text"><?php echo e(__('Mutlu Müşteri')); ?></span>
                </div>
                <div class="stat-box">
                    <span class="stat-number">50+</span>
                    <span class="stat-text"><?php echo e(__('Uzman Kadro')); ?></span>
                </div>
                <div class="stat-box">
                    <span class="stat-number">1000+</span>
                    <span class="stat-text"><?php echo e(__('Tamamlanan Proje')); ?></span>
                </div>
            </div>
        </div>
    </section>

    <script>
    function openRefModal(id) {
        const modal = document.getElementById('ref-modal-' + id);
        if(modal) modal.style.display = 'flex';
    }
    function closeRefModal(id) {
        const modal = document.getElementById('ref-modal-' + id);
        if(modal) modal.style.display = 'none';
    }
    document.addEventListener('keydown', function(e) {
        if(e.key === 'Escape') {
            document.querySelectorAll('.ref-modal').forEach(m => m.style.display = 'none');
        }
    });
    </script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<style>
/* Genel Section Stilleri */
.section-label {
    display: inline-block;
    font-size: 0.85rem;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 3px;
    color: #999;
    margin-bottom: 15px;
}

.section-title {
    font-size: 2.2rem;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 15px;
    line-height: 1.2;
}

.section-header {
    text-align: center;
    margin-bottom: 50px;
}

.section-footer {
    text-align: center;
    margin-top: 40px;
}

/* Butonlar */
.btn {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 12px 28px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s;
    border-radius: 4px;
}

.btn-primary {
    background: #1a1a1a;
    color: #fff;
    border: 2px solid #1a1a1a;
}

.btn-primary:hover {
    background: #333;
    color: #fff;
}

.btn-outline {
    background: transparent;
    color: #1a1a1a;
    border: 2px solid #1a1a1a;
}

.btn-outline:hover {
    background: #1a1a1a;
    color: #fff;
}

/* Hakkımızda */
.home-about {
    padding: 100px 0;
    background: #fff;
}

.about-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 80px;
    align-items: center;
}

.about-text {
    font-size: 1.05rem;
    color: #666;
    line-height: 1.8;
    margin-bottom: 30px;
}

.about-image {
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0,0,0,0.1);
}

.about-image img {
    width: 100%;
    display: block;
}

/* Hizmetler */
.home-services {
    padding: 100px 0;
    background: #f8f9fa;
}

.services-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 25px;
}

.service-card {
    background: #fff;
    border-radius: 12px;
    padding: 35px 25px;
    text-align: center;
    text-decoration: none;
    color: inherit;
    transition: all 0.3s;
    border: 1px solid #e5e5e5;
}

.service-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    border-color: #1a1a1a;
}

.service-icon {
    width: 60px;
    height: 60px;
    margin: 0 auto 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f0f0f0;
    border-radius: 50%;
    font-size: 1.5rem;
    color: #1a1a1a;
}

.service-icon img {
    max-width: 30px;
    max-height: 30px;
}

.service-name {
    font-size: 1.1rem;
    font-weight: 600;
    color: #1a1a1a;
    margin-bottom: 10px;
}

.service-desc {
    font-size: 0.9rem;
    color: #666;
    margin: 0;
}

/* Referanslar */
.home-references {
    padding: 100px 0;
    background: #fff;
}

.references-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 30px;
}

.reference-item {
    height: 100px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    background: #f8f9fa;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s;
    border: 1px solid #e5e5e5;
}

.reference-item:hover {
    background: #fff;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
}

.reference-item img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
}

.reference-placeholder {
    font-size: 2rem;
    color: #ccc;
}

.reference-name {
    font-size: 1rem;
    font-weight: 600;
    color: #333;
    text-align: center;
    line-height: 1.3;
}

/* Referans Modal */
.ref-modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1000;
    align-items: center;
    justify-content: center;
}

.ref-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.7);
}

.ref-content {
    position: relative;
    background: #fff;
    padding: 40px;
    border-radius: 12px;
    max-width: 500px;
    width: 90%;
    z-index: 1001;
}

.ref-close {
    position: absolute;
    top: 15px;
    right: 15px;
    width: 35px;
    height: 35px;
    border: none;
    background: #f0f0f0;
    border-radius: 50%;
    cursor: pointer;
}

.ref-content h3 {
    font-size: 1.5rem;
    margin-bottom: 15px;
    color: #1a1a1a;
}

.ref-content p {
    color: #333;
    line-height: 1.6;
}

/* İstatistikler */
.home-stats {
    padding: 80px 0;
    background: #1a1a1a;
    color: #fff;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 40px;
}

.stat-box {
    text-align: center;
}

.stat-number {
    display: block;
    font-size: 3rem;
    font-weight: 700;
    color: #fff;
    line-height: 1;
    margin-bottom: 10px;
}

.stat-text {
    font-size: 0.9rem;
    color: #999;
    text-transform: uppercase;
    letter-spacing: 2px;
}

/* Responsive */
@media (max-width: 1024px) {
    .about-grid {
        grid-template-columns: 1fr;
        gap: 50px;
    }

    .about-image {
        order: -1;
    }

    .services-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .references-grid {
        grid-template-columns: repeat(3, 1fr);
    }

    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .section-title {
        font-size: 1.8rem;
    }

    .services-grid {
        grid-template-columns: 1fr;
    }

    .references-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .stats-grid {
        grid-template-columns: 1fr;
        gap: 30px;
    }

    .stat-number {
        font-size: 2.5rem;
    }
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('client.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Lenovo\danismanlik\danismanlik\resources\views/client/home.blade.php ENDPATH**/ ?>