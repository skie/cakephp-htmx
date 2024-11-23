<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Post $post
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Post'), ['action' => 'edit', $post->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Post'), ['action' => 'delete', $post->id], ['confirm' => __('Are you sure you want to delete # {0}?', $post->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Posts'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Post'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="posts view content">
            <h3><?= h($post->title) ?></h3>
            <table>
                <tr>
                    <th><?= __('Title') ?></th>
                    <td><?= h($post->title) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($post->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($post->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($post->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Published') ?></th>
                    <td><?= $post->is_published ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Overview') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($post->overview)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Body') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($post->body)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>