<?php
if (!defined('_INCODE')) die('Access Deined...');
?>

<div class="" style="width: 600px; padding: 20px 30px; text-align: center; margin: 0 auto">
    <h2 style="text-transform: uppercase">Lỗi liên quan đến CSDL</h2>
    <hr>
    <?php
    echo $exception->getMessage().'<br>';
    echo 'File: '.$exception->getFile().'<br>';
    echo 'Line: '.$exception->getLine().'<br>';
    ?>
</div>
