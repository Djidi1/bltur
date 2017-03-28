<?php

session_start();

$loginErrors = array(
    0 => 'Введите имя пользователя и пароль',
    1 => 'Вы вошли как: %s',
    -1 => '',
    -2 => 'Имя пользователя или пароль не верны',
    -3 => 'Сессия устарела',
    -4 => ''

);



class TUser extends database {
  
  private $user_name;
  private $user_login;
  private $user_id;
  private $user_right;   /* array ! */
  /**
   * class TValues
   * @var TValues
   */
  private $Vals;   /*  */
  private $Log;   /*  */

  /* ID сесси в таблице */
  protected $session_id;
  protected $adm;

  protected $login;
  protected $name;
  protected $phone;

  protected $login_error;

  protected $userData;
  public  $nView;

  public function  __construct () {
    global $values, $LOG;
    
    parent::__construct('auth');
    
    $this->Log = $LOG;
    $this->Vals = $values;
    $this->user_id = 0;
    $this->user_right = array();
    $this->userData = array('group_name'=>'');
    $this->nView = new userView();

    $mod = 'modset';
    parent::__construct();
  }

  public function getUserTabNo() { if(isset($this->userData['tab_no'])) return $this->userData['tab_no']; else return 0;}
  public function getUserID() { return $this->user_id; }
  public function getUserName() { if(isset($this->userData['name'])) return $this->userData['name']; else return false; }
  public function getUserGroupName() { if(isset($this->userData['gname'])) return $this->userData['gname']; else return false; }
  public function getUserGroup() { if(isset($this->userData['gid'])) return $this->userData['gid']; else return false; }
  public function lastError() { return $this->login_error; }
  
  /* На какие модули есть админские права - Права определяются по Разрешению(наличию) Дейсвия добавления */
  public function getRightAdmin() {
  	$right = array();
  	foreach ($this->user_right as $module => $action) {
  		if (isset($this->user_right[$module]['add'])) {
  			if ($this->user_right[$module]['add'] == true) {
  				$right[$module] = true;
  			}
  		}
  		/*
  		if (isset($this->user_right[$module]['useAdmin'])) {
  			if ($this->user_right[$module]['useAdmin'] == true) {
  				$right[$module] = true;
  			}
  		}
  		*/
  	}
  	return $right;   	
  }


  public function getRight($module, $action) {
    $right = false;
    if (isset($this->user_right[$module][$action])) $right = $this->user_right[$module][$action];
    $this->Log->addToLog('Запрос прав '.$module.'.'.$action.' '.(($right) ? 'Разрешено' : 'Запрещено'), __LINE__, __METHOD__);
    return $right;
  }

  public function getRightModule($module) {
    $right = true;
    //stop($this->user_right[$module]);
    if (!isset($this->user_right[$module])) {
     $right = false;
     return $right;
    }
    foreach  ($this->user_right[$module] as $a) if ($a == 0) {$right = false;}
    $this->Log->addToLog('Запрос прав '.$module.' '.$right, __LINE__, __METHOD__);
    return $right;
  }

  
  /**
   * проверка логина и пароля (если имеются) и текущей сессии
   */
  public function authentication ($username, $password) {
    if ($username == '' || $password == '') return false;
    $sql = 'SELECT * FROM '.TAB_PREF.'users WHERE login = \'%1$s\' AND pass = \'%2$s\' AND isban = 0';
    $this->query($sql, $username, md5($password));
//    stop($this->numRows());
$row = $this->fetchOneRowA();
    if ($this->numRows() == 1) {

      $this->user_id = $row['id'];
      $this->user_name = $row['name'];
	  
	  $sql2 = '
      INSERT INTO ' . TAB_PREF . 'logins
           (id_user,ip,referer,browser,screen_size,os)
     VALUES
           (\'' . $row ["id"] . '\', \'' . $_SERVER ["REMOTE_ADDR"] . '\', 
            \'' . $_SERVER ["HTTP_REFERER"] . '\', \'' . $_SERVER ["HTTP_USER_AGENT"] . '\',
            \'\', \'' . PHP_OS . '\')';
			$this->query ( $sql2 );
	  
      return true;
    }

    return false;
  }
  
  /*
  Получени параметров меню, есть ли установка NEW
  */
  public function get_menu_new($id){
		$sql = "SELECT access FROM ".TAB_PREF."pages WHERE id ='$id'";
		$this->query($sql);
		$row = $this->fetchOneRowA();
		return $row['access'];
	}
  
  /**
   * Получение данных о пользователе и установка прав
   */
  public function get_user_data ($user_id) {
  	if ($user_id > 0) {
  		$sql = 'SELECT u.*, g.id as gid, g.name as gname FROM '.TAB_PREF.'users u
            LEFT JOIN ('.TAB_PREF.'groups_user ug INNER JOIN '.TAB_PREF.'groups g ON ug.group_id = g.id) ON u.id = ug.user_id
            WHERE u.id = \'%1$u\'';
	    $this->query($sql, $user_id);
	    $this->userData = $this->fetchRowA();
	    
	    $sql = 'SELECT 
	    IF(ma.access IS NOT NULL, ma.access, ma2.access) as access, 
	    IF(ma.action_name IS NOT NULL, ma.action_name, ma2.action_name) as action_name, 
	    IF(mc.access IS NOT NULL, mc.access, ma.access) as mcaccess, 
	    IF(m.name IS NOT NULL, m.codename, m2.codename) as mcodename, 
	    IF(gu.group_id IS NOT NULL, gu.group_id, 0)  , 
	    IF(tn.owner IS NOT NULL, tn.owner, 0)  ,
	    IF(g.name IS NOT NULL, g.name, \'\') , 
	    IF(ma.id IS NOT NULL, ma.id, ma2.id) as maid
		FROM '.TAB_PREF.'tree_nodes tn
		INNER join '.TAB_PREF.'groups_user gu on (tn.child = gu.group_id or tn.owner = gu.group_id) and gu.user_id = %1$u
		INNER join '.TAB_PREF.'module_access mc on (tn.child = mc.group_id or tn.owner = mc.group_id)
		INNER join '.TAB_PREF.'groups g on mc.group_id = g.id
		INNER join '.TAB_PREF.'module_actions ma on mc.action_id = ma.id
		INNER join '.TAB_PREF.'modules m on ma.mod_id = m.id

		left join '.TAB_PREF.'module_actions ma2 ON (ma2.access = 2 and %1$u > 0) or (ma2.access = 1)
		left JOIN '.TAB_PREF.'modules m2 ON ma2.mod_id = m2.id
		
		GROUP BY maid';
	    
	    if (DB_USE == 'MSSQL') {
	    	$sql = 'SELECT distinct
	    ma.action_name, 
	    ma.access as access,
	    mc.access as mcaccess , 
	    m.codename as mcodename, 
	    gu.group_id, 
	    tn.owner,
	    g.name, 
	    ma.id
	    
	FROM '.TAB_PREF.'tree_nodes tn (nolock)
	INNER join '.TAB_PREF.'groups_user gu (nolock) on (tn.child = gu.group_id or tn.owner = gu.group_id) and gu.user_id = %1$u
	INNER join '.TAB_PREF.'module_access mc (nolock) on (tn.child = mc.group_id or tn.owner = mc.group_id)
	INNER join '.TAB_PREF.'groups g (nolock) on mc.group_id = g.id
	INNER join '.TAB_PREF.'module_actions ma (nolock) on mc.action_id = ma.id
	INNER join '.TAB_PREF.'modules m( nolock)  on  ma.mod_id = m.id
	union all
	select 
	ma2.action_name, 
	ma2.[access], 
	ma2.[access], 
	m2.codename, 
	0,
	0,
	\'\', 
	ma2.id
	from '.TAB_PREF.'module_actions ma2 (nolock)  
	INNER JOIN '.TAB_PREF.'modules m2 (nolock) ON ma2.mod_id = m2.id
	where (ma2.access = 2 and %1$u > 0) or (ma2.access = 1)';
	    }
	    
	    $user_group = $this->userData['gid'];
	    $this->query($sql, $user_id,$user_group);

	    while (($row = $this->fetchRowA())!==false) {
	    	$a = false;
	    	
	    	if (($row['access'] == 1) || ($row['access'] == 2 && $user_id > 0)) $a = true;
	    	elseif ($row['mcaccess'] == 1) $a = true;
	     	$this->Log->addToLog('Установка разрешения '.$row['mcodename'].'.'.$row['action_name'].' установка в '.(($a) ? 'Разрешено' : 'Запрещено'), __LINE__, __METHOD__);
	    	$this->user_right[$row['mcodename']][$row['action_name']] = $a;
	    }   
	    //stop($this->user_right);
  	} else {
  		# ACTION_PUBLIC
  		$this->user_right = array();
  		$sql = 'SELECT ma.*, m.name as mname, m.codename as mcodename, mc.access as mcaccess, mc.group_id
	            FROM '.TAB_PREF.'module_actions ma
	            LEFT JOIN '.TAB_PREF.'module_access mc ON ma.id = mc.action_id
	            INNER JOIN '.TAB_PREF.'modules m ON ma.mod_id = m.id
	            WHERE ma.access = %2$u';

  		$this->query($sql, $user_id, ACTION_PUBLIC);

  		while (($row = $this->fetchRowA())!==false) {
  			$a = false;
  			if ($row['access'] == 1 ) $a = true;
  			elseif ($row['mcaccess'] == 1) $a = true;
  			$this->user_right[$row['mcodename']][$row['action_name']] = $a;
  			$this->Log->addToLog('Установка разрешения '.$row['mcodename'].'.'.$row['action_name'].' установка в '.(($a) ? 'Разрешено' : 'Запрещено'), __LINE__, __METHOD__);
  		}
  	}  	
  }
  
  
  public function get_user_data_LDAP ($group_name) {
  	  	
  	$this->Log->addToLog(array('Права авторизированнго пользователя LDAP', 'group_name' =>$group_name, 'login'=>(($group_name) ? 'TRUE' : 'FALSE')), __LINE__,__METHOD__);
  	
	/* Права авторизированнго пользователя */
  	if ($group_name != '' && DB_USE == 'MSSQL') {
  		$sql = 'SELECT distinct
	    ma.action_name, 
	    ma.access as access,
	    mc.access as mcaccess , 
	    m.codename as mcodename, 
	--    gu.group_id, 
	    tn.owner,
	    g.name, 
	    ma.id
	    
		FROM '.TAB_PREF.'tree_nodes tn (nolock)
		-- INNER join '.TAB_PREF.'groups_user gu (nolock) on tn.child = gu.group_id or tn.owner = gu.group_id
		LEFT join '.TAB_PREF.'module_access mc (nolock) on (tn.child = mc.group_id or tn.owner = mc.group_id)
		LEFT join '.TAB_PREF.'groups g (nolock) on mc.group_id = g.id and g.name = \'%1$s\'
		LEFT join '.TAB_PREF.'module_actions ma (nolock) on mc.action_id = ma.id
		LEFT join '.TAB_PREF.'modules m( nolock)  on  ma.mod_id = m.id
		union all
		select 
		ma2.action_name, 
		ma2.[access], 
		ma2.[access], 
		m2.codename, 
	--	0,
		0,
		\'\', 
		ma2.id
		from '.TAB_PREF.'module_actions ma2 (nolock)
		INNER JOIN '.TAB_PREF.'modules m2 (nolock) ON ma2.mod_id = m2.id
		where (ma2.access = 2 and \'%1$s\' <> \'\') or (ma2.access = 1)';
  	
  	
  	$this->query($sql,$group_name, ACTION_PUBLIC);
  	while (($row = $this->fetchRowA())!==false) {
  		$a = false;
  		if ($row['access'] == 1 ) $a = true;
  		elseif ($row['mcaccess'] == 1) $a = true;
  		$this->user_right[$row['mcodename']][$row['action_name']] = $a;
  		$this->Log->addToLog('Установка разрешения (LDAP) '.$row['mcodename'].'.'.$row['action_name'].' установка в '.(($a) ? 'Разрешено' : 'Запрещено'), __LINE__, __METHOD__);
  	}
  	} else {
  		$this->get_user_data(0);
  	}
  }
  
  /**
   * выход (вывод) из системы, как самростоятельно так и по окончании сессии
   */     
  public function logout($redirect = false) {
     if ($redirect) session_start(); 
    session_unset();
    session_destroy();
    if ($redirect) header('Location: http://'.$_SERVER["SERVER_NAME"].'/');
  }

  
  /* Вход по Базе Данных */
  protected function login_DB() {
  	$this->Log->addToLog('Авторизация по БД', __LINE__,__METHOD__);
  /**
   * 0 - нет ошибок, вход не выполнен
   * 1 - вошли удачно
   * -2 - логин или пароль не верены
   * -3 - сессия устарела
   */
    if ($this->Vals->isVal('logout','GET')) $this->logout(true);
    $login = false;
    /**
     * Проверка и Вход по логину и паролю - аутентификация
     */
    if ($this->Vals->isVal('username', 'POST') && $this->Vals->isVal('userpass', 'POST')) {
      $login = $this->authentication ($this->Vals->getVal('username', 'POST', 'string'),$this->Vals->getVal('userpass', 'POST', 'string'));
      if (!$login) $this->login_error = -2;
    }
    
    /**
     * Старт сессии и проверка существующей на жизнь
     */
    if (isset($_SESSION['authorization'])) {
      if (session_id() == $_SESSION['authorization_ses'] && $_SESSION['authorization_user'] != 0) {
        $login = true;
        $this->login_error = 1;
        $this->user_id = $_SESSION['authorization_user'];
      } else { $login = false; $this->login_error = -3; }
    }

    $this->get_user_data ($this->user_id);
    /**
     * При удачной аутентификации, авторизируем
     */
    if ($login) {      
      $_SESSION['authorization'] = 1;
      $_SESSION['authorization_LDAP'] = 0;
      $_SESSION['authorization_user'] = $this->user_id;
      $_SESSION['authorization_ses'] = session_id();
      $this->authorization = true;
      $this->login_error = 1;
      $this->Log->addToLog('Пользователь авторизован',__LINE__, __METHOD__);
      $this->Log->addToLog($this->user_right, __LINE__, __METHOD__);
      return true;
    } else {
      $this->login_error = 0;
      $this->Log->addToLog(array('Пользователь не авторизован (Гость)', $this->user_id),__LINE__, __METHOD__);
      
      $this->logout();
      $this->Log->addToLog($this->user_right, __LINE__, __METHOD__);
      return false;
    }
  }
  
  /* Вход по LDAP */
  protected function login_LDAP() {
  	$this->Log->addToLog('Авторизация по LDAP', __LINE__,__METHOD__);
  	$this->user_id = 0;  
  /**
   * 0 - нет ошибок, вход не выполнен
   * 1 - вошли удачно
   * -2 - логин или пароль не верены
   * -3 - сессия устарела
   */
    if ($this->Vals->isVal('logout','GET')) $this->logout(true);
    $login = false;
    
    
    /**
     * Проверка и Вход по логину и паролю - аутентификация
     */
    $LDAPAuth = new LDAP_AUTH();
    if ($this->Vals->isVal('username', 'POST') && $this->Vals->isVal('userpass', 'POST') && $this->Vals->isVal('domain', 'POST')) {
    	
    	$login = $LDAPAuth->authLDAP($this->Vals->getVal('username', 'POST', 'string'),$this->Vals->getVal('userpass', 'POST', 'string'),$this->Vals->getVal('domain', 'POST', 'string'));
    	$this->Log->addToLog(array('Проверка имени и пароля LDAP', 'login'=>(($login) ? 'TRUE' : 'FALSE')), __LINE__,__METHOD__);
      if (!$login || $LDAPAuth->error != 0) {
      	$this->login_error = -2; 
      	$this->userData['group_name'] = '';
      	$this->userData['gname'] = '';
      	$this->userData['name'] = 'Гость';
      	$_SESSION['ldap_group_name'] = '';
      	$_SESSION['ldap_user_name'] = '';
      }              
      else {
      	$LDAPuserData = $LDAPAuth->getLDAPUserData();
      	$this->user_id = $LDAPAuth->getUserId();   
//      	stop($LDAPAuth->getUserName());   	
      	$this->name = $LDAPAuth->getUserName();      	
      	$this->userData['group_name'] = $LDAPAuth->getGroupName();      	
      	$this->userData['gname'] = $LDAPAuth->getGroupName();      	
      	$this->userData['name'] = $this->name;
      	$_SESSION['ldap_group_name'] = $this->userData['group_name'];
      	$_SESSION['ldap_user_name'] = $this->name;      	
      }    
      
      $this->Log->addToLog(array('Проверка имени и пароля LDAP', 'login'=>(($login) ? 'TRUE' : 'FALSE')), __LINE__,__METHOD__);
    }
    
    /**
     * Старт сессии и проверка существующей на жизнь
     */
    if (isset($_SESSION['authorization'])) {
      if (session_id() == $_SESSION['authorization_ses'] && $_SESSION['authorization_user'] != 0 && $_SESSION['authorization_LDAP'] == 1) {      	
      	$login = true;
        $this->login_error = 1;
        $this->user_id = $_SESSION['authorization_user'];
        $this->name = $_SESSION['ldap_user_name'];   
        //stop($this->name);   	
      	$this->userData['group_name'] = $_SESSION['ldap_group_name'];      	
      	$this->userData['gname'] = $_SESSION['ldap_group_name'];      	
      	$this->userData['name'] = $_SESSION['ldap_user_name'];
        
      } else { $login = false; $this->login_error = -3; }
      
      $this->Log->addToLog(array('Проверка Существующей сессии LDAP', 'login'=>(($login) ? 'TRUE' : 'FALSE'), session_id() ,$_SESSION['authorization_ses'],$_SESSION['authorization_user'], $_SESSION['authorization_LDAP']), __LINE__,__METHOD__);
      
    }

    $this->get_user_data_LDAP($this->userData['group_name']);
    
    /**
     * При удачной аутентификации, авторизируем
     */
    if ($login) {      
      $_SESSION['authorization'] = 1;
      $_SESSION['authorization_LDAP'] = 1;
      $_SESSION['authorization_user'] = $this->user_id;
      $_SESSION['authorization_ses'] = session_id();
      $this->authorization = true;
      $this->login_error = 1;
      $this->Log->addToLog('Пользователь авторизован',__LINE__, __METHOD__);
      $this->Log->addToLog($this->user_right, __LINE__, __METHOD__);
      return true;
    } else {
      $this->login_error = 0;
      $this->Log->addToLog(array('Пользователь не авторизован (Гость)', $this->user_id),__LINE__, __METHOD__);
      
      $this->logout();
      $this->Log->addToLog($this->user_right, __LINE__, __METHOD__);
      return false;
    }
  }
  
  
  /**
   * вход в систему, проверка сессии
   */
  public function login() {
  	if ($this->Vals->isVal('domain','POST')) {
  		$domain = $this->Vals->getVal('domain','POST','string');
  		if ($domain != '' && $domain != 'local') {  			
  			return $this->login_LDAP();
  		}
  		else {  			
  			return $this->login_DB();
  		}
  	} elseif (isset($_SESSION['authorization_LDAP'])) {
  		if ($_SESSION['authorization_LDAP'] == 1) {
  			return $this->login_LDAP(); 
  		} else {
  			return $this->login_DB();
  		}
  	} else {
  		return $this->login_DB();
  	}
  	
  	return false;
  }


  public function isAutch() {
    if (!isset($_SESSION['authorization']) || !isset($_SESSION['authorization_user'])) return false;
    if ($_SESSION['authorization'] == 1 && $_SESSION['authorization_user'] != 0) return $this->authorization;
    return false;
  }

}

class userView extends module_view {
	public function __construct () {
		$modName = 'CurentUser';
		$sysMod = new modsetItem(array());
		parent::__construct($modName, $sysMod);
		$this->pXSL = array();
	}
	/**
	 * Форма регистрации	 
	 * @return unknown_type
	 */
	public function getModName() {
		return $this->modName;
	}
	public function viewRegister() {
		
	}
	/**
	 * Стандартная информация о пользователе
	 * @param $userData Массив данных из TUser->userData
	 * @return unknown_type
	 */
	public function viewUserInfo($userData) {
		if(!is_array($userData)) return false;
		
	}
	/**
	 * Продвинутый блок логина и пароля, включает в себя дополнительные параметры
	 * @param $message
	 * @param $user_id
	 * @param $Params - параметры отображения окна логин/статус
	 * @param $StatusBar - данные для окна статуса
	 * @return unknown_type
	 */
	public function viewLoginParams ($title, $message, $user_id, $Params, $StatusBar, $rightsModAdmin=0) {
		global $_SESSION, $User, $loginErrors;
		/*
		 * $Params set array of
		 * 	isLogout : {0,1}
		 * 	isRegister : {0,1}
		 * 	regLink : string
		 * 	titleType : {norm,error,warning}
		 * 	isRedirect : {0,1}
		 */
		$sysMod = new modsetItem(array());
		$sysMod->name = 'login';
		$sysMod->defModName = 'login';
		$View = new module_view('login', $sysMod);
		if (gettype($message) != 'array') $message = array(0 => $message);
		if (gettype($title) != 'array') $title = array(0 => $title);
		$Container = $this->newContainer('login');

		$this->pXSL[] = RIVC_ROOT.'layout/viewLoginBar.xsl';
		# sprintf($loginErrors[$User->lastError()], $User->getUserName())
		$this->addToNode($Container, 'login', intval($User->lastError()));
		$this->addToNode($Container, 'referer', SITE_ROOT.$_SERVER["REQUEST_URI"]);
		$this->addToNode($Container, 'user_id', $user_id);
		$this->addToNode($Container, 'rightsModAdmin', $rightsModAdmin);
		$this->addToNode($Container, 'subject', $message[0]);
		$this->addToNode($Container, 'title', $title[0]);
		$this->addToNode($Container, 'error', sprintf($loginErrors[$User->lastError()], $User->getUserName()));
		if ($User->lastError() == 1) $this->addToNode($Container, 'user_name', $User->getUserName());
		else $this->addToNode($Container, 'user_name', '');
		
		$StatusBar[] = array ('subject' => 'Группа', 'message' => $User->getUserGroupName());
		 
		$ParamsBlock = $this->addToNode($Container, 'params','');
		foreach ($Params as $key => $val) {
			$this->arrToXML($val,$ParamsBlock,'item');
		}
		$StatusBarBlock = $this->addToNode($Container, 'statusbar','');
		foreach ($StatusBar as $key => $val) {
			$this->arrToXML($val,$ParamsBlock,'item');

		}
	}
}
?>
