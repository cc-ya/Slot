 <?php
class Login_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    /** ログインチェックをおこなう */
    public function check($data)
    {
    	$this->load->database();
    	$this->db->where('name', $data['name']);
        $this->db->where('pass', $data['pass']);
        $query = $this->db->get("slot_tbl");

        if ($query->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }

    /** DBに新しいユーザーを登録 */
    public function insertDb($data)
    {
        $this->load->database();
        $this->db->set($data);
        if($this->db->insert('slot_tbl') == TRUE){
            return TRUE;
        }else {
            return FALSE;
        }
    }
}