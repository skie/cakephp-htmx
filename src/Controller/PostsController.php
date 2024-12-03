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
     * View method
     *
     * @param string|null $id Post id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
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
     * @param string|null $id Post id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
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
     * @param string|null $id Post id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
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
