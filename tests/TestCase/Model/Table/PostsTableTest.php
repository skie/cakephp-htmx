<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PostsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PostsTable Test Case
 */
class PostsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PostsTable
     */
    protected $Posts;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Posts',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Posts') ? [] : ['className' => PostsTable::class];
        $this->Posts = $this->getTableLocator()->get('Posts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Posts);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\PostsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
