<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Layout extends Controller {
	
        private static $instance;
	protected $_separator   = ' | ';
	protected $_prefix 	= 'SmartCampus';
	protected $_title 	= '';
	protected $_keywords	= '';
	protected $_description	= '';
	protected $_data	= array();
	protected $_layout_data	= array();

	public function before()
	{
            if(empty(self::$instance))
            {
                self::$instance = true;
                  Helper_Output::factory()
                    ->link_css('css/style')
                    ->link_css('laguadmin/css/style')
                    ->link_css('laguadmin/lib/datatables/css/table_jui')
                    ->link_css('laguadmin/lib/jquery-ui/css/smoothness/jquery-ui-1.8.15.custom')
                    ->link_js('js/libs/jquey-1.8.2.min')
                    ->link_js('js/libs/bootstrap.min')
                    ->link_js('js/libs/jquery-ui-1.9.2.custom.min')
                    ->link_js('laguadmin/js/head.load.min') 
//                    ->link_js('laguadmin/lib/jquery-validation/jquery.validate');
                    ->link_js('laguadmin/js/lagu')
                    ->link_js('js/laguadmin/users')
                    ->link_js('js/record/index')
                    ->link_js('js/record/financial')
                          
//                 //================users=============================================         
//                    ->link_js('/laguadmin/js/jquery-1.6.2.min')
//                    ->link_js('/laguadmin/lib/fusion-charts/FusionCharts')
//                    ->link_js('/laguadmin/js/jquery.microaccordion')
//                    ->link_js('/laguadmin/js/jquery.stickyPanel')
//                    ->link_js('/laguadmin/js/xbreadcrumbs')
//                    ->link_js('/laguadmin/lib/slidernav/slidernav')
//                    ->link_js('/laguadmin/js/lagu')
//                    ->link_js('/laguadmin/lib/jquery-ui/jquery-ui-1.8.15.custom.min')
//                    ->link_js('/laguadmin/lib/harvesthq-chosen/chosen.jquery.min')
//                    ->link_js('/laguadmin/lib/fancybox/jquery.easing-1.3.pack')
//                    ->link_js('/laguadmin/lib/fancybox/jquery.fancybox-1.3.4.pack')
//                    ->link_js('/laguadmin/lib/tiny-mce/jquery.tinymce')
//                    ->link_js('/laguadmin/js/jquery.tools.min')
//                    ->link_js('/laguadmin/lib/datatables/jquery.dataTables.min')
//                    ->link_js('/laguadmin/lib/datatables/dataTables.plugins')
//                    ->link_js('/laguadmin/lib/timepicker-addon/jquery-ui-timepicker-addon')
//                 //================users=============================================         
                          
            //========================================
                    ->link_js('js/laguadmin/dashboard')
                    ->link_js('js/laguadmin/users_edit')
                    ->link_js('js/laguadmin/teachers')   
                    ->link_js('js/record/total')
                    ->link_js('js/user/admins')
                    ->link_js('js/user/index')
                    ->link_js('js/user/students')
                    ->link_js('js/user/teachers')
                    ->link_js('js/ajaximage/ajaximage')
                    ->link_js('js/level/index')
                    ->link_js('js/class/templates')
                    ->link_js('js/record/index')
                    ->link_css('laguadmin/lib/datatables/css/table_jui')
                    ->link_css('laguadmin/lib/harvesthq-chosen/chosen')
//            //========================================
                    ->link_js('js/laguadmin/settings')
                    ->link_js('js/laguadmin/records')
                          
                          

             //**************************************************
//                    ->link_js('laguadmin/lib/fusion-charts/FusionCharts')
//                    ->link_js('/laguadmin/js/jquery.microaccordion')
//                    ->link_js('/laguadmin/js/jquery.tools.min')
////                    ->link_js('/laguadmin/lib/fusion-charts/FusionCharts')
//                    ->link_js('/laguadmin/js/jquery.stickyPanel')
//                    ->link_js('/laguadmin/js/jquery.text-overflow.min')
//                    ->link_js('/laguadmin/js/xbreadcrumbs')
//                    ->link_js('/laguadmin/js/login')
//                    ->link_js('/laguadmin/lib/harvesthq-chosen/chosen.jquery.min')
//                    ->link_js('/laguadmin/lib/fancybox/jquery.easing-1.3.pack')
//                    ->link_js('/laguadmin/lib/fancybox/jquery.fancybox-1.3.4.pack')
//                    ->link_js('/laguadmin/lib/file-uploader/fileuploader')
//                    ->link_js('/laguadmin/lib/tiny-mce/jquery.tinymce')
//                    ->link_js('/laguadmin/lib/styled-checkboxes/iphone-style-checkboxes')
//                    ->link_js('/laguadmin/lib/jquery-raty/jquery.raty.min')
//                    ->link_js('/laguadmin/lib/timepicker-addon/jquery-ui-timepicker-addon')
//                    ->link_js('/laguadmin/lib/slidernav/slidernav')
//                    ->link_js('/laguadmin/lib/datatables/jquery.dataTables.min')
//                    ->link_js('/laguadmin/lib/datatables/dataTables.plugins')
             //**************************************************             

                          
                    ->link_js('js/modules/main');
            }
            $this->template = View::factory('layouts/main');
            
            $config                 = Kohana::$config->load('config');
            $this->_title 		= $config->get('Site Title');
            $this->_keywords 	= $config->get('Site Keywords');
            $this->_description     = $config->get('Site Description');
	}

	/*
	*  SEO data
	*/
	public function setTitle($title = '')
	{
		if($title != '') {
			$this->_title = __($title).$this->_separator.__($this->_prefix);
		}
                
		return $this;
	}

	public function setKeyword($text = '')
	{
		if($text != '') {
			$this->_keywords = $text;
		}
		return $this;
	}

	public function set_layout_data($data)
	{
            foreach ($data as $key => $value) {
                $this->_layout_data[$key] = $value;
            }
	}
        
	public function setDescription($text = '')
	{
		if($text != '') {
			$this->_description = $text;
		}
		return $this;
	}
        
        public function set_template_content($data = array())
        {
            if(!empty($data)) {
                foreach ($data as $key => $value) {
                    $this->template
                            ->set($key, $value);
                }
            }
            return $this;
        }

        /*
	* set partial template
	*/
	public function view($partials = '', $data = array())
	{
		$this->template->content = View::factory($partials);
                
                if(!empty($this->_layout_data))
                    $this->setData($this->_layout_data, $this->template->content);
                
		if(!empty($data)) {
			$this->setData($data, $this->template->content);
		}
		return $this;
	}

	public function setData($data = array(), $scope = false)
	{
		if(!empty($data)) {
			foreach ($data as $key => $value) {
				if($scope) {
					$scope->$key = $value;
				}
				$this->template->$key = $value;
			}
		}

		$this->_data = $data;

		return $this;
	}

	/*
	* @param $format:: html(default), json
	*/
	public function render($format = 'html')
	{
//                 Helper_Output::setRenderCustomJs('/js/libs/jquey-1.8.2.min');
//                 Helper_Output::setRenderCustomJs('/media/3667b55d9e609e2161157b3f38f0650d');
		 $this->template->title 		= $this->_title;
		 $this->template->keywords 		= $this->_keywords;
		 $this->template->description 	= $this->_description;
		 switch($format) {
		 	case 'html': 
		 		$this->response->body($this->template);
		 		break;
		 	case 'json':
		 		header('Content-type: text/json');
				header('Content-type: application/json');
				echo json_encode($this->_data);
		 		break;
		 }
	}
        
        /*
	* set display assets
	*/
        public function action_media()
	{
            // prevent auto render
            $this->auto_render = FALSE;
            // Generate and check the ETag for this file
            //		$this->request->check_cache(sha1($this->request->uri));
            // Get the file path from the request
            $file = Request::current()->param('file');
            $dir = Request::current()->param('dir');
            // Find the file extension
            $ext = pathinfo($file, PATHINFO_EXTENSION);
            // Remove the extension from the filename
            $file = substr($file, 0, - ( strlen($ext) + 1 ));
            $file = Kohana::find_file('assets', $dir . '/' . $file, $ext);
            if ($file)
            {
                // Send the file content as the response
                $this->response->body(file_get_contents($file));
            }
            else
            {
                // Return a 404 status
                $this->response->status(404);
            }
            // Set the proper headers to allow caching
            $this->response->headers('Content-Type', File::mime_by_ext($ext));
            $this->response->headers('Content-Length', (string) filesize($file));
            $this->response->headers('Last-Modified', date('r', filemtime($file)));
	}
        
        private function get_media($type)
        {
            $result = array();
            $part_path = Kohana::$config->load('minify.path.media');
            if($type == 'css')
                $media_array = array_keys($this->styles);
            else
                $media_array = $this->scripts;
            $min_media = Minify::factory($type)->minify($media_array);
            foreach ($min_media as $key => $value)
            {
                if(substr_count($value, $part_path))
                    $value = str_replace ($part_path, 'media/', $value);
                if($type == 'css')
                    $result[$value] = 'screen';
                else
                    $result[] = $value;
            }
            return $result;
        }
}
