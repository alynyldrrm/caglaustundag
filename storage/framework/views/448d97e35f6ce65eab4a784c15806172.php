<?php
    $currentLanguage = session('defaultDatas')['currentLanguage'] ?? null;

    // Eğer list boşsa, direkt veritabanından çek
    if(!isset($list) || !is_array($list) || count($list) == 0) {
        $list = getTypeValues('referanslar', 100);
    }
?>



<?php $__env->startSection('title', $menu->name ?? __('Referanslar')); ?>

<?php $__env->startSection('content'); ?>
<section class="page-header">
    <div class="container">
        <h1 class="page-title"><?php echo $menu->name ?? __('Referanslar'); ?></h1>
        <p class="page-subtitle"><?php echo e(__('Başarı projelerimiz ve iş ortaklarımız')); ?></p>
    </div>
</section>

<section class="references-section">
    <div class="container">
        <?php if($list && count($list) > 0): ?>
            <div class="references-grid">
                <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $referans): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="reference-card" onclick="openReferenceModal(<?php echo e($referans['id']); ?>)">
                        <div class="reference-image">
                            <?php if(isset($referans['fields']['resim'][0])): ?>
                                <img src="<?php echo e(getImageLink($referans['fields']['resim'][0]['path'], ['w' => 300, 'h' => 200, 'q' => 90, 'fit' => 'contain'])); ?>"
                                     alt="<?php echo $referans['name']; ?>"
                                     loading="lazy">
                            <?php elseif(isset($referans['fields']['logo'][0])): ?>
                                <img src="<?php echo e(getImageLink($referans['fields']['logo'][0]['path'], ['w' => 300, 'h' => 200, 'q' => 90, 'fit' => 'contain'])); ?>"
                                     alt="<?php echo $referans['name']; ?>"
                                     loading="lazy">
                            <?php else: ?>
                                <div class="reference-name-display">
                                    <h3><?php echo $referans['name']; ?></h3>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="reference-info">
                            <h3 class="reference-name"><?php echo e($referans['name']); ?></h3>
                            <?php if(getValue('sektor', $referans)): ?>
                                <span class="reference-sector"><?php echo getValue('sektor', $referans); ?></span>
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
            <div class="empty-state">
                <i class="fas fa-folder-open"></i>
                <p><?php echo e(__('Henüz referans eklenmemiş.')); ?></p>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
:root {
    --gradient-primary: linear-gradient(135deg, #2d3748 0%, #1a202c 100%);
    --gradient-secondary: linear-gradient(135deg, #4a5568 0%, #2d3748 100%);
    --color-primary: #2d3748;
    --color-text: #2d3748;
    --color-text-light: #718096;
    --shadow-soft: 0 10px 40px rgba(45, 55, 72, 0.15);
    --shadow-hover: 0 20px 60px rgba(45, 55, 72, 0.25);
}

/* Page Header */
.page-header {
    background: var(--gradient-primary);
    padding: 120px 0 80px;
    text-align: center;
    color: #fff;
    position: relative;
    overflow: hidden;
}

.page-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}

.page-title {
    font-family: 'Playfair Display', serif;
    font-size: 3rem;
    font-weight: 700;
    margin-bottom: 15px;
    position: relative;
}

.page-subtitle {
    font-size: 1.15rem;
    color: rgba(255,255,255,0.9);
    position: relative;
}

/* References Section */
.references-section {
    padding: 100px 0;
    background: linear-gradient(180deg, #f8f9ff 0%, #ffffff 100%);
}

.references-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    gap: 30px;
}

.reference-card {
    background: #fff;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: var(--shadow-soft);
    cursor: pointer;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    border: 2px solid rgba(45, 55, 72, 0.1);
}

.reference-card:hover {
    transform: translateY(-10px);
    box-shadow: var(--shadow-hover);
    border-color: rgba(45, 55, 72, 0.3);
}

.reference-image {
    height: 160px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 30px;
    background: linear-gradient(135deg, #fafbff 0%, #fff 100%);
    position: relative;
}

.reference-image img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
    filter: grayscale(100%);
    transition: all 0.5s;
}

.reference-card:hover .reference-image img {
    filter: grayscale(0%);
    transform: scale(1.05);
}

.reference-placeholder {
    width: 70px;
    height: 70px;
    background: linear-gradient(135deg, rgba(45, 55, 72, 0.1), rgba(26, 32, 44, 0.1));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--color-primary);
    font-size: 1.8rem;
}

.reference-name-display {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 25px;
    background: var(--gradient-primary);
}

.reference-name-display h3 {
    font-family: 'Playfair Display', serif;
    font-size: 1.3rem;
    font-weight: 700;
    color: #fff;
    text-align: center;
    line-height: 1.4;
    margin: 0;
}

.modal-name-display {
    width: 180px;
    height: 130px;
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    padding: 25px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 15px 50px rgba(0,0,0,0.3);
    position: relative;
    z-index: 1;
    border: 2px solid rgba(255, 255, 255, 0.2);
}

.modal-name-display h2 {
    font-family: 'Playfair Display', serif;
    font-size: 1.4rem;
    font-weight: 700;
    color: #fff;
    text-align: center;
    line-height: 1.3;
    margin: 0;
}

.reference-info {
    padding: 25px;
    text-align: center;
    background: #fff;
}

.reference-name {
    font-size: 1.05rem;
    font-weight: 600;
    color: var(--color-text);
    margin-bottom: 8px;
    line-height: 1.4;
}

.reference-sector {
    display: inline-block;
    font-size: 0.85rem;
    color: var(--color-text-light);
    padding: 5px 15px;
    background: linear-gradient(135deg, rgba(45, 55, 72, 0.08), rgba(26, 32, 44, 0.08));
    border-radius: 15px;
}

/* Modal Styles */
.ref-modal-page {
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

.ref-modal-page.active {
    display: flex;
}

.ref-overlay-page {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.7);
}

.ref-content-page {
    position: relative;
    background: #fff;
    padding: 40px;
    border-radius: 12px;
    max-width: 500px;
    width: 90%;
    z-index: 1001;
}

.ref-close-page {
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

.ref-content-page h3 {
    font-size: 1.5rem;
    margin-bottom: 15px;
    color: #1a1a1a;
}

.ref-content-page p {
    color: #333;
    line-height: 1.6;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 100px 20px;
}

.empty-state i {
    font-size: 5rem;
    color: var(--color-primary);
    opacity: 0.3;
    margin-bottom: 25px;
}

.empty-state p {
    font-size: 1.1rem;
    color: var(--color-text-light);
}

/* Responsive */
@media (max-width: 1024px) {
    .references-grid {
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 25px;
    }
}

@media (max-width: 768px) {
    .page-header {
        padding: 100px 20px 60px;
    }

    .page-title {
        font-size: 2.2rem;
    }

    .references-section {
        padding: 60px 20px;
    }

    .references-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }

    .reference-image {
        height: 130px;
        padding: 20px;
    }

    .reference-info {
        padding: 20px;
    }

    .ref-content-page {
        width: 90%;
        padding: 30px;
    }

    .ref-content-page h3 {
        font-size: 1.3rem;
    }
}

@media (max-width: 480px) {
    .references-grid {
        grid-template-columns: 1fr;
        gap: 15px;
    }

    .ref-content-page {
        padding: 25px;
    }
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

// ESC tuşu ile kapatma
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        document.querySelectorAll('.reference-modal.active').forEach(function(modal) {
            modal.classList.remove('active');
            document.body.style.overflow = '';
        });
    }
});
</script>

<?php echo $__env->make('client.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Lenovo\danismanlik\danismanlik\resources\views/client/referanslar.blade.php ENDPATH**/ ?>