<div class="action-wrapper"
    hx-get="<?= $this->Url->build([
        'action' => 'tableActions',
        $entity->id,
    ]) ?>"
    hx-trigger="click"
    hx-swap="outerHTML"
    hx-target="this"
    hx-indicator="#spinner-<?= $entity->id ?>"
>
    <?= $this->Html->tag('button', '<i class="fas fa-ellipsis-vertical"></i>', [
        'class' => 'btn btn-light btn-sm rounded-circle',
        'type' => 'button'
    ]) ?>
    <div id="spinner-<?= $entity->id ?>" class="htmx-indicator" style="display: none;">
        <div class="spinner-border spinner-border-sm text-secondary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
</div>
