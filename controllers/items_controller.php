<?php

App::import('Sanitize');

class ItemsController extends AppController {

    var $name = 'Items';
    var $publicActions = array('saveItem', 'status', 'delItem');
    var $helpers = array( 'Text', 'Tags.TagCloud');

//--------------------------------------------------------------------
//--------------------------------------------------------------------	
    function beforeFilter() {

        //default title
        $this->set('title_for_layout', __('Items', true));
        //default menuType
        $this->set('menuType', 'todo');
        //allowed actions
        $this->Auth->allow('index', 'view');

        parent::beforeFilter();
        $this->Auth->autoRedirect = false;

        // swiching off Security component for ajax call

        if ($this->RequestHandler->isAjax() && in_array($this->action, $this->publicActions)) {
            $this->Security->validatePost = false;
        }

        $this->disableCache();
    }

//--------------------------------------------------------------------
//--------------------------------------------------------------------
//--------------------------------------------------------------------
    //ajax staff
    //----------------------------------------------------------------

    function saveItem() {

        $auth = false;
        $authUserId = null;
        $curItem = array();
        $contents['stat'] = 0;

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

                $tempData = $this->data;
                unset($this->data);

                //if we set id we will update the item. if we set wrong id - finish.
                if (isset($tempData['id'])) {


                    $this->data['Item']['id'] = Sanitize::paranoid($tempData['id'], array('-'));

                    $curItem = $this->Item->find('first', array('conditions' => array('Item.id' => $this->data['Item']['id'], 'Item.user_id' => $authUserId, 'Item.active' => 1), 'contain' => false));
                    if ($curItem == array()) {
                        $contents['piz'] = 1;
                        $contents = json_encode($contents);
                        $this->header('Content-Type: application/json');
                        return ($contents);
                    }
                }

                $this->data['Item']['user_id'] = $authUserId;


                if (isset($tempData['prj'])) {
                    $this->data['Item']['project_id'] = $tempData['prj'];
                } else {
                    //if no project id specified and aciton is not "update" (no item id) we finish.
                    if (!isset($this->data['Item']['id'])) {
                        $contents = json_encode($contents);
                        $this->header('Content-Type: application/json');
                        return ($contents);
                    } else {
                        $tempData['prj'] = $curItem['Item']['project_id'];
                    }
                }



                if (isset($tempData['item'])) {
                    //sanitize and test it here.
                    if ($tempData['item'] == null) {
                        $contents = json_encode($contents);
                        $this->header('Content-Type: application/json');
                        return ($contents);
                    } else {
                        $this->data['Item']['item'] = $tempData['item'];
//                        $contents['word'] = $this->data["Item"]["item"];
                    }
                } else {
                    //case when no data item, but we creating new item;
                    if (!isset($this->data['Item']['id'])) {
                        $contents = json_encode($contents);
                        $this->header('Content-Type: application/json');
                        return ($contents);
                    }
                }



                if (isset($tempData['task']) && in_array((int) $tempData['task'], array(0, 1, 2, 3), true)) {
                    $this->data['Item']['task'] = (int) $tempData['task'];
//                    $contents['task'] = $this->data["Item"]["task"];
                }


                if (isset($tempData['status']) && in_array((int) $tempData['status'], array(0, 1, 2, 3), true)) {
                    $this->data['Item']['status'] = (int) $tempData['status'];
                }

                //tags data
                if (isset($tempData['tags']) && is_array($tempData['tags'])) {
                    $tagsSet = array();
                    foreach ($tempData['tags'] as $tag) {
                        if (($tag = Sanitize::paranoid($tag, array('-', '_')) ) != '') {
                            $tagsSet[] = 'prj-' . $tempData['prj'] . ':' . $tag;
                        }
                    }
                    if ($tagsSet !== array()) {
                        $this->data['Item']['tags'] = implode(',', $tagsSet);
//                        $contents['tags'] = $tagsSet;
                    }
                }

                if (isset($tempData['target'])) {

                    $nw = (int) $tempData['target'];
                    if ($nw !== 0) {
                        $this->data['Item']['target'] = date('Y-m-d', $nw);
                    } else {
                        $this->data['Item']['target'] = null;
                    }
                }


            }

            $this->data = Sanitize::clean($this->data);

            if ($this->Item->save($this->data)) {
                $contents['stat'] = 1;
                $savedId = $this->Item->id;
                $savedData = $this->Item->find('first',array(
                            'conditions'=>array('Item.id'=>$savedId),
                            'fields'=>array('Item.id','Item.item'),
                            'contain'=>'Tag' 
                            )
                        );
                foreach ($savedData['Tag'] as $k=>$v){
                    unset($savedData['Tag'][$k]['created']);
                    unset($savedData['Tag'][$k]['keyname']);
                    unset($savedData['Tag'][$k]['modified']);
                }
//                unset($contents['Tag']);
                
                
            } else {
                unset($contents);
                $contents['stat'] = 0;
                $contents['dat'] = $this->data;
            }
            $contents['jn'] = __('Just now 1',true);

            $contents = json_encode($contents);
            $this->header('Content-Type: application/json');
            return ($contents);
        } else {
            $this->Security->blackHoleCallback = 'gotov';
        }
    }

    function delItem() {

        $authUserId = null;
        $contents['stat'] = 0;
        $idToDel = null;
        $curItem = array();

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

                $this->data['Item']['active'] = 0;

                $idToDel = $this->data['itId'];
                if (isset($idToDel) && $idToDel != null) {
                    $this->data['Item']['id'] = $idToDel;
                    $curItem = $this->Item->find('first', array('conditions' => array('Item.id' => $this->data['Item']['id'], 'Item.user_id' => $authUserId), 'contain' => false));

                    if ($curItem != array()) {
                        if ($this->Item->save($this->data)) {
                            $contents['stat'] = 1;
                        } else {
                            $contents['stat'] = 0;
                        }
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

    //blackhole redirection
    //-----------------------------
    function gotov() {
        $this->redirect(null, 404, true);
    }

//--------------------------------------------------------------------
    function index() {
        $this->set('title_for_layout', __('Main page', true));
        $this->set('menuType', 'index');
        $authUserId = $this->Auth->user('id');
        if ($authUserId) {
            $this->redirect(array('action' => 'todo'));
        }
    }

//--------------------------------------------------------------------
    function todo() {

        $todos = array();
        $authUserId = $this->Auth->user('id');
        $pagItemCond = array();
        $curPrj = array();
        $curPrjId = null;

        $itemTypes = Configure::read('itemTypes');       
        $itemStatuses = Configure::read('itemStatuses');
        





        if (isset($this->params['named']['prj']) && $this->params['named']['prj'] != null && $this->params['named']['prj'] !== 'all') {

            $curPrjId = $this->data['Project']['id'] = Sanitize::paranoid($this->params['named']['prj'], array('-'));
            //conditions for items pagination.
            $pagItemCond = array('Item.user_id' => $authUserId, 'Item.project_id' => $curPrjId, 'Item.active' => 1);

            //we selected new prj, so updade the cur time
            if (isset($this->params['url']['cur']) && $this->params['url']['cur'] === "1") {
                $prId = $this->Item->Project->find('first', array('conditions' => array('Project.id' => $curPrjId), 'contain' => false));
                if ($prId != array()) {
                    $this->data['Project']['current'] = time();
                    $this->Item->Project->save($this->data);
                }
            }
        } else if (isset($this->params['named']['prj']) && $this->params['named']['prj'] === 'all') {
            //condition for paginatio all the projects that user has.
            $pagItemCond = array('Item.user_id' => $authUserId, 'Item.active' => 1);
        } else {
            //case when we just entered the page, or we are new user without project yet.
            $curPrj = $this->Item->Project->find('all', array(
                        'conditions' => array('Project.user_id' => $authUserId, 'Project.active' => 1),
                        'fields' => array('id', 'name'),
                        'order' => array('current' => 'DESC'),
                        'contain' => false)
            );
            //check if this user is new, or has current project he whorks on.																		
            if ($curPrj == array()) {
                $this->data['Project']['user_id'] = $authUserId;
                $this->data['Project']['name'] = __('Project 1', true);
                $this->data['Project']['current'] = time();
                $this->Item->Project->save($this->data);
                $curPrj[0] = $this->Item->Project->read();
            }
            $curPrjId = $curPrj[0]['Project']['id'];
            $pagItemCond = array('Item.user_id' => $authUserId, 'Item.project_id' => $curPrjId, 'Item.active' => 1);
        }


        $this->paginate['conditions'] = $pagItemCond;
        $this->paginate['order'] = array('Item.created' => 'DESC');
        $this->paginate['limit'] = 12;
        $this->paginate['contain'] = array(
            'Tag' => array('fields' => array('Tag.name'),
                'order' => array('Tagged.created' => 'ASC'),
                'conditions' => array('Tag.identifier' => 'prj-' . $curPrjId)
            )
        );


  

        if ($this->RequestHandler->isAjax() && isset($this->params['url']['startIndex']) && isset($this->params['url']['nbItemsByPage'])) {



//            $this->params["paging"]["Item"]["options"]["page"] = $this->params['url']['startIndex']/$this->params['url']['nbItemsByPage'] + 1;
//            $this->params["named"]["page"] = 3;
            $this->paginate['limit'] = $this->params['url']['nbItemsByPage'];
            $this->paginate['page'] = $this->params['url']['startIndex'] / $this->params['url']['nbItemsByPage'] + 1;

            Configure::write('debug', 0);
            $this->autoLayout = false;
            $this->autoRender = FALSE;
            $todos = $this->paginate('Item');
            //importing helpers to prepare date in goode format
            App::import('Helper', 'Time');
            App::import('Helper', 'Timenomin');
            $Timenomin = new TimenominHelper();

            foreach ($todos as $k => $todo) {

                //$todos[$k]['Item']['nust'] = 'cor';

                $statusClass = "itS0";
                $statusText = "opend";
                if ($itemStatuses) {
                    foreach ($itemStatuses as $v) {
                        if ($todo['Item']['status'] == $v['n']) {
                            $statusClass = "itS" . $v['n'];
                            $statusText = $v['t'];
                        }
                    }

                    unset($todos[$k]['Item']['status']);

                    $todos[$k]['Item']['statusClass'] = $statusClass;
                    $todos[$k]['Item']['statusText'] = $statusText;
                }

                $itemTypeClass = "itT0";
                $itemTypeText = "todo";
                if ($itemTypes) {
                    foreach ($itemTypes as $v) {
                        if ($todo['Item']['task'] == $v['n']) {
                            $itemTypeClass = "itT" . $v['n'];
                            $itemTypeText = $v['t'];
                        }
                    }
                    unset($todos[$k]['Item']['task']);
                    $todos[$k]['Item']['typeClass'] = $itemTypeClass;
                    $todos[$k]['Item']['typeText'] = $itemTypeText;
                }

                $formatedDate = ''; //__('No target',true);
                if (!empty($todo["Item"]["target"])) {
                    $date = new DateTime($todo["Item"]["target"]);
                    $formatedDate = $date->format('d.m.y');
                }
                $todos[$k]['Item']['target'] = $formatedDate;

                if (!empty($todo["Item"]["created"])) {
                    $todos[$k]["Item"]["created"] = $Timenomin->timeAgoInWords($todo["Item"]["created"]);
                }
            }
            $contents["data"] = $todos;
            $contents["nbTotalItems"] = $this->params["paging"]["Item"]["count"];




            $contents = json_encode($contents);
            $this->header('Content-Type: application/json');
            return ($contents);
        }

        $this->set('itemTypes', $itemTypes);
        $this->set('itemStatuses', $itemStatuses);
        $this->set('todos', $this->paginate('Item'));
        $this->set('menuType', 'todo');
        $this->set('curPrj', $curPrj);
        $this->set('tags', $this->Item->Tagged->find('cloud', array('conditions' => array('Tag.identifier' => 'prj-' . $curPrjId), 'limit' => 10, 'contain' => false)));
    }

//--------------------------------------------------------------------
    function diary() {
        
    }

//--------------------------------------------------------------------
    function note() {
        
    }

//--------------------------------------------------------------------










    function view($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid Item', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->set('Item', $this->Item->read(null, $id));
    }

    function add() {
        if (!empty($this->data)) {
            $this->Item->create();
            if ($this->Item->save($this->data)) {
                $this->Session->setFlash(__('The Item has been saved', true));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The Item could not be saved. Please, try again.', true));
            }
        }
        $users = $this->Item->User->find('list');
        $this->set(compact('users'));
    }

    function edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid Item', true));
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            if ($this->Item->save($this->data)) {
                $this->Session->setFlash(__('The Item has been saved', true));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The Item could not be saved. Please, try again.', true));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Item->read(null, $id);
        }
        $users = $this->Item->User->find('list');
        $this->set(compact('users'));
    }

    function delete($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for Item', true));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->Item->delete($id)) {
            $this->Session->setFlash(__('Item deleted', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Item was not deleted', true));
        $this->redirect(array('action' => 'index'));
    }

    function admin_index() {
        $this->Item->recursive = 0;
        $this->set('Items', $this->paginate());
    }

    function admin_view($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid Item', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->set('Item', $this->Item->read(null, $id));
    }

    function admin_add() {
        if (!empty($this->data)) {
            $this->Item->create();
            if ($this->Item->save($this->data)) {
                $this->Session->setFlash(__('The Item has been saved', true));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The Item could not be saved. Please, try again.', true));
            }
        }
        $users = $this->Item->User->find('list');
        $this->set(compact('users'));
    }

    function admin_edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid Item', true));
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            if ($this->Item->save($this->data)) {
                $this->Session->setFlash(__('The Item has been saved', true));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The Item could not be saved. Please, try again.', true));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Item->read(null, $id);
        }
        $users = $this->Item->User->find('list');
        $this->set(compact('users'));
    }

    function admin_delete($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for Item', true));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->Item->delete($id)) {
            $this->Session->setFlash(__('Item deleted', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Item was not deleted', true));
        $this->redirect(array('action' => 'index'));
    }

}

?>
