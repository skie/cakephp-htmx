<?php
declare(strict_types=1);

namespace App\View\Helper;

use Cake\View\Helper;
use Cake\View\View;
use Cake\Datasource\EntityInterface;
use CakeDC\Admin\Settings\Field\FieldInterface;

/**
 * HtmxWidgetsHelper
 *
 * A helper for rendering htmx widgets.
 */
class HtmxWidgetsHelper extends Helper
{
    /**
     * @var array
     */
    public array $helpers = ['Url'];

    /**
     * Render an inline edit for a field.
     *
     * @param string $field The field name.
     * @param mixed $value The field value.
     * @param \Cake\Datasource\EntityInterface $entity The entity containing the field.
     * @param \Cake\View\View $view The view object.
     * @return string The formatted HTML.
     */
    public function inlineEdit(string $field, $value, EntityInterface $entity): string
    {
        $url = [
            'action' => 'inlineEdit',
            $entity->get('id'),
            $field,
            '?' => ['field' => $field],
        ];
        $url = $this->Url->build($url);

        return sprintf(
            '<div
                class="inline-edit-wrapper inline-edit-trigger"
                hx-target="this"
                hx-swap="outerHTML">
                    <span class="field-value">%s</span>
                    <button class="btn btn-sm inline-edit-btn" hx-get="%s">
                        <i class="fas fa-edit"></i>
                    </button>
            </div>',
            ($value),
            $url
        );
    }
}
