<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreatePosts extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function change(): void
    {
        $this->table('posts')
            ->addColumn('title', 'string', [
                'limit' => 255,
            'null' => false,
            ])
            ->addColumn('overview', 'text', [
                'null' => true,
            ])
            ->addColumn('body', 'text', [
                'null' => false,
            ])
            ->addColumn('is_published', 'boolean', [
                'default' => false,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'null' => false,
            ])
            ->addColumn('modified', 'datetime', [
                'null' => false,
            ])
            ->create();
    }
}
