<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Posts Model
 *
 * @method \App\Model\Entity\Post newEmptyEntity()
 * @method \App\Model\Entity\Post newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Post> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Post get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Post findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Post patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Post> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Post|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Post saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Post>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Post>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Post>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Post> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Post>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Post>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Post>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Post> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PostsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('posts');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');
        $this->addBehavior('PlumSearch.Filterable');

        $this->addBehavior('Timestamp');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('title')
            ->minLength('title', 5)
            ->maxLength('title', 255)
            ->requirePresence('title', 'create')
            ->notEmptyString('title');

        $validator
            ->scalar('overview')
            ->allowEmptyString('overview');

        $validator
            ->scalar('body')
            ->requirePresence('body', 'create')
            ->notEmptyString('body');

        $validator
            ->boolean('is_published')
            ->notEmptyString('is_published');

        return $validator;
    }
}
