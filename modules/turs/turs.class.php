<?php
class siteModel extends module_model {
	public function __construct($modName) {
		parent::__construct ( $modName );
	}	
	
	public function turList($param) {
        /* Умолачния  */
        $param['price_from'] = ($param['price_from']=='')?0:$param['price_from'];
        $param['price_to'] = ($param['price_to']=='')?1000000:$param['price_to'];
        $param['raion'] = (is_null($param['raion']))?array('[.]'):$param['raion'];
		/* Не Лаппеенранта */
		$add_where = (is_array($param['target']))?(in_array("9", $param['target'])?' AND UPPER(t.name) NOT REGEXP \'ЛАППЕЕНРАНТА\' ':''):'';
		
		/* Продолжительность */
		if ($param['how_long']>0) {
			$add_where .= ($param['how_long']<4)?" AND t.days = ".$param['how_long']."":" AND t.days > 3";
		}
		
		/* Направление (страна) */
		if ($param['country']>0) {
			$add_where .= " AND t.id_loc = ".$param['country']."";
		}
		
		/* Период */
		if ($param['start_date']>0 and $param['type'] == 3) {
			$add_where .= " AND (`date` >= '".$this->dmy_to_mydate($param['start_date'])."' AND `date` <= '".$this->dmy_to_mydate($param['end_date'])."') 
			or (t.date_to >= '".$this->dmy_to_mydate($param['start_date'])."' and t.date_to >= '".$this->dmy_to_mydate($param['end_date'])."' and t.tur_type = 3)";
		}
		
		/* Праздничные даты */
		$pr_where = ($param['type'] == 4)?" AND (
		(`date` >= '2014-10-30' AND `date` <= '2014-11-10') OR
		(`date` >= '2014-12-29' AND `date` <= '2015-01-12') OR
		(`date` >= '2015-02-21' AND `date` <= '2015-02-25') OR
		(`date` >= '2015-03-06' AND `date` <= '2015-03-10') OR
		(`date` >= '2015-03-23' AND `date` <= '2015-04-01') OR
		(`date` >= '2015-04-30' AND `date` <= '2015-05-12') OR
		(`date` >= '2015-06-11' AND `date` <= '2015-06-15')
		) ":' AND tur_type = \''.$param['type'].'\' ';
		/* Новогодние туры */
		$pr_where = ($param['type'] == 5)?" AND (
		(`date` >= '2014-12-30' AND `date` <= '2015-01-11')
		) ":$pr_where;
		
		/* Прочие условия */
		$other_where = ($param['type'] != 5 AND $param['type'] != 4)?'
			/* AND id_loc  IN ('.@implode(',',$param['loc']).')*/
			 AND (UPPER(t.name)  REGEXP \''.@implode('|',$param['raion']).'\' or t.tur_type <> 1 or \''.@implode('|',$param['raion']).'\' = \'[.]\')
			/* AND tur_transport  IN ('.@implode(',',$param['trans']).')*/
			/* AND tur_target  IN ('.@implode(',',$param['target']).')*/
			 ':'';
		$where = '';
		if ($param['price_from'] >= 0) {
		 $kurs = 60*1.02;
		 $where = '
			 AND (
			 (cost >= \''.$param['price_from'].'\' AND cost <= \''.$param['price_to'].'\' AND currency <> \'у.е.\')
			 OR
			 (cost >= \''.$param['price_from']/$kurs.'\' AND cost <= \''.$param['price_to']/$kurs.'\' AND currency = \'у.е.\')
			 )
		 ';
		}
	
		$sql = "SELECT t.`id`, t.`name`,t.`date`, t.date_to, t.days,
		c.`name` city_name, l.`name` loc_name, t.fire, t.dop_info,
		g.`name` gid_name, b.`number` bus_number,cost,currency, id_page,tur_type,overview,bus_size,tur_transport,tur_target,
		(select count(*) from tc_tur_list tl WHERE tl.id_tur = t.`id`) turists
		FROM `tc_tur` t
		LEFT JOIN tc_citys c ON t.id_city = c.id
		LEFT JOIN tc_locations l ON t.id_loc = l.id
		LEFT JOIN tc_gids g ON t.id_gid = g.id
		LEFT JOIN tc_bus b ON t.id_bus = b.id
		WHERE ((date >= NOW() - INTERVAL 1 DAY) or (t.date_to >= NOW() - INTERVAL 1 DAY and (t.tur_type = 3 or tur_target = 8)))
			$pr_where
			$other_where
			$where
			$add_where
			/*and datediff(`date`,now()) < 180*/
		ORDER BY date
		LIMIT 0,300";
		$this->query ( $sql );
		echo "<!-- ".$this->sql." -->";
	//		stop($this->sql,0);
		$items = array ();
		while ( ($row = $this->fetchRowA ()) !== false ) {
			$row ['date'] = $this->dateToRuFormat( $row ['date'] );
			$row ['date_to'] = $this->dateToRuFormat( $row ['date_to'] );
			$items [] = $row;
		}
		return $items;
	}
	
	function dateToRuFormat($date) {
		$date = $this->mydate_to_dmy( $date );
		setlocale(LC_ALL, 'ru_RU.CP1251', 'rus_RUS.CP1251', 'Russian_Russia.1251');
		$date = strftime("%a, %d.%m.%Y", strtotime($date));
		return iconv('windows-1251','Utf-8', $date);
	}
	
	public function tourGet($tur_id) {	
		$sql = 'SELECT t.`id`, t.`name`,`date`,c.`name` city_name, l.`name` loc_name, l.`id` loc_id,
		g.`name` gid_name, b.`number` bus_number,cost,currency, t.fire,
		(select count(*) from tc_tur_list tl WHERE tl.id_tur = t.`id`) turists
		FROM `tc_tur` t
		LEFT JOIN tc_citys c ON t.id_city = c.id
		LEFT JOIN tc_locations l ON t.id_loc = l.id
		LEFT JOIN tc_gids g ON t.id_gid = g.id
		LEFT JOIN tc_bus b ON t.id_bus = b.id
		WHERE t.`id` = '.$tur_id.' ';
		//	stop($sql);
		$this->query ( $sql );
		$items = array ();
		while ( ($row = $this->fetchRowA ()) !== false ) {
			$row ['date'] = $this->mydate_to_dmy( $row ['date'] );
			$items [] = $row;
		}
		return $items;
	}
	
	public function getMenu() {
		$sql = 'SELECT  id,  name,  `desc`,  url,  cost FROM tc_menu;';
		$this->query($sql);
		$items = array();
		while(($row = $this->fetchRowA())!==false) {
			$items[] = $row;
		}
		return $items;
	}
	public function getType($type) {
		$sql = 'SELECT  id,  name,  `desc`,  url,  cost FROM tc_menu WHERE id = '.$type.';';
		$this->query($sql);
		$items = array();
		while(($row = $this->fetchRowA())!==false) {
			$items[] = $row;
		}
		return $items;
	}
    public function getLocs() {
        $sql = 'SELECT id, `name`, `color` FROM `tc_locations` WHERE actual = 1';
        $this->query($sql);
        $items = array();
        while(($row = $this->fetchRowA())!==false) {
            $items[] = $row;
        }
        return $items;
    }

    public function getTourTypePath($id, $prev_name) {
        $sql = "SELECT id, tour_sub_name, parent_id  FROM tc_tour_sub_types WHERE id = $id";
        $this->query($sql);
        $item = $this->fetchRowA();
        $parent_id = $item['parent_id'];
        $id = $item['id'];
        $name = $item['tour_sub_name'];
        if ($name != '') {
            $name = "<li><a href='/turs/sub_type-$id'>" . $name . "</a></li>" . ($prev_name != '' ? "" . $prev_name : '');
        }
        if ($parent_id > 0){
            $name = $this->getTourTypePath($parent_id, $name);
        }
        return $name;
    }

    public function getTourTypeName($id) {
        $sql = "SELECT tour_main_title FROM tc_tour_main_types WHERE id = $id";
        $this->query($sql);
        $name = $this->getOne();
        $name = "<li><a href='/turs/main_type-$id'>".$name."</a></li>";
        return $name;
    }
    public function getTourTypes() {
        $sql = 'SELECT id, tour_main_type btn_name, sort, dk FROM tc_tour_main_types';
        $this->query($sql);
        $items = array();
        $btn_style = array('btn-success','btn-warning','btn-info','btn-primary','btn-danger');
        $i = 0;
        while(($row = $this->fetchRowA())!==false) {
            $row['btn-style'] = $btn_style[$i];
            $i = ($i > 3) ? 0 : $i + 1;
            $items[] = $row;
        }
        return $items;
    }
    public function getTourSubTypes($id,$id_sub) {
	    if ($id_sub > 0){
            $sql = "SELECT id, tour_sub_name btn_name, id_main_type, sort, dk FROM tc_tour_sub_types WHERE parent_id = $id_sub";
        }else {
            $sql = "SELECT id, tour_sub_name btn_name, id_main_type, sort, dk FROM tc_tour_sub_types WHERE id_main_type = $id";
        }
        $this->query($sql);
        $items = array();
        $btn_style = array('btn-success','btn-warning','btn-info','btn-primary','btn-danger');
        $i = 0;
        while(($row = $this->fetchRowA())!==false) {
            $row['btn-style'] = $btn_style[$i];
            $i = ($i > 3) ? 0 : $i + 1;
            $items[] = $row;
        }
        return $items;
    }

    public function getTourData($id) {
        $sql = "SELECT tour_sub_name, id_main_type, sort, dk, p.overview 
                FROM tc_tour_sub_types st 
                LEFT JOIN tc_programs p ON p.id = st.id_program
                WHERE st.id = $id";
        $this->query($sql);
        $items = $this->fetchRowA();
        return $items;
    }
    public function getTopTen($id_sub_type, $id_main_type, $id_parent = 0, $step = 0) {
        $id_sub_type = ($id_sub_type > 0) ? $id_sub_type:'0';
        $id_main_type = ($id_main_type > 0) ? $id_main_type:'0';
        $sql = "SELECT 
                    tt.id,
                    tt.name tur_name,
                    tt.date tur_date,
                    tt.date_to tur_date_finish,
                    tc.name tur_from,
                    tl.name tur_to,
                    tg.name gid_name,
                    tg.phone gid_phone,
                    tg.comment gid_comment,
                    tb.number bus_numner,
                    tt.cost tur_cost,
                    tt.currency tur_cost_curr,
                    tt.id_page,
                    tt.fire,
                    tt.days,
                    tt.dop_info,
                    tt.overview,
                    tt.bus_size,
                    tt.tur_transport,
                    tt.comment,
                    tm.name tur_type,
                    (select count(*) from tc_tur_list tl2 WHERE tl2.id_tur = tt.`id`) turists
				FROM tc_tur tt
				LEFT JOIN tc_citys tc ON tc.id = tt.id_city
				LEFT JOIN tc_tour_sub_types ttst ON ttst.id = tt.id_tour_sub_type
				LEFT JOIN tc_tour_main_types ttmt ON ttmt.id = ttst.id_main_type
				LEFT JOIN tc_locations tl ON tl.id = tt.id_loc
				LEFT JOIN tc_gids tg ON tg.id = tt.id_gid
				LEFT JOIN tc_bus tb ON tb.id = tt.id_bus
				LEFT JOIN tc_menu tm ON tm.id = tt.id_type
				  WHERE ((date >= NOW() - INTERVAL 1 DAY) 
				        AND (tt.id_tour_sub_type = $id_sub_type OR $id_sub_type = 0)
				        AND (ttst.parent_id = $id_parent OR $id_parent = 0)
				        AND (ttmt.id = $id_main_type OR $id_main_type = 0)
				        /*or (tt.date_to >= NOW() - INTERVAL 1 DAY and tt.tur_type = 3)*/)
				  ORDER BY tt.date
				  LIMIT 0,15";
        $this->query($sql);
        $items = array();
        while(($row = $this->fetchRowA())!==false) {
            setlocale(LC_ALL, 'ru_RU.CP1251', 'rus_RUS.CP1251', 'Russian_Russia.1251');
            $row ['tur_date'] = strftime("%a, %d.%m.%Y", strtotime($row ['tur_date']));
            $row ['tur_date'] = iconv('windows-1251','Utf-8', $row ['tur_date']);
            $row ['comment_alert'] = isset($row ['comment']) ? nl2br($row ['comment']) : '';
            $row ['comment_alert'] = str_replace("\r\n",'', $row ['comment_alert']);
            $items[] = $row;
        }
        // Если не нашли ни одного конечного тура, то ищем по родителям, но не более 5 итераций
        if (count($items) == 0 and $step < 5){
            $step++;
            $items = $this->getTopTen(0, $id_main_type, $id_sub_type, $step);
        }
        return $items;
    }
	public function getSpecTours($type) {
		$sql = "SELECT 
                    tt.id,
                    tt.name tur_name,
                    tt.date tur_date,
                    tt.date_to tur_date_finish,
                    tc.name tur_from,
                    tl.name tur_to,
                    tg.name gid_name,
                    tg.phone gid_phone,
                    tg.comment gid_comment,
                    tb.number bus_numner,
                    tt.cost tur_cost,
                    tt.currency tur_cost_curr,
                    tt.id_page,
                    tt.fire,
                    tt.days,
                    tt.dop_info,
                    tt.overview,
                    tt.bus_size,
                    tt.tur_transport,
                    tt.comment,
                    tm.name tur_type,
                    (select count(*) from tc_tur_list tl2 WHERE tl2.id_tur = tt.`id`) turists
				FROM tc_tur tt
				LEFT JOIN tc_citys tc ON tc.id = tt.id_city
				LEFT JOIN tc_tour_sub_types ttst ON ttst.id = tt.id_tour_sub_type
				LEFT JOIN tc_tour_main_types ttmt ON ttmt.id = ttst.id_main_type
				LEFT JOIN tc_locations tl ON tl.id = tt.id_loc
				LEFT JOIN tc_gids tg ON tg.id = tt.id_gid
				LEFT JOIN tc_bus tb ON tb.id = tt.id_bus
				LEFT JOIN tc_menu tm ON tm.id = tt.id_type
				  WHERE ((date >= NOW() - INTERVAL 1 DAY) AND tt.$type = 1)
				  ORDER BY tt.date
				  LIMIT 0,15";
		$this->query($sql);
		$items = array();
		while(($row = $this->fetchRowA())!==false) {
			setlocale(LC_ALL, 'ru_RU.CP1251', 'rus_RUS.CP1251', 'Russian_Russia.1251');
			$row ['tur_date'] = strftime("%a, %d.%m.%Y", strtotime($row ['tur_date']));
			$row ['tur_date'] = iconv('windows-1251','Utf-8', $row ['tur_date']);
			$row ['comment_alert'] = isset($row ['comment']) ? nl2br($row ['comment']) : '';
			$row ['comment_alert'] = str_replace("\r\n",'', $row ['comment_alert']);
			$items[] = $row;
		}
		return $items;
	}

	public function getCountrys() {
		$sql = 'SELECT * FROM tc_countrys';
		$this->query ( $sql );
		$groups = array ();
		while ( ($row = $this->fetchRowA ()) !== false ) {
			$groups [] = $row;
		}
		return $groups;
	}
	public function getMP($loc_id) {
		$where = ($loc_id>0)?' WHERE id_loc = '.$loc_id:'';
		$sql = 'SELECT * FROM tc_mp'.$where;

		$this->query ( $sql );
		$groups = array ();
		while ( ($row = $this->fetchRowA ()) !== false ) {
			$groups [] = $row;
		}
		return $groups;
	}
	
	public function orderUpdate($params) {
		$sql = 'UPDATE `tc_tourists` SET
		`name_f` = \'%1$s\',`name_i` = \'%2$s\',`name_o` = \'%3$s\',
		`dob` = \'%4$s\',`passport` = \'%5$s\',`phone` = \'%6$s\',
		`def_mp` = \'%7$u\',`country` = \'%8$u\',`comment` = \'%9$s\'
		WHERE `id` = \'%10$u\'';
		if (! $this->query ( $sql, $params['username_f'],$params['username_i'],$params['username_o'],
				$this->dmy_to_mydate($params['dob']),$params['passport'],$params['phone'],
				$params['def_mp'],$params['country'],$params['comment'],$params['user_id'] ))
			return false;
		return true;
	}

	public function addTuristInTour($params,$user_id){
		// Смотрим последний номер брони и присваиваем следующий
		$sql = "SELECT MAX(book_num) FROM tc_tur_list WHERE id_tur = '".$params['tur_id']."'";
		$this->query($sql);
		$book_number = $this->getOne()+1;
		
		// Сколько добавляем туристов в этом заказе
		$count_tourists = count($params['turist_f']);
		
		for ($i=0; $i<$count_tourists; $i++) {
			if ($params['turist_id'][$i]>0) {
				$turist_id = $params['turist_id'][$i];
			}else{
				$sql = "INSERT INTO tc_tourists
							(  name_f ,name_i ,name_o ,dob ,country ,passport ,phone, name, def_mp ,comment ,dk ,ban,new_site)
						VALUES
							(  '".$params['turist_f'][$i]."','".$params['turist_i'][$i]."','".$params['turist_o'][$i]."',
								'".$this->dmy_to_mydate($params['turist_dob'][$i])."','".$params['turist_country'][$i]."','".$params['turist_passport'][$i]."',
							'".$params['turist_phone'][$i]."','".$params['name']."','".$params['def_mp'][$i]."','Добавлен с сайта',NOW(),0,1)";
				$this->query($sql); // Добавляем туриста
				$turist_id = $this->insertID();
			}
			
			$sql = "INSERT INTO tc_tur_list
						(id_tur,id_tourist,id_mp,book_date,book_num,comment,cabin,number,
						new_site,new_phone,new_passport,agent_id)
					VALUES
						('".$params['tur_id']."','".$turist_id."','".$params['def_mp'][$i]."',NOW(),'".$book_number."','".$params['comment']."','','',1,'".$params['turist_phone'][$i]."','".$params['turist_passport'][$i]."','".$user_id."')";
			$this->query($sql); // Добавляем туриста в список
		}
		return $this->insertID();
	}
	
	public function getTourist($pn) {
		$sql = "SELECT id, name_f, name_i, name_o, dob, def_mp,passport FROM `tc_tourists` WHERE passport = '$pn'";
		$this->query ( $sql );
	
		$items = array ();
		while ( ($row = $this->fetchRowA ()) !== false ) {
		$row ['dob'] = ($row ['dob']!='0000-00-00' and $row ['dob']!='1970-01-01')?$this->mydate_to_dmy( $row ['dob'] ):'';
		$row ['name'] =  $row ['name_f'].' '.$row ['name_i'].' '.$row ['name_o'].' ('.$row ['dob'].') ';
		$items [] = $row;
		}
		return $items;
	}
	
	public function get_emails($email) {
		$sql = "SELECT * FROM turs_signups WHERE signup_email_address='$email'";
		$this->query ( $sql );
		return $this->numRows();
	}
	public function set_emails($email,$name,$date,$time) {
		$sql = "INSERT INTO turs_signups (signup_email_address,signup_username, signup_date, signup_time) VALUES ('$email','$name','$date','$time')";
		$test = $this->query ( $sql );
		return $test;
	}
	public function insert_bank_data ( $Order_ID,$Status ) {
		$real_orders = array ();
		$real_orders[] = $Order_ID;
		if ($Order_ID > 10000000) { // Если заказ на оплату всех, то находим все заказы
			$real_order = $Order_ID/1000;
			$sql = "SELECT tl.id FROM tc_tur_list tl
					WHERE tl.id_tur = (SELECT tl2.id_tur FROM tc_tur_list tl2  WHERE tl2.id = '$real_order')
					AND tl.book_num = (SELECT tl3.book_num FROM tc_tur_list tl3  WHERE tl3.id = '$real_order')
					AND (SELECT COUNT(*) FROM  tc_view_bank_results vbr WHERE vbr.Order_ID = tl.id) = 0
					AND tl.payed = 0";
			$this->query ( $sql );
			$real_orders = array ();
			while ( ($row = $this->fetchRowA ()) !== false ) {
				$real_orders [] = $row['id'];
			}
		}
        $test = false;
		foreach ($real_orders as $real_order) {
			$sql = "INSERT INTO tc_bank_results ( Order_ID, Status, dk ) VALUES ('$real_order','$Status', NOW())";
			$test = $this->query ( $sql );
		}
		return $test;
	}

	
	public function SearchOrder($order) {
		$kurs = 60+60*.02;
		$sql = 'SELECT tl.id,tl.id_tur,tt.name_f,tt.name_i,tt.name_o, tt.phone, tt.dob,tt.passport,
		mp.`name`, tl.book_date,tl.book_num, tl.`comment`,tl.`cabin`,tl.`number`,tl.new_site, tl.payed,tc.cost,tc.currency,
		(SELECT count(*) FROM tc_tur_list tl2 WHERE tl2.id_tourist=tt.id) as c_tours,tl.id_tourist,tc.name tur_name,
		(SELECT COUNT(*) FROM  tc_view_bank_results vbr WHERE vbr.Order_ID = tl.id) bank_payed
		FROM `tc_tur_list` tl
 		LEFT JOIN tc_tur tc ON tl.id_tur = tc.id
		LEFT JOIN tc_tourists tt ON tl.id_tourist = tt.id
		LEFT JOIN tc_mp mp ON tl.id_mp = mp.id
	
		WHERE tl.id_tur = (SELECT tl2.id_tur FROM tc_tur_list tl2  WHERE tl2.id = \''.$order.'\')
		AND tl.book_num = (SELECT tl3.book_num FROM tc_tur_list tl3  WHERE tl3.id = \''.$order.'\')
		';

		$this->query ( $sql );
		$items = array ();
		while ( ($row = $this->fetchRowA ()) !== false ) {
			$row ['cost'] = ($row['currency']=='у.е.')?$row['cost']*$kurs:$row['cost'];
			$row ['dob'] = ($row ['dob']!='0000-00-00' and $row ['dob']!='1970-01-01')?$this->mydate_to_dmy( $row ['dob'] ):'';
			$row ['book_date'] = ($row ['book_date']!='0000-00-00 00:00:00')?$this->mydate_to_dmy( $row ['book_date'] ):'';
			$items [] = $row;
		}
		return $items;
	
	}
	
	public function SearchPayOrders($order) {
		$kurs = 60+60*.02;
		$sql = 'SELECT tl.id,tl.id_tur,tt.name_f,tt.name_i,tt.name_o, tt.phone, tt.dob,tt.passport,
		mp.`name`, tl.book_date,tl.book_num, tl.`comment`,tl.`cabin`,tl.`number`,tl.new_site, tl.payed,tc.cost,tc.currency,
		(SELECT count(*) FROM tc_tur_list tl2 WHERE tl2.id_tourist=tt.id) as c_tours,tl.id_tourist,tc.name tur_name
		FROM `tc_tur_list` tl
 		LEFT JOIN tc_tur tc ON tl.id_tur = tc.id
		LEFT JOIN tc_tourists tt ON tl.id_tourist = tt.id
		LEFT JOIN tc_mp mp ON tl.id_mp = mp.id
	
		WHERE tl.id_tur = (SELECT tl2.id_tur FROM tc_tur_list tl2  WHERE tl2.id = \''.$order.'\')
		AND tl.book_num = (SELECT tl3.book_num FROM tc_tur_list tl3  WHERE tl3.id = \''.$order.'\')
		AND (SELECT COUNT( * ) FROM  `tc_view_bank_results` vbr WHERE vbr.Order_ID = tl.id)=0
		AND tl.payed = 0
		';

		$this->query ( $sql );
		$items = array ();
		while ( ($row = $this->fetchRowA ()) !== false ) {
			$row ['cost'] = ($row['currency']=='у.е.')?$row['cost']*$kurs:$row['cost'];
			$row ['dob'] = ($row ['dob']!='0000-00-00' and $row ['dob']!='1970-01-01')?$this->mydate_to_dmy( $row ['dob'] ):'';
			$row ['book_date'] = ($row ['book_date']!='0000-00-00 00:00:00')?$this->mydate_to_dmy( $row ['book_date'] ):'';
			$items [] = $row;
		}
		return $items;
	
	}
	
	public function SearchPayOrder($order) {
		$kurs = 60+60*.02;
		$sql = 'SELECT tl.id,tl.id_tur,tt.name_f,tt.name_i,tt.name_o, tt.phone, tt.dob,tt.passport,
		mp.`name`, tl.book_date,tl.book_num, tl.`comment`,tl.`cabin`,tl.`number`,tl.new_site, tl.payed,tc.cost,tc.currency,
		(SELECT count(*) FROM tc_tur_list tl2 WHERE tl2.id_tourist=tt.id) as c_tours,tl.id_tourist,tc.name tur_name
		FROM `tc_tur_list` tl
 		LEFT JOIN tc_tur tc ON tl.id_tur = tc.id
		LEFT JOIN tc_tourists tt ON tl.id_tourist = tt.id
		LEFT JOIN tc_mp mp ON tl.id_mp = mp.id
	
		WHERE tl.id = \''.$order.'\'';
	
		$this->query ( $sql );
		$items = array ();
		while ( ($row = $this->fetchRowA ()) !== false ) {
			$row ['cost'] = ($row['currency']=='у.е.')?$row['cost']*$kurs:$row['cost'];
			$row ['dob'] = ($row ['dob']!='0000-00-00' and $row ['dob']!='1970-01-01')?$this->mydate_to_dmy( $row ['dob'] ):'';
			$row ['book_date'] = ($row ['book_date']!='0000-00-00 00:00:00')?$this->mydate_to_dmy( $row ['book_date'] ):'';
			$items [] = $row;
		}
		return $items;
	
	}

function mydate_to_dmy($date) {
	return date ( 'd.m.Y', strtotime ( substr ( $date, 0, 20 ) ) );
}

function dmy_to_mydate($date) {
	return date ( 'Y-m-d', strtotime (  $date ) );
}

public function getNewsList($limCount) {
      $page = 1;
      $limStart = ($page - 1) * $limCount;      
      $sql = 'SELECT n.*, DATE_FORMAT(`time`, \'%%d.%%m.%%Y\') as time, 
			    	(SELECT COUNT(*) FROM news) as news_count
			     FROM news n
			     WHERE target = 1
				ORDER BY n.`time` DESC';
      if ($limCount > 0) $sql.= ' LIMIT '.$limStart.','.$limCount;
      $this->query($sql);
      $collect = Array();
      while($row = $this->fetchRowA()) {      	
      	$collect[]=$row;
      }      
      return $collect;
    }
public function getTourismNewsList($limCount) {
      $page = 1;
      $limStart = ($page - 1) * $limCount;
      $sql = 'SELECT n.*, DATE_FORMAT(`time`, \'%%d.%%m.%%Y\') as time, 
			    	(SELECT COUNT(*) FROM news) as news_count
			     FROM news n
			     WHERE target = 2
				ORDER BY n.`time` DESC';
      if ($limCount > 0) $sql.= ' LIMIT '.$limStart.','.$limCount;
      $this->query($sql);
      $collect = Array();
      while($row = $this->fetchRowA()) {
      	$collect[]=$row;
      }
      return $collect;
    }
function GetInTranslit($string) {
	$replace=array(
			"'"=>"",
			"`"=>"",
			"а"=>"a","А"=>"a",
			"б"=>"b","Б"=>"b",
			"в"=>"v","В"=>"v",
			"г"=>"g","Г"=>"g",
			"д"=>"d","Д"=>"d",
			"е"=>"e","Е"=>"e",
			"ж"=>"zh","Ж"=>"zh",
			"з"=>"z","З"=>"z",
			"и"=>"i","И"=>"i",
			"й"=>"y","Й"=>"y",
			"к"=>"k","К"=>"k",
			"л"=>"l","Л"=>"l",
			"м"=>"m","М"=>"m",
			"н"=>"n","Н"=>"n",
			"о"=>"o","О"=>"o",
			"п"=>"p","П"=>"p",
			"р"=>"r","Р"=>"r",
			"с"=>"s","С"=>"s",
			"т"=>"t","Т"=>"t",
			"у"=>"u","У"=>"u",
			"ф"=>"f","Ф"=>"f",
			"х"=>"kh","Х"=>"kh",
			"ц"=>"tc","Ц"=>"tc",
			"ч"=>"ch","Ч"=>"ch",
			"ш"=>"sh","Ш"=>"sh",
			"щ"=>"shch","Щ"=>"shch",
			"ъ"=>"","Ъ"=>"",
			"ы"=>"y","Ы"=>"y",
			"ь"=>"","Ь"=>"",
			"э"=>"e","Э"=>"e",
			"ю"=>"iu","Ю"=>"iu",
			"я"=>"ia","Я"=>"ia",
			"і"=>"i","І"=>"i",
			"ї"=>"yi","Ї"=>"yi",
			"є"=>"e","Є"=>"e"
	);
	return $str=iconv("UTF-8","UTF-8//IGNORE",strtr($string,$replace));
}

}

class siteProcess extends module_process {
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
		/*
		 * actionDefault - Действие по умолчанию. Должно браться из БД!!!
		 */
		$this->actionDefault = '';
		$this->actionsColl = new actionColl ();
		$this->nModel = new siteModel ( $modName );
		$sysMod = $this->nModel->getSysMod ();
		$this->sysMod = $sysMod;
		$this->mod_id = $sysMod->id;
		$this->nView = new siteView ( $this->modName, $this->sysMod );
		$this->regAction ( 'view', 'Главная страница', ACTION_GROUP );
		$this->regAction ( 'viewTur', 'Список туров', ACTION_GROUP );
		$this->regAction ( 'type', 'Типы туров', ACTION_GROUP );
		$this->regAction ( 'locations', 'Районы отправления', ACTION_GROUP );
		$this->regAction ( 'order', 'Заявка', ACTION_GROUP );
		$this->regAction ( 'orderUpdate', 'Редактирование заявки', ACTION_GROUP );
		$this->regAction ( 'search_tourist', 'Поиск туриста по паспорту', ACTION_GROUP );
		$this->regAction ( 'signup', 'Подписка на рассылку', ACTION_GROUP );
		$this->regAction ( 'search_order', 'Поиск по номеру заказа', ACTION_GROUP );
		$this->regAction ( 'pay_order', 'Оплата по номеру заказа', ACTION_GROUP );
		$this->regAction ( 'bank_order_data', 'Получение данных о результате заказа', ACTION_GROUP );
		
		if (DEBUG == 0) {
			$this->registerActions ( 1 );
		}
		if (DEBUG == 1) {
			$this->registerActions ( 0 );
		}
	}
	
	
	public function update($_action = false) {
		if ($_action)
			$this->action = $_action;
		if ($this->action)
			$action = $this->action;
		else
			$action = $this->checkAction ();
		if (! $action) {
			$this->Vals->URLparams ( $this->sysMod->defQueryString );
			$action = $this->actionDefault;
		}
		$user_id = $this->User->getUserID ();
		$user_group_id = $this->User->getUserGroup ();

		if ($user_id > 0) {
			$this->User->nView->viewLoginParams ( 'Система БЛТ', '', $user_id, array (), array (), $this->User->getRight ( 'admin', 'view' ) );
		}
		
		if ($user_group_id == 2) {
			$this->nView->viewMessage('Ваши бронирования осуществляются в рамках Агентского договора. ', 'Сообщение');
		}
		
		if ($action == 'view') {
            $id_main_type = $this->Vals->getVal ( 'main_type', 'GET', 'integer' );
            $id_sub_type = $this->Vals->getVal ( 'sub_type', 'GET', 'integer' );
            $topten = $this->nModel->getTopTen ($id_sub_type, $id_main_type);
            $tour_path = '';
            if ($id_main_type > 0 or $id_sub_type > 0){
                $tour_types = $this->nModel->getTourSubTypes ($id_main_type, $id_sub_type);
                if (isset($tour_types[0]['id_main_type'])) {
                    $tour_name = $this->nModel->getTourTypeName($tour_types[0]['id_main_type']);
                    $tour_path = $this->nModel->getTourTypePath($id_sub_type, '');
                }else{
                    $tour_data = $this->nModel->getTourData($id_sub_type);
                    $tour_name = $this->nModel->getTourTypeName($tour_data['id_main_type']);
                    $tour_path = $this->nModel->getTourTypePath($id_sub_type, '');
                    $this->nView->viewTurData($tour_name, $tour_path, $tour_data, $topten);
                }
            }else{
                $tour_types = $this->nModel->getTourTypes ();
                $tour_name = '';
            }
		    if (isset($tour_types) and !isset($tour_data)) {
                /* показать список новостей */
                $ourNews = (isset($tour_name) and $tour_name != '')?array():$this->nModel->getNewsList(3);
                $tourismNews = (isset($tour_name) and $tour_name != '')?array():$this->nModel->getTourismNewsList(3);
                $promo = $this->nModel->getSpecTours ('action');
                $party = $this->nModel->getSpecTours ('party');
                $fire = $this->nModel->getSpecTours ('fire');
                $this->nView->viewTur($tour_name, $tour_path,  $tour_types, $topten, $ourNews, $tourismNews, $fire, $promo, $party);
            }
		}
		
		if ($action == 'type') {
			$id_type = $this->Vals->getVal ( 'type', 'GET', 'integer' );
			$locs = $this->nModel->getLocs ();
			$items = $this->nModel->getMenu ();
			$type = $this->nModel->getType ($id_type);
			$this->nView->viewlocations ($type,$items,$locs);
		}

		if ($action == 'viewTur') {
		
			$param['type'] = $this->Vals->getVal ( 'type', 'POST', 'integer' );
			$param['type'] = (empty($param['type']))?1:$param['type'];		
			$param['loc'] = $this->Vals->getVal ( 'loc', 'POST', 'array' );
			$param['country'] = $this->Vals->getVal ( 'country', 'POST', 'array' );
			$param['raion'] = $this->Vals->getVal ( 'raion', 'POST', 'array' );
			$param['trans'] = $this->Vals->getVal ( 'transport', 'POST', 'array' );
			$param['target'] = $this->Vals->getVal ( 'target', 'POST', 'array' );
			$param['how_long'] = $this->Vals->getVal ( 'how_long', 'POST', 'array' );
			$param['range'] = $this->Vals->getVal ( 'range', 'POST', 'string' );
			$param['price_from'] = $this->Vals->getVal ( 'price_from', 'POST', 'string' );
			$param['price_to'] = $this->Vals->getVal ( 'price_to', 'POST', 'string' );
			$param['start_date'] = $this->Vals->getVal ( 'start_date', 'POST', 'string' );
			$param['end_date'] = $this->Vals->getVal ( 'end_date', 'POST', 'string' );
			
			$isAjax = $this->Vals->getVal ( 'ajax', 'INDEX' );
			/*
			$id_type = (empty($id_type))?$this->Vals->getVal ( 'viewTur', 'GET', 'integer' ):$id_type;		
			$order = $this->Vals->getVal ( 'srt', 'POST', 'string' );
			$f_name = $this->Vals->getVal ( 'name', 'POST', 'string' );
			$f_city = $this->Vals->getVal ( 'city', 'POST', 'string' );
			$f_country = $this->Vals->getVal ( 'country', 'POST', 'string' );
			$id_loc = (empty($id_loc))?$this->Vals->getVal ( 'loc', 'GET', 'integer' ):$id_loc;
			$type = $this->nModel->getType ($id_type);
			*/
			//stop($param['target'],0);
			$turs = $this->nModel->turList ( $param );
			$countris = $this->nModel->getCountrys ();
			$locs = $this->nModel->getLocs ();
			$this->nView->viewTurList ( $turs, $isAjax, $locs, $countris);
			
		}
		
		if ($action == 'order') {
			$tur_id = $this->Vals->getVal ( 'order', 'GET', 'integer' );
			$tour = array();
			if ($tur_id > 0){
				$tour = $this->nModel->tourGet ( $tur_id );
			}
			$countris = $this->nModel->getCountrys ();
			$mp = $this->nModel->getMP ($tour[0]['loc_id']);
			$this->nView->viewOrderEdit ( $tour, $countris, $mp );
			
		}
		
		if ($action == 'orderUpdate') {
			$params['tur_id'] = $this->Vals->getVal ( 'tur_id', 'POST', 'integer' );
			$params['def_mp'] = $this->Vals->getVal ( 'def_mp', 'POST', 'integer' );
			$params['phone'] = $this->Vals->getVal ( 'phone', 'POST', 'string' );
			$params['name'] = $this->Vals->getVal ( 'name', 'POST', 'string' );
			$params['comment'] = $this->Vals->getVal ( 'comment', 'POST', 'string' );
			$params['turist_id'] = $this->Vals->getVal ( 'turist_id', 'POST', 'array' ); // Если уже ездили с нами
			$params['turist_f'] = $this->Vals->getVal ( 'turist_f', 'POST', 'array' );
			$params['turist_i'] = $this->Vals->getVal ( 'turist_i', 'POST', 'array' );
			$params['turist_o'] = $this->Vals->getVal ( 'turist_o', 'POST', 'array' );
			$params['turist_phone'] = $this->Vals->getVal ( 'turist_phone', 'POST', 'array' );
			$params['turist_dob'] = $this->Vals->getVal ( 'turist_dob', 'POST', 'array' );
			$params['turist_passport'] = $this->Vals->getVal ( 'turist_passport', 'POST', 'array' );
			$params['turist_country'] = $this->Vals->getVal ( 'turist_country', 'POST', 'array' );

			$id_tur_code = $this->nModel->addTuristInTour($params, $user_id);
			$this->nView->viewMessage('Вы успешно добавлены в тур. Ваш код подтверждения: '.$id_tur_code, 'Сообщение');
		}
		if ($action == 'search_tourist') {
			$pn = $this->Vals->getVal ( 'pn', 'POST', 'string' );
            $tourist = '';
			if (trim($pn!=''))
				$tourist = $this->nModel->getTourist($pn);
			exit(json_encode($tourist));
		}
/** Поиск своего заказа */		
		if ($action == 'search_order') {
			$order = $this->Vals->getVal ( 'order_number', 'POST', 'integer' );
			$items = $this->nModel->SearchOrder ( $order);
			$this->nView->viewSearchOrder ( $items );
			
		}
/** Оплата заказа */
		if ($action == 'pay_order') {			
			$Order_ID = $this->Vals->getVal ( 'pay_order', 'GET', 'integer' );
			$forall = $this->Vals->getVal ( 'forall', 'GET', 'integer' );
			$items = ($forall==1)?$this->nModel->SearchPayOrders ( $Order_ID):$this->nModel->SearchPayOrder ( $Order_ID);
			// Если оплата идет по всем неоплаченным заказам, то умножаем заказ на 1 000
			$Order_ID = ($forall==1)?$Order_ID*1000:$Order_ID;
			// Инициализация параметров для формы платежа
			$Shop_IDP = "0788126593-3756"; // идентификатор точки продажи ТЕСТ 
		//	$Shop_IDP = "00003765"; // идентификатор точки продажи
			$Lifetime = 3600; // время жизни формы оплаты в секундах 3600 - 1 час
			// Сумма для оплаты и идентификатор зарегистрированного пользователя
			$Subtotal_P = 0;
			foreach ($items as $cost){
				$Subtotal_P += $cost['cost'];
			}
			$Customer_IDP = '12345';
			// Адреса возврата после успешной и неуспешной оплат покупателями
			$URL_RETURN_OK = "http://".$_SERVER['HTTP_HOST']."/pages/view-36/";
			$URL_RETURN_NO = "http://".$_SERVER['HTTP_HOST']."/pages/view-37/";

			$password = "Ot2cxNrp2bn1QAI89XH8NPbyMpierGBsnsUI50ZcieaOLvOBYe5KROJpHWoiHWoZA3MPwFe9FaPwLYHX"; // пароль из ЛК Uniteller
			// Подпись для формы, вместо неиспользуемых параметров передаются пустые строки
			$Signature = $this->getSignature( $Shop_IDP, $Order_ID, $Subtotal_P, "", "",$Lifetime, $Customer_IDP, "", "", "", $password );

			$form_data = array('Signature'=>$Signature,'Shop_IDP'=>$Shop_IDP,'Order_ID'=>$Order_ID,'Subtotal_P'=>$Subtotal_P, 
					'Lifetime'=>$Lifetime,'Customer_IDP'=>$Customer_IDP,'URL_RETURN_OK'=>$URL_RETURN_OK,'URL_RETURN_NO'=>$URL_RETURN_NO);

			$this->nView->viewPayOrder ( $items,$form_data );
			
		}
/** Подтверждение заказа от банка */
		if ($action == 'bank_order_data') {			
			$Order_ID = $this->Vals->getVal ( 'Order_ID', 'POST', 'integer' );
			$Status = $this->Vals->getVal ( 'Status', 'POST', 'string' );
			$Signature = $this->Vals->getVal ( 'Signature', 'POST', 'integer' );
			$password = "Ot2cxNrp2bn1QAI89XH8NPbyMpierGBsnsUI50ZcieaOLvOBYe5KROJpHWoiHWoZA3MPwFe9FaPwLYHX"; // пароль из ЛК Uniteller
			$Signature_test = strtoupper(md5($Order_ID.$Status.$password));
			
			if ($Signature_test == $Signature) {
				$this->nModel->insert_bank_data ( $Order_ID,$Status );
				exit('OK');
			}else{
				exit('ERROR');
			}
		}
/** Подписка на рассылку */		
		if ($action == 'signup') {
			$email = $this->Vals->getVal ( 'signup-email', 'POST', 'string' );
			$name = $this->Vals->getVal ( 'signup-name', 'POST', 'string' );
			//Подчищаем данные
			$email = $this->mysql_escape_mimic($email);
			$name = $this->mysql_escape_mimic($name);
				
			//Проверяем адрес email
			if(empty($email)){
				$status = "error";
				$message = "Вы не ввели адрес email!";
			}
			else if(!preg_match('/^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/', $email)){
				$status = "error";
				$message = "Вы ввели неправильный адрес email!";
			}
			else {
				$existingSignup = $this->nModel->get_emails ( $email );
				if($existingSignup < 1){
					$date = date('Y-m-d');
					$time = date('H:i:s');
					$insertSignup = $this->nModel->set_emails ( $email,$name,$date,$time );
					if($insertSignup){ //если вставка прошла успешно
						$status = "success";
						$message = "Вы подписаны!";
					}
					else { //если вставка прошла неудачно
						$status = "error";
						$message = "Произошла техническая ошибка!";
					}
				}
				else { //если пользователь уже подписан
					$status = "error";
					$message = "Данный адрес уже зарегистрирован!";
				}
			}
			//возвращаем ответ json
			$data = array('status' => $status,'message' => $message);
				
			echo json_encode($data);
			exit;
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


	}

    public function mysql_escape_mimic($inp) {
        if (is_array($inp))
            return array_map(__METHOD__, $inp);

        if (!empty($inp) && is_string($inp)) {
            return str_replace(array('\\', "\0", "\n", "\r", "'", '"', "\x1a"), array('\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'), $inp);
        }

        return $inp;
    }

// Функции оплаты
	public function getSignature( $Shop_IDP, $Order_IDP, $Subtotal_P, $MeanType, $EMoneyType,
			$Lifetime, $Customer_IDP, $Card_IDP, $IData, $PT_Code, $password ) {
		$Signature = strtoupper(
				md5(
						md5($Shop_IDP) . "&" .
						md5($Order_IDP) . "&" .
						md5($Subtotal_P) . "&" .
						md5($MeanType) . "&" .
						md5($EMoneyType) . "&" .
						md5($Lifetime) . "&" .
						md5($Customer_IDP) . "&" .
						md5($Card_IDP) . "&" .
						md5($IData) . "&" .
						md5($PT_Code) . "&" .
						md5($password)
				)
		);
		return $Signature;
	}
	
	
	
}

class siteView extends module_View {
	public function __construct($modName, $sysMod) {
		parent::__construct ( $modName, $sysMod );
		$this->pXSL = array ();
	}
	
	public function viewTur($tour_name, $tour_path, $tour_types, $topten, $ourNews,$tourismNews, $fire, $promo, $party) {
		$this->pXSL [] = RIVC_ROOT . 'layout/'.$this->sysMod->layoutPref.'/turs.view.xsl';
        $Container = $this->newContainer ( 'turlist' );
        $this->addAttr('tour_name',$tour_name, $Container);
        $this->addAttr('tour_path',$tour_path, $Container);
        $ContainerTourTypes = $this->addToNode ( $Container, 'tour_types', '' );
        foreach ( $tour_types as $item ) {
            $this->arrToXML ( $item, $ContainerTourTypes, 'item' );
        }
		$ContainerTopTen = $this->addToNode ( $Container, 'topten', '' );
		foreach ( $topten as $item ) {
			$this->arrToXML ( $item, $ContainerTopTen, 'item' );
		}
        $ContainerNews = $this->addToNode ( $Container, 'news', '' );
        foreach ( $ourNews as $item ) {
            $this->arrToXML ( $item, $ContainerNews, 'item' );
        }
        $ContainerTourismNews = $this->addToNode ( $Container, 'tnews', '' );
        foreach ( $tourismNews as $item ) {
            $this->arrToXML ( $item, $ContainerTourismNews, 'item' );
        }
        $ContainerPromo = $this->addToNode ( $Container, 'promo', '' );
        foreach ( $promo as $item ) {
            $this->arrToXML ( $item, $ContainerPromo, 'item' );
        }
        $ContainerParty = $this->addToNode ( $Container, 'party', '' );
        foreach ( $party as $item ) {
            $this->arrToXML ( $item, $ContainerParty, 'item' );
        }
        $ContainerFire = $this->addToNode ( $Container, 'fire', '' );
        foreach ( $fire as $item ) {
            $this->arrToXML ( $item, $ContainerFire, 'item' );
        }
		return true;
	}
	public function viewTurData($tour_name, $tour_path, $tour_data, $topten) {
		$this->pXSL [] = RIVC_ROOT . 'layout/'.$this->sysMod->layoutPref.'/turs.data.xsl';
        $Container = $this->newContainer ( 'turlist' );
        $this->addAttr('tour_name',$tour_name, $Container);
        $this->addAttr('tour_path',$tour_path, $Container);
        $this->arrToXML ( $tour_data, $Container, 'item' );
		$ContainerTopTen = $this->addToNode ( $Container, 'topten', '' );
		foreach ( $topten as $item ) {
			$this->arrToXML ( $item, $ContainerTopTen, 'item' );
		}
		return true;
	}
	public function viewlocations($type,$items,$locs) {
		$this->pXSL [] = RIVC_ROOT . 'layout/'.$this->sysMod->layoutPref.'/turs.locations.xsl';
		$Container = $this->newContainer ( 'locations' );
		$ContainerMenu = $this->addToNode ( $Container, 'menu', '' );
		foreach ( $items as $item ) {
			$this->arrToXML ( $item, $ContainerMenu, 'item' );
		}
		$ContainerType = $this->addToNode ( $Container, 'type', '' );
		foreach ( $type as $item ) {
			$this->arrToXML ( $item, $ContainerType, 'item' );
		}
		$ContainerLocs = $this->addToNode ( $Container, 'locs', '' );
		foreach ( $locs as $item ) {
			$this->arrToXML ( $item, $ContainerLocs, 'item' );
		}
		return true;
	}
	public function viewTurList($turs, $isAjax, $locs, $countris) {
		$this->pXSL [] = RIVC_ROOT . 'layout/'.$this->sysMod->layoutPref.'/turs.turlist.xsl';
		if ($isAjax == 1) {
			$this->pXSL [] = RIVC_ROOT . 'layout/head.page.xsl';
		}
		$Container = $this->newContainer ( 'turlist' );
		$Containerusers = $this->addToNode ( $Container, 'turs', '' );
		foreach ( $turs as $item ) {
			$this->arrToXML ( $item, $Containerusers, 'item' );
		}
		$ContainerLocs = $this->addToNode ( $Container, 'locs', '' );
		foreach ( $locs as $item ) {
			$this->arrToXML ( $item, $ContainerLocs, 'item' );
		}
		$ContainerCntr = $this->addToNode ( $Container, 'countris', '' );
		foreach ( $countris as $item ) {
			$this->arrToXML ( $item, $ContainerCntr, 'item' );
		}
		return true;
	}
	
	public function viewOrderEdit($tour, $countris, $mp) {
		$this->pXSL [] = RIVC_ROOT . 'layout/'.$this->sysMod->layoutPref.'/turs.order.xsl';
		$Container = $this->newContainer ( 'orderedit' );
		$ContainerCountris = $this->addToNode ( $Container, 'tour', '' );
		foreach ( $tour as $item ) {
			$this->arrToXML ( $item, $ContainerCountris, 'item' );
		}
		$ContainerCountris = $this->addToNode ( $Container, 'countris', '' );
		foreach ( $countris as $item ) {
			$this->arrToXML ( $item, $ContainerCountris, 'item' );
		}
		$ContainerMP = $this->addToNode ( $Container, 'mp', '' );
		foreach ( $mp as $item ) {
			$this->arrToXML ( $item, $ContainerMP, 'item' );
		}
		return true;
	}
	
	public function viewSearchOrder ( $items ) {
		$this->pXSL [] = RIVC_ROOT . 'layout/'.$this->sysMod->layoutPref.'/turs.travel_search.xsl';
		$Container = $this->newContainer ( 'travellist' );
		$Containerusers = $this->addToNode ( $Container, 'travel', '' );
		foreach ( $items as $item ) {
			$this->arrToXML ( $item, $Containerusers, 'item' );
		}
		return true;
	}
	
	public function viewPayOrder ( $items,$frmData ) {
		$this->pXSL [] = RIVC_ROOT . 'layout/'.$this->sysMod->layoutPref.'/turs.travel_pay.xsl';
		$Container = $this->newContainer ( 'travellist' );
		$Containerusers = $this->addToNode ( $Container, 'travel', '' );
		foreach ( $items as $item ) {
			$this->arrToXML ( $item, $Containerusers, 'item' );
		}
		$this->arrToXML ( $frmData, $Containerusers, 'form_data' );

		return true;
	}
	

}