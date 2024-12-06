<?php
/**
 * Modal layout
 */
echo $this->fetch('css');
echo $this->fetch('script');

?>
<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"><?= $this->fetch('title') ?></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <?= $this->fetch('content') ?>
        </div>
    </div>
</div>
