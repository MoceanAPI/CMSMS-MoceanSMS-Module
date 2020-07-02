<?php

class History
{
    const ROW_PER_PAGE = 30;
    private $_data = array(
        "id" => null,
        "text" => null,
        "ip" => null,
        "receiver" => null,
        "datetime" => null,
    );

    public function __get($key)
    {
        switch ($key) {
            case "id":
            case "text":
            case "ip":
            case "receiver":
            case "datetime":
                return $this->_data[$key];
        }
        return null;
    }

    public function __set($key, $value)
    {
        if (array_key_exists($key,$this->_data)) {
            $this->_data[$key] = $value;
        }
    }

    public function save() {
        return $this->insert();
    }

    private function insert() {
        /** @var $db \CMSMS\Database\Connection */
        $db = \cms_utils::get_db();
        $sql = "INSERT INTO ".cms_db_prefix()."mod_moceansms_history SET text=?,ip=?,receiver=?,datetime=?";
        $res = $db->Execute($sql,array($this->text,$this->ip,$this->receiver,$this->datetime));
        if(!$res) {
            return false;
        }
        $this->_data['id'] = $db->Insert_ID();
        return true;
    }

    private function generatePagingInfo($page_now,$total_rows)
    {
        $total_show_pages = 5;
        $total_page = ceil($total_rows/self::ROW_PER_PAGE);
        $middle_page_add_on_number = floor(5/$total_show_pages);

        if($total_page < $total_show_pages)
        {
            $start_page = 1;
            $end_page = $total_page;
        }
        else
        {
            if(($page_now + $middle_page_add_on_number) > $total_page)
            {
                $start_page = $total_page - $total_show_pages + 1;
                $end_page = $total_page;
            }
            else if($page_now > $middle_page_add_on_number)
            {
                $start_page = $page_now - $middle_page_add_on_number;
                $end_page = $start_page + $total_show_pages - 1;

            }
            else
            {
                $start_page = 1;
                $end_page = $total_show_pages;
            }
        }

        $fist_page = 1;
        $last_page = ($total_page > 0 ? $total_page : $fist_page);
        $prev_page = ($page_now>1 ? $page_now -1 : 1);
        $next_page = ($page_now<$total_page ? $page_now +1 : $last_page);

        return array("start"=>$start_page, "end"=>$end_page, "first"=>$fist_page, "last"=>$last_page, "previous"=>$prev_page, "next"=>$next_page, "now"=>$page_now);
    }

    public static function loadBypPage($page=1)
    {
        /** @var $db \CMSMS\Database\Connection */
        $db = \cms_utils::get_db();

        $offset = ($page - 1)*self::ROW_PER_PAGE;

        $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM ".cms_db_prefix()."mod_moceansms_history ORDER BY datetime DESC LIMIT $offset,".self::ROW_PER_PAGE;
        $data = $db->GetAll($sql);

        $sql = "SELECT FOUND_ROWS() as num";
        $res = $db->Execute($sql);
        $num = $res->FetchRow();
        $num = $num["num"];

        return array("data"=>$data,"paging_info"=>self::generatePagingInfo($page,$num));
    }
}