<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Post> $posts
 */
?>

<div id="posts" class="posts index content">
<?php $this->start('posts'); ?>
    <?= $this->Html->link(__('New Post'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Posts') ?></h3>
    <div class="table-container">
        <div id="table-loading" class="htmx-indicator">
            <div class="spinner"></div>
        </div>
        <div class="table-responsive">
            <table>
                <thead
                    hx-boost="true"
                    hx-target="#posts"
                    hx-indicator="#table-loading"
                    hx-push-url="true"
                >
                    <tr>
                        <th><?= $this->Paginator->sort('id') ?></th>
                        <th><?= $this->Paginator->sort('title') ?></th>
                        <th><?= $this->Paginator->sort('is_published') ?></th>
                        <th><?= $this->Paginator->sort('created') ?></th>
                        <th><?= $this->Paginator->sort('modified') ?></th>
                        <th class="actions"><?= __('Actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($posts as $post): ?>
                    <tr>
                        <td><?= $this->Number->format($post->id) ?></td>
                        <td><?= $this->HtmxWidgets->inlineEdit('title', $post->title, $post) ?></td>
                        <td><?= $this->HtmxWidgets->inlineEdit('is_published', $post->is_published ? __('Yes') : __('No'), $post) ?></td>
                        <td><?= h($post->created) ?></td>
                        <td><?= h($post->modified) ?></td>
                        <td class="actions">
                            <?= $this->element('lazy_actions', ['entity' => $post]) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="paginator"
            hx-boost="true"
            hx-target="#posts"
            hx-indicator="#table-loading"
            hx-push-url="true"
        >
            <ul class="pagination">
                <?= $this->Paginator->first('<< ' . __('first')) ?>
                <?= $this->Paginator->prev('< ' . __('previous')) ?>
                <?= $this->Paginator->numbers() ?>
                <?= $this->Paginator->next(__('next') . ' >') ?>
                <?= $this->Paginator->last(__('last') . ' >>') ?>
            </ul>
            <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
        </div>
    </div>
<?php $this->end(); ?>
<?= $this->fetch('posts'); ?>
</div>

