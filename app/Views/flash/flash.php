<?php if (session()->getFlashdata('success')) : ?>
<div class="flash-data" data-flashsuccess="<?= session()->getFlashdata('success'); ?>"></div>
<?php elseif (session()->getFlashdata('info')) : ?>
<div class="flash-data" data-flashinfo="<?= session()->getFlashdata('info'); ?>"></div>
<?php elseif (session()->getFlashdata('warning')) : ?>
<div class="flash-data" data-flashwarning="<?= session()->getFlashdata('warning'); ?>"></div>
<?php elseif (session()->getFlashdata('login')) : ?>
<div class="flash-data" data-flashlogin="<?= session()->getFlashdata('login'); ?>"></div>
<?php else : ?>
<div class="flash-data" data-flasherror="<?= session()->getFlashdata('error'); ?>"></div>
<?php endif; ?>