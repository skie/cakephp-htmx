<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Posts Controller
 *
 * @property \App\Model\Table\PostsTable $Posts
 */
class PostsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->list();
    }

    /**
     * Cards Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function cards()
    {
        $this->list();
    }

    /**
     * Infinite Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function infinite()
    {
        $this->list();
    }

    /**
     * Common Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    protected function list()
    {
        $query = $this->Posts->find();
        $posts = $this->paginate($query, ['limit' => 12]);
        $this->set(compact('posts'));

        if ($this->request->is('htmx') || $this->request->is('boosted')) {
            $this->response = $this->response
                ->withHeader('Cache-Control', 'no-store, no-cache, must-revalidate')
                ->withHeader('Pragma', 'no-cache')
                ->withHeader('Expires', '0');
        }
        if ($this->getRequest()->is('htmx')) {
            $this->viewBuilder()->disableAutoLayout();

            $this->Htmx->setBlock('posts');
            sleep(1); // timeout to demonstrate loader functionality
        }
    }

    /**
     * Inline edit
     *
     * @param int $id Post id.
     * @param string $field Field name.
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function inlineEdit(int $id, string $field)
    {
        $post = $this->Posts->get($id, contain: []);
        $allowedFields = ['title', 'overview', 'body', 'is_published'];
        if (!in_array($field, $allowedFields)) {
            return $this->response->withStatus(403);
        }
        $mode = 'edit';
        if ($this->request->is(['post', 'put'])) {
            if ($this->request->getData('button') == 'cancel') {
                $mode = 'view';
            } else {
                $value = $this->request->getData($field);
                $post->set($field, $value);
                $result = $this->Posts->save($post);
                if ($result) {
                    $mode = 'view';
                }
            }
        }
        if ($this->getRequest()->is('htmx')) {
            $this->viewBuilder()->disableAutoLayout();

            $this->Htmx->setBlock('edit');
        }
        $this->set(compact('post', 'mode', 'field'));
    }

    /**
     * View method
     *
     * @param int $id Post id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(int $id)
    {
        $post = $this->Posts->get($id, contain: []);
        $this->set(compact('post'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $post = $this->Posts->newEmptyEntity();
        if ($this->request->is('post')) {
            $post = $this->Posts->patchEntity($post, $this->request->getData());
            if ($this->Posts->save($post)) {
                $this->Flash->success(__('The post has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The post could not be saved. Please, try again.'));
        }
        $this->set(compact('post'));
    }

    /**
     * Edit method
     *
     * @param int $id Post id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id)
    {
        $post = $this->Posts->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $post = $this->Posts->patchEntity($post, $this->request->getData());
            if ($this->Posts->save($post)) {
                $this->Flash->success(__('The post has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The post could not be saved. Please, try again.'));
        }
        $this->set(compact('post'));
    }

    /**
     * Delete method
     *
     * @param int $id Post id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id)
    {
        $this->request->allowMethod(['post', 'delete']);
        $post = $this->Posts->get($id);
        $deleted = $this->Posts->delete($post);
        if ($deleted) {
            $message = __('The post has been deleted.');
            $status = 'success';
        } else {
            $message = __('The post could not be deleted. Please, try again.');
            $status = 'error';
        }

        if ($this->getRequest()->is('htmx')) {
            $response = [
                'messages' => [
                    ['message' => $message, 'status' => $status],
                ],
                'removeContainer' => true,
            ];

            return $this->getResponse()
                ->withType('json')
                ->withHeader('X-Response-Type', 'json')
                ->withStringBody(json_encode($response));

        } else {
            $this->Flash->{$status}($message);

            return $this->redirect(['action' => 'index']);
        }
    }
}
