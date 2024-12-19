<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Post> $posts
 */
?>
<?= $this->Html->css('CakeDC/SearchFilter.inline'); ?>
<?= $this->Html->script('CakeDC/SearchFilter.vue3.js'); ?>
<?= $this->Html->script('CakeDC/SearchFilter.main.js', ['type' => 'module']); ?>
<?= $this->element('CakeDC/SearchFilter.Search/v_templates'); ?>

<div id="posts" class="posts index content">
<?php $this->start('posts'); ?>
    <?= $this->Html->link(__('New Post'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Posts') ?></h3>

    <div id="search">
        <?= $this->Form->create(null, [
            'id' => 'search-form',
            'type' => 'get',
            'hx-get' => $this->Url->build(['controller' => 'Posts', 'action' => 'index']),
            'hx-target' => "#posts",
        ]); ?>
        <div id="ext-search"></div>
        <?= $this->Form->button('Search', ['type' => 'submit', 'class' => 'btn btn-primary']); ?>

        <?= $this->Form->end(); ?>
    </div>
    <script>
        window._search = window._search || {};
        window._search.fields = <?= json_encode($viewFields) ?>;
        var values = null;
        <?php if (!empty($values)): ?>
            window._search.values = <?= json_encode($values) ?>;
        <?php else: ?>
            window._search.values = {};
        <?php endif; ?>
    </script>

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
<script>
function setupTable(reload) {
    if (reload) {
        setTimeout(function () {
            window._search.app.unmount()
            window._search.createMyApp(window._search.rootElemId)
        }, 20);
    }
}
document.addEventListener('DOMContentLoaded', function() {
    window._search.createMyApp(window._search.rootElemId)
    setupTable(false);
    htmx.on('htmx:afterRequest', (evt) => {
        setupTable(true);
    })
});
</script>
