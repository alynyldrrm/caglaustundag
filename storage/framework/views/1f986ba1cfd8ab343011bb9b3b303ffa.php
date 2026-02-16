<?php
    $currentLanguage = session('defaultDatas')['currentLanguage'] ?? null;
    
    // Hakkımızda içeriğini çek
    $hakkimizdaList = getTypeValues('sayfalar', 1);
    $hakkimizda = count($hakkimizdaList) > 0 ? $hakkimizdaList[0] : null;
?>



<?php $__env->startSection('title', $menu->name ?? __('Hakkımızda')); ?>

<?php $__env->startSection('content'); ?>
<section class="page-header">
    <div class="container">
        <h1 class="page-title"><?php echo e($menu->name ?? __('Hakkımızda')); ?></h1>
    </div>
</section>

<section class="page-content hakkimizda-page">
    <div class="container">
        <?php if($hakkimizda): ?>
            <div class="hakkimizda-grid">
                <div class="hakkimizda-image">
                    <?php if(isset($hakkimizda['fields']['gorsel'][0])): ?>
                        <img src="<?php echo e(getImageLink($hakkimizda['fields']['gorsel'][0]['path'], ['w' => 800, 'h' => 600, 'fit' => 'cover'])); ?>" alt="<?php echo e(getValue('baslik', $hakkimizda)); ?>">
                    <?php endif; ?>
                </div>
                <div class="hakkimizda-content">
                    <h2><?php echo e(getValue('baslik', $hakkimizda)); ?></h2>
                    <div class="hakkimizda-text">
                        <?php echo getValue('icerik', $hakkimizda); ?>

                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="empty-content">
                <p><?php echo e(__('İçerik bulunamadı.')); ?></p>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<style>
.page-header {
    background: #1a1a1a;
    padding: 60px 0;
    color: #fff;
}

.page-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #fff;
    margin: 0;
}

.page-content {
    padding: 80px 0;
    background: #f8f9fa;
}

.hakkimizda-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 60px;
    align-items: center;
}

.hakkimizda-image {
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}

.hakkimizda-image img {
    width: 100%;
    display: block;
}

.hakkimizda-content h2 {
    font-size: 2rem;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 30px;
    line-height: 1.3;
}

.hakkimizda-text {
    font-size: 1.1rem;
    color: #555;
    line-height: 1.8;
}

.hakkimizda-text p {
    margin-bottom: 20px;
}

.empty-content {
    text-align: center;
    padding: 60px 0;
    color: #888;
}

@media (max-width: 1024px) {
    .hakkimizda-grid {
        grid-template-columns: 1fr;
        gap: 40px;
    }
    
    .hakkimizda-image {
        order: -1;
    }
}

@media (max-width: 768px) {
    .page-header {
        padding: 40px 0;
    }
    
    .page-title {
        font-size: 1.8rem;
    }
    
    .page-content {
        padding: 50px 0;
    }
    
    .hakkimizda-content h2 {
        font-size: 1.6rem;
    }
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('client.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Lenovo\danismanlik\danismanlik\resources\views/client/hakkimizda.blade.php ENDPATH**/ ?>