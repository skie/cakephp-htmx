<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Post $post
 */

if ($this->getRequest()->is('htmx')) {
    $formOptions = [
        'hx-post' => $this->Url->build([
            'action' => 'edit',
            $post->id,
        ]),
        'hx-target' => '#modal-area',
        'hx-headers' => json_encode([
            'X-Modal-Request' => 'true',
        ]),
        'hx-swap' => 'innerHTML',
    ];
} else {
    $formOptions = [];
}

?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $post->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $post->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Posts'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <?php $this->start('post'); ?>
        <div class="posts form content">
            <?= $this->Form->create($post, $formOptions) ?>
            <fieldset>
                <legend><?= __('Edit Post') ?></legend>
                <?php
                    echo $this->Form->control('title');
                    echo $this->Form->control('overview');
                    echo $this->Form->control('body');
                    echo $this->Form->control('is_published');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
        <?php $this->end(); ?>
        <?= $this->fetch('post'); ?>
    </div>
</div>
