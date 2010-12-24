<?php

App::import('Sanitize');

class ProjectsController extends AppController {

    var $name = 'Projects';
    var $publicActions = array('savePrj', 'delPrj');
    var $components = array('TagCloudIteration');

//--------------------------------------------------------------------
//--------------------------------------------------------------------	
    function beforeFilter() {

        //default title
        $this->set('title_for_layout', __('Projects', true));
        //allowed actions
        $this->Auth->allow('index');

        parent::beforeFilter();
        $this->Auth->autoRedirect = false;

        // swiching off Security component for ajax call

        if ($this->RequestHandler->isAjax() && in_array($this->action, $this->publicActions)) {
            $this->Security->validatePost = false;
        }
    }

//--------------------------------------------------------------------
//--------------------------------------------------------------------
//--------------------------------------------------------------------
    //ajax staff
    //----------------------------------------------------------------

    function savePrj() {

        //ajax preparation
        Configure::write('debug', 0);
        $this->autoLayout = false;
        $this->autoRender = false;

        if ($this->RequestHandler->isAjax()) {

            //our host only
            if (strpos(env('HTTP_REFERER'), trim(env('HTTP_HOST'), '/')) === false) {
                $this->Security->blackHoleCallback = 'gotov';
            }

            //main staff
            $authUserId = $this->Auth->user('id');

            if ($authUserId !== null) {

                $this->data['Project']['name'] = trim($this->data['Prj']['name']);
                $this->data['Project']['current'] = time();
                $this->data['Project']['user_id'] = $authUserId;


                if (isset($this->data['Prj']['id']) && (int) $this->data['Prj']['id'] != null) {
                    $prjCheck = $this->Project->find('all', array('conditions' => array('Project.id' => (int) $this->data['Prj']['id'], 'Project.user_id' => $authUserId)));
                    if ($prjCheck != array()) {
                        $this->data['Project']['id'] = (int) $this->data['Prj']['id'];
                    } else {
                        $contents['stat'] = 0;
                        $contents = json_encode($contents);
                        $this->header('Content-Type: application/json');
                        return ($contents);
                    }
                    unset($this->data['Project']['current']);
                }

                $this->data = Sanitize::clean($this->data, array('encode' => true));

                if ($this->Project->save($this->data)) {
                    $contents['stat'] = 1;
                    $contents['prj']['name'] = $this->data['Project']['name'];
                    $contents['prj']['id'] = $this->Project->id;
                } else {
                    $contents['stat'] = 0;
                }
            } else {
                $contents['stat'] = 0;
            }




            $contents = json_encode($contents);
            $this->header('Content-Type: application/json');
            return ($contents);
        } else {
            $this->Security->blackHoleCallback = 'gotov';
        }
    }

    //blackhole redirection
    //-----------------------------
    function gotov() {
        $this->redirect(null, 404, true);
    }

/**
 * setting selected project as a current
 * 
 * @return type json
 */
    function setPrj() {
        Configure::write('debug', 0);
        $this->autoLayout = false;
        $this->autoRender = false;

        $contents['stat'] = 0;

        if ($this->RequestHandler->isAjax()) {
            //our host only
            if (strpos(env('HTTP_REFERER'), trim(env('HTTP_HOST'), '/')) === false) {
                $this->Security->blackHoleCallback = 'gotov';
            }
            $authUserId = $this->Auth->user('id');

            //we selected new prj, so updade the cur time
            unset($this->data);
            if (isset($this->params['named']['prj']) && $this->params['named']['prj'] != null) {

                $curPrjId = $this->data['Project']['id'] = Sanitize::paranoid($this->params['named']['prj'], array('-'));
                $prId = $this->Project->find('first', array('conditions' => array('Project.user_id' => $authUserId, 'Project.id' => $curPrjId), 'contain' => false));
                if ($prId != array()) {
                    $this->data['Project']['current'] = time();
                    if ($this->Project->save($this->data)) {
                        $contents['stat'] = 1;
                        
                        $tagCloud = $this->Project->Item->Tagged->find('cloud', array('conditions' => array('Tag.identifier' => 'prj-' .$curPrjId ), 'limit' => 15, 'contain' => false));
                        $contents['tags'] = $this->TagCloudIteration->iterate($tagCloud);
                         
                    } else {
                        $contents['stat'] = 0;
                    }
                }
            } else {
                $contents['stat'] = 0;
            }


            $contents = json_encode($contents);
            $this->header('Content-Type: application/json');
            return ($contents);
        } else {
            $this->Security->blackHoleCallback = 'gotov';
        }
    }

    function delPrj() {
        //ajax preparation
        Configure::write('debug', 0);
        $this->autoLayout = false;
        $this->autoRender = false;

        if ($this->RequestHandler->isAjax()) {

            //our host only
            if (strpos(env('HTTP_REFERER'), trim(env('HTTP_HOST'), '/')) === false) {
                $this->Security->blackHoleCallback = 'gotov';
            }

            //main staff
            $authUserId = $this->Auth->user('id');

            if ($authUserId !== null) {
                $this->data['Project']['id'] = (int) $this->data['Prj']['id'];
                $this->data['Project']['active'] = 0;
                //$this->data['Project']['user_id'] = $authUserId;							
                $prjToDel = $this->Project->find('first', array('conditions' => array('Project.user_id' => $authUserId, 'Project.id' => $this->data['Project']['id'])));
                if ($prjToDel != array()) {

                    if ($this->Project->save($this->data)) {
                        $contents['stat'] = 1;
                    } else {
                        $contents['stat'] = 0;
                    }
                } else {
                    $contents['stat'] = 0;
                }
            } else {
                $contents['stat'] = 0;
            }


            $contents = json_encode($contents);
            $this->header('Content-Type: application/json');
            return ($contents);
        } else {
            $this->Security->blackHoleCallback = 'gotov';
        }
    }

//--------------------------------------------------------------------
    function index() {
        
    }

//--------------------------------------------------------------------










    function view($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid card', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->set('card', $this->Card->read(null, $id));
    }

    function add() {
        if (!empty($this->data)) {
            $this->Card->create();
            if ($this->Card->save($this->data)) {
                $this->Session->setFlash(__('The card has been saved', true));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The card could not be saved. Please, try again.', true));
            }
        }
        $users = $this->Card->User->find('list');
        $this->set(compact('users'));
    }

    function edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid card', true));
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            if ($this->Card->save($this->data)) {
                $this->Session->setFlash(__('The card has been saved', true));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The card could not be saved. Please, try again.', true));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Card->read(null, $id);
        }
        $users = $this->Card->User->find('list');
        $this->set(compact('users'));
    }

    function delete($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for card', true));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->Card->delete($id)) {
            $this->Session->setFlash(__('Card deleted', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Card was not deleted', true));
        $this->redirect(array('action' => 'index'));
    }

    function admin_index() {
        $this->Card->recursive = 0;
        $this->set('cards', $this->paginate());
    }

    function admin_view($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid card', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->set('card', $this->Card->read(null, $id));
    }

    function admin_add() {
        if (!empty($this->data)) {
            $this->Card->create();
            if ($this->Card->save($this->data)) {
                $this->Session->setFlash(__('The card has been saved', true));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The card could not be saved. Please, try again.', true));
            }
        }
        $users = $this->Card->User->find('list');
        $this->set(compact('users'));
    }

    function admin_edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid card', true));
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            if ($this->Card->save($this->data)) {
                $this->Session->setFlash(__('The card has been saved', true));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The card could not be saved. Please, try again.', true));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Card->read(null, $id);
        }
        $users = $this->Card->User->find('list');
        $this->set(compact('users'));
    }

    function admin_delete($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for card', true));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->Card->delete($id)) {
            $this->Session->setFlash(__('Card deleted', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Card was not deleted', true));
        $this->redirect(array('action' => 'index'));
    }

}

?>
