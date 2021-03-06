
<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Duty extends CI_Controller{
	public $data;
	public $weekday;

	public function __construct()
	{
		//周一零点开始选班
		parent::__construct();
		$this->load->model('Duty_model');
		$this->load->model('Email_model');

		$this->weekday['today'] = date('w',strtotime(date('Y-m-d')));
		$this->weekday['days'] = $this->getdays(date('Y-m-d'));
		$this->weekday['monday'] = $this->weekday['days']['firstday'];
		$this->weekday['Tuesday'] = date('Y-m-d',strtotime('+1 day',strtotime($this->weekday['monday'])));
		$this->weekday['Wednesday'] = date('Y-m-d',strtotime('+1 day',strtotime($this->weekday['Tuesday'])));
		$this->weekday['Thursday'] = date('Y-m-d',strtotime('+1 day',strtotime($this->weekday['Wednesday'])));
		$this->weekday['Friday'] = date('Y-m-d',strtotime('+1 day',strtotime($this->weekday['Thursday'])));
		$this->weekday['Saturday'] = date('Y-m-d',strtotime('+1 day',strtotime($this->weekday['Friday'])));
		$this->weekday['Sunday'] = date('Y-m-d',strtotime('+1 day',strtotime($this->weekday['Saturday'])));


		// 本地服务器配置
		$config = array(
						'appID' => 'b3a15ae91bbdb732',
                        'appSecret' => 'fc253742de277b0ca343794f6997c45c',
                        'callback' => "http://f.yiban.cn/iapp63235"
                        );

		$this->load->library('YibanSDK',$config,'yiban');

		$this->yiban->getAuth();
        $this->data['user_info'] = $this->session->user_info;

		if($this->weekday['today'] == $this->weekday['monday'])
		{
			if(! $this->Duty_model->DutyQRcode('get',$this->weekday['today']))
			{
				$edited['user_id'] = $this->data['user_info']['yb_userid'];
		        $edited['user_name'] = $this->data['user_info']['yb_username'];
		        $edited['created_date'] = date('Y-m-d h:i:s');
		        $event_id = $this->Qiandao_model->create($edited);
		        if($event_id)
		        {
					include(APPPATH . 'third_party/phpqrcode/qrlib.php');
		            $save_path = 'attch/' . md5($event_id) . '.png';
		            QRcode::png(base_url() . "index.php/qiandao/check?event_id=".$event_id." ", $save_path, QR_ECLEVEL_H, 7);
		            //更新二维码路径
		            $this->Qiandao_model->update_qrcode($event_id, $save_path);
		            $this->data['qrcode'] = $save_path;
		            $this->Duty_model->DutyQRcode('set',date('Y-m-d h:i:s'));
		            return;
	        	}
			}
		}
	}

	public function index()
	{
		// 若没绑定
		if(! $this->Duty_model->yb_data($this->data['user_info']['yb_username']))
		{
			$this->Duty_model->set_ybdata($this->data['user_info']['yb_userid'],$this->data['user_info']['yb_username']);
			header('Location :'.base_url().'duty');
		}
		else//已经进行绑定
		{
			$this->duty['data'] = $this->Duty_model->get_duty($this->weekday);
			
			$this->load->view('duty/header');
			$this->load->view('duty/index',$this->duty);
			$this->load->view('duty/footer');
		}
	}

	//退班
	//获取点击的日期和类型
	public function apply()
	{
		$date = "";
		$type = "";
		if($this->Duty_model->apply("inquire",$date,$type,$this->data['user_info']['yb_userid']))
		{
			$this->Duty_model->apply("manage",$date,$type,$this->data['user_info']['yb_userid']);
			$data['content'] = "申请已发送,请及时查看值班表";
			$this->load->view('duty/header');
			$this->load->view('duty/apply',$data);
			$this->load->view('duty/footer');

		}
	}

	public function select()
	{
		$this->duty = $this->Duty_model->get_duty($this->weekday);
		$this->goal['dy'] = $this->input->post();//获取值班时间和班次类型
		$this->goal['data'] = $this->data;
		$this->status = $this->Duty_model->set_duty($this->goal);
		var_dump($this->duty);var_dump($this->goal);var_dump($this->status);
		// exit();
		if($this->status == 'false')
		{
			$data['content'] = "此班人数已满";
		}
		else
		{
			$data['content'] = "选班成功";
			$para = $this->Duty_model->yb_data($this->data['user_info']['yb_username']);
			$this->Email_model->send($para['email'],)
		}
	}

	public function check()
	{
		header("Location:".base_url()."qiandao/check?event_id=".$this->Duty_model->DutyQRcode('get',$this->weekday['monday']));
	}

	public function statistics()
	{
		$nimade['statistics'] = $this->Duty_model->statistics($this->data['user_info']['yb_userid']);
		// var_dump($nimade['statistics']['detail']);


		$this->load->view('duty/header');
		$this->load->view('duty/statistics',$nimade);
		$this->load->view('duty/footer');
	}

	public function contacts()
	{
		$nimade['tamade'] = $this->Duty_model->contacts() ;
		//处理部门和小组数据，分组展示
		$this->load->view('duty/header');
		
		$this->load->view('duty/contents',$nimade);
		$this->load->view('duty/footer');
	}

	public function getdays($day)
	{ 
	    $lastday=date('Y-m-d',strtotime("$day Sunday")); 
	    $firstday=date('Y-m-d',strtotime("$lastday -6 days")); 
	    return array('firstday' => $firstday,'lastday' => $lastday); 
	} 
	//行政具有管理员权限
	//部长总监具有超管权限
	public function admin()
	{
		if($this->Duty_model->admin('privilege',$this->data['user_info']['yb_userid']) == "guanliyuan")
		{
			//换班
			$data['content'] = $this->Duty_model->admin('admin_apply','zanliu');
			
			//排班
			$data['paiban'] = $this->input->post();
			$data['data']   = $this->data;
			$this->status = $this->Duty_model->set_duty($this->data);
			// var_dump($this->duty);var_dump($this->goal);var_dump($this->status);
			// exit();
			if($this->status == 'false')
			{
				$data['paiban_content'] = "此班人数已满";
			}
			else
			{
				$data['paiban_content'] = "排班成功";
			}

			$this->load->view('duty/admin/header');
			$this->load->view('duty/admin/index',$data);
			//ajax处理数据显示申请状态
			$this->load->view('duty/admin/footer');

		}
		elseif($this->Duty_model->admin('privilege',$this->data['user_info']['yb_userid']) == "chaoguan")
		{
			//管理管理员	ajax修改管理员权限
			$admin['list'] = $this->Duty_model->admin('list','zanliu');

			//换班
			$data['content'] = $this->Duty_model->admin('admin_apply','zanliu');
			
			//排班
			$data['paiban'] = $this->input->post();
			$data['data']   = $this->data;
			$this->status = $this->Duty_model->set_duty($this->data);
			// var_dump($this->duty);var_dump($this->goal);var_dump($this->status);
			// exit();
			if($this->status == 'false')
			{
				$data['paiban_content'] = "此班人数已满";
			}
			else
			{
				$data['paiban_content'] = "排班成功";
			}

			$this->load->view('duty/admin/header');
			$this->load->view('duty/admin/admin',$data);
			//ajax处理数据显示申请状态
			$this->load->view('duty/admin/footer');
		}
	}

}