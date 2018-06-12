<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Slot extends CI_Controller {
    private $reel_array = [
        "left"  => [0,1,2,0,1,3,4,0,1,5,6,2,0,1,4,0,1,7,8,7,8],
        "center"=> [0,6,1,0,2,3,4,1,0,6,5,6,1,0,3,1,0,8,7,8,1],
        "right" => [1,2,0,1,4,3,0,1,6,5,0,1,3,2,0,1,8,7,8,7,0]
    ];
    const MIN = 0;
    const MAX = 20;
    private $display =['上段','中段','下段','右下','右上'];

    /** 最初の画面表示の部分です */
    public function index()
    {
        $res[] = NULL;
        $data['reel_array'] = $this->reel_array;
        $data['res'] = $res;
        $this->load->view('slot_top',$data);
    }

    /** 全体の流れをmainで管理したいです */
    public function main()
    {
        $res_array = $this->_rotationReel($this->reel_array);
        $data['reel_array'] = $res_array;
        $judge_array =$this->_judgeArray($res_array);
        foreach ($judge_array as $judge_value) {
            $res[] = $this->_judge($judge_value);
        }
        $data['res'] = $res;
        $data['display'] = $this->display;
        $this->load->view('slot_top',$data);
    }

    /** リールの回転部分の処理なのでrotationにしました*/
    private function _rotationReel($reel_array)
    {
        $arr[] = NULL;
        foreach ($reel_array as $position => $posi_array) {
            $first_key = 0;
            $end_key = count($posi_array)-1;
            $times = mt_rand(self::MIN,self::MAX);
            for ($i=0; $i<=$times; $i++) {
                foreach ($posi_array as $key => $value) {
                    $end_value = $posi_array[$end_key];
                    if ($key != $first_key) {
                        $arr[$key] = $posi_array[$key-1];
                    }
                    if ($key == $end_key){
                        $arr[$first_key] = $end_value;
                    }
                }
                $posi_array = $arr;
            }
            $reel_array[$position] = $arr;
        }
        return $reel_array;
    }

    /**　回転後の配列を判定できる５つの配列に入れなおす*/
    private function _judgeArray($res_array){
        $i = 0;
        $j = 2;
        foreach($res_array as $position => $posi_array) {
            $upp[] = $posi_array[0];
            $mid[] = $posi_array[1];
            $low[] = $posi_array[2];
            $low_right[] = $posi_array[$i];
            $upp_right[] = $posi_array[$j];
            $i++;
            $j--;
        }
        $judge_array[] = $upp;
        $judge_array[] = $mid;
        $judge_array[] = $low;
        $judge_array[] = $low_right;
        $judge_array[] = $upp_right;
        return $judge_array;
    }

    /*判定したいです*/
    private function _judge($res_value)
    {
        return (count(array_unique($res_value)) == 1)? true : false ;
    }
}