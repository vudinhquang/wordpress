<?php

class Zendvn_Mp_Setting_Ajax2{
        
	private $_menu_slug = 'zendvn-mp-st-ajax2';
	
	private $_option_name = 'zendvn_mp_st_ajax2';
	
	private $_setting_options;

	public function __construct(){
		// echo "<br/>" . __METHOD__;
            
		$this->_setting_options = get_option($this->_option_name,array());
		add_action('admin_menu', array($this,'settingMenu'));

		add_action('admin_init', array($this,'register_setting_and_fields'));
    }

	public function register_setting_and_fields(){
        add_action('admin_enqueue_scripts', array($this,'add_js_file'));

        add_action('wp_ajax_zendvn_check_form2', array($this,'zendvn_check_form2'));

		register_setting($this->_menu_slug,$this->_option_name, array($this,'validate_setting'));
	
		//MAIN SETTING
		$mainSection = 'zendvn_mp_main_section';
		add_settings_section($mainSection, "Main setting", 
							array($this,'main_section_view'), $this->_menu_slug);
		add_settings_field($this->create_id('title'), 'Site title', array($this,'create_form'), 
							$this->_menu_slug,$mainSection,array('name'=>'title'));	

		add_settings_field($this->create_id('email'), 'Email', array($this,'create_form'),
							$this->_menu_slug,$mainSection,array('name'=>'email'));

		add_settings_field($this->create_id('logo'), 'Logo', array($this,'create_form'),
							$this->_menu_slug,$mainSection,array('name'=>'logo'));
    }

	public function zendvn_check_form2(){
        /*
		echo __METHOD__;
		echo '<pre>';
		print_r($_POST);
        echo '</pre>';
        */
		$postVal = $_POST;
		$errors = array();
		
		if(!empty($postVal['value']) && $postVal['inputID'] == 'zendvn_mp_st_ajax2_title'){
			if($this->stringMaxValidate($postVal['value'], 20) == false){
				$errors['msg'] = "Chuoi dai qua 20 ky tu";
			}
		}

		if(!empty($postVal['value']) && $postVal['inputID'] == 'zendvn_mp_st_ajax2_email'){
			if(!filter_var($postVal['value'], FILTER_VALIDATE_EMAIL)){
				$errors['msg'] = "Gia tri khong phai lai dia chi email";
			}
		}

		if(!empty($postVal['value']) && $postVal['inputID'] == 'zendvn_mp_st_ajax2_logo'){
			if($this->fileExtionsValidate($postVal['value'], 'JPG|PNG|GIF') == false){
				$errors['msg'] = "Phần mở rộng của tập tin không đúng định dạng kiểu";
			}
		}

		$msg = array();
		if(count($errors)>0){
			$msg['status'] = false;
			$msg['errors'] = $errors;
		}else{
			$msg['status'] = true;
		}
		
		echo json_encode($msg);
        wp_die();
	}

	public function create_form($args){
		$htmlObj = new ZendvnHtml();
		if($args['name']== 'title'){
			//Tao phan tu chua Title
			$inputID 	= $this->create_id('title');
			$inputName 	= $this->create_name('title');
			$inputValue = @$this->_setting_options['title'];
			$arr 		= array('size' =>'25','id' => $inputID);
			$html 		= $htmlObj->textbox($inputName,$inputValue,$arr)
			            . $htmlObj->pTag('Nhập vào một chuỗi không quá 20 ký tự',array('class'=>'description'));
			echo $html;
		}	

		if($args['name']== 'email'){
			//Tao phan tu chua Email
			$inputID 	= $this->create_id('email');
			$inputName 	= $this->create_name('email');
			$inputValue = @$this->_setting_options['email'];
			$arr 		= array('size' =>'25','id' => $inputID);
			$html 		= $htmlObj->textbox($inputName,$inputValue,$arr);
			
			echo $html;
		}

		if($args['name']== 'logo'){
			//Tao phan tu chua Logo
			$inputID 	= $this->create_id('logo');
			$inputName 	= $this->create_name('logo');
			$inputValue = '';
			$arr 		= array('id' => $inputID);
			$html 		= $htmlObj->fileupload($inputName,$inputValue,$arr);
				
			echo $html;
		}
    }
    
	public function add_js_file(){
		wp_register_script($this->_menu_slug, ZENDVN_MP_JS_URL . '/ajax2.js', array('jquery'),'1.0');
		wp_enqueue_script($this->_menu_slug);
	}

	//===============================================
	//Kiem tra cac dieu kien truoc khi luu du lieu vao database
	//===============================================
	public function validate_setting($data_input) {
		//Mang chua cac thong bao loi cua form
		$errors = array();
		if($this->stringMaxValidate($data_input['title'], 20) === false){
			$errors['title'] = "Site title: Chuoi dai qua so ky tu da qui dinh";
		}

		if(count($errors)>0){
			$data_input = $this->_setting_options;
			$strErrors = '';
			foreach ($errors as $val){
				$strErrors .= $val . '<br/>';
			}
			
			add_settings_error($this->_menu_slug, 'my-setting', $strErrors,'error');
		}else{
            add_settings_error($this->_menu_slug, 'my-setting', 'Cap nhat du lieu thanh cong','success');
		}
		return $data_input;
    }
    
	//===============================================
	//Kiem tra chieu chieu dai cua chuoi
	//===============================================
	private function stringMaxValidate($val, $max){
		$flag = false;
		
		$str = trim($val);
		if(strlen($str) <= $max){    
			$flag = true;
		}
		
		return $flag;
	}

	//===============================================
	//Kiem tra phần mở rộng của file
	//===============================================
	private function fileExtionsValidate($file_name, $file_type){
		$flag = false;
		
		$pattern = '/^.*\.('. strtolower($file_type) . ')$/i'; //$file_type = JPG|PNG|GIF
		if(preg_match($pattern, strtolower($file_name)) == 1){
			$flag = true;
		}
		
		return $flag;
	}

	private function create_id($val){
		return $this->_option_name . '_' . $val;
    }
    
	private function create_name($val){
		return $this->_option_name . '[' . $val . ']';
	}
    
	public function main_section_view(){
		
	}
    
	public function settingMenu(){
		
		add_menu_page(	
						'My Ajax title', 
						'My Ajax 2', 
						'manage_options', 
						$this->_menu_slug, 
						array($this,'display')
					);
    }
    
	public function display(){
		require_once ZENDVN_MP_VIEWS_DIR . '/setting-page2.php';
	}
	
}