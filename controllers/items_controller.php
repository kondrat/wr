<?php

App::import('Sanitize');

class ItemsController extends AppController {

    var $name = 'Items';
    var $publicActions = array('saveItem', 'status', 'delItem');
    var $helpers = array('Text', 'Tags.TagCloud');
    var $components = array('TagCloudIteration');


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

//-------------------------------------------------------------------

    /**
     * saving/editing of the items
     * 
     * @return type json
     */
    function saveItem() {

        $auth = false;
        $authUserId = null;
        $curItem = array();
        $contents['stat'] = 1;

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
                
                //getting info about current user's project
                $curPrj = $this->Item->Project->find('first', array('conditions' => array('Project.user_id' => $authUserId), 'order' => array('Project.current' => 'DESC')));
                if ($curPrj !== array()) {
                    $this->data['Item']['project_id'] = $curPrj['Project']['id'];
                } else {
                    $contents['stat'] = 0;
                    $contents = json_encode($contents);
                    $this->header('Content-Type: application/json');
                    return ($contents);
                }

                //if we set id we will update the item. if we set wrong id - finish.
                
                if (isset($tempData['id']) && $tempData['id'] !== "000") {
                    //edit mode
                    
                    $this->data['Item']['id'] = Sanitize::paranoid($tempData['id'], array('-'));

                    $curItem = $this->Item->find('first', array('conditions' => array('Item.id' => $this->data['Item']['id'], 'Item.user_id' => $authUserId, 'Item.active' => 1), 'contain' => false));
                    //status "2" - editing item, not saving a new one.
                    $contents['stat'] = 2;

//                   @todo to del temp solution since tags component doesn't delete the last tag
                    if (isset($tempData['tags']) && $tempData['tags'] == '') {
                        $this->data['Item']['tags'] = '';
                        $taggedItem = $this->Item->Tagged->find('all', array('conditions' => array('Tagged.foreign_key' => $curItem['Item']['id']), 'contain' => false));
                        $taggedItem = Set::extract('/Tagged/id', $taggedItem);
                        $this->Item->Tagged->delete($taggedItem);
                    }


                    //if we havn't found item for provided id we finish
                    if ($curItem == array()) {
                        $contents['stat'] = 0;
                        $contents = json_encode($contents);
                        $this->header('Content-Type: application/json');
                        return ($contents);
                    }
                    
                } 


                $this->data['Item']['user_id'] = $authUserId;


                if (isset($tempData['item'])) {
                    //sanitize and test it here.
                    if ($tempData['item'] == null) {
                        $contents = json_encode($contents);
                        $this->header('Content-Type: application/json');
                        return ($contents);
                    } else {
                        $this->data['Item']['item'] = $tempData['item'];
                    }
                } else {
                    //case when no data item, but we creating new item;
                    if (!isset($this->data['Item']['id'])) {
                        $contents['stat'] = 0;
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
                            $tagsSet[] = 'prj-' . $curPrj['Project']['id'] . ':' . $tag;
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

                $savedId = $this->Item->id;
                $savedData[0] = $this->Item->find('first', array(
                            'conditions' => array('Item.id' => $savedId),
                            'fields' => array('Item.id', 'Item.item', 'Item.status', 'Item.task', 'Item.target', 'Item.created'),
                            'contain' => array('Tag'=>array('conditions'=>array('Tag.identifier' => 'prj-'.$this->data['Item']['project_id'])))
                                )
                );


                $contents['res'] = $this->_iterateItem($savedData);
                if (isset($this->data['Item']['tags'])) {
                    $tagCloud = $this->Item->Tagged->find(
                            'cloud', 
                            array(
                                'conditions' => array('Tag.identifier' => 'prj-'.$this->data['Item']['project_id']),
                                'limit' => 15,
                                'contain' => false
                                )
                            );
                    
                    $contents['tags'] = $this->TagCloudIteration->iterate($tagCloud);
                    
                }
            } else {
                unset($contents);
                $contents['stat'] = 0;
                $contents['dat'] = $this->data;
            }
//            $contents['jn'] = __('Just now 1', true);

            $contents = json_encode($contents);
            $this->header('Content-Type: application/json');
            return ($contents);
        } else {
            $this->Security->blackHoleCallback = 'gotov';
        }
    }

    /**
     * deleting of the item from the list
     * 
     * @return type json
     */
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

                //prev from soft delete. now conceled
                //$this->data['Item']['active'] = 0;

                $idToDel = Sanitize::paranoid($this->data['itId'], array('-'));
                if (isset($idToDel) && $idToDel != null) {

                    $this->data['Item']['id'] = $idToDel;

                    $curItem = $this->Item->find('first', array('conditions' => array('Item.id' => $this->data['Item']['id'], 'Item.user_id' => $authUserId), 'contain' => false));

                    if ($curItem != array()) {

                        if ($this->Item->delete($idToDel)) {
                            $contents['stat'] = 1;
                            $tagCloud = $this->Item->Tagged->find('cloud', array('conditions' => array('Tag.identifier' => 'prj-'.$curItem['Item']['project_id']), 'limit' => 15, 'contain' => false));
                            $contents['tags'] = $this->TagCloudIteration->iterate($tagCloud);
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
    }

    /**
     * blackhole redirection
     * 
     * @return type
     */
    function gotov() {
        $this->redirect(null, 404, true);
    }

    /**
     * @return type
     * 
     */
    function index() {
        $this->set('title_for_layout', __('Main page', true));
        $this->set('menuType', 'index');
        $authUserId = $this->Auth->user('id');
        if ($authUserId) {
            $this->redirect(array('action' => 'todo'));
        }
    }

    /**
     *
     * @return type json
     */
    function todo() {

        $todos = array();
        $authUserId = $this->Auth->user('id');
        $pagItemCond = array();
        $userPrj = array();
        $curPrjId = null;





        if (isset($this->params['named']['prj']) && $this->params['named']['prj'] != null && $this->params['named']['prj'] !== 'all') {

            $curPrjId = $this->data['Project']['id'] = Sanitize::paranoid($this->params['named']['prj'], array('-'));
            //conditions for items pagination.
            $pagItemCond = array('Item.user_id' => $authUserId, 'Item.project_id' => $curPrjId, 'Item.status' =>0, 'Item.active' => 1);
            

        } else if (isset($this->params['named']['prj']) && $this->params['named']['prj'] === 'all') {
            //condition for paginatio all the projects that user has.
            $pagItemCond = array('Item.user_id' => $authUserId, 'Item.active' => 1);
        } else {

            //case when we just entered the page, or we are new user without project yet.
            $userPrj = $this->Item->Project->find('all', array(
                        'conditions' => array('Project.user_id' => $authUserId, 'Project.active' => 1),
                        'fields' => array('id', 'name'),
                        'order' => array('current' => 'DESC'),
                        'contain' => false)
            );
            //check if this user is new, or has current project he whorks on.																		
            if ($userPrj == array()) {
                $this->data['Project']['user_id'] = $authUserId;
                $this->data['Project']['name'] = __('Project 1', true);
                $this->data['Project']['current'] = time();
                $this->Item->Project->save($this->data);
                $userPrj[0] = $this->Item->Project->read();
            }
            $curPrjId = $userPrj[0]['Project']['id'];
            $pagItemCond = array('Item.user_id' => $authUserId, 'Item.project_id' => $curPrjId, 'Item.status' =>0, 'Item.active' => 1);
        }


        $this->paginate['conditions'] = $pagItemCond;
        $this->paginate['fields'] = array('Item.id', 'Item.item', 'Item.status', 'Item.task', 'Item.target', 'Item.created');
        $this->paginate['order'] = array('Item.created' => 'DESC');
        $this->paginate['contain'] = array('Tag'=>array(
            'fields' => array('Tag.name'),
            'order' => array('Tagged.created' => 'ASC'),
            'conditions' => array('Tag.identifier' => 'prj-'.$curPrjId)
        ));
        
//        $this->paginate['contain'] = array(
//            'Tag' => array('fields' => array('Tag.name'),
//                'order' => array('Tagged.created' => 'ASC'),
//                'conditions' => array('Tag.identifier' => 'prj-'.$curPrjId)
//            )
//        );


//        we are asked by universal pagiane query plugin
        if ($this->RequestHandler->isAjax() && isset($this->params['url']['startIndex']) && isset($this->params['url']['nbItemsByPage'])) {


            $this->paginate['limit'] = $this->params['url']['nbItemsByPage'];
            $this->paginate['page'] = $this->params['url']['startIndex'] / $this->params['url']['nbItemsByPage'] + 1;

            Configure::write('debug', 0);
            $this->autoLayout = false;
            $this->autoRender = FALSE;
            $todos = $this->paginate('Item');


            $contents["data"] = $this->_iterateItem($todos);
            $contents["nbTotalItems"] = $this->params["paging"]["Item"]["count"];



            $contents = json_encode($contents);
            $this->header('Content-Type: application/json');
            return ($contents);
            
        } else if ($this->RequestHandler->isAjax()) {
           
//            Configure::write('debug', 0);
//            $this->autoLayout = false;
//            $this->autoRender = FALSE;
//            $todos = $this->paginate('Item');

            $contents["stat"] = 0;
            $contents = json_encode($contents);
            $this->header('Content-Type: application/json');
            return ($contents);
        }





        $this->set('toM', $this->paginate('Item'));
        $this->set('menuType', 'todo');
        $this->set('userPrj', $userPrj);

        $tagCloudOld = //$this->TagCloudIteration->iterate(
                $this->Item->Tagged->find(
                        'cloud', array(
                    'conditions' => array('Tag.identifier' => 'prj-' . $curPrjId),
                    'fields' => 'Tag.*, Tagged.tag_id',
                    'limit' => 15,
                    'contain' => false)
                        //        )
        );
        
        $tagCloudOld = Set::extract($tagCloudOld,'{n}/Tag/id');
        
        $countTest = $this->Item->Tagged->find(
                'all',
                array(
                    'conditions'=>array('Tagged.tag_id' => $tagCloudOld),
                    'fields'=>array('Tag.id, Tag.name, COUNT(*) AS occurrence'),
                    'group' => 'Tag.id'
                )
            );
        
        foreach ($tagCloudOld as $singleTag) {
            
        }
        
        $tagCloud = $this->Item->Tagged->find(
                'cloud',
                array(
                    'conditions' => array('Tag.identifier' => 'prj-' . $curPrjId),
                    'fields'=>'Tag.*, Tagged.tag_id, COUNT(*) AS occurrence',
                    'limit' => 15,
                    'contain' => false
                    )
                );
        $this->set('tags', $tagCloud);
        $this->set('tagsOld', $tagCloudOld);
        $this->set('countTest', $countTest);
    }

    /**
     * iterating throught item data before sending to front end.
     * @param array $items The items we a iterating to prepere output.
     * 
     * @return type array
     * @access private
     */
    private function _iterateItem($items=array()) {

        $itemTypes = Configure::read('itemTypes');
        $itemStatuses = Configure::read('itemStatuses');

        foreach ($items as $k => $todo) {


            $statusClass = "itS0";
            $statusText = "opend";
            if ($itemStatuses) {
                foreach ($itemStatuses as $v) {
                    if ($todo['Item']['status'] == $v['n']) {
                        $statusClass = "itS" . $v['n'];
                        $statusText = $v['t'];
                    }
                }

                unset($items[$k]['Item']['status']);

                $items[$k]['Item']['statusClass'] = $statusClass;
                $items[$k]['Item']['statusText'] = $statusText;
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
                unset($items[$k]['Item']['task']);
                $items[$k]['Item']['typeClass'] = $itemTypeClass;
                $items[$k]['Item']['typeText'] = $itemTypeText;
            }

            $formatedDate = ''; //__('No target',true);
            //importing helpers to prepare date in goode format
            App::import('Helper', 'Time');
            App::import('Helper', 'Timenomin');
            $Timenomin = new TimenominHelper();



            if (!empty($todo["Item"]["target"])) {
                $date = new DateTime($todo["Item"]["target"]);
                $formatedDate = $date->format('d.m.y');
            }
            $items[$k]['Item']['target'] = $formatedDate;

            if (!empty($todo["Item"]["created"])) {
                $items[$k]["Item"]["created"] = $Timenomin->timeAgoInWords($todo["Item"]["created"]);
            }

            unset($items[$k]['Item']['tags']);

            $items[$k] = $this->_itemsTagsUnsetIterate($items[$k]);
        }

        return $items;
    }

    /**
     * 
     * @return type array
     */
    private function _itemsTagsUnsetIterate($res = array()) {
        if (isset($res['Tag'])) {
            foreach ($res['Tag'] as $k => $v) {
                unset($res['Tag'][$k]['created']);
                unset($res['Tag'][$k]['keyname']);
                unset($res['Tag'][$k]['modified']);
                unset($res['Tag'][$k]['Tagged']['created']);
                unset($res['Tag'][$k]['Tagged']['foreign_key']);
                unset($res['Tag'][$k]['Tagged']['language']);
                unset($res['Tag'][$k]['Tagged']['model']);
                unset($res['Tag'][$k]['Tagged']['modified']);
                unset($res['Tag'][$k]['Tagged']['tag_id']);
                unset($res['Tag'][$k]['Tagged']['times_tagged']);
                unset($res['Tag'][$k]['Tagged']['test']);
            }
        }
        return $res;
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
