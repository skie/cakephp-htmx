<?php $this->start('actions'); ?>
<?= $this->Html->link(__('View'), ['action' => 'view', $post->id]) ?>
<?= $this->Html->link(__('Edit'), ['action' => 'edit', $post->id]) ?>
<?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $post->id], ['confirm' => __('Are you sure you want to delete # {0}?', $post->id)]) ?>
<?php $this->end(); ?>
<?= $this->fetch('actions'); ?>
