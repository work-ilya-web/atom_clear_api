<?php

    #  конвертируем в boolean
    function convertBoolean($string){
        if($string == 'true' OR $string == 1 ){
            return 1;
        } else {
            return 0;
        }
    }

    #  конвертируем в int
    function convertBooleanRevers($string){
        if($string == 'true' OR $string == 1 ){
            return true;
        } else {
            return false;
        }
    }

    #  получаем данные из post
    function getDataPost($data){
        if(empty($data)){
            $data = (object)$_POST;
        }
        return $data;
    }

    #  русские месяцы в функции date
    function rdate($param, $time=0) {
    	if(intval($time)==0)$time=time();
    	$MonthNames=array("Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь");
    	if(strpos($param,'M')===false) return date($param, $time);
    		else return date(str_replace('M',$MonthNames[date('n',$time)-1],$param), $time);
    }

    #  сокращеные русские месяцы в функции date
    function rdate_short($param, $time=0) {
    	if(intval($time)==0)$time=time();
    	$MonthNames=array("янв", "фев", "мар", "апр", "май", "июн", "июл", "авг", "сен", "окт", "ноя", "дек");
    	if(strpos($param,'M')===false) return date($param, $time);
    		else return date(str_replace('M',$MonthNames[date('n',$time)-1],$param), $time);
    }

    #  русские месяцы в функции date в винительном
    function rdate_wp($param, $time=0) {
    	if(intval($time)==0)$time=time();
    	$MonthNames=array("января", "февраля", "марта", "апреля", "мая", "июня", "июля", "августа", "сентября", "октября", "ноября", "декабря");
    	if(strpos($param,'M')===false) return date($param, $time);
    		else return date(str_replace('M',$MonthNames[date('n',$time)-1],$param), $time);
    }

    #  русские дни недели
    function get_day_week_short($day) {
    	$DaysNames=array(1=>"Пн", 2=>"Вт", 3=>"Ср", 4=>"Чт", 5=>"Пт", 6=>"Сб", 7=>"Вс");
    	return $DaysNames[$day];
    }

    # Вычисление количества рабочих дней между двумя датами
    # Сначала указываем даты праздников:
    # $holidays = array("2008-12-25", "2008-12-26", "2009-01-01");
    # Затем вызываем нашу функцию, передав дату начала, конца и массив с праздничными датами:
    # echo getWorkingDays("2008-12-22", "2009-01-02", $holidays);

    function getWorkingDays($startDate,$endDate,$holidays){
       $endDate = strtotime($endDate);
       $startDate = strtotime($startDate);

       $days = ($endDate - $startDate) / 86400 + 1;

       $no_full_weeks = floor($days / 7);
       $no_remaining_days = fmod($days, 7);

       $the_first_day_of_week = date("N", $startDate);
       $the_last_day_of_week = date("N", $endDate);

       if ($the_first_day_of_week <= $the_last_day_of_week) {
           if ($the_first_day_of_week <= 6 && 6 <= $the_last_day_of_week) $no_remaining_days--;
           if ($the_first_day_of_week <= 7 && 7 <= $the_last_day_of_week) $no_remaining_days--;
       }
       else {
           if ($the_first_day_of_week == 7) {
               $no_remaining_days--;

               if ($the_last_day_of_week == 6) {
                   $no_remaining_days--;
               }
           }
           else {
               $no_remaining_days -= 2;
           }
       }

       $workingDays = $no_full_weeks * 5;
       if ($no_remaining_days > 0 )
       {
           $workingDays += $no_remaining_days;
       }

       if (is_array($holidays)) {
           foreach($holidays as $holiday){
               $time_stamp=strtotime($holiday);
               if ($startDate <= $time_stamp && $time_stamp <= $endDate && date("N",$time_stamp) != 6 && date("N",$time_stamp) != 7)
                   $workingDays--;
           }
       }


       return $workingDays;
    }

    #  преобразуем данные в соотвествии с получаемыми типами
    function reTypes($types, $data){
        if (!empty($data)) {
            if(!empty($types)){
                if(is_array($data) || $data instanceof Traversable){
                    foreach ($data as  $row=>$item) {
                        if(is_array($item) || $item instanceof Traversable){
                            foreach ($item as $key => $field) {
                                if(@$types[$key]=='int'){
                                    $data[$row][$key] = (int)$field;
                                }
                                if(@$types[$key]=='string'){
                                    $data[$row][$key] = (string)$field;
                                }
                                if(@$types[$key]=='bool'){
                                    $data[$row][$key] = (boolean)$field;
                                }
                            }
                        }
                    }
                }
            }
            return $data;
        } else {
            return false;
        }
    }
    #  преобразуем данные в соотвествии с получаемыми типами
    function reTypesSingle($types, $data){
        if(!empty($types)){
            $data = (array)$data;
            foreach ($data as  $key=>$field) {
                if(@$types[$key]=='int'){
                    $data[$key] = (int)$field;
                }
                if(@$types[$key]=='string'){
                    $data[$key] = (string)$field;
                }
                if(@$types[$key]=='bool'){
                    $data[$key] = (boolean)$field;
                }
            }
        }
        return $data;
    }

?>
