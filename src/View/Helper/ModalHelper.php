<?php
declare(strict_types=1);

namespace App\View\Helper;

use Cake\ORM\Entity;
use Cake\View\Helper;

/**
 * Modal helper
 */
class ModalHelper extends Helper
{
    /**
     * Default configuration for modal links
     *
     * @var array<string, mixed>
     */
    protected array $_defaultConfig = [
        'modalTarget' => '#modal-area',
    ];

    /**
     * @var array
     */
    public array $helpers = ['Html', 'Url'];


    /**
     * Generate a modal link with HTMX attributes
     *
     * @param string $title Link text
     * @param array|string $url URL
     * @param array $options Link options
     * @return string
     */
    public function link(string $title, array|string $url, array $options = []): string
    {
        $defaultOptions = $this->getModalOptions($this->Url->build($url), 'get');
        $options = array_merge($defaultOptions, $options);

        return $this->Html->tag('a', $title, $options);
    }

    /**
     * Prepare modal options
     *
     * @param string $url Url.
     * @param string $method HTTP method.
     * @return array
     */
    public function getModalOptions(string $url, string $method): array
    {
        $options = [
            'hx-target' => $this->getConfig('modalTarget'),
            'hx-trigger' => 'click',
            'hx-headers' => json_encode([
                'X-Modal-Request' => 'true',
            ]),
            'href' => 'javascript:void(0)',
            'data-bs-target' => $this->getConfig('modalTarget'),
        ];
        if (strtolower($method) === 'get') {
            $options['hx-get'] = $url;
        } else {
            $options['hx-' . strtolower($method)] = $url;
        }

        return $options;
    }
}
