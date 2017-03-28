<?php
class titleItem extends module_item {
	public $id;
	
	public function __construct($Params, $prefix = '') {
		parent::__construct ();
		if ($prefix != '')
			$prefix .= '_';
		if (isset ( $Params [$prefix . 'id'] ))
			$this->id = $Params [$prefix . 'id'];
		else
			$this->id = 0;
		$this->notInsert ['id'] = 1;
	}
	public function toArray() {
		$Params ['id'] = $this->id;
		return $Params;
	}
	public function toSelect($pref) {
		$sql = '`' . $pref . '`.`id` AS `' . $pref . '_id`, `' . $pref . '`.`id_reis` AS `' . $pref . '_id_reis`, `' . $pref . '`.`nr` AS `' . $pref . '_nr`, `' . $pref . '`.`nm` AS `' . $pref . '_nm`, `' . $pref . '`.`nu` AS `' . $pref . '_nu`, `' . $pref . '`.`lit` AS `' . $pref . '_lit`, `' . $pref . '`.`bort` AS `' . $pref . '_bort`, `' . $pref . '`.`bort_rez` AS `' . $pref . '_bort_rez`, `' . $pref . '`.`stat` AS `' . $pref . '_stat`, `' . $pref . '`.`fl` AS `' . $pref . '_fl`, `' . $pref . '`.`ap1` AS `' . $pref . '_ap1`, `' . $pref . '`.`ap2` AS `' . $pref . '_ap2`, `' . $pref . '`.`vo` AS `' . $pref . '_vo`, `' . $pref . '`.`vp` AS `' . $pref . '_vp`, `' . $pref . '`.`aobt` AS `' . $pref . '_aobt`, `' . $pref . '`.`atot` AS `' . $pref . '_atot`, `' . $pref . '`.`atl` AS `' . $pref . '_atl`, `' . $pref . '`.`ata` AS `' . $pref . '_ata`, `' . $pref . '`.`vo_l` AS `' . $pref . '_vo_l`, `' . $pref . '`.`vp_l` AS `' . $pref . '_vp_l`, `' . $pref . '`.`zr1` AS `' . $pref . '_zr1`, `' . $pref . '`.`vz1` AS `' . $pref . '_vz1`, `' . $pref . '`.`prich1` AS `' . $pref . '_prich1`, `' . $pref . '`.`zr2` AS `' . $pref . '_zr2`, `' . $pref . '`.`vz2` AS `' . $pref . '_vz2`, `' . $pref . '`.`prich2` AS `' . $pref . '_prich2`, `' . $pref . '`.`ts` AS `' . $pref . '_ts`, `' . $pref . '`.`dtvo` AS `' . $pref . '_dtvo`, `' . $pref . '`.`dtvp` AS `' . $pref . '_dtvp`, `' . $pref . '`.`dtaobt` AS `' . $pref . '_dtaobt`, `' . $pref . '`.`dtata` AS `' . $pref . '_dtata`, `' . $pref . '`.`kbc` AS `' . $pref . '_kbc`, `' . $pref . '`.`mm` AS `' . $pref . '_mm`, `' . $pref . '`.`kce` AS `' . $pref . '_kce`, `' . $pref . '`.`kbp` AS `' . $pref . '_kbp`, `' . $pref . '`.`p1` AS `' . $pref . '_p1`, `' . $pref . '`.`pe` AS `' . $pref . '_pe`, `' . $pref . '`.`pb` AS `' . $pref . '_pb`, `' . $pref . '`.`kb` AS `' . $pref . '_kb`, `' . $pref . '`.`komp1` AS `' . $pref . '_komp1`, `' . $pref . '`.`kompb` AS `' . $pref . '_kompb`, `' . $pref . '`.`kompe` AS `' . $pref . '_kompe`, `' . $pref . '`.`tb1` AS `' . $pref . '_tb1`, `' . $pref . '`.`tbb` AS `' . $pref . '_tbb`, `' . $pref . '`.`tbe` AS `' . $pref . '_tbe`, `' . $pref . '`.`po` AS `' . $pref . '_po`, `' . $pref . '`.`pp` AS `' . $pref . '_pp`, `' . $pref . '`.`po_l` AS `' . $pref . '_po_l`, `' . $pref . '`.`pp_l` AS `' . $pref . '_pp_l`, `' . $pref . '`.`ae1` AS `' . $pref . '_ae1`, `' . $pref . '`.`ae2` AS `' . $pref . '_ae2`, `' . $pref . '`.`pkz` AS `' . $pref . '_pkz`, `' . $pref . '`.`za` AS `' . $pref . '_za`, `' . $pref . '`.`fuel` AS `' . $pref . '_fuel`, `' . $pref . '`.`pax1` AS `' . $pref . '_pax1`, `' . $pref . '`.`paxb` AS `' . $pref . '_paxb`, `' . $pref . '`.`paxe` AS `' . $pref . '_paxe`, `' . $pref . '`.`vzr` AS `' . $pref . '_vzr`, `' . $pref . '`.`rb` AS `' . $pref . '_rb`, `' . $pref . '`.`rm` AS `' . $pref . '_rm`, `' . $pref . '`.`kab` AS `' . $pref . '_kab`, `' . $pref . '`.`bag` AS `' . $pref . '_bag`, `' . $pref . '`.`pochta` AS `' . $pref . '_pochta`, `' . $pref . '`.`gruz` AS `' . $pref . '_gruz`, `' . $pref . '`.`StationReport` AS `' . $pref . '_StationReport`, `' . $pref . '`.`DelayCateg` AS `' . $pref . '_DelayCateg`, `' . $pref . '`.`prim` AS `' . $pref . '_prim`, `' . $pref . '`.`dvu` AS `' . $pref . '_dvu`, `' . $pref . '`.`dtvu` AS `' . $pref . '_dtvu`, `' . $pref . '`.`dk` AS `' . $pref . '_dk`, `' . $pref . '`.`vr` AS `' . $pref . '_vr`, `' . $pref . '`.`ld` AS `' . $pref . '_ld`, `' . $pref . '`.`edit` AS `' . $pref . '_edit`, `' . $pref . '`.`first` AS `' . $pref . '_first`, `' . $pref . '`.`econom` AS `' . $pref . '_econom`, `' . $pref . '`.`ts_nmas` AS `' . $pref . '_ts_nmas`, `' . $pref . '`.`data` AS `' . $pref . '_data`, `' . $pref . '`.`ofp` AS `' . $pref . '_ofp`, `' . $pref . '`.`book1` AS `' . $pref . '_book1`, `' . $pref . '`.`bookB` AS `' . $pref . '_bookB`, `' . $pref . '`.`bookE` AS `' . $pref . '_bookE`, `' . $pref . '`.`LastBookingLoad` AS `' . $pref . '_LastBookingLoad`, `' . $pref . '`.`pv` AS `' . $pref . '_pv`, `' . $pref . '`.`zprim` AS `' . $pref . '_zprim`, `' . $pref . '`.`zarrprim` AS `' . $pref . '_zarrprim`, `' . $pref . '`.`dtvo_s` AS `' . $pref . '_dtvo_s`';
		return $sql;
	}
	public function toUpdate($pref) {
		$sql = ' `id_reis` = \'%2$s\' `nr` = \'%3$s\' `nm` = \'%4$s\' `nu` = \'%5$s\' `lit` = \'%6$s\' `bort` = \'%7$s\' `bort_rez` = \'%8$s\' `stat` = \'%9$s\' `fl` = \'%10$s\' `ap1` = \'%11$s\' `ap2` = \'%12$s\' `vo` = \'%13$s\' `vp` = \'%14$s\' `aobt` = \'%15$s\' `atot` = \'%16$s\' `atl` = \'%17$s\' `ata` = \'%18$s\' `vo_l` = \'%19$s\' `vp_l` = \'%20$s\' `zr1` = \'%21$s\' `vz1` = \'%22$s\' `prich1` = \'%23$s\' `zr2` = \'%24$s\' `vz2` = \'%25$s\' `prich2` = \'%26$s\' `ts` = \'%27$s\' `dtvo` = \'%28$s\' `dtvp` = \'%29$s\' `dtaobt` = \'%30$s\' `dtata` = \'%31$s\' `kbc` = \'%32$s\' `mm` = \'%33$s\' `kce` = \'%34$s\' `kbp` = \'%35$s\' `p1` = \'%36$s\' `pe` = \'%37$s\' `pb` = \'%38$s\' `kb` = \'%39$s\' `komp1` = \'%40$s\' `kompb` = \'%41$s\' `kompe` = \'%42$s\' `tb1` = \'%43$s\' `tbb` = \'%44$s\' `tbe` = \'%45$s\' `po` = \'%46$s\' `pp` = \'%47$s\' `po_l` = \'%48$s\' `pp_l` = \'%49$s\' `ae1` = \'%50$s\' `ae2` = \'%51$s\' `pkz` = \'%52$s\' `za` = \'%53$s\' `fuel` = \'%54$s\' `pax1` = \'%55$s\' `paxb` = \'%56$s\' `paxe` = \'%57$s\' `vzr` = \'%58$s\' `rb` = \'%59$s\' `rm` = \'%60$s\' `kab` = \'%61$s\' `bag` = \'%62$s\' `pochta` = \'%63$s\' `gruz` = \'%64$s\' `StationReport` = \'%65$s\' `DelayCateg` = \'%66$s\' `prim` = \'%67$s\' `dvu` = \'%68$s\' `dtvu` = \'%69$s\' `dk` = \'%70$s\' `vr` = \'%71$s\' `ld` = \'%72$s\' `edit` = \'%73$s\' `first` = \'%74$s\' `econom` = \'%75$s\' `ts_nmas` = \'%76$s\' `data` = \'%77$s\' `ofp` = \'%78$s\' `book1` = \'%79$s\' `bookB` = \'%80$s\' `bookE` = \'%81$s\' `LastBookingLoad` = \'%82$s\' `pv` = \'%83$s\' `zprim` = \'%84$s\' `zarrprim` = \'%85$s\' `dtvo_s` = \'%86$s\'';
		return $sql;
	}
	public function toJoin($thisTable, $pref, $pref2, $type, $thisField, $field2, $addr = '') {
		
		if ($thisTable == '' || $thisField == '' || $field2 == '')
			return '';
		
		$sql = $type . ' JOIN ' . $thisTable . ' as ' . $pref . ' ON ' . $pref . '.' . $thisField . ' = ' . $pref2 . '.' . $field2 . ' ' . $addr . rn;
		
		$sql .= rn;
		
		return $sql;
	
	}
}
class titleCollection extends module_collection {
	
	public function __construct() {
		
		parent::__construct ();
	
	}
	
	public function addItem($Params) {
		
		$item = new titleItem ( $Params );
		
		$this->add ( $item );
	
	}

}
class titleModel extends module_model {
	public function __construct($modName) {
		parent::__construct ( $modName );
	}
	
	public function getIndex() {
		/***** Старая версия (полное меню независящее отправ ******/
	/*	$sql = 'SELECT sm.[parent]
      ,sm.[name_ru]
      ,sm.[name_en]
      ,sm.[url]
      ,smp.[desc]
      ,smp.name_en as modul
  FROM [".TAB_PREF."menu] sm (nolock)
  left join [".TAB_PREF."menu] smp on sm.parent=smp.id
  where smp.isen > 0 and sm.isen > 0
  order by sm.parent';*/
		
		/***** Зависимость от прав группы на использование модулей ***/
		$user_id=$this->User->getUserID();

		$sql='SELECT group_id
  				FROM '.TAB_PREF.'groups_user
  				WHERE user_id='.$user_id;
		$this->query ($sql);
		$group = $this->fetchOneRowA ();
		$group=$group['group_id'];	
$pref_lang = "_" .  $_SESSION ['lang'];		
		$sql = "SELECT sm.parent
,sm.name" . $pref_lang . " as name
      ,sm.id
      ,sm.url
      ,smp.desc" . $pref_lang . " as desc
      ,smp.name_en as modul
      
  FROM ".TAB_PREF."menu sm (nolock)
  left join ".TAB_PREF."menu smp (nolock) on sm.parent=smp.id
  left join ".TAB_PREF."modules m (nolock) on sm.url like '/'+m.codename+'/'
  left join ".TAB_PREF."module_actions mact (nolock) on mact.mod_id=m.id and (mact.action_name=m.defAction)
  left join ".TAB_PREF."module_actions mact2 (nolock) on sm.url like '%%/'+mact2.action_name+'-%%'
  left join ".TAB_PREF."modules m2 (nolock) on m2.id=mact2.mod_id and sm.url like '/'+m2.codename+'/%%'
  left join ".TAB_PREF."module_access mac (nolock) on mac.action_id=mact.id and mac.group_id=".$group."  -- номер группы
  left join ".TAB_PREF."module_access mac2 (nolock) on mac2.action_id=mact2.id and mac2.group_id=".$group."
  where 
  smp.isen > 0 and sm.isen > 0 and 
  (mact.action_name is not null or m2.id is not null)
  and (mac.access=1 or mac2.access=1)
  order by sm.parent";

		$this->query ($sql);
		$titleCollection = array ();
		$test='';
		while ( ($row = $this->fetchRowA ()) !== false ) {
			if ($test!=$row['modul']){$test=$row['modul'];}
			$titleCollection[$test][] = $row;
		}
		return $titleCollection;
	}
}
class titleProcess extends module_process {
	public function __construct($modName) {
		global $values, $User, $LOG, $System;
		parent::__construct ( $modName );
		$this->Vals = $values;
		$this->System = $System;
		if (! $modName)
			unset ( $this );
		$this->modName = $modName;
		$this->User = $User;
		$this->Log = $LOG;
		$this->action = false;
		/* actionDefault - Действие по умолчанию. Должно браться из БД!!! */		$this->actionDefault = '';
		$this->actionsColl = new actionColl ();
		$this->nModel = new titleModel ( $modName );
		$sysMod = $this->nModel->getSysMod ();
		$this->sysMod = $sysMod;
		$this->mod_id = $sysMod->id;
		$this->nView = new titleView ( $this->modName, $this->sysMod );
		$this->regAction ( 'view', 'Главная страница', ACTION_GROUP );
		if (DEBUG == 0) {
			$this->registerActions ( 1 );
		}
		if (DEBUG == 1) {
			$this->registerActions ( 0 );
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

		$user_right = $this->User->getRight ( $this->modName, $action );
		if ($user_right == 0 && $user_id > 0) {
			$p = array ('У Вас нет прав для использования модуля', '$this->modName' => $this->modName, 'action' => $action, 'user_id' => $user_right, 'user_right' => $user_right );
			$this->nView->viewError ( 'У Вас нет прав на это действие.', 'Предупреждение' );
			$this->Log->addError ( $p, __LINE__, __METHOD__ );
			$this->updated = true;
			return;
		}
	//	if ($user_right == 0 && ! $_action) {
			$this->User->nView->viewLoginParams ( '', '', $user_id, array (), array () );
			$this->updated = true;
			return;
//		}
		
		
		/********************************************************************************/
		if ($action == 'view') {
			
			
			$item = $this->nModel->getIndex ();
			
			
			$this->nView->view_Index ( $item );
			$this->updated = true;
		}
		
		/********************************************************************************/
		
	}
}
/*************************************/
class titleView extends module_View {
	public function __construct($modName, $sysMod) {
		parent::__construct ( $modName, $sysMod );
		$this->pXSL = array ();
	}
	
	public function view_Index($items) {
		$Container = $this->newContainer ( 'index' );
		$itemConteiner = $this->addToNode ( $Container, 'items', '' );
		$this->pXSL [] = RIVC_ROOT . 'layout/' . $this->modName . '/index.view.xsl';
$pref_lang = "_" .  $_SESSION ['lang'];
		foreach ( $items as $key => $item ) {
			$itemConteiner2 = $this->addToNode ( $itemConteiner, 'item', '' );
			$this->addAttr ( 'modul', $key.$pref_lang, $itemConteiner2 );
			foreach ( $item as $mod ) {
				try {
					$this->arrToXML ( $mod, $itemConteiner2, 'mod', array () );
				} catch ( Exception $e ) {
					stop ( 'Caught exception: ' . $e->getMessage (), "\n" );
				}
			}
		}
	}

}
/*************************************/
?>
