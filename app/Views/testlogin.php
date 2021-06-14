<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php if(session()->getTempdata('error')): ?>
    <div class="form-notify-error">
        <span class="error-text info-text text-sm">
            <?= session()->getTempdata('error') ?>
        </span>
    </div><br>
    <?php elseif(session()->getTempdata('incorrect')): ?>
    <div class="form-notify-error">
        <span class="error-text info-text text-sm">
            <?= session()->getTempdata('incorrect') ?>
        </span>
    </div><br>
    <?php endif; ?>

    <br><br>
    <form action="<?= base_url() ?>/auth-secure/login" method="post">
        <input type="email" name="public_key" id="" placeholder="Enter email">
        <input type="password" name="private_key" id="" placeholder="Enter password">

        <br><br>
        <input type="submit" value="log in">
    </form>
</body>
</html>