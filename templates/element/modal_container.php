<?php if (!$this->getRequest()->is('htmx')): ?>
<div id="modal-area"
    class="modal modal-blur fade"
    style="display: none"
    aria-hidden="false"
    tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content"></div>
    </div>
</div>
<script type="text/x-template" id="modal-loader">
    <div class="modal-body d-flex justify-content-center align-items-center" style="min-height: 200px;">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
</script>
<?php endif; ?>
