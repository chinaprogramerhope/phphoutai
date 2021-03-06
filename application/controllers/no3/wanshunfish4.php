<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Wanshunfish4 extends MY_Controller {
	public function __construct() {
		parent::__construct ( false, false );
		if (! $this->Common_model->isLogin ()) {
			redirect ( 'no3/login' );
		}
		if (! $this->Common_model->isPriv ( 'yybb_wanshunfish4' )) {
			redirect ( 'no3/index' );
		}
		$this->load->helper ( 'other' );
	}
	public function get_exchange_data() {
		$this->load->model ( 'wanshunfish4_model' );
		$action = $this->input->get_post ( 'action' );
		$mystarttime = $this->input->get_post ( 'mystarttime' );
		$myendtime = $this->input->get_post ( 'myendtime' );
		$userid = $this->input->get_post ( 'userid' );
		$beginindex = $this->input->get_post ( 'beginindex' );
		
		$res = $this->wanshunfish4_model->get_exchange_his ( $userid, $mystarttime, $myendtime, $beginindex );
		
		echo json_encode ( $res );
	}
	public function index() {
		$data = array (
				'menu' => $this->Common_model->getAdminMenuList (),
				"gamelist" => $this->config->item ( 'gamecode' ),
				"choose" => array (
						"father" => "捕鱼项目",
						"child" => "捕鱼使用互动表情记录" 
				),
				"header1" => array (
						"father" => "捕鱼项目",
						"child" => "捕鱼使用互动表情记录" 
				),
				"header2" => array (
						"father" => "捕鱼使用互动表情记录",
						"child" => "游戏首玩时间查询历史统计 " 
				) 
		);
		$this->load->view ( 'no3/wanshunfish4_view', $data );
	}
}
