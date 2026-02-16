<?php
    $contact = getContact() ? getContact()->first() : null;
    $menus = getMenus();
    $homeSections = getTypeValues('sayfalar', 1);
    $homeSection = count($homeSections) > 0 ? $homeSections[0] : null;
    $settings = getWebsiteSettings();
?>

<footer id="footer">
    <div class="footer-main">
        <div class="container">
            <div class="row gy-5">
                <div class="col-lg-4">
                    <div class="footer-brand">
                        <a href="/">
                            <img src="/files/logo/cagla-ustundag-logo-text.png" alt="Çağla Üstündağ Logo" style="height: 50px;">
                        </a>
                        <p class="footer-tagline"><?php echo e(__('Profesyonel danışmanlık hizmetleri')); ?></p>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="footer-contact">
                        <h4><?php echo e(__('İletişim')); ?></h4>
                        <?php if($contact): ?>
                        <ul class="contact-list">
                            <?php if($contact->address): ?>
                            <li>
                                <i class="fas fa-map-marker-alt"></i>
                                <span><?php echo e($contact->address); ?></span>
                            </li>
                            <?php endif; ?>
                            <?php if($contact->phone): ?>
                            <li>
                                <i class="fas fa-phone"></i>
                                <a href="tel:<?php echo e($contact->phone); ?>"><?php echo e($contact->phone); ?></a>
                            </li>
                            <?php endif; ?>
                            <?php if($contact->email): ?>
                            <li>
                                <i class="fas fa-envelope"></i>
                                <a href="mailto:<?php echo e($contact->email); ?>"><?php echo e($contact->email); ?></a>
                            </li>
                            <?php endif; ?>
                        </ul>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="footer-links">
                        <h4><?php echo e(__('Hızlı Linkler')); ?></h4>
                        <ul class="quick-links">
                            <?php $__currentLoopData = $menus->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li>
                                    <a href="<?php echo e($menu['url'] == '' ? route('showPage', [$menu['language']['key'], $menu['permalink']]) : $menu['url']); ?>">
                                        <?php echo e($menu->name); ?>

                                    </a>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <div class="footer-bottom-content">
                <p class="copyright"><?php echo e(__('© 2026 Tüm Hakları Saklıdır.')); ?></p>
                <div class="footer-social">
                    <?php $__currentLoopData = ['facebook' => 'facebook-f', 'twitter' => 'twitter', 'instagram' => 'instagram', 'linkedin' => 'linkedin-in']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $icon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(!empty($settings->$key)): ?>
                            <a href="<?php echo e($settings->$key); ?>" target="_blank" class="social-link">
                                <i class="fab fa-<?php echo e($icon); ?>"></i>
                            </a>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
    #footer {
        background: #f8f9fa;
        border-top: 1px solid #e5e5e5;
    }

    .footer-main {
        padding: 80px 0 60px;
    }

    .footer-brand img {
        margin-bottom: 20px;
    }

    .footer-tagline {
        color: #888;
        font-size: 1rem;
        margin: 0;
    }

    .footer-contact h4,
    .footer-links h4 {
        color: #1a1a1a;
        font-size: 0.9rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-bottom: 25px;
    }

    .contact-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .contact-list li {
        display: flex;
        align-items: flex-start;
        gap: 15px;
        margin-bottom: 15px;
        color: #666;
        font-size: 0.95rem;
    }

    .contact-list i {
        color: #1a1a1a;
        margin-top: 3px;
        font-size: 0.9rem;
    }

    .contact-list a {
        color: #666;
        text-decoration: none;
        transition: color 0.3s;
    }

    .contact-list a:hover {
        color: #000;
    }

    .quick-links {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .quick-links li {
        margin-bottom: 10px;
    }

    .quick-links a {
        color: #666;
        text-decoration: none;
        font-size: 0.95rem;
        transition: all 0.3s;
        display: inline-block;
    }

    .quick-links a:hover {
        color: #000;
        padding-left: 5px;
    }

    .footer-bottom {
        border-top: 1px solid #e5e5e5;
        padding: 25px 0;
        background: #fff;
    }

    .footer-bottom-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .copyright {
        color: #999;
        font-size: 0.85rem;
        margin: 0;
    }

    .footer-social {
        display: flex;
        gap: 15px;
    }

    .social-link {
        width: 40px;
        height: 40px;
        border: 1px solid #ddd;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #666;
        text-decoration: none;
        transition: all 0.3s;
    }

    .social-link:hover {
        border-color: #000;
        color: #000;
        transform: translateY(-3px);
    }

    @media (max-width: 768px) {
        .footer-bottom-content {
            flex-direction: column;
            gap: 20px;
            text-align: center;
        }
    }
</style>
<?php /**PATH C:\Users\Lenovo\danismanlik\danismanlik\resources\views/client/partials/footer.blade.php ENDPATH**/ ?>