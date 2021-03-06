<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Wanshun4 extends MY_Controller {

    public function __construct() {
        parent::__construct(false, false);
        if(empty($_COOKIE['SMC_NO3_YG'])){
            redirect(site_url('no3/login'));
        }
        $this->load->model('no3/configs_model', 'configs');
        $this->load->helper('other');
    }

    public function get_exchange_data() {
        $this->load->model('wanshun4_model');

        $action = $this->input->get_post('action');
        $gametype = $this->input->get_post('gametype');
        $iswin = $this->input->get_post('iswin');
        $mydate = $this->input->get_post('mydate');
        $beginindex = $this->input->get_post('beginindex');
        $wintype = $this->input->get_post('wintype');
        
        
        $res = $this->wanshun4_model->get_exchange_his($gametype,$mydate,$iswin,$wintype);

        echo json_encode($res);
    }

    public function index() {
        $menucheck = array();
        $myfilename = DYCONFIG."private_data.log";
        if (file_exists($myfilename)) {
            $saveres = file_get_contents($myfilename, LOCK_EX);
             $rxry = json_decode($saveres);
             foreach ($rxry as $rx => $ry){
                  foreach ($ry as $key => $val){
                      $menucheck[$rx][$key] = $rxry->$rx->$key;
                   }
             }
        }
        $usernamezz = $_COOKIE['SMC_NO3_YG'];
        $data = array(
            "systemconfig" => $this->configs->get_navmenu(),
            "menucheck" => $menucheck,
            "message" => array("username" => $usernamezz, "mail" => "aaa"),
            "gamelist" => $this->config->item('gamecode'),
            "choose" => array("father" => "运营报表", "child" => "游戏净分排名"),
            "header1" => array("father" => "运营报表", "child" => "游戏净分排名"),
            "header2" => array("father" => "游戏净分排名", "child" => "玩家兑换记录历史统计 "),
            "header3" => array("father" => "游戏净分排名创建于2015年11月13日", "child" => " 游戏运营从2014年6月25日开始 (v1.0) "),
        );
        $this->load->view('no3/wanshun4_view', $data);
    }

}
