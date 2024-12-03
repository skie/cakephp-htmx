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
    <div class="table-container">
        <div id="table-loading" class="htmx-indicator">
            <div class="spinner"></div>
        </div>
        <div class="table-responsive">
            <table id="posts-table">
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
                    <tr class="item-container">
                        <td><?= $this->Number->format($post->id) ?></td>
                        <td><?= h($post->title) ?></td>
                        <td><?= h($post->is_published) ?></td>
                        <td><?= h($post->created) ?></td>
                        <td><?= h($post->modified) ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__('View'), ['action' => 'view', $post->id]) ?>
                            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $post->id]) ?>
                            <?= ''//$this->Form->postLink(__('Delete'), ['action' => 'delete', $post->id], ['confirm' => __('Are you sure you want to delete # {0}?', $post->id)]) ?>

                            <?php $csrfToken = $this->getRequest()->getAttribute('csrfToken');
                            $linkOptions = [
                                'hx-delete' => $this->Url->build(['action' => 'delete', $post->id]),
                                'hx-confirm' => __('Are you sure you want to delete # {0}?', $post->id),
                                'hx-target' => 'closest .item-container',
                                'hx-headers' => json_encode([
                                    'X-CSRF-Token' => $csrfToken,
                                    'Accept' => 'application/json',
                                ]),
                                'href' => 'javascript:void(0)',
                            ];

                            echo $this->Html->tag('a', __('Delete'), $linkOptions); ?>

                        </td>
                    </tr>
                    <?php $rows++; ?>
                    <?php endforeach; ?>
                    <?php if ($rows > 0): ?>
                        <tr
                            hx-get="<?= $this->Paginator->generateUrl(['page' => $this->Paginator->current() + 1]) ?>"
                            hx-select="#posts-table tbody tr"
                            hx-swap="outerHTML"
                            hx-trigger="intersect"
                            class="infinite-paginator"
                        >
                            <td class="text-center" colspan="6">
                                <div class="d-flex justify-content-center align-items-center py-2">
                                    <i class="fas fa-spinner fa-spin me-2"></i>
                                    <span><?= __('Loading more...') ?></span>
                                </div>
                            </td>
                        </tr>
                        <?php elseif (($this->getRequest()->getQuery('page', 1) == 1)): ?>
                        <tr>
                            <td class="text-center" colspan="6"><?= __('No items found') ?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php $this->end(); ?>
<?= $this->fetch('posts'); ?>
</div>
<script>
let toasts = new Toasts({
    offsetX: 20,
    offsetY: 20,
    gap: 20,
    width: 300,
    timing: 'ease',
    duration: '.5s',
    dimOld: true,
    position: 'top-right',
    dismissible: true,
    autoClose: true,
});

document.addEventListener('htmx:configRequest', function(event) {
    const element = event.detail.elt;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    if (csrfToken) {
        event.detail.headers['X-CSRF-Token'] = csrfToken;
    }
});
document.addEventListener('htmx:beforeSwap', function(evt) {
    const xhr = evt.detail.xhr;
    const responseType = xhr.getResponseHeader('X-Response-Type');

    if (responseType === 'json') {
        try {
            const data = JSON.parse(xhr.responseText);
            evt.detail.shouldSwap = false;

            if (data.messages) {
                data.messages.forEach(message => {
                    toasts.push({
                        title: message.message,
                        content: '',
                        style: message.status,
                        dismissAfter: '10s',
                        dismissible: true,
                    });
                });
            }

            if (data.removeContainer) {
                const item = evt.detail.target.closest('.item-container');
                if (item) {
                    evt.detail.shouldSwap = false;

                    item.style.transition = 'opacity 0.5s ease-out';
                    item.style.opacity = '0';

                    setTimeout(() => {
                        item.style.transition = 'max-height 0.5s ease-out';
                        item.style.maxHeight = '0';
                        setTimeout(() => {
                            item.remove();
                        }, 500);
                    }, 500);
                }
            }

            if (data.reload) {
                if (data.url) {
                    window.location.href = data.url;
                } else {
                    window.location.reload();
                }
            }
        } catch (e) {
            console.error('JSON parsing error:', e);
        }
    }
});
</script>
