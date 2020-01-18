<?php

class Upload extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->helper(array('form', 'url', 'file'));
				$this->load->library('javascript');
				$this->load->library(
						'javascript',
						array(
								'js_library_driver' => 'scripto',
								'autoload' => FALSE
						)
				);
        }

        public function index()
        {
			$this->load->view('admin/page/header');
                $this->load->view('admin/content/upload/depan', array('error' => ' ' ));
				$this->load->view('admin/page/footer');
        }

        public function do_upload()
        {
                $config['upload_path']          = './uploads/';
                $config['allowed_types']        = 'gif|jpg|png';
                $config['max_size']             = 1000;
                $config['max_width']            = 1024;
                $config['max_height']           = 768;

                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('file'))
                {
                        $error = array('error' => $this->upload->display_errors());

                        // $this->load->view('admin/content/upload/depan', $error);
						
						$message =  array(
							"message" => $this->upload->display_errors()
						);
						$this->load->view("admin/valids/validationmessage", $message);
                }
                else
                {
                        $data = array('upload_data' => $this->upload->data());
						//echo $this->input->post("nama");
						//echo $this->input->post("file");
						//echo $this->upload->data('file_name'); 
                        //$this->load->view('admin/content/upload/success', $data);
                }
        }
}
?>