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

document.addEventListener('htmx:beforeRequest', function(evt) {
    const target = evt.detail.target;
    if (target.id === 'modal-area') {
        const modalContent = document.querySelector('#modal-area .modal-content');
        if (modalContent) {
            modalContent.innerHTML = document.getElementById('modal-loader').innerHTML;
        }
        const modal = bootstrap.Modal.getInstance(target) || new bootstrap.Modal(target);
        modal.show();
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
