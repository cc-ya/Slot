<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Login_model');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('form_validation');
    }

    /* ログインのチェックをおこないます */
	public function loginIndex()
	{
        session_start();
        $this->form_validation->set_rules('name', 'ユーザー名','required');
        $this->form_validation->set_rules('pass', 'パスワード', 'required');
        $data = [
            'name' => $this->input->post('name'),
            'pass' => $this->input->post('pass'),
            'access' => $this->input->post('access'),
        ];

        if ($this->form_validation->run() == FALSE && !empty($data['access'])) {
            $data['error_message'] = '必須項目が空です。';
        }else if($this->form_validation->run() == TRUE){
            if($this->Login_model->check($data) == TRUE) {
                $_SESSION['name'] = $data['name'];
                header( "Location:http://localhost/ci/index.php/Slot/index/" ) ;
    exit ;
            }else {
                $data['error_message'] = 'パスワードかユーザー名が違います。';
            }
        }
        $this->load->view('slot/loginIndex',$data);
	}

    /* 新規登録をおこないます */
    public function loginRegistration()
    {
        $this->form_validation->set_rules('name', 'ユーザー名','required|is_unique[slot_tbl.name]|alpha_dash');
        $this->form_validation->set_rules('pass', 'パスワード', 'required|min_length[8]|alpha_dash');
        $data = [
            'name' => $this->input->post('name'),
            'pass' => $this->input->post('pass')
        ];
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('slot/loginRegistration');
        }else {
            if($this->Login_model->insertDb($data) == TRUE){
                $this->load->view('slot/loginSuccess');
            }else {
                $this->load->view('slot/loginRegistration');
            }
        }

    }
}
