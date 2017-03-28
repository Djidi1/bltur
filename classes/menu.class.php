<?php

class menuRoot extends module_item {
	public $id;
	public $codename;	
	public $title;
	public $xsl;
	public $nodes;
	
	public function __construct($Params) {	
		parent::__construct();	
		if (isset($Params['id'])) $this->id = $Params['id']; else $this->id = 0;
		if (isset($Params['codename'])) $this->codename = $Params['codename']; else $this->codename = 0;	
		if (isset($Params['title'])) $this->title = $Params['title']; else $this->title = 0;
		if (isset($Params['xsl'])) $this->xsl = $Params['xsl']; else $this->xsl = '';
		
		if (isset($Params['nodes'])) $this->nodes = $Params['nodes']; else $this->nodes = new menuTree();
		
		$this->notInsert['nodes'] = 1;
	}
	
	public function toArray() {
		$Params['id'] = $this->id;
		$Params['title'] = $this->title;
		$Params['codename'] = $this->codename;
		$Params['nodes'] = $this->nodes;
		$Params['xsl'] = $this->xsl;
		return $Params;
	}
	
	/**
	 * Установить выбранный пункт, по QueryString
	 * @param $QS - QueryString
	 * @return boolean
	 */
	public function setActiveBySQ($QS) {
		$res = false;
		if ($this->nodes->count() > 0) {
			$i = $this->nodes->getIterator();
			foreach($i as $node) {
				if(strpos($node->queryString, $SQ) !== false) {
					$node->isActive = true;
					$res = true;
				}
			}
		}
		return $res;
	}
	/**
	 * Установить выбранный пункт, по модулю
	 * @param $modName
	 * @return boolean
	 */
	public function setActiveByModule($modName) {
		$res = false;
		if ($this->nodes->count() > 0) {
			$i = $this->nodes->getIterator();
			foreach($i as $node) {
				if($node->module == $modName) {
					$node->isActive = true;
					$res = true;
				}
			}
		}
		return $res;
	}	
	/**
	 * Установить выбранный пункт, по codename
	 * @param $codename
	 * @return boolean
	 */
	public function setActiveByCodename($codename) {
		$res = false;
		if ($this->nodes->count() > 0) {
			$i = $this->nodes->getIterator();
			foreach($i as $node) {
				if($node->codename == $codename) {
					$node->isActive = true;
					$res = true;
				}
			}
		}
		return $res;
	}	
	/**
	 * Установить выбранный пункт, по ID
	 * @param $codename
	 * @return boolean
	 */
	public function setActiveById($id) {
		$res = false;
		if ($this->nodes->count() > 0) {
			$i = $this->nodes->getIterator();
			foreach($i as $node) {
				if($node->id == $id) {
					$node->isActive = true;
					$res = true;
				}
			}
		}
		return $res;
	}	
}

class menuRootCollection extends module_collection {
	public function __construct() {
		parent::__construct();
	}
	public function addItem($Params) {
		$item = new menuRoot($Params);
		$this->add($item);
	}
}

class menuItem extends module_item {
	public $id;
	/**
	 * ID of Root Element
	 * @var integer 
	 */
	public $root_id;	
	/**
	 * Пункт меню
	 * @var string
	 */
	public $title;
	/**
	 * Уникальное имя
	 */
	public $codename;
	/**
	 * Модуль - codename
	 * @var string
	 */
	public $module;
	/**
	 * Запрос для формирования ссылки, после вставки модуля
	 * @var string
	 */
	public $queryString;
	/**
	 * Предок
	 * @var unknown_type
	 */
	public $parent;
	/**
	 * Стиль CSS
	 * @var string
	 */
	public $style;
	/**
	 * Приоритет сортировки
	 * @var integer
	 */
	public $position;
	/******************/
	/**
	 * Выделенный пункт
	 * @var unknown_type
	 */
	public $isActive;
	/**
	 * Ссылка на предка
	 * @var link
	 */
	public $parentLink;
	public $childs;
	public $rootName;
		
	public function __construct($Params) {		
		parent::__construct();
		if (isset($Params['id'])) $this->id = $Params['id']; else $this->id = 0;
		if (isset($Params['root_id'])) $this->root_id = $Params['root_id']; else $this->root_id = 0;
		if (isset($Params['title'])) $this->title = $Params['title']; else $this->title = 0;
		if (isset($Params['codename'])) $this->codename = $Params['codename']; else $this->codename = 0;
		if (isset($Params['module'])) $this->module = $Params['module']; else $this->module = 0;
		if (isset($Params['queryString'])) $this->queryString = $Params['queryString']; else $this->queryString = 0;
		if (isset($Params['parent'])) $this->parent = $Params['parent']; else $this->parent = 0;
		if (isset($Params['style'])) $this->style = $Params['style']; else $this->style = 0;
		if (isset($Params['position'])) $this->position = $Params['position']; else $this->position = 0;
		if (isset($Params['isActive'])) $this->isActive = $Params['isActive']; else $this->isActive = 0;
		if (isset($Params['parentLink'])) $this->parentLink = $Params['parentLink']; else $this->parentLink = NULL;	
		if (isset($Params['childs'])) $this->childs = $Params['childs']; else $this->childs = array();	
		
		$this->notInsert['isActive'] = 1;	
		$this->notInsert['parentLink'] = 1;	
		$this->notInsert['childs'] = 1;	
		$this->notInsert['rootName'] = 'unknown';	
	}
	
	public function toArray() {
		$Params['id'] = $this->id;
		$Params['root_id'] = $this->root_id;
		$Params['title'] = $this->title;
		$Params['codename'] = $this->codename;
		$Params['module'] = $this->module;
		$Params['queryString'] = $this->queryString;
		$Params['parent'] = $this->parent;
		$Params['style'] = $this->style;
		$Params['position'] = $this->position;
		$Params['isActive'] = $this->isActive;
		$Params['parentLink'] = $this->parentLink;		
		$Params['childs'] = $this->childs;		
		$Params['rootName'] = $this->rootName;				
		return $Params;	
	}
	public function hasChild() {
		if (count($this->childs) > 0) return true;
		else return false;
	}	
}

class menuTree extends module_collection {
  public function __construct () {
    parent::__construct();
  }

  public function addItem($params) {
    $item = new menuItem($params);
    $this->add($item);
    if ($item->parent != 0) {
    	if ($this->offsetExists($item->parent)) {
    		$item->parentLink = $this->offsetGet($item->parent);
    		$item->parentLink->childs[] = $item;
    	} else {
    		
    	}
    }
    return true;
  }
}

class menuModel extends module_model {
	private $modAssign;
	private $essenceID;
	
	public function __construct($modAssing, $essenceID) {
		$this->modAssign = $modAssing;
		$this->essenceID = $essenceID;
		$modName = 'menu';
		parent::__construct($modName);	
	}
	/**
	 * 
	 * @param menuItem $item
	 * @return boolean
	 */
	public function addNode(menuItem $item) {
		if($item->root_id == 0) return false;
		list($i,$v,$p) = $item->toInsert();
		$sql = 'INSERT INTO '.TAB_PREF.'menu_nodes ('.$i.') VALUES ('.$v.')';		    
	    $q = array_merge(array(0=>$sql),$p);
	    $this->query($q);
	    $id = $this->insertID();	
	    $item->id = $id;
	    if ($id > 0) return true;
	    else return false;
	}	
	
	public function delNode(menuItem $item) {
		if($item->id == 0) return false;
		/*
		 * Выбираем все связи с Пунктом. Переносим. Удаляем пункт
		 */
		$sql = 'SELECT * FROM '.TAB_PREF.'menu_nodes WHERE id = %1$u OR `parent` = %1$u';
		$this->query($sql, $item->id);
		$tree = new menuTree();
		while($row = $this->fetchRowA()) {
			$tree->addItem($row);
		}
		$mItem = $tree->get($item->id);
		if ($mItem->hasChild()) {
			foreach ($mItem->childs as $child) {
				$child->parent = $mItem->parent;
				$this->updateNode($child);
			}
		}
		$sql = 'DELETE FROM '.TAB_PREF.'menu_nodes WHERE id=%1$u';
		$this->query($sql,$item->id);
		
		$pFile = new fileProcess($this->modSet->defModName, $item->id);
		$pFile->update('delfile', $item->id);
		
		unset($tree);		
		return true;		
	}
	
	public function updateNode(menuItem $item) {
		if($item->id == 0) return false;
		$Params = $item->toArray();
		$sql = 'UPDATE '.TAB_PREF.'menu_nodes 
				SET `root_id` = \'%2$s\', `title` = \'%3$s\', `codename` = \'%4$s\', `module` = \'%5$s\', 
					`queryString` = \'%6$s\', `parent` = \'%7$s\', `style` = \'%8$s\', `position` = \'%9$s\'
				WHERE id = %1$u';
		$this->query($sql, $Params['id'], $Params['root_id'], $Params['title'], $Params['codename'], $Params['module'], $Params['queryString'], $Params['parent'], $Params['style'], $Params['position']);
		$pFile = new fileProcess($this->modSet->defModName, $item->id);
		$pFile->update('update');
		return true;	
	}
	
	public function getNode($id) {
		if($id == 0) return false;
		$sql = 'SELECT mn.* 
				FROM '.TAB_PREF.'menu_nodes mn 				 
				WHERE mn.id = %1$u';
		$this->query($sql, $id);
		$row = $this->fetchOneRowA();
		$item = new menuItem($row);
		return $item;		
	}
	
	public function addRoot(menuRoot $item) {
		//if($item->id == 0) return false;
		list($i,$v,$p) = $item->toInsert();
		$sql = 'INSERT INTO '.TAB_PREF.'menu_root ('.$i.') VALUES ('.$v.')';		    
	    $q = array_merge(array(0=>$sql),$p);
	    $this->query($q);
	    $id = $this->insertID();	
	    $item->id = $id;
	    if ($id > 0) return true;
	    else return false;
	}
	
	public function getMenu($rootCodename) {
		$sql = 'SELECT mr.id as mrid, mr.codename as mrcodename, mr.title as mrtitle, mr.xsl as mrxsl,
				mn.*
				FROM '.TAB_PREF.'menu_root mr
				LEFT JOIN '.TAB_PREF.'menu_nodes mn  ON mr.id = mn.root_id 
				WHERE mr.codename = \'%1$s\'
				ORDER BY mn.position DESC';
		$this->query($sql,$rootCodename);
		$a = true;
		$menu = new menuRoot(array());
		$tree = new menuTree(array());
		$menu->nodes = $tree;		
		while($row = $this->fetchRowA()) {
			if($a) {
				$menu->id = $row['mrid'];
				$menu->codename = $row['mrcodename'];
				$menu->title = $row['mrtitle'];
				$menu->xsl = $row['mrxsl'];
				$a = false;
			}
			$tree->addItem($row);
		}
		return $menu;
	}
	
	public function getMenuByID($root_id) {
		if(!$root_id) return false;
		$sql = 'SELECT mr.id as mrid, mr.codename as mrcodename, mr.title as mrtitle, mr.xsl as mrxsl, 
				mn.*
				FROM '.TAB_PREF.'menu_root mr
				LEFT JOIN '.TAB_PREF.'menu_nodes mn  ON mr.id = mn.root_id
				WHERE mr.id = %1$u ORDER BY mr.id, mn.position DESC';
		$this->query($sql,$root_id);
		$a = true;
		$menu = new menuRoot(array());
		$tree = new menuTree(array());
		$menu->nodes = $tree;		
		while($row = $this->fetchRowA()) {
			if($a) {
				$menu->id = $row['mrid'];
				$menu->codename = $row['mrcodename'];
				$menu->title = $row['mrtitle'];
				$menu->xsl = $row['mrxsl'];
				$a = false;
			}
			$tree->addItem($row);
		}
		return $menu;
	}	
	
	public function getAllMenu() {
		$sql = 'SELECT mr.id as mrid, mr.codename as mrcodename, mr.title as mrtitle, mr.xsl as mrxsl, 
				mn.*
				FROM '.TAB_PREF.'menu_root mr
				LEFT JOIN '.TAB_PREF.'menu_nodes mn  ON mr.id = mn.root_id ORDER BY mr.id, mn.position DESC';
		$this->query($sql);
		$a = true;
		
		$allMenu = new menuRootCollection();
			
		$lastMenu = 0;	
		while($row = $this->fetchRowA()) {
			if ($lastMenu != $row['mrid']) {
				$menu = new menuRoot(array());
				$tree = new menuTree(array());								
				$menu->id = $row['mrid'];
				$menu->codename = $row['mrcodename'];
				$menu->title = $row['mrtitle'];
				$menu->xsl = $row['mrxsl'];
				$menu->nodes = $tree;		
				$allMenu->add($menu);		
				$lastMenu = $row['mrid'];
			}
			$tree->addItem($row);
		}
		return $allMenu;
	}
	
	public function delRoot($id) {
		if($id == 0) return false;
		$sql = 'DELETE FROM '.TAB_PREF.'menu_nodes WHERE root_id = %1$u';
		$this->query($sql, $id);
		$sql = 'DELETE FROM '.TAB_PREF.'menu_root WHERE id = %1$u';
		$this->query($sql, $id);
	}
}

class menuProcess extends module_process {

  public function __construct ($modName) {
    parent::__construct($modName);

    $this->nModel = new menuModel($modName, 0);
    $this->nView = new menuView($this->modName,$this->sysMod);

    /* Default Process Class actions */
    $this->regAction('newnode', 'New node', ACTION_GROUP);
    $this->regAction('addnode', 'Add node', ACTION_GROUP);
    $this->regAction('editnode', 'Edit node', ACTION_GROUP);
    $this->regAction('updatenode', 'Update node', ACTION_GROUP);
    $this->regAction('viewmenu', 'View Menu', ACTION_PUBLIC);
    $this->regAction('delnode', 'Del node', ACTION_GROUP);

    $this->regAction('newroot', 'New menu', ACTION_GROUP);
    $this->regAction('addroot', 'Add menu', ACTION_GROUP);
    $this->regAction('editroot', 'Edit menu', ACTION_GROUP);
    $this->regAction('updateroot', 'Update menu', ACTION_GROUP);
    $this->regAction('viewroot', 'View menu', ACTION_GROUP);
    $this->regAction('delroot', 'Del menu', ACTION_GROUP);
    $this->regAction('viewadm', 'системное меню', ACTION_GROUP);
    $this->registerActions();
  }

  public function update($_action = false) {
    $this->updated = false;
    $this->Log->addToLog('Меню', __LINE__, __METHOD__);

    if ($_action) $this->action = $_action;
    $action = $this->actionDefault;
//stop($action,0);
    if ($this->action) $action = $this->action;
    else $action = $this->checkAction();
//stop($action,0);  	
    if (!$action) {
    	$this->Vals->URLparams($this->sysMod->defQueryString);    
    	$action = $this->actionDefault;
    }
//stop($action,0);    
    $user_id = $this->User->getUserID();
    $user_right = $this->User->getRight($this->modName, $action);

    if ($user_right == 0) {
    	$p = array('У Вас нет прав для исмользования модуля', 'user_id'=>$user_id, 'user_right'=>$user_right);
    	//$this->nView->viewError($p);
    	$this->nView->viewLogin($p[0], $user_id);
    	$this->Log->addError($p, __LINE__, __METHOD__);
    	$this->updated = true;
    	return;
    }
    /**
     * ******************************************************************************************************
     */
    if ($action == 'addroot') {
    	$Params['codename'] = $this->vals->getVal('codename', 'POST', 'string');
    	$Params['title'] = $this->vals->getVal('title', 'POST', 'string');
    	$Params['xsl'] = $this->vals->getVal('xsl', 'POST', 'string');
    	$menu = new menuRoot($Params);
    	if($this->nModel->addRoot($menu)) {
    		$this->nView->viewMessage('Ветка Добавлена', 'Сообщение');
    	} else {
    		$this->nView->viewError('Ошибка добавления', 'Сообщение');
    	}    	
    	$Params = array();
    	$Params['root_id'] = $menu->id;
		$Params['title'] = $this->vals->getVal('nodetitle', 'POST', 'string');;
		$Params['codename'] = $this->vals->getVal('nodecodename', 'POST', 'string');;
		$Params['module'] = $this->vals->getVal('nodemodule', 'POST', 'string');;
		$Params['queryString'] = $this->vals->getVal('nodequeryString', 'POST', 'string');;
		$Params['parent'] = $this->vals->getVal('nodeparent', 'POST', 'integer');;
		$Params['style'] = $this->vals->getVal('nodestyle', 'POST', 'string');;
    	$menuNode = new menuItem($Params);
    	if($this->nModel->addNode($menuNode)) {
    		$this->nView->viewMessage('Пункт добавлен', 'Сообщение');
    	} else {
    		$this->nView->viewError('Ошибка добавления', 'Сообщение');
    	}    	
    	$this->updated = true;
    	$action = 'viewadm';
    	$this->Vals->setValTo('viewadm', 1, 'GET');
    }
    
    if ($action == 'updateroot') {
    	$Params['id'] = $this->vals->getVal('id', 'POST', 'integer');
    	$Params['codename'] = $this->vals->getVal('codename', 'POST', 'string');
    	$Params['title'] = $this->vals->getVal('title', 'POST', 'string');
    	$Params['xsl'] = $this->vals->getVal('xsl', 'POST', 'string');
    	$menu = new menuRoot($Params);
    	if($this->nModel->updateRoot($menu)) {
    		$this->nView->viewMessage('Изменение прошло успешно', 'Сообщение');
    	} else {
    		$this->nView->viewError('Ошибка изменения', 'Сообщение');
    	}
    	$Params['root_id'] = $this->vals->getVal('noderoot_id', 'POST', 'integer');;
		$Params['title'] = $this->vals->getVal('nodetitle', 'POST', 'string');;
		$Params['codename'] = $this->vals->getVal('nodecodename', 'POST', 'string');;
		$Params['module'] = $this->vals->getVal('nodemodule', 'POST', 'string');;
		$Params['queryString'] = $this->vals->getVal('nodequeryString', 'POST', 'string');;
		$Params['parent'] = $this->vals->getVal('nodeparent', 'POST', 'integer');;
		$Params['style'] = $this->vals->getVal('nodestyle', 'POST', 'string');;
    	$menuNode = new menuItem($Params);
    	if($this->nModel->addNode($menuNode)) {
    		$this->nView->viewMessage('Пункт добавлен', 'Сообщение');
    	} else {
    		$this->nView->viewError('Ошибка добавления', 'Сообщение');
    	}    	
    	
    	$this->updated = true;
    	
    }
    if ($action == 'delroot') {
    	$Params['id'] = $this->vals->getVal('id', 'POST', 'integer');
    	$this->nModel->delRoot($Params['id']);
    	$this->nView->viewMessage('Удаление прошло успешно', 'Сообщение');
    	$action = 'viewadm';
    	$this->Vals->setValTo('viewadm', 1, 'GET');
    }
    
    if ($action == 'addnode') {    	
		$Params['root_id'] = $this->vals->getVal('root_id', 'POST', 'integer');;
		$Params['title'] = $this->vals->getVal('title', 'POST', 'string');;
		$Params['codename'] = $this->vals->getVal('codename', 'POST', 'string');;
		$Params['module'] = $this->vals->getVal('module', 'POST', 'string');;
		$Params['queryString'] = $this->vals->getVal('queryString', 'POST', 'string');;
		$Params['parent'] = $this->vals->getVal('parent', 'POST', 'integer');;
		$Params['style'] = $this->vals->getVal('style', 'POST', 'string');;
		$Params['position'] = $this->vals->getVal('position', 'POST', 'integer');;
    	$menuNode = new menuItem($Params);
    	if($this->nModel->addNode($menuNode)) {
    		$this->nView->viewMessage('Добавлено', 'Сообщение');
    	} else {
    		$this->nView->viewError('Ошибка добавления', 'Сообщение');
    	}
    	$this->updated = true;
    	$this->Vals->setValTo('node_id', $menuNode->id, 'GET');
    	$this->Vals->getVal('root_id',$menuNode->root_id,'GET');
    	$action = 'viewadm';
    	$this->Vals->setValTo('viewadm', 1, 'GET');
    }    
    
    if ($action == 'updatenode') {
    	$Params['id'] = $this->vals->getVal('node_id', 'POST', 'integer');;
    	$Params['root_id'] = $this->vals->getVal('root_id', 'POST', 'integer');;
		$Params['title'] = $this->vals->getVal('title', 'POST', 'string');;
		$Params['codename'] = $this->vals->getVal('codename', 'POST', 'string');;
		$Params['module'] = $this->vals->getVal('module', 'POST', 'string');;
		$Params['queryString'] = $this->vals->getVal('queryString', 'POST', 'string');;
		$Params['parent'] = $this->vals->getVal('parent', 'POST', 'integer');;
		$Params['style'] = $this->vals->getVal('style', 'POST', 'string');;
		$Params['position'] = $this->vals->getVal('position', 'POST', 'integer');;
    	$menuNode = new menuItem($Params);
    	if($this->nModel->updateNode($menuNode)) {
    		$this->nView->viewMessage('Изменено', 'Сообщение');
    	} else {
    		$this->nView->viewError('Ошибка изменения', 'Сообщение');
    	}
    	$this->updated = true;
    	$this->Vals->setValTo('node_id', $menuNode->id, 'GET');
    	$this->Vals->getVal('root_id',$menuNode->root_id,'GET');
    	$action = 'viewadm';
    	$this->Vals->setValTo('viewadm', 1, 'GET');
    }
    if ($action == 'delnode') {
    	$Params['id'] = $this->vals->getVal('node_id', 'GET', 'integer');    	
    	$menuNode = $this->nModel->getNode($Params['id']);
    	if($this->nModel->delNode($menuNode)) {
    		$this->nView->viewMessage('Удалено', 'Сообщение');
    	} else {
    		$this->nView->viewError('Ошибка удаления', 'Сообщение');
    	}
    	$this->updated = true;
    	$action = 'viewadm';
    	$this->Vals->setValTo('viewadm', 1, 'GET');
    }
    
    if ($action == 'newnode') {
    	$root_id = $this->Vals->getVal('root_id','GET','integer');
    	$menu = $this->nModel->getMenuByID($root_id);
    	$this->nView->viewNewNode($menu);
    	$this->updated = true;
    }
    
    if ($action == 'editnode') { 
    	$node_id = $this->vals->getVal('node_id', 'GET', 'integer');
    	$root_id = $this->Vals->getVal('root_id','GET','integer');
    	$menu = $this->nModel->getMenuByID($root_id);    	
    	$menuNode = $this->nModel->getNode($node_id);
    	if ($menuNode->id != 0 && $menu->id != 0) {
    		$this->nView->viewEditNode($menuNode, $menu);
    		$this->updated = true;
    	} else {
    		$this->nView->viewError('Ветка не найдена',0);
    	}
    }
    
    if ($action == 'viewmenu') {
    	$root_codename = $this->Vals->getModuleVal($this->modName,'menu','string');
    	if (!$root_codename) $root_codename = $this->Vals->getVal('menu','GET','string');
    	
    	if($root_codename != '') {
    		$menu = $this->nModel->getMenu($root_codename);
    		if ($menu->id > 0) {
    			$mi = $this->Vals->getVal('mi','GET','integer');
    			$menu->setActiveById($mi);
    	  		$this->nView->viewMenu($menu);
    	  		$this->updated = true;
    		} else $this->nView->viewError('Пустое меню',0);
    	}
    }    
  
    if ($action == 'newroot') { 
    	$Params['codename'] = $this->vals->getVal('codename', 'POST', 'string');
    	$Params['title'] = $this->vals->getVal('title', 'POST', 'string');
    	$Params['xsl'] = $this->vals->getVal('xsl', 'POST', 'string');
    	$menu = new menuRoot($Params);
    	$this->nView->viewNewRoot($menu);
    	$this->updated = true;    	
    }
    
    if ($action == 'editroot') {    	
    	$root_id = $this->Vals->getVal('menu','GET','integer');
    	$menu = $this->nModel->getMenuByID($root_id);
    	if ($menu->id > 0) {
    		$this->nView->viewEditRoot($menu);
    	} else $this->nView->viewError('Меню не найдено', __LINE__, __METHOD__);
    	$this->updated = true;
    }
    if ($action == 'viewadm') {
    	$allMenu = $this->nModel->getAllMenu();
    	$this->nView->viewADMMenu($allMenu);
    	$this->updated = true;
    }
    
    if ($action == 'viewroot') { }
    
  }
}	

class menuView extends module_view {
	public function __construct($modName, $sysMod) {
		parent::__construct($modName,$sysMod);
	}
	
	public function viewNewRoot(menuRoot $item) {
      $this->pXSL[] = RIVC_ROOT.'layout/form.xsl';
      $Container = $this->newContainer('form');

      $form = new CFormGenerator($this->modName, SITE_ROOT.$this->modName.'/addroot-1/', 'POST', 0);
      $form->addHidden('add', '1', 'addroot');
      $form->addText('title', '','Название', 'name', '', 30);
      $form->addText('codename', '','Уникальное имя', 'name', '', 30);
      $form->addText('xsl', '','XSL', 'name', '', 30);
      $form->addSubmit('submit', 'создать', '', '');
      
      $form->addMessage('Добавить пункт', 'Добавить пункт', '');
      $form->addHidden('root_id', $item->id, 'root_id');
      $form->addText('nodetitle', '','Название', 'name', '', 30);
      $form->addText('nodecodename', '','Уникальное имя', 'name', '', 30);
      $form->addText('nodexsl', '','XSL', 'name', '', 30);
      $form->addText('nodemodule', '','Модуль для перехода', 'name', '', 30);
      $form->addText('nodequeryString', '','Параметры для перехода', 'name', '', 30);
      $form->addText('nodeparent', 0,'Родительская нода', 'name', '', 30);
      $form->addText('nodestyle', '','CSS класс', 'name', '', 30);
      
      $form->getBody($Container,'xml');

      return $form;
    }
    
	public function viewEditRoot(menuRoot $item) {
      $this->pXSL[] = RIVC_ROOT.'layout/form.xsl';
      $Container = $this->newContainer('form');

      $form = new CFormGenerator($this->modName, SITE_ROOT.$this->modName.'/addroot-1/', 'POST', 0);
      $form->addHidden('addroot', $item->id, 'addroot');
      $form->addText('title', $item->title,'Название', 'name', '', 30);
      $form->addText('codename', $item->codename,'Уникальное имя', 'name', '', 30);
      $form->addText('xsl', $item->xsl,'XSL', 'name', '', 30);            
      
      $form->addMessage('Добавить пункт', 'Добавить пункт', '');
      $form->addHidden('root_id', $item->id, 'root_id');
      $form->addText('nodetitle', '','Название', 'name', '', 30);
      $form->addText('nodecodename', '','Уникальное имя', 'name', '', 30);
      $form->addText('nodexsl', '','XSL', 'name', '', 30);
      $form->addText('nodemodule', '','Модуль для перехода', 'name', '', 30);
      $form->addText('nodequeryString', '','Параметры для перехода', 'name', '', 30);
      $form->addText('nodeparent', 0,'Родительская нода', 'name', '', 30);
      $form->addText('nodestyle', '','CSS класс', 'name', '', 30);
      
      $form->addSubmit('submit', 'создать', '', '');
      $form->getBody($Container,'xml');

      $this->pXSL[] = RIVC_ROOT.'layout/'.$item->xsl;
      $this->Log->addToLog(array('XSL'=>$item->xsl),__LINE__,__METHOD__);
      $Container = $this->newContainer('edit_menu');
      $Iterator = $item->nodes->getIterator();
       
      $items = $this->xml->createElement('items', '');
      $Container->appendChild($items);
      foreach ($Iterator as $menuItem) {

      	$this->rMenu($menuItem, $items, 'menuadminitem');
      }
      
      return $form;
    }
    
public function viewEditNode(menuItem $item, menuRoot $menu) {
      $this->pXSL[] = RIVC_ROOT.'layout/form.xsl';
      $Container = $this->newContainer('form');

      $form = new CFormGenerator($this->modName, SITE_ROOT.$this->modName.'/updatenode-1/', 'POST', 0);
      $form->addHidden('updatenode', $item->id, 'update');
      $form->addHidden('node_id', $item->id, 'node');      
      $form->addHidden('root_id', $item->root_id, 'root_id');
      $form->addMessage('msg','Меню: '.$menu->title, '');
      $form->addText('title', $item->title,'Название', 'name', '', 30);
      $form->addText('codename', $item->codename,'Уникальное имя', 'name', '', 30);
//      $form->addText('xsl', $item->xsl,'XSL', 'name', '', 30);
      $form->addText('module', $item->module, 'Модуль для перехода', 'name', '', 30);
      $form->addText('queryString',$item->queryString,'Параметры для перехода', 'name', '', 30);
      $form->addText('parent', $item->parent,'Родительская нода', 'name', '', 30);
      $form->addText('style', $item->style,'CSS класс', 'name', '', 30);
      $form->addText('position', $item->position,'Сортировка', 'position', '', 30);
      /*
      $pFile = new fileProcess('menu', $item->id);в
      $fileInputs = $pFile->update('edit');
      
      */
      
      $pFile = new fileProcess('menu',$item->id);
      $fileInputsColl = new fileInputColl();
      $pFI = array();
      $pFI['inputName'] = 'menuItem';
      $pFI['label'] = 'Картинка пункта';            
      $pFI['isDescr'] = 1;            
      $fileInputsColl->addItem($pFI);
      $pFI = array();
      $pFI['inputName'] = 'pageBG';
      $pFI['label'] = 'Картинка страницы';            
      $fileInputsColl->addItem($pFI);
      $pFile->fileInputs = $fileInputsColl;
      $fileInputs = $pFile->update('editfi');
      $form->addInputs($fileInputs);
      
      $form->addSubmit('submit', 'сохранить', '', '');
      $form->getBody($Container,'xml');
      
      $this->pXSL[] = RIVC_ROOT.'layout/'.$menu->xsl;
      $this->Log->addToLog(array('XSL'=>$menu->xsl),__LINE__,__METHOD__);
      /*
      $Container = $this->newContainer('edit_menu');
      $Iterator = $menu->nodes->getIterator();       
      $items = $this->xml->createElement('items', '');
      $Container->appendChild($items);
      foreach ($Iterator as $menuItem) {
      	$this->rMenu($menuItem, $items, 'menuadminitem');
      }
      */
      
      
      
      
      return $form;
    }
       
    public function viewADMMenu(menuRootCollection $allMenu) {
    	$this->pXSL[] = RIVC_ROOT.'layout/menu.xsl';
      	//$this->Log->addToLog(array('XSL'=>$menu->xsl),__LINE__,__METHOD__);	
      	
      	foreach ($allMenu as $menu) {
      		$Container = $this->newContainer('edit_menu');
      		$Iterator = $menu->nodes->getIterator();      		 
      		$items = $this->xml->createElement('items', '');
      		$this->addAttr('menutitle',$menu->title,$items);
      		$this->addAttr('menuCodename',$menu->codename,$items);
      		$this->addAttr('id',$menu->id,$items);
      		$Container->appendChild($items);
      		foreach ($Iterator as $menuItem) {
      			$this->rMenu($menuItem, $items, 'menuadminitem');
      		}
      	}
    }
    
	public function viewNewNode(menuRoot $menu) {
      $this->pXSL[] = RIVC_ROOT.'layout/form.xsl';
      $Container = $this->newContainer('form');
/*
 $Params['root_id'] = $this->vals->getVal('root_id', 'POST', 'integer');;
		$Params['title'] = $this->vals->getVal('title', 'POST', 'string');;
		$Params['codename'] = $this->vals->getVal('codename', 'POST', 'string');;
		$Params['module'] = $this->vals->getVal('module', 'POST', 'string');;
		$Params['queryString'] = $this->vals->getVal('queryString', 'POST', 'string');;
		$Params['parent'] = $this->vals->getVal('parent', 'POST', 'integer');;
		$Params['style'] = $this->vals->getVal('style', 'POST', 'string');
 */
      $form = new CFormGenerator($this->modName, SITE_ROOT.$this->modName.'/addnode-1/', 'POST', 0);
      $form->addHidden('root_id', $menu->id, 'root_id');
      $form->addMessage('',$menu->title,'');
      $form->addText('title', '','Название', 'name', '', 30);
      $form->addText('codename', '','Уникальное имя', 'name', '', 30);
      $form->addText('xsl', '','XSL', 'name', '', 30);
      $form->addText('module', '','Модуль для перехода', 'name', '', 30);
      $form->addText('queryString', '','Параметры для перехода', 'name', '', 30);
      $form->addText('parent', 0,'Родительская нода', 'name', '', 30);
      $form->addText('style', '','CSS класс', 'name', '', 30);
      $form->addText('position', '','Сортировка', 'position', '', 30);

      $pFile = new fileProcess('menu');
      $fileInputsColl = new fileInputColl();
      $pFI = array();
      $pFI['inputName'] = 'menuItem';
      $pFI['label'] = 'Картинка пункта';            
      $pFI['isDescr'] = 1;            
      $fileInputsColl->addItem($pFI);
      $pFI = array();
      $pFI['inputName'] = 'pageBG';
      $pFI['label'] = 'Картинка страницы';            
      $fileInputsColl->addItem($pFI);
      $pFile->fileInputs = $fileInputsColl;
      $fileInputs = $pFile->update('newfi');
      $form->addInputs($fileInputs);
      
      $form->addSubmit('submit', 'создать', '', '');
      $form->getBody($Container,'xml');

      return $form;
    }    
    
    private function rMenu(menuItem $menuItem, DOMElement $Container, $conName = 'menuitem') {
    	$p = $menuItem->toArray();
    	$item = $this->addToNode($Container,$conName,'');
    	$this->addToNode($item,'id',$p['id']);
    	$this->addToNode($item,'root_id',$p['root_id']);
    	$this->addToNode($item,'title',$p['title']);
    	$this->addToNode($item,'codename',$p['codename']);
    	$this->addToNode($item,'module',$p['module']);
    	$this->addToNode($item,'queryString',$p['queryString']);
    	$this->addToNode($item,'parent',$p['parent']);
    	$this->addToNode($item,'style',$p['style']);
    	$this->addToNode($item,'isActive',intval($p['isActive']));
    	if ($menuItem->hasChild()) {
    		$subContainer = $this->addToNode($item ,'items','');
    		foreach ($menuItem->childs as $subItem) {
    			$this->rMenu($subItem, $subContainer, $conName);		
    		}
    	}
    	return $item;
    }
    
    public function viewMenu(menuRoot $menu) {
    	$this->pXSL[] = RIVC_ROOT.'layout/menu.xsl';
    	$this->Log->addToLog(array('XSL'=>$menu->xsl),__LINE__,__METHOD__);
      	$Container = $this->newContainer('menu_'.$menu->codename);      	
      	$Iterator = $menu->nodes->getIterator();	
      	
      	$items = $this->xml->createElement('items', '');
      	$Container->appendChild($items);
      	
      	$pFile = new fileProcess('menu');     
      	$fileInputsColl = new fileInputColl();
      	$pFI = array();
      	$pFI['inputName'] = 'menuItem';
      	$pFI['label'] = 'Картинка пункта';
      	$pFI['isDescr'] = 1;
      	$fileInputsColl->addItem($pFI);
      	$pFI = array();
      	$pFI['inputName'] = 'pageBG';
      	$pFI['label'] = 'Картинка страницы';
      	$fileInputsColl->addItem($pFI);
      	$pFile->fileInputs = $fileInputsColl;
      	
      
      	foreach ($Iterator as $menuItem) {
      		$menuItem->queryString = str_replace('&','/',$menuItem->queryString);     		
      		     		
      		$menuItemNode = $this->rMenu($menuItem, $items);
      		$pFile->dropBody();
	      	$pFile->assignTo = $menuItem->id;
	      	$pFile->update('viewIMG');
	      	#      $vFile = new fileView($this->modName);
	      	$fileBody = $pFile->getBody();
	      	$this->mergeXML($this->xml, $menuItemNode, $fileBody->getXML());
	      	$this->pXSL = array_merge($this->pXSL, $fileBody->getXSL());	
      	}
    }
    
}
?>