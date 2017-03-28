<?php

include CORE_ROOT . 'classes/tree.class.php';

class adminModel extends module_model {
	public function __construct($modName) {
		parent::__construct ( $modName );
	
		// stop($this->System);
	}
	
	public function userCreate($username, $email, $login, $pass, $ip, $group_id, $tab_no) {
		$sql = 'INSERT INTO ' . TAB_PREF . '`users` (`name`, `email`, `login`, `pass`, `ip`, `date_reg`, `isban`, `tab_no`)
  				VALUES
  				(\'%1$s\', \'%2$s\', \'%3$s\', \'%4$s\', \'%5$s\', NOW(), 0, \'%6$s\')';
		$a = $this->query ( $sql, $username, $email, $login, $pass, $ip, $tab_no );
		$user_id = $this->insertID ();
		if ($user_id == 0)
			return false;
		$sql = 'INSERT INTO ' . TAB_PREF . '`groups_user` (`group_id`, `user_id`) VALUES (%1$u, %2$u)';
		$b = $this->query ( $sql, $group_id, $user_id );
		if ($a && $b) {
			$this->Log->addToLog ( 'Зарегистрирован новый пользователь', __LINE__, __METHOD__ );
			return $user_id;
		}
		return false;
	}
	public function userUpdate($username, $email, $login, $tab_no, $pass, $ip, $group_id, $isBan, $user_id) {
		$sql = 'UPDATE ' . TAB_PREF . '`users`
				SET `name` = \'%1$s\', `email` = \'%2$s\', `login` = \'%3$s\', tab_no = \'%4$s\', ';
		$passi = '';
		if ($pass != '') {
			$passi = md5 ( $pass );
			$sql .= ' `pass` = \'%5$s\', ';
		}
		$this->Log->addToLog ( array ($pass, $passi ), __LINE__, __METHOD__ );
		$sql .= ' `ip` = \'%6$s\',  `isban`=%8$u	WHERE `id` = %9$u';
		if (! $this->query ( $sql, $username, $email, $login, $tab_no, $passi, $ip, $group_id, $isBan, $user_id ))
			return false;
		
		$sql = 'UPDATE ' . TAB_PREF . '`groups_user` SET `group_id`  = %1$u WHERE `user_id` = %2$u';
		$this->query ( $sql, $group_id, $user_id );

		return true;
	}
	
	public function userBan($user_id, $full) {
		$type = 1;
		if ($full)
			$type = 2;
		$sql = 'UPDATE ' . TAB_PREF . '`users`
				SET `isBan` = %2$u
                WHERE `id` = %1$u';
		$this->query ( $sql, $user_id, $type );
		return true;
	}
	
	public function groupHide($group_id) {
		$sql = ' UPDATE ' . TAB_PREF . 'groups
                SET [hidden] = 1
                WHERE id = %1$u';
		$this->query ( $sql, $group_id );
		return true;
	}
	public function groupCount($group_id) {
		$sql = ' SELECT COUNT(group_id) as count
  				FROM ' . TAB_PREF . 'groups_user
  				where group_id= %1$u';
		$this->query ( $sql, $group_id );
		$count = array ();
		$count = $this->fetchOneRowA ();
		return $count;
	}
	
	public function userUnBan($user_id) {
		$sql = 'UPDATE ' . TAB_PREF . '`users`
				SET `isBan` = 0
                WHERE `id` = %1$u';
		$this->query ( $sql, $user_id );
		return true;
	}
	
	public function user_rights($user_id) {
		$sql = 'SELECT [allow]  FROM ' . TAB_PREF . 'user_rights  where right_id=1 AND [user_id]=' . $user_id;
		$this->query ( $sql );
		$user_rights = array ();
		while ( ($row = $this->fetchRowA ()) !== false ) {
			$user_rights [] = $row;
		}
		return $user_rights;
	}
	
	public function userGet($user_id) {
		
		if (! $user_id)
			return false;
		$sql = 'SELECT u.id as user_id, u.*,g.id as group_id, g.name as group_name
				FROM ' . TAB_PREF . '`users` u
				LEFT JOIN ' . TAB_PREF . '`groups_user` gu ON u.id = gu.user_id
				LEFT JOIN ' . TAB_PREF . '`groups` g ON gu.group_id = g.id
				WHERE u.id = %1$u';
		$this->query ( $sql, $user_id );
		$user = array ();
		$user = $this->fetchOneRowA ();
		return $user;
	}
	public function getGroupsO() {
		$sql = 'SELECT * FROM ' . TAB_PREF . 'report_groups';
		$this->query ( $sql );
		$groups = array ();
		while ( ($row = $this->fetchRowA ()) !== false ) {
			$groups [] = $row;
		}
		return $groups;
	}
	
	public function userList($order, $f_name, $f_tabno, $f_login, $f_group, $f_otdel, $id_group) {
		
		$fsql = '';
		if ($id_group != '') {
			$fsql .= ' AND g.id = \'' . $id_group . '\' ';
		}
		if ($f_name != '') {
			$fsql .= ' AND u.name like \'%%%1$s%%\' ';
		}
		if ($f_tabno != '') {
			$fsql .= ' AND u.tab_no like \'%%%2$s%%\' ';
		}
		if ($f_login != '') {
			$fsql .= ' AND u.login like \'%%%3$s%%\' ';
		}
		if ($f_group != '') {
			$fsql .= ' AND g.name like \'%%%4$s%%\' ';
		}
		$order_by = ' ORDER BY u.name';
		if ($order) {
			$order_by = " ORDER BY $order";
		}
		
		$sql = 'SELECT u.id as user_id, u.*,g.id as group_id, g.name as group_name
				FROM ' . TAB_PREF . '`users` u
				LEFT JOIN ' . TAB_PREF . '`groups_user` gu ON u.id = gu.user_id
				LEFT JOIN ' . TAB_PREF . '`groups` g ON gu.group_id = g.id
				WHERE u.isBan<2 ' . $fsql . $order_by;
		$this->query ( $sql, $f_name, $f_tabno, $f_login, $f_group, $f_otdel );
		$users = array ();
		while ( ($row = $this->fetchRowA ()) !== false ) {
			$row ['date_reg'] = date ( 'd.m.Y', strtotime ( substr ( $row ['date_reg'], 0, 20 ) ) );
			$users [] = $row;
		}
		return $users;
	}
	
	public function getLogins($page, $limCount) {
		
		$limStart = 0;
		if ($page != 0) {
			/*$count = $this->getOne ();
			if ($page > $count)
				$page = $count;*/
			if ($page < 1)
				$page = 1;
			
		//$col = 10;
			if ($limCount < 1)
				$limCount = 1;
			$limStart = ($page - 1) * $limCount;
			if ($limStart < 0)
				$limStart = 0;
		}
		
		$sql = 'SELECT 
u.name,lu.ip,lu.date,lu.referer,lu.browser,lu.os,g.name as group_name,
(SELECT COUNT(*) FROM ' . TAB_PREF . 'logins) as logscount 
  FROM ' . TAB_PREF . 'logins lu
  LEFT JOIN ' . TAB_PREF . 'users u ON lu.id_user = u.id
  LEFT JOIN ' . TAB_PREF . 'groups_user gu ON u.id = gu.user_id
  LEFT JOIN ' . TAB_PREF . 'groups g ON gu.group_id = g.id
   LIMIT ' . $limStart . ', ' . ($limStart + $limCount) . '';
		
		$this->query ( $sql );
		
		$logins = array ();
		while ( ($row = $this->fetchRowA ()) !== false ) {
			$logins [] = $row;
		}
		return $logins;
	}
	
	public function userTest($login_n) {
		$sql = 'SELECT count(id) FROM ' . TAB_PREF . '`users` u  WHERE u.login = \'%1$s\'';
		$this->query ( $sql, $login_n );
		$test = $this->getOne ();
		return $test;
	}
	
	/**
	 * Обновить действия только для модуля
	 * @param $rights
	 * @return unknown_type
	 */
	public function groupRightModuleUpdate($rights, $group_id) {
	
	}
	/**
	 *
	 * @param $rights array ( mod_id = array( action_id => access));
	 *
	 */
	public function groupRightUpdate($actions, $group_id) {
		//foreach($rights as $mod => $action) {
		foreach ( $actions as $action_id => $access ) {
			if (DB_USE == 'MSSQL') {
				$sql = 'begin tran
						declare @aaa as int;
						SET @aaa = (SELECT COUNT(*) FROM ' . TAB_PREF . 'module_access  WHERE group_id = %1$u AND action_id = %2$u)
						if (@aaa = 0) begin
							INSERT INTO ' . TAB_PREF . 'module_access  (group_id, action_id, access) VALUES (%1$u, %2$u, %3$u) 
						end 
							else 
						begin
							UPDATE ' . TAB_PREF . 'module_access SET access = %3$u WHERE group_id = %1$u AND action_id = %2$u	
						end
						commit tran';
			}
			
			if (DB_USE == 'mySQL') {
				$sql = 'INSERT INTO ' . TAB_PREF . '`module_access` (`group_id`, `action_id`, `access`) VALUES (%1$u, %2$u, %3$u) ON DUPLICATE KEY UPDATE `access` = %3$u';
			}
			if ($this->query ( $sql, $group_id, $action_id, $access ))
				$this->Log->addToLog ( 'Задано действие', __LINE__, __METHOD__ );
			else
				$this->Log->addError ( array ('Ошибка задания действия', $action_id, $access ), __LINE__, __METHOD__ );
		}
		//}
		return true;
	}
	public function groupReset($group_id, $module_id) {
	
	}
	
	public function groupAdd($group_name, $group_name, $parent = 0, $position = 100) {
		$sql = 'INSERT INTO ' . TAB_PREF . '`groups` (`name`,`name`, `admin`, `parent`) VALUES (\'%1$s\' ,\'%2$s\' , 1, %3$u)';
		$this->query ( $sql, $group_name, $group_name, $parent );
		$group_id = $this->insertID ();
		
		if ($group_id > 0) {
			$tree = new TreeNodes ( 'groups' );
			$tree->add ( $group_id, $parent, 1, $position );
			$this->System->actionLog ( $this->mod_id, $group_id, 'Создана новая группа: ' . $group_name . '/' . $group_name, dateToDATETIME ( date ( 'Y-d-m h-i-s' ) ), $this->User->getUserID (), 1, 'groupAdd' );
		}
		return $group_id;
	}
	
	public function groupUpdate($group_name, $group_name, $group_id) {
		if ($group_id == 0)
			return false;
		$sql = 'UPDATE ' . TAB_PREF . 'groups SET name = \'%1$s\', name = \'%2$s\' WHERE id = %3$u';
		return $this->query ( $sql, $group_name, $group_name, $group_id );
	}
	
	public function getActions($group_id) {
		$sql = 'SELECT ma.*,
                m.name as mod_name,
                mc.access as mcaccess,
                mc.group_id,
                ug.user_id,
                g.name as gname,
                g.name as gname,
                u.name as uname,';
		
		//         $sql.= '       IF (mc.group_id IS NOT NULL, mc.group_id, 0) as group_adm';
		/*
		$sql.= 'mc.group_id as group_adm
            FROM '.TAB_PREF.'module_actions ma
            INNER JOIN '.TAB_PREF.'modules m ON  ma.mod_id = m.id
            LEFT JOIN ('.TAB_PREF.'module_access mc
            INNER JOIN '.TAB_PREF.'groups_user ug ON mc.group_id = ug.group_id
            INNER JOIN '.TAB_PREF.'groups g ON ug.group_id = g.id AND ug.group_id = %1$u
            INNER JOIN '.TAB_PREF.'users u ON ug.user_id = u.id) ON ma.id = mc.action_id
         
            order by m.id';
		*/
		
		$sql .= 'mc.group_id as group_adm
            FROM ' . TAB_PREF . 'module_actions ma
            INNER JOIN ' . TAB_PREF . 'modules m ON  ma.mod_id = m.id
            LEFT JOIN ' . TAB_PREF . 'module_access mc ON ma.id = mc.action_id AND mc.group_id = %1$u
            LEFT JOIN ' . TAB_PREF . 'groups_user ug ON mc.group_id = ug.group_id
            LEFT JOIN ' . TAB_PREF . 'groups g ON ug.group_id = g.id 
            LEFT JOIN ' . TAB_PREF . 'users u ON ug.user_id = u.id 
          /*  group by ma.id*/
            order by m.id';
		
		if (isset ( $_SESSION ['authorization_LDAP'] )) {
			if ($_SESSION ['authorization_LDAP'] == 1) {
				$sql = 'SELECT ma.*,
                m.name as mod_name,
                mc.access as mcaccess,
                mc.group_id ,       
                mc.group_id as group_adm
            FROM ' . TAB_PREF . 'module_actions ma            
            INNER JOIN ' . TAB_PREF . 'module_access mc ON ma.id = mc.action_id AND mc.group_id  = 10
            INNER JOIN ' . TAB_PREF . 'modules m ON  ma.mod_id = m.id';
			}
		}
		
		$this->query ( $sql, $group_id );
		//stop($this->sql);
		$coll = array ();
		$lastID = 0;
		$lastGR = '';
		$actionColl = new actionColl ();
		while ( ($row = $this->fetchRowA ()) !== false ) {
			#stop($row);
			if ($lastID != $row ['id']) {
				$groupColl = new mcColl ();
				
				$Params = array ();
				$Params ['id'] = $row ['id'];
				$Params ['mod_id'] = $row ['mod_id'];
				$Params ['mod_name'] = $row ['mod_name'];
				$Params ['action_name'] = $row ['action_name'];
				$Params ['action_title'] = $row ['action_title'];
				$Params ['access'] = $row ['access'];
				$Params ['group_adm'] = $row ['group_adm'];
				$Params ['groups'] = $groupColl;
				$action = new moduleAction ( $Params );
				$actionColl->add ( $action );
				$lastID = $row ['id'];
			}
			
			$gr = array ();
			if ($row ['group_id'] > 0 && $row ['mcaccess'] > 0) {
				$gr ['id'] = $row ['group_id'];
				$gr ['action_id'] = $row ['id'];
				$gr ['group_id'] = $row ['group_id'];
				$gr ['group_name'] = $row ['gname'];
				$gr ['group_name'] = $row ['gname'];
				$gr ['user_id'] = $row ['user_id'];
				$gr ['access'] = $row ['access'];
				$gr ['module_id'] = $row ['mod_id'];
				$groupColl->addItem ( $gr );
			}
		
		}
		return $actionColl;
	}
	public function getGroupName_ru($group_id) {
		$sql = 'SELECT name FROM ' . TAB_PREF . 'groups WHERE id = %1$u';
		$this->query ( $sql, $group_id );
		return $this->getOne ();
	}
	public function getGroupName_en($group_id) {
		$sql = 'SELECT name FROM ' . TAB_PREF . 'groups WHERE id = %1$u';
		$this->query ( $sql, $group_id );
		return $this->getOne ();
	}
	
	public function gelLogs($type) {
		$logs = array ();
		if ($type == 'few') {
			$sql = 'SELECT s.*, CONVERT (char(10), s.`date`, 105) as date, u.name as username
					FROM ' . TAB_PREF . '`sys_log` s
					INNER JOIN ' . TAB_PREF . '`users` u ON s.user_id = u.id
					ORDER BY s.`date` DESC';
			$this->query ( $sql );
			while ( ($row = $this->fetchOneRowA ()) !== false ) {
				$logs [] = $row;
			}
		}
		return $logs;
	}
}

class adminProcess extends module_process {
	private $updated;
	protected $nModel;
	protected $nView;
	
	public function __construct($modName) {
		global $values, $User, $LOG;
		
		//	if ($modName != 'admin') exit('Access denied');
		parent::__construct ( $modName );
		$this->Vals = $values;
		if (! $modName)
			unset ( $this );
		
		$this->modName = $modName;
		$this->User = $User;
		$this->Log = $LOG;
		$this->action = false;
		/* actionDefault - должно быбираться из БД!!! */
		
		$this->actionDefault = '';
		
		$this->actionsColl = new actionColl ();
		
		$this->nModel = new adminModel ( $modName );
		$sysMod = $this->nModel->getSysMod ();
		$this->sysMod = $sysMod;
		$this->mod_id = $sysMod->id;
		
		$this->nView = new adminView ( $this->modName, $this->sysMod );
		
		/* Default Process Class actions */
		$this->regAction ( 'useAdmin', 'Использование Админки', ACTION_GROUP );
		$this->regAction ( 'newUser', 'Форма создания пользователя', ACTION_GROUP );
		$this->regAction ( 'addUser', 'Вставить пользователя в БД', ACTION_GROUP );
		$this->regAction ( 'userList', 'Список пользователей', ACTION_GROUP );
		$this->regAction ( 'userEdit', 'Редактировать пользователя', ACTION_GROUP );
		$this->regAction ( 'userUpdate', 'Обновить данные пользователя', ACTION_GROUP );
		$this->regAction ( 'userBan', 'Удалить пользователя в корзину', ACTION_GROUP );
		$this->regAction ( 'userUnBan', 'Восстановить пользователя', ACTION_GROUP );
		$this->regAction ( 'groupNew', 'Диалог создания группы', ACTION_GROUP );
		$this->regAction ( 'groupAdd', 'Добавить группу', ACTION_GROUP );
		$this->regAction ( 'groupEdit', 'Редактировать группу', ACTION_GROUP );
		$this->regAction ( 'groupUpdate', 'Обновить данные группы', ACTION_GROUP );
		$this->regAction ( 'groupHide', 'Скрыть группу', ACTION_GROUP );
		$this->regAction ( 'groupList', 'Список групп', ACTION_GROUP );
		$this->regAction ( 'groupRights', 'Права групп', ACTION_GROUP );
		$this->regAction ( 'groupRightsAdmin', 'Права групп для Администратора', ACTION_GROUP );
		$this->regAction ( 'groupRightsUpdate', 'Обновление прав групп', ACTION_GROUP );
		$this->regAction ( 'LoginsList', 'Журнал входов', ACTION_GROUP );
		$this->regAction ( 'logs', 'Журнал изменений', ACTION_GROUP );
		$this->regAction ( 'mails', 'Рассылка писем', ACTION_GROUP );
		if (DEBUG == 0) {
			$this->registerActions ( 1 );
		}
		if (DEBUG == 1) {
			$this->registerActions ( 0 );
		
		// $this->registerActions(0);
		}
	
	}
	
	public function update($_action = false) {
		$this->updated = false;
		
		if ($_action)
			$this->action = $_action;
		$action = $this->actionDefault;
		if ($this->action)
			$action = $this->action;
		else
			$action = $this->checkAction ();
		if (! $action) {
			$this->Vals->URLparams ( $this->sysMod->defQueryString );
			$action = $this->actionDefault;
		}
		
		$user_id = $this->User->getUserID ();
		$user_right = $this->User->getRight ( $this->modName, 'useAdmin' );
		
		if ($user_right == 0) {
			$p = array ('У Вас отсутствуют административные права' );
			$this->nView->viewLogin ( $p, $user_id );
			$this->Log->addError ( $p, __LINE__, __METHOD__ );
			$this->updated = true;
			return;
		} else {
			$p = array ('Система администрирования' );
			//$this->nView->viewLogin($p, $user_id);
			//$this->Log->addError($p, __LINE__, __METHOD__);
			$this->updated = false;
		}
		
		$useMod = $this->Vals->getVal ( 'mod', 'GET', 'string' );
		$useAct = $this->Vals->getVal ( 'act', 'GET', 'string' );
		$useVal = $this->Vals->getVal ( 'actval', 'GET', 'string' );
		
		$user_right = $this->User->getRight ( $useMod, $useAct );
		
		if ($useMod) {
			if ($this->User->getRight ( $useMod, $useAct ) == 0) {
				$p = array ('У Вас нет прав доступа к этому модулю', $useMod, $useAct );
				$this->nView->viewLoginParams ( $p [0], '', $user_id, array (), array () );
				//$this->nView->viewError($p, false);
				$this->Log->addError ( $p, __LINE__, __METHOD__ );
				$this->updated = true;
				return false;
			}
			$modData = modulePreload ( $useMod );
			
			if ($modData) {
				if (is_file ( 'modules/' . $modData->module_defModName . '/' . $modData->module_defModName . '.class.php' )) {
					$this->Log->addWarning ( array ('Модуль подключен', $useMod ), __LINE__, 'index.php' );
				} else {
					$this->Log->addWarning ( array ('подключен виртуальный модуль', $useMod ), __LINE__, 'index.php' );
				}
				//stop($modData->module_isSystem.' '.$modData->module_processName,0 );
				if (! $modData->module_isSystem && ! class_exists ( $modData->module_processName ))
					include ('modules/' . $modData->module_defModName . '/' . $modData->module_defModName . '.class.php');
				if ($modData->module_isSystem && ! class_exists ( $modData->module_processName ))
					include ('classes/' . $modData->module_defModName . '.class.php');
				$autoClass = $modData->module_processName;
				//$values->URLparams($modData->module_defQueryString);
				$sysMod = new $autoClass ( $modData->module_codename );
				$sysMod->setDefaultAction ( $modData->module_defAction );
				$this->Vals->setValTo ( $useAct, $useVal, 'GET' );
				$sysMod->update ( $useAct );
				$modBodySet = $sysMod->getBody ( 'xml' );
				$this->nView->addXML ( $modBodySet, 'adm_' . $modData->module_codename );
				//$this->nView->mergeXML($this->)
				$this->updated = true;
			}
		
		}
		
		/* * Пользователи * */
		if ($user_right == 0 && $user_id == 0 && ! $_action) {
			$this->nView->viewLogin ( 'SkyLC', '', $user_id, array (), array () );
			$this->updated = true;
			return;
		}
		
		if ($user_id > 0 && ! $_action) {
			$this->User->nView->viewLoginParams ( 'SkyLC', '', $user_id, array (), array (), $this->User->getRightModule ( 'admin' ) );
		}
		
		if ($action == 'newUser') {
			$groups = $this->nModel->getGroups ();
			$this->nView->viewNewUser ( $groups );
			$this->updated = true;
		}
		
		if ($action == 'addUser') {
			$Params ['username'] = $this->Vals->getVal ( 'username', 'POST', 'string' );
			$Params ['email'] = $this->Vals->getVal ( 'email', 'POST', 'string' );
			$Params ['ip'] = $this->Vals->getVal ( 'ip', 'POST', 'string' );
			$Params ['login'] = $this->Vals->getVal ( 'login', 'POST', 'string' );
			//			$Params['login'] = $Params['email'];
			$Params ['pass'] = $this->Vals->getVal ( 'pass', 'POST', 'string' );
			$Params ['group_id'] = $this->Vals->getVal ( 'group_id', 'POST', 'integer' );
			$Params ['isAutoPass'] = $this->Vals->getVal ( 'isAutoPass', 'POST', 'integer' );
			$Params ['tab_no'] = $this->Vals->getVal ( 'tab_no', 'POST', 'string' );
			
			if (! $Params ['tab_no'])
				$Params ['tab_no'] = '0';
			
			$users = $this->nModel->userTest ( $Params ['login'] );
			if ($users > 0) {
				$this->nView->viewError ( array ('Ошибка добавления пользователя.', 'Пользователь с таким логином существует.', $Params ['login'] ) );
			} else {
				// $Params = $this->Vals->getVal('username', 'POST', 'string');
				if ($Params ['isAutoPass']) {
					$pass = $this->generatePass ( 6 );
					$Params ['pass'] = $pass;
				}
				
				// $username, $email, $login, $pass, $ip, $group_id
				if ($Params ['username'] != '' && $Params ['email'] != '' && $Params ['group_id'] > 0) {
					$res = $this->nModel->userCreate ( $Params ['username'], $Params ['email'], $Params ['login'], md5 ( $Params ['pass'] ), $Params ['ip'], $Params ['group_id'], $Params ['tab_no'] );
					if ($res > 0) {
						//					$this->System->actionLog($this->mod_id, $res, 'Добавлен новый пользователь: '.$Params['username'], dateToDATETIME (date('Y-d-m h-i-s')), $this->User->getUserID(), 1, $action);
						$this->nView->viewMessage ( 'Добавлен новый пользователь', 'Сообщение' );
						$message1 = ' Вы были зарегистрированны в системе "Интранет портал РИВЦ-Пулково"<br />' . rn . rn;
						$message2 = ' Добавлен новый пользователь<br />' . rn . rn;
						$usInfo = '';
						foreach ( $Params as $key => $val ) {
							$usInfo .= $key . ' : ' . $val . '<br />' . rn;
						}
						$message1 .= $usInfo;
						$message2 .= $usInfo;
					
		//$message = join('<br />'.rn,$Params);
					// sendMail('Регистрация в системе', $message1, $Params['email'],'Интранет портал РИВЦ-Пулково');
					// sendMail('Новый пользователь', $message2, 'poltavcev@rivc-pulkovo.ru','Интранет портал РИВЦ-Пулково');
					} else {
						$this->nView->viewError ( array ('Ошибка добавления пользователя' ) );
					}
				} else {
					$this->nView->viewError ( array ('Заполнены не все обязательные поля! ', $Params ['username'], $Params ['email'], $Params ['group_id'] ) );
					return;
				}
				$action = 'userList';
			
			}
		
		//$this->updated = true;
		}
		
		if ($action == 'groupHide') {
			$Params ['group_id'] = $this->Vals->getVal ( 'groupHide', 'GET', 'integer' );
			$count = $this->nModel->groupCount ( $Params ['group_id'] );
			
			if ($count ['count'] > 0) {
				$this->nView->viewError ( array ('Ошибка удаления группы. В группе есть пользователи.' ) );
			} else {
				$res = $this->nModel->groupHide ( $Params ['group_id'] );
				if ($res) {
					$this->nView->viewMessage ( 'Группа перемещена в корзину', 'Сообщение' );
					$message1 = ' Группа удалена "SkyLC"<br />' . rn . rn;
					$message2 = ' Группа успешно удалена<br />' . rn . rn;
					$usInfo = '';
					foreach ( $Params as $key => $val ) {
						$usInfo .= $key . ' : ' . $val . '<br />' . rn;
					}
					$message1 .= $usInfo;
					$message2 .= $usInfo;
				} else {
					$this->nView->viewError ( array ('Ошибка удаления группы' ) );
				}
				header ( "Location:/admin/groupList-1/" );
			}
		}
		
		if ($action == 'userBan') {
			$Params ['user_id'] = $this->Vals->getVal ( 'userBan', 'GET', 'integer' );
			$Params ['full'] = $this->Vals->getVal ( 'full', 'GET', 'integer' );
			$res = $this->nModel->userBan ( $Params ['user_id'], $Params ['full'] );
			if ($res) {
				$this->nView->viewMessage ( 'Пользователь перемещен в корзину', 'Сообщение' );
				$message1 = ' Ваш профиль удален "SkyLC"<br />' . rn . rn;
				$message2 = ' Пользователь успешно удален<br />' . rn . rn;
				$usInfo = '';
				foreach ( $Params as $key => $val ) {
					$usInfo .= $key . ' : ' . $val . '<br />' . rn;
				}
				$message1 .= $usInfo;
				$message2 .= $usInfo;
			} else {
				$this->nView->viewError ( array ('Ошибка удаления пользователя' ) );
			}
			header ( "Location:/admin/userList-1/" );
		}
		
		if ($action == 'userUnBan') {
			$Params ['user_id'] = $this->Vals->getVal ( 'userUnBan', 'GET', 'integer' );
			$res = $this->nModel->userUnBan ( $Params ['user_id'] );
			if ($res) {
				$this->nView->viewMessage ( 'Пользователь восстановлен из корзины', 'Сообщение' );
				$message1 = ' Ваш профиль восстановлен "SkyLC"<br />' . rn . rn;
				$message2 = ' Пользователь успешно восстановлен<br />' . rn . rn;
				$usInfo = '';
				foreach ( $Params as $key => $val ) {
					$usInfo .= $key . ' : ' . $val . '<br />' . rn;
				}
				$message1 .= $usInfo;
				$message2 .= $usInfo;
			} else {
				$this->nView->viewError ( array ('Ошибка восстановления пользователя' ) );
			}
			header ( "Location:/admin/userList-1/" );
		}
		
		if ($action == 'userUpdate') {
			$Params ['user_id'] = $this->Vals->getVal ( 'user_id', 'POST', 'integer' );
			if ($Params ['user_id'] == 0) {
				$this->nView->viewError ( 'Ошибка ID' );
				return false;
			}
			$Params ['username'] = $this->Vals->getVal ( 'username', 'POST', 'string' );
			$Params ['email'] = $this->Vals->getVal ( 'email', 'POST', 'string' );
			$Params ['ip'] = $this->Vals->getVal ( 'ip', 'POST', 'string' );
			$Params ['login'] = $this->Vals->getVal ( 'login', 'POST', 'string' );
			$Params ['tab_no'] = $this->Vals->getVal ( 'tab_no', 'POST', 'string' );
			//$Params['login'] = $Params['email'];
			$Params ['pass'] = $this->Vals->getVal ( 'pass', 'POST', 'string' );
			$Params ['group_id'] = $this->Vals->getVal ( 'group_id', 'POST', 'integer' );
			$Params ['isAutoPass'] = $this->Vals->getVal ( 'isAutoPass', 'POST', 'integer' );
			$Params ['isBan'] = $this->Vals->getVal ( 'isBan', 'POST', 'integer' );
			
			if ($Params ['isAutoPass'] > 0) {
				$pass = $this->generatePass ( 6 );
				$Params ['pass'] = $pass;
			}
			// $username, $email, $login, $pass, $ip, $group_id
			if ($Params ['username'] != '' && $Params ['email'] != '' && $Params ['group_id'] > 0) {
				$res = $this->nModel->userUpdate ( $Params ['username'], $Params ['email'], $Params ['login'],$Params ['tab_no'], $Params ['pass'], $Params ['ip'], $Params ['group_id'], $Params ['isBan'], $Params ['user_id'] );
				if ($res) {
					//					$this->System->actionLog($this->mod_id, $Params['user_id'], 'Пользователь обновлен: '.$Params['username'], dateToDATETIME (date('Y-d-m h-i-s')), $this->User->getUserID(), 1, $action);
					$this->nView->viewMessage ( 'Пользователь успешно обновлен', 'Сообщение' );
					$message1 = ' Ваш профиль обновлен "SkyLC"<br />' . rn . rn;
					$message2 = ' Пользователь успешно обновлен<br />' . rn . rn;
					$usInfo = '';
					foreach ( $Params as $key => $val ) {
						$usInfo .= $key . ' : ' . $val . '<br />' . rn;
					}
					$message1 .= $usInfo;
					$message2 .= $usInfo;
				
		//$message = join('<br />'.rn,$Params);
				//sendMail('Профиль обновлен', $message1, $Params['email'],'Интранет портал РИВЦ-Пулково');
				//sendMail('Пользователь обновлен', $message2, 'poltavcev@rivc-pulkovo.ru','Интранет портал РИВЦ-Пулково');
				} else {
					$this->nView->viewError ( array ('Ошибка обновления пользователя' ) );
				}
			} else {
				$this->nView->viewError ( array ('Заполнены не все обязательные поля', $Params ['username'], $Params ['email'], $Params ['group_id'] ) );
				return;
			}
			$action = 'userList';
			$this->updated = true;
		}
		
		if ($action == 'userEdit') {
			$user_id = $this->Vals->getVal ( 'userEdit', 'GET', 'integer' );
			if ($user_id > 0) {
				$user = $this->nModel->userGet ( $user_id );
				$groups = $this->nModel->getGroups ();
				$groups_o = $this->nModel->getGroupsO ();
				$user_rights = $this->nModel->user_rights ( $user_id );
				
				if ($user ['user_id'] > 0)
					$this->nView->viewUserEdit ( $user, $groups, $groups_o, $user_rights );
				else
					$this->nView->viewError ( 'Пользователь не найден' );
			} else {
				$this->nView->viewError ( 'Пользователь не выбран' );
			}
			$this->updated = true;
		}
		
		if ($action == 'userList') {
			$order = $this->Vals->getVal ( 'srt', 'POST', 'string' );
			$f_name = $this->Vals->getVal ( 'f_name', 'POST', 'string' );
			$f_tabno = $this->Vals->getVal ( 'f_tabno', 'POST', 'string' );
			$f_login = $this->Vals->getVal ( 'f_login', 'POST', 'string' );
			$f_group = $this->Vals->getVal ( 'f_group', 'POST', 'string' );
			$f_otdel = $this->Vals->getVal ( 'f_otdel', 'POST', 'string' );
			$id_group = $this->Vals->getVal ( 'idg', 'INDEX', 'string' );
			$isAjax = $this->Vals->getVal ( 'ajax', 'INDEX' );
			$users = $this->nModel->userList ( $order, $f_name, $f_tabno, $f_login, $f_group, $f_otdel, $id_group );
			$groups = $this->nModel->getGroups ();
			$this->nView->viewUserList ( $users, $order, $isAjax, $id_group, $groups );
			$this->updated = true;
		}
		/* * Конец Пользователи * */
		
		/* * Группы * */
		
		if ($action == 'groupNew') {
			$this->nView->viewNewGroup ();
			$this->updated = true;
		}
		
		if ($action == 'groupAdd') {
			$group_name = $this->Vals->getVal ( 'name', 'POST', 'string' );
			$group_name = $this->Vals->getVal ( 'name', 'POST', 'string' );
			if ($group_name != '')
				$group_id = $this->nModel->groupAdd ( $group_name, $group_name );
			else
				$this->nView->viewError ( array ('Укажите название группы (rus)' ) );
			$action = 'groupList';
		}
		
		if ($action == 'groupEdit') {
			$group_id = $this->Vals->getVal ( 'groupEdit', 'GET', 'integer' );
			$group_name = $this->nModel->getGroupName_ru ( $group_id );
			$group_name = $this->nModel->getGroupName_en ( $group_id );
			$this->nView->viewEditGroup ( $group_name, $group_name, $group_id );
			$this->updated = true;
		}
		if ($action == 'groupUpdate') {
			$group_id = $this->Vals->getVal ( 'group_id', 'POST', 'integer' );
			$group_name = $this->Vals->getVal ( 'name', 'POST', 'string' );
			$group_name = $this->Vals->getVal ( 'name', 'POST', 'string' );
			if (! $this->nModel->groupUpdate ( $group_name, $group_name, $group_id ))
				$this->nView->viewError ( array ('Ошибка обновления группы' ) );
			
		//	else $this->System->actionLog($this->mod_id, $group_id, 'Обновлена группа: '.$group_name.'/'.$group_name, dateToDATETIME (date('d-m-Y h-i-s')), $this->User->getUserID(), 1, $action);
			$action = 'groupList';
		}
		
		if ($action == 'groupRightsUpdate') {
			$actions = $this->Vals->getVal ( 'action', 'POST', 'array' );
			$group_id = $this->Vals->getVal ( 'group_id', 'POST', 'integer' );
			if ($group_id < 1)
				return $this->nView->viewError ( array ('Группа не найдена' ) );
			
		//stop($actions);
			if ($this->nModel->groupRightUpdate ( $actions, $group_id )) {
				$this->nView->viewMessage ( 'Права группы обновлены', 'Сообщение' );
			
		//	$this->System->actionLog($this->mod_id, $group_id, 'Обновлены права группы: '.$group_id, dateToDATETIME (date('d-m-Y h-i-s')), $this->User->getUserID(), 1, $action);
			} else {
				$this->nView->viewError ( array ('Ошибка обновления группы' ) );
			}
		}
		
		if ($action == 'groupList') {
			
			$groups = $this->nModel->getGroups ();
			$this->nView->viewGroups ( $groups );
			$this->updated = true;
		}
		
		if ($action == 'LoginsList') {
			
			$limCount = $this->vals->getVal ( 'count', 'get', 'integer' );
			if (! $limCount)
				$limCount = $this->vals->getModuleVal ( $this->modName, 'count', 'GET', 'integer' );
			$page = $this->vals->getVal ( 'page', 'GET', 'integer' );
			if ($page <= 0 || $page === NULL) {
				$this->Vals->setValTo ( 'page', '1', 'GET' );
				$page = 1;
			}
			if ($limCount == 0)
				$limCount = 20;
			
			$logins = $this->nModel->getLogins ( $page, $limCount );
			
			$Archive = new archiveStruct ( $this->modName, $logins [0] ['logscount'], $limCount, $page, '' );
			
			$this->nView->viewLogins ( $logins, $Archive );
			$this->updated = true;
		}
		
		if ($action == 'groupRights') {
			$group_id = $this->Vals->getVal ( 'groupRights', 'GET', 'integer' );
			$actions = $this->nModel->getActions ( $group_id );
			$group_name = $this->nModel->getGroupName_ru ( $group_id );
			$this->nView->viewGroupRight ( $actions, $group_name, $group_id );
			$this->updated = true;
		}
		
		if ($action == 'groupRightsAdmin') {
			$group_id = $this->Vals->getVal ( 'groupRightsAdmin', 'GET', 'integer' );
			$actions = $this->nModel->getActions ( $group_id );
			$group_name = $this->nModel->getGroupName_ru ( $group_id );
			$group_name = $this->nModel->getGroupName_en ( $group_id );
			$this->nView->viewGroupRightAdmin ( $actions, $group_name, $group_name, $group_id );
			$this->updated = true;
		}
		/* * Конец Группы * */
		
		if ($action == 'logs') {
			$type = 'few';
			$logs = $this->nModel->gelLogs ( $type );
			$this->nView->viewLogs ( $logs, $type );
			$this->updated = true;
		}
		
		if ($this->Vals->isVal ( 'ajax', 'INDEX' )) {
			if ($this->Vals->isVal ( 'xls', 'INDEX' )) {
				$PageAjax = new PageForAjax ( $this->modName, $this->modName, $this->modName, 'page.xls.xsl' );
				$PageAjax->addToPageAttr ( 'xls', '1' );
			} else
				$PageAjax = new PageForAjax ( $this->modName, $this->modName, $this->modName, 'page.ajax.xsl' );
			$isAjax = $this->Vals->getVal ( 'ajax', 'INDEX' );
			$PageAjax->addToPageAttr ( 'isAjax', $isAjax );			
			$html = $PageAjax->getBodyAjax2 ( $this->nView );

			if ($this->Vals->isVal ( 'xls', 'INDEX' )) {
				$reald = date ( "d.m.Y" );
				header ( "Content-Type: application/vnd.ms-excel", true );
				header ( "Content-Disposition: attachment; filename=\"list_" . $reald . ".xls\"" );
				exit ( $html );
			} else
				sendData ( $html );
		
		}
		
		if (! $this->updated) {
			$this->nView->viewMainPage ();
			$this->updated = true;
		}
	
	}
	
	function generatePass($length = 6) {
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789_;.";
		$code = "";
		$clen = strlen ( $chars ) - 1;
		while ( strlen ( $code ) < $length ) {
			$code .= $chars [mt_rand ( 0, $clen )];
		}
		return $code;
	}

}

class adminView extends module_view {
	public function __construct($modName, modsetItem $sysMod) {
		parent::__construct ( $modName, $sysMod );
		$this->pXSL = array ();
	}
	
	public function addXML(bodySet $bodySet, $contName) {
		$this->pXSL = array_merge ( $this->pXSL, $bodySet->getXSL () );
		$Container = $this->newContainer ( $contName );
		parent::mergeXML ( $this->xml, $Container, $bodySet->getXML (), 'xx' );
	}
	
	public function viewNewUser($groups) {
		$this->pXSL [] = RIVC_ROOT . 'layout/users/user.new.xsl';
		$Container = $this->newContainer ( 'newuser' );
		$ContainerGroups = $this->addToNode ( $Container, 'groups', '' );
		// stop($groups);
		foreach ( $groups as $item ) {
			$this->arrToXML ( $item, $ContainerGroups, 'item' );
		}
		return true;
	}
	/**
	 *
	 *
	 * @param $users array()
	 * @return unknown_type
	 */
	public function viewUserList($users, $order, $isAjax, $id_group, $groups) {
		$this->pXSL [] = RIVC_ROOT . 'layout/users/user.list.xsl';
		if ($isAjax == 1) {
			$this->pXSL [] = RIVC_ROOT . 'layout/head.page.xsl';
		}
		
		$Container = $this->newContainer ( 'userlist' );
		$Containerusers = $this->addToNode ( $Container, 'users', '' );
		$this->addAttr ( 'order', $order, $Containerusers );
		$this->addAttr ( 'id_group', $id_group, $Containerusers );
		foreach ( $users as $user ) {
			$this->arrToXML ( $user, $Containerusers, 'user' );
		}
		$ContainerGroups = $this->addToNode ( $Container, 'groups', '' );
		foreach ( $groups as $item ) {
			$this->arrToXML ( $item, $ContainerGroups, 'item' );
		}
		return true;
	}
	
	public function viewMainPage() {
		$this->pXSL [] = RIVC_ROOT . 'layout/admin/admin.main.xsl';
		$Container = $this->newContainer ( 'adminmain' );
		return true;
	}
	
	public function viewUserEdit($user, $groups, $groups_o, $user_rights) {
		$this->pXSL [] = RIVC_ROOT . 'layout/users/user.edit.xsl';
		$Container = $this->newContainer ( 'useredit' );
		$this->arrToXML ( $user, $Container, 'user' );
		$ContainerGroups = $this->addToNode ( $Container, 'groups', '' );
		foreach ( $groups as $item ) {
			$this->arrToXML ( $item, $ContainerGroups, 'item' );
		}
		$ContainerGroupsO = $this->addToNode ( $Container, 'groupsO', '' );
		foreach ( $groups_o as $item ) {
			$this->arrToXML ( $item, $ContainerGroupsO, 'item' );
		}
		$ContainerRights = $this->addToNode ( $Container, 'user_rights', '' );
		foreach ( $user_rights as $item ) {
			$this->arrToXML ( $item, $ContainerRights, 'item' );
		}
		$ContainerAirs = $this->addToNode ( $Container, 'airports', '' );
		
		return true;
	}
	
	public function viewGroups($groups) {
		$this->pXSL [] = RIVC_ROOT . 'layout/users/group.list.xsl';
		$Container = $this->newContainer ( 'grouplist' );
		$ContainerGroups = $this->addToNode ( $Container, 'groups', '' );
		foreach ( $groups as $item ) {
			$this->arrToXML ( $item, $ContainerGroups, 'item' );
		}
		return true;
	}
	
	public function viewNewGroup() {
		$this->pXSL [] = RIVC_ROOT . 'layout/users/group.new.xsl';
		$Container = $this->newContainer ( 'groupnew' );
		return true;
	}
	
	public function viewEditGroup($group_name, $group_name, $group_id) {
		$this->pXSL [] = RIVC_ROOT . 'layout/users/group.edit.xsl';
		$Container = $this->newContainer ( 'groupedit' );
		$groupC = $this->addToNode ( $Container, 'group', '' );
		$this->addAttr ( 'group_id', $group_id, $groupC );
		$this->addAttr ( 'group_name', $group_name, $groupC );
		$this->addAttr ( 'group_name', $group_name, $groupC );
		return true;
	}
	
	public function viewGroupRight(actionColl $actions, $group_name, $group_id) {
		$this->pXSL [] = RIVC_ROOT . 'layout/users/group.rights.xsl';
		$Container = $this->newContainer ( 'grouprights' );
		$actIterator = $actions->getIterator ();
		$ContainerAct = $this->addToNode ( $Container, 'actions', '' );
		$this->addAttr ( 'group_id', $group_id, $ContainerAct );
		$this->addAttr ( 'group_name', $group_name, $ContainerAct );
		/* moduleAction */
		//$action = new moduleAction();
		$lastMod = 0;
		foreach ( $actIterator as $action ) {
			if ($lastMod != $action->mod_id) {
				$modElememt = $this->addToNode ( $ContainerAct, 'module', '' );
				$this->addAttr ( 'mod_name', $action->mod_name, $modElememt );
				$this->addAttr ( 'mod_id', $action->mod_id, $modElememt );
				$lastMod = $action->mod_id;
			}
			$aArray = $action->toArray ();
			$actElememt = $this->arrToXML ( $aArray, $modElememt, 'action' );
			if ($action->groups->count () > 0) {
				$this->addToNode ( $actElememt, 'inGroup', $action->groups->count () );
			} else {
				$this->addToNode ( $actElememt, 'inGroup', 0 );
			}
		
		//stop($action->groups->count(), 0);
		}
		return true;
	}
	
	public function viewGroupRightAdmin(actionColl $actions, $group_name, $group_name, $group_id) {
		$this->pXSL [] = RIVC_ROOT . 'layout/users/group.rights.Admin.xsl';
		$Container = $this->newContainer ( 'grouprights' );
		$actIterator = $actions->getIterator ();
		$ContainerAct = $this->addToNode ( $Container, 'actions', '' );
		$this->addAttr ( 'group_id', $group_id, $ContainerAct );
		$this->addAttr ( 'group_name', $group_name, $ContainerAct );
		$this->addAttr ( 'group_name', $group_name, $ContainerAct );
		/* moduleAction */
		//$action = new moduleAction();
		$lastMod = 0;
		foreach ( $actIterator as $action ) {
			if ($lastMod != $action->mod_id) {
				$modElememt = $this->addToNode ( $ContainerAct, 'module', '' );
				$this->addAttr ( 'mod_name', $action->mod_name, $modElememt );
				$this->addAttr ( 'mod_id', $action->mod_id, $modElememt );
				$lastMod = $action->mod_id;
			}
			$aArray = $action->toArray ();
			$actElememt = $this->arrToXML ( $aArray, $modElememt, 'action' );
			if ($action->groups->count () > 0) {
				$this->addToNode ( $actElememt, 'inGroup', $action->groups->count () );
			} else {
				$this->addToNode ( $actElememt, 'inGroup', 0 );
			}
		
		//stop($action->groups->count(), 0);
		}
		return true;
	}
	
	public function viewLogins($logins, archiveStruct $Archive) {
		$this->pXSL [] = RIVC_ROOT . 'layout/admin/admin.logins.xsl';
		$Container = $this->newContainer ( $Archive->module . '/LoginsList-1' );
		$this->addAttr ( 'module', $Archive->module . '/LoginsList-1', $Container );
		$this->addAttr ( 'count', $Archive->count, $Container );
		$this->addAttr ( 'size', $Archive->size, $Container );
		$this->addAttr ( 'curPage', $Archive->curPage, $Container );
		foreach ( $logins as $aArray )
			$actElememt = $this->arrToXML ( $aArray, $Container, 'item' );
		return true;
	}
	
	public function viewLogs($logs, $type) {
		$this->pXSL [] = RIVC_ROOT . 'layout/admin/admin.logs.xsl';
		$Container = $this->newContainer ( 'logsfew' );
		
		if ($type == 'few') {
			foreach ( $logs as $aArray )
				$actElememt = $this->arrToXML ( $aArray, $Container, 'item' );
		}
		return true;
	}

}

?>