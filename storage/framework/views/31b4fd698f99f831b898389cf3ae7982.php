<?php
    $contact      = getContact() ? getContact()->first() : null;
    $menus        = getMenus();
    $homeSections = getTypeValues('sayfalar', 1);
    $homeSection  = count($homeSections) > 0 ? $homeSections[0] : null;
    $settings     = getWebsiteSettings();
?>

<footer id="footer">

    <div class="ft-main">
        <div class="container">
            <div class="ft-grid">

                <!-- Marka -->
                <div class="ft-brand">
                    <a href="/" class="ft-brand__logo">
                        <img src="/files/logo/cagla-ustundag-logo-text.png" alt="Çağla Üstündağ Logo">
                    </a>
                    <p class="ft-brand__tag"><?php echo e(__('Profesyonel danışmanlık hizmetleri')); ?></p>
                </div>

                <!-- İletişim -->
                <div class="ft-col">
                    <p class="ft-col__label"><?php echo e(__('İletişim')); ?></p>
                    <?php if($contact): ?>
                    <ul class="ft-contact">
                        <?php if($contact->address): ?>
                        <li>
                            <span class="ft-contact__ico"><i class="fas fa-map-marker-alt"></i></span>
                            <span><?php echo $contact->address; ?></span>
                        </li>
                        <?php endif; ?>
                        <?php if($contact->phone): ?>
                        <li>
                            <span class="ft-contact__ico"><i class="fas fa-phone"></i></span>
                            <a href="tel:<?php echo e($contact->phone); ?>"><?php echo $contact->phone; ?></a>
                        </li>
                        <?php endif; ?>
                        <?php if($contact->email): ?>
                        <li>
                            <span class="ft-contact__ico"><i class="fas fa-envelope"></i></span>
                            <a href="mailto:<?php echo e($contact->email); ?>"><?php echo $contact->email; ?></a>
                        </li>
                        <?php endif; ?>
                    </ul>
                    <?php endif; ?>
                </div>

                <!-- Hızlı Linkler -->
                <div class="ft-col">
                    <p class="ft-col__label"><?php echo e(__('Hızlı Linkler')); ?></p>
                    <ul class="ft-links">
                        <?php $__currentLoopData = $menus->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>
                            <a href="<?php echo e($menu['url'] == '' ? route('showPage', [$menu['language']['key'], $menu['permalink']]) : $menu['url']); ?>">
                                <i class="fas fa-chevron-right"></i>
                                <?php echo $menu->name; ?>

                            </a>
                        </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>

            </div>
        </div>
    </div>

    <div class="ft-bottom">
        <div class="container">
            <div class="ft-bottom__inner">
                <p class="ft-bottom__copy"><?php echo e(__('© 2026 Tüm Hakları Saklıdır.')); ?></p>
                <div class="ft-social">
                    <?php $__currentLoopData = ['facebook' => 'facebook-f', 'twitter' => 'twitter', 'instagram' => 'instagram', 'linkedin' => 'linkedin-in']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $icon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(!empty($settings->$key)): ?>
                            <a href="<?php echo e($settings->$key); ?>" target="_blank" class="ft-social__link">
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
    font-family: 'Outfit', sans-serif;
    -webkit-font-smoothing: antialiased;
    background: var(--white, #fff);
    border-top: 1px solid #e4e2dc;
}

#footer .container { width: min(1140px, 92vw); margin-inline: auto; }

/* ─── main ─── */
.ft-main { padding: 72px 0 56px; }

.ft-grid {
    display: grid;
    grid-template-columns: 1.4fr 1fr 1fr;
    gap: 60px;
}

/* Brand */
.ft-brand__logo img {
    height: 46px;
    width: auto;
    display: block;
    margin-bottom: 18px;
}

.ft-brand__tag {
    font-size: .875rem;
    color: #9a9891;
    font-weight: 300;
    line-height: 1.6;
    max-width: 240px;
}

/* Columns */
.ft-col__label {
    font-size: .65rem;
    font-weight: 600;
    letter-spacing: .14em;
    text-transform: uppercase;
    color: #9a9891;
    margin-bottom: 20px;
}

/* Contact list */
.ft-contact {
    list-style: none;
    display: flex;
    flex-direction: column;
    gap: 14px;
}

.ft-contact li {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    font-size: .875rem;
    color: #555550;
    font-weight: 300;
    line-height: 1.55;
}

.ft-contact__ico {
    width: 28px; height: 28px;
    background: rgba(42,61,82,.07);
    border-radius: 6px;
    display: flex; align-items: center; justify-content: center;
    color: #2a3d52;
    font-size: .7rem;
    flex-shrink: 0;
    margin-top: 1px;
}

.ft-contact a {
    color: inherit;
    text-decoration: none;
    transition: color .2s;
}

.ft-contact a:hover { color: #2a3d52; }

/* Links */
.ft-links {
    list-style: none;
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.ft-links a {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 0;
    font-size: .875rem;
    color: #555550;
    font-weight: 300;
    text-decoration: none;
    border-bottom: 1px solid #e4e2dc;
    transition: color .2s, padding-left .2s;
}

.ft-links li:last-child a { border-bottom: none; }

.ft-links a i {
    font-size: .5rem;
    color: #ccc9c0;
    transition: color .2s;
}

.ft-links a:hover { color: #2a3d52; padding-left: 4px; }
.ft-links a:hover i { color: #2a3d52; }

/* ─── bottom ─── */
.ft-bottom {
    border-top: 1px solid #e4e2dc;
    padding: 22px 0;
    background: #fafaf8;
}

.ft-bottom__inner {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
}

.ft-bottom__copy {
    font-size: .78rem;
    color: #9a9891;
    font-weight: 300;
}

.ft-social {
    display: flex;
    gap: 10px;
}

.ft-social__link {
    width: 34px; height: 34px;
    border: 1px solid #e4e2dc;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    color: #9a9891;
    font-size: .75rem;
    text-decoration: none;
    transition: all .22s;
}

.ft-social__link:hover {
    border-color: #2a3d52;
    color: #2a3d52;
    transform: translateY(-2px);
}

/* ─── responsive ─── */
@media (max-width: 900px) {
    .ft-grid { grid-template-columns: 1fr 1fr; gap: 40px; }
    .ft-brand { grid-column: 1 / -1; }
}

@media (max-width: 600px) {
    .ft-grid { grid-template-columns: 1fr; gap: 36px; }
    .ft-bottom__inner { flex-direction: column; text-align: center; }
}
</style>
<?php /**PATH C:\Users\Lenovo\danismanlik\danismanlik\resources\views/client/partials/footer.blade.php ENDPATH**/ ?>