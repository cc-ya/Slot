<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Slot extends CI_Controller {
    private $_reel_all = [
        "left"  => [0,1,2,0,1,3,4,0,1,5,6,2,0,1,4,0,1,7,8,7,8],
        "center"=> [0,6,1,0,2,3,4,1,0,6,5,6,1,0,3,1,0,8,7,8,1],
        "right" => [1,2,0,1,4,3,0,1,6,5,0,1,3,2,0,1,8,7,8,7,0]
    ];

    private $_display =['上段','中段','下段','右下','右上'];
    const POSITION_UPPER  = 0;
    const POSITION_MIDDLE = 1;
    const POSITION_LOWER  = 2;
    const RECODE_MAX      = 5;

    public function __construct()
    {
        parent::__construct();
        if (ENVIRONMENT === 'development') {
            $this->output->enable_profiler();
        }
        $this->load->model('Coin_model');
        session_start();
    }

    /** 最初の画面表示の部分です */
    public function index()
    {
        $status['name']       = $_SESSION['name'];
        $status['coin']       = $this->Coin_model->getCoin($status['name']);
        $data['name']         = $status['name'];
        $data['coin']         = $status['coin'];
        $_SESSION['reel_all'] = $this->_reel_all;
        $data['reel_all']     = $this->_reel_all;
        $_SESSION['record_list']   = array_fill(0, self::RECODE_MAX, '**********');
        $data['record_list']       = $_SESSION['record_list'];
        $this->load->view('slot/index', $data);
    }

    /** mainから他のfunctionを呼び出し、その結果をviewに渡す */
    public function main()
    {
        $status['name'] = $_SESSION['name'];
        $data['name']   = $status['name'];
        $status['coin'] = $this->Coin_model->getCoin($status['name']);
        if($status['coin'] >= Coin_model::PAY) {
            $data = $this->_enoghDisplay($status);
        }else {
            $data =  $this->_lackDisplay($status);
        }
        $this->load->view('slot/index', $data);
    }

    /* コインが足りている時のviewを表示 */
    private function _enoghDisplay($status)
    {
        $status['coin']       = $this->Coin_model->payCoin($status);
        $res_all              = $this->_rotationReel();
        $_SESSION['reel_all'] = $res_all; //前回の結果を格納
        $judge_line           = $this->_conversionArray($res_all);
        $result               = self::_judge($judge_line);
        $status['coin']       = $this->_correct($judge_line, $result, $status['coin']);
        $record_list          = self::_addRecord();
        $data['coin']         = $status['coin'];
        $data['result']       = $result; //当たり外れがBoolianで入る
        $data['reel_all']     = $res_all;
        $data['display']      = $this->_display;
        $data['record_list']  = $record_list;
        return $data;
    }

    /* コイン不足の時viewを表示 */
    private function _lackDisplay($status)
    {
        $data['name']     = $status['name'];
        $data['coin']     = $status['coin'];
        $data['reel_all'] = $_SESSION['reel_all'];
        $data['lack']     = TRUE;
        return $data;
    }


    /** リールの回転部分の処理なのでrotationにしました */
    private function _rotationReel()
    {
        foreach ($this->_reel_all as $position => $posi_array) {
            end($posi_array);
            $end_key = key($posi_array);
            $total   = count($posi_array);
            $times   = mt_rand(0, $end_key);
            foreach ($posi_array as $posi_key => $posi_value) {
                $new_key = $times + $posi_key;
                if ($new_key > $end_key) {
                    $after_array[$posi_key] = $posi_array[$new_key - $total];
                }else if ($new_key <= $end_key) {
                    $after_array[$posi_key] = $posi_array[$new_key];
                }
            }
            $res_all[$position] = $after_array;
        }
        return $res_all;
    }

    /**　回転後の配列を判定できる５つの配列に入れなおす */
    private function _conversionArray($res_all)
    {
        $position_down = self::POSITION_UPPER;
        $position_up   = self::POSITION_LOWER;
        foreach($res_all as $position => $posi_array) {
            $POSITION_UPPER[]  = $posi_array[self::POSITION_UPPER];
            $POSITION_MIDDLE[] = $posi_array[self::POSITION_MIDDLE];
            $POSITION_LOWER[]  = $posi_array[self::POSITION_LOWER];
            $POSITION_LOWER_right[] = $posi_array[$position_down];
            $POSITION_UPPER_right[] = $posi_array[$position_up];
            $position_down++;
            $position_up--;
        }
        $judge_line[] = $POSITION_UPPER;
        $judge_line[] = $POSITION_MIDDLE;
        $judge_line[] = $POSITION_LOWER;
        $judge_line[] = $POSITION_LOWER_right;
        $judge_line[] = $POSITION_UPPER_right;
        return $judge_line;
    }

    /* 判定したいです */
    private static function _judge($judge_line)
    {
        foreach($judge_line as $judge_value) {
            $result[] = (count(array_unique($judge_value)) == 1)? TRUE: FALSE;
        }
        return $result;
    }

    /* スロットが揃った時の処理　*/
    private function _correct($judge_line, $result, $coin)
    {
        $count = FALSE;
        $coin_record = NULL;
        end($judge_line);
        $end_key = key($judge_line);
        foreach($judge_line as $key => $value) {
            if($result[$key] == TRUE) {
                $coin = $this->Coin_model->lineCorrect($value, $coin);
                $coin_record += $_SESSION['coin_record'];
                $count = TRUE;
            }else if(empty($count) && $key == $end_key) {
                $coin_record = '-'.Coin_model::PAY;
            }
            $_SESSION['coin_record'] = $coin_record;
        }
        return $coin;
    }

    /* 履歴($record_list)の追加　*/
    private static function _addRecord()
    {
        array_unshift($_SESSION['record_list'], $_SESSION['coin_record']);
        array_pop($_SESSION['record_list']);
        return $_SESSION['record_list'];
    }
}