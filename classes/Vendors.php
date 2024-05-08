<?php
require_once('../config.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);
class Vendors extends DBConnection {
    private $settings;

    public function __construct() {
        global $_settings;
        $this->settings = $_settings;
        parent::__construct();
    }

    public function __destruct() {
        parent::__destruct();
    }

    
        public function save_vendors() {
            extract($_POST);
            $data = '';
            foreach ($_POST as $k => $v) {
                if (!in_array($k, array('id'))) {
                    if (!empty($data)) $data .= " , ";
                    $data .= " `{$k}` = '{$v}' "; // Add backticks around column names
                }
            }
            $loc_id = $this->settings->userdata("loc_id");
		
		    $data .= ", `loc_id`={$loc_id} ";
            if (empty($id)) {
                $qry = $this->conn->query("INSERT INTO vendor_list SET {$data}");
                if ($qry) {
                    $id = $this->conn->insert_id;
                    $this->settings->set_flashdata('success', 'User Details successfully saved.');
                    foreach ($_POST as $k => $v) {
                        if ($k != 'id') {
                            if (!empty($data)) $data .= " , ";
                            if ($this->settings->userdata('id') == $id)
                                $this->settings->set_userdata($k, $v);
                        }
                    }
                    return 1;
                } else {
                    return "INSERT INTO vendor_list SET {$data}";
                }
            } else {
                // If the ID is not empty, it seems you want to perform an update
                $qry = $this->conn->query("UPDATE vendor_list SET {$data} WHERE id = {$id}");
                if ($qry) {
                    $this->settings->set_flashdata('success', 'User Details successfully updated.');
                    return 1;
                } else {
                    return "UPDATE vendor_list SET {$data} WHERE id = {$id}";
                }
            }
        }

        public function delete_vendors() {
           $vendor_id =  $_POST['id'];

            $qry = $this->conn->query("DELETE FROM vendor_list WHERE id = {$vendor_id}");
            if ($qry) {
                $this->settings->set_flashdata('success', 'Vendor Details successfully deleted.');
                return 1;
            } else {
                return "DELETE FROM vendor_list WHERE id = {$vendor_id}";
            }
        }
    
   
}

$vendors = new Vendors();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
switch ($action) {
    case 'save':
        echo $vendors->save_vendors();
        break;
    
    case 'delete':
        echo $vendors->delete_vendors();        
        break;
    
    default:
        // echo $sysset->index();
        break;
}
?>
