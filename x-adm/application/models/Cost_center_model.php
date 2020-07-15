<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Cost_center Model Class
 * @author alfian purnomo <alfian.pacul@gmail.com>
 * @version 3.0
 * @category Model
 * @desc Cost_center model
 * 
 */
class Cost_center_model extends CI_Model
{
    /**
     * constructor
     */
    function __construct()
    {
        parent::__construct();
    }
    
    /**
     * get vendor data
     * @return array data
     */
    function GetVendor() {
        
        $data = $this->db
                ->order_by('id_vendor','asc')
                ->join('vendor_category','vendor_category.id_vendor_category=vendor.id_category_vendor','left')
                ->get('vendor')
                ->result_array();
        
        return $data;
    }
    

    function InsertRecordVendor($param){
      $this->db->insert('vendor',$param);
      $id = $this->db->insert_id();

      return $id;
    }

    /**
     * check exist bd_number
     * @param string $bd_number
     * @param int $id
     * @return boolean true/false 
     */
    function checkBdNumber($bd_number,$id=0) {
        if ($id != '' && $id != 0) {
            $this->db->where('id_bd_number !=',$id);
        }
        $count_records = $this->db
                ->from('form_bd')
                ->where('bd_number',$bd_number)
                ->count_all_results();
        if ($count_records>0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
    /**
     * get all admin data
     * @param string $param
     * @return array data
     */
    function GetAllCost_centerData($param=array()) {
        
        if (isset($param['search_value']) && $param['search_value'] != '') {
            $this->db->group_start();
            $i=0;
            foreach ($param['search_field'] as $row => $val) {
                if ($val['searchable'] == 'true') {
                    if ($i==0) {
                        if($val['data']=='iso_1'){
                            $this->db->like('LCASE(`cost_center`.`iso_1`)',strtolower($param['search_value']));
                        } elseif($val['data']=='iso_2') {
                            $this->db->like('LCASE(`cost_center`.`iso_2`)',strtolower($param['search_value']));
                        } else{
                            
                        }
                    } else {
                        if($val['data']=='iso_1'){
                            $this->db->like('LCASE(`cost_center`.`iso_1`)',strtolower($param['search_value']));
                        } elseif($val['data']=='iso_2') {
                            $this->db->like('LCASE(`cost_center`.`iso_2`)',strtolower($param['search_value']));
                        } else{
                            
                        }
                        #$this->db->or_like('LCASE(`'.$val['data'].'`)',strtolower($param['search_value']));
                    }
                    $i++;
                }
            }
            $this->db->group_end();
        }
        if (isset($param['row_from']) && isset($param['length'])) {
            $this->db->limit($param['length'],$param['row_from']);
        }
        if (isset($param['order_field'])) {
            if (isset($param['order_sort'])) {
                $this->db->order_by($param['order_field'],$param['order_sort']);
            } else {
                $this->db->order_by($param['order_field'],'desc');
            }
        } else {
            $this->db->order_by('id_cost_center','desc');
        }
        $data = $this->db
                ->select('*')
                ->get('cost_center')
                ->result_array();
        return $data;
    }
    
    /**
     * count records
     * @param string $param
     * @return int total records
     */
    function CountAllCost_center($param=array()) {
       
        if (is_array($param) && isset($param['search_value']) && $param['search_value'] != '') {
            $this->db->group_start();
            $i=0;
            foreach ($param['search_field'] as $row => $val) {
                if ($val['searchable'] == 'true') {
                    if ($i==0) {
                        if($val['data']=='iso_1'){
                            $this->db->like('LCASE(`cost_center`.`iso_1`)',strtolower($param['search_value']));
                        } elseif($val['data']=='iso_2') {
                            $this->db->like('LCASE(`cost_center`.`iso_2`)',strtolower($param['search_value']));
                        } else{
                            
                        }
                    } else {
                        if($val['data']=='iso_1'){
                            $this->db->like('LCASE(`cost_center`.`iso_1`)',strtolower($param['search_value']));
                        } elseif($val['data']=='iso_2') {
                            $this->db->like('LCASE(`cost_center`.`iso_2`)',strtolower($param['search_value']));
                        } else{
                            
                        }
                        #$this->db->or_like('LCASE(`'.$val['data'].'`)',strtolower($param['search_value']));
                    }
                    $i++;
                }
            }
            $this->db->group_end();
        }
        $total_records = $this->db
                        ->select('*')
                        ->from('cost_center')
                        ->count_all_results();
        return $total_records;
    }
    
    /**
    * Get PPH tax 
    * @return array data
    */
    function GetPPH(){
        $data = $this->db
                ->select('sub_tax.id_sub_tax,sub_tax.name as name')
                ->join('tax','tax.id_tax=sub_tax.id_tax','left')
                ->where('tax.is_delete',0)
                ->where('sub_tax.is_delete',0)
                ->get('sub_tax')
                ->result_array();
        return $data;
    }

    /**
     * Get admin user detail by id
     * @param int $id
     * @return array data
     */
    function GetCost_center($id) {
        $data = $this->db
                ->where('id_cost_center',$id)
                ->limit(1)
                ->get('cost_center')
                ->row_array();
        return $data;
    }
    
    /**
     * insert new record
     * @param array $param
     * @return int last inserted id
     */
    function InsertRecord($param) {
        $this->db->insert('cost_center',$param);
        $last_id = $this->db->insert_id();
        return $last_id;
    }
    
    function InsertItemBatch($param){
        $this->db->insert_batch('cost_center',$param);
    }

    function insertCost_center($param) {
        $this->db->insert('cost_center', $param);
        $last_id = $this->db->insert_id();
        return $last_id;
    }
    function insertBatchCost_centerValue($param) {
      $this->db->insert_batch('cost_center_value', $param);
    }

    /**
     * update record admin user
     * @param int $id
     * @param array $param
     */
    function UpdateRecord($id,$param) {
        $this->db->where('id_cost_center',$id);
        $this->db->update('cost_center',$param);
    }
    
    /**
     * delete record
     * @param int $id
     */
    function DeleteRecord($id) {
        $this->db->where('id_cost_center',$id);
        $this->db->update('cost_center',array('is_delete'=>1));
    }
    
    /**
     * check exist email
     * @param string $email
     * @param int $id
     * @return boolean true/false 
     */
    function checkName($email,$id=0) {
        if ($id != '' && $id != 0) {
            $this->db->where('id_sub_tax !=',$id);
        }
        $count_records = $this->db
                ->from('tax')
                ->where('LCASE(name)',strtolower($email))
                ->count_all_results();
        if ($count_records>0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    /**
     * check exist username
     * @param string $username
     * @param int $id
     * @return boolean true/false 
     */
    function checkExistsUsername($username,$id=0) {
        if ($id != '' && $id != 0) {
            $this->db->where('id_sub_tax !=',$id);
        }
        $count_records = $this->db
                ->from('tax')
                ->where('username',$username)
                ->count_all_results();
        if ($count_records>0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
}
/* End of file Cost_center_model.php */
/* Location: ./application/models/Cost_center_model.php */