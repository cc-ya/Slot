 <?php
class Coin_model extends CI_Model {

    const PAY = 3;
    const HIT = [
        'zero'   => 10,
        'one'   => 20,
        'two' => 30,
        'three'  => 40,
        'four'  => 50,
        'five'   => 60,
        'six' => 70,
        'seven' => 10000,
        'eight'  => 1000,
    ];

    public function __construct()
    {
        parent::__construct();
    }

    /** ユーザーのIDとコインを取得 */
    public function getCoin($name)
    {
        $this->load->database();
        $this->db->select('coin');
        $this->db->where('name', $name);
        $query = $this->db->get('slot_tbl');

        if ($query->num_rows() == 1) {
            $result = $query->row(0,'object');
            return $result->coin;
        } else {
            return false;
        }
    }

    public function payCoin($status)
    {
        $result = $status['coin'] - self::PAY;

        $this->load->database();
        $this->db->set('coin',$result);
        $this->db->where('name',$status['name']);
        $query = $this->db->update('slot_tbl');

        return $result;
    }

    public function lineCorrect($position_line, $coin){
        switch($position_line[1]){
            case 0:
                $result = $coin + self::HIT['zero'];
                $_SESSION['coin_record'] = self::HIT['zero'];
                break;
            case 1:
                $result = $coin + self::HIT['one'];
                $_SESSION['coin_record'] = self::HIT['one'];
                break;
            case 2:
                $result = $coin + self::HIT['two'];
                $_SESSION['coin_record'] = self::HIT['two'];
                break;
            case 3:
                $result = $coin + self::HIT['three'];
                $_SESSION['coin_record'] = self::HIT['three'];
                break;
            case 4:
                $result = $coin + self::HIT['four'];
                $_SESSION['coin_record'] = self::HIT['four'];
                break;
            case 5:
                $result = $coin + self::HIT['five'];
                $_SESSION['coin_record'] = self::HIT['five'];
                break;
            case 6:
                $result = $coin + self::HIT['six'];
                $_SESSION['coin_record'] = self::HIT['six'];
                break;
            case 7:
                $result = $coin + self::HIT['seven'];
                $_SESSION['coin_record'] = self::HIT['seven'];
                break;
            case 8:
                $result = $coin + self::HIT['eight'];
                $_SESSION['coin_record'] = self::HIT['eight'];
                break;
        }
        $this->load->database();
        $this->db->set('coin',$result);
        $this->db->where('name',$_SESSION['name']);
        $query = $this->db->update('slot_tbl');

        return $result;
    }

}