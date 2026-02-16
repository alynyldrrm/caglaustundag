<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>

<body>
    <?php echo e($data['name']); ?> kişisinin iletişim formu üzerinden gönderdiği mesaj : <br>
    <?php echo e($data['message']); ?> <br>
    Konu: <?php echo e($data['subject']); ?> <br>
    Eposta: <?php echo e($data['email']); ?>

</body>

</html>
<?php /**PATH C:\Users\Lenovo\danismanlik\danismanlik\resources\views/mailLayouts/contact.blade.php ENDPATH**/ ?>