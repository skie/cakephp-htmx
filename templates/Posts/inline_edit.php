<?php
$formOptions = [
    'id' => 'posts',
    'hx-put' => $this->Url->build([
        'action' => 'inlineEdit',
        $post->id,
        $field,
    ]),
    'hx-target' => 'this',
    'hx-swap' => 'outerHTML',
    'class' => 'inline-edit-form inline-edit-wrapper',
];

?>
<?php $this->start('edit'); ?>
<?php if ($mode == 'view'): ?>
    <?php if ($field == 'is_published'): ?>
        <?= $this->HtmxWidgets->inlineEdit($field, $post->is_published ? 'Published' : 'Unpublished', $post); ?>
    <?php elseif ($field == 'body'): ?>
        <?= $this->HtmxWidgets->inlineEdit('body', $this->Text->autoParagraph(h($post->body)), $post) ?>
    <?php elseif ($field == 'overview'): ?>
        <?= $this->HtmxWidgets->inlineEdit('overview', $this->Text->autoParagraph(h($post->overview)), $post) ?>
    <?php else: ?>
        <?= $this->HtmxWidgets->inlineEdit($field, $post->get($field), $post); ?>
    <?php endif; ?>
<?php else: ?>
    <?= $this->Form->create($post, $formOptions) ?>
    <?= $this->Form->hidden('id'); ?>
    <?php if ($field == 'title'): ?>
        <?= $this->Form->control('title'); ?>
    <?php elseif ($field == 'overview'): ?>
        <?= $this->Form->control('overview'); ?>
    <?php elseif ($field == 'body'): ?>
        <?= $this->Form->control('body'); ?>
    <?php elseif ($field == 'is_published'): ?>
        <?= $this->Form->control('is_published'); ?>
    <?php endif; ?>
    <div class="inline-edit-actions">
    <?= $this->Form->button('<i class="fas fa-check"></i>', [
            'class' => 'btn btn-primary btn-sm inline-edit-trigger',
            'name' => 'button',
            'value' => 'save',
            'escapeTitle' => false,
        ]); ?>
        <?= $this->Form->button('<i class="fas fa-times"></i>', [
            'class' => 'btn btn-secondary btn-sm inline-edit-trigger',
            'name' => 'button',
            'value' => 'cancel',
            'escapeTitle' => false,
        ]); ?>
    </div>
    <?= $this->Form->end() ?>
<?php endif; ?>
<?php $this->end(); ?>
<?= $this->fetch('edit'); ?>
