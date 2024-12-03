<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Post> $posts
 */

$rows = 0;
?>

<div id="posts" class="posts index content">
<?php $this->start('posts'); ?>
    <?= $this->Html->link(__('New Post'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Posts') ?></h3>
    <div class="row">
    </div>
    <div class="cards-grid">
        <?php foreach ($posts as $index => $post): ?>
            <div class="card item-container"
                <?php if ($index === count($posts) - 1): ?>
                    hx-get="<?= $this->Paginator->generateUrl(['page' => $this->Paginator->current() + 1]) ?>"
                    hx-trigger="revealed"
                    hx-swap="afterend"
                    hx-select="div.card"
                    hx-target="this"
                    hx-headers='{"HX-Disable-Loader": "true"}'
                    hx-indicator="#infinite-scroll-indicator"
                <?php endif; ?>>

                <div class="card-content">
                    <h3><?= h($post->title) ?></h3>
                    <p class="post-body"><?= h($post->body) ?></h3>
                    <p class="post-created"><?= h($post->created) ?></p>
                </div>
            </div>
            <?php $rows++; ?>
        <?php endforeach; ?>
    </div>
    <?php if ($rows > 0): ?>
        <div id="infinite-scroll-indicator" class="d-flex justify-content-center align-items-center py-3">
            <i class="fas fa-spinner fa-spin me-2"></i>
            <span><?= __('Loading more...') ?></span>
        </div>
    <?php endif; ?>
<?php $this->end(); ?>
<?= $this->fetch('posts'); ?>
</div>
