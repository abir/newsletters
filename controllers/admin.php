<?php if(!defined('BASEPATH'))exit('No direct script access allowed'); 
####################################################################################################

class Admin extends Admin_Controller {

####################################################################################################

	// Validation rules to be used for create and edit
	private $recipient_rules = array(
               array(
                     'field'   => 'name',
                     'label'   => 'Name',
                     'rules'   => 'trim|required'
                  ),
            array(
                     'field'   => 'email',
                     'label'   => 'Email',
                     'rules'   => 'valid_email|trim|required'
					 //callback is preventing editing w same email
					 //wtf is up with this
                  ),
			array(
                     'field'   => 'group[]',
                     'label'   => 'Group',
                     'rules'   => 'required|numeric'
                  )
            );
			
		private $group_rules = array(
               array(
                     'field'   => 'group_name',
                     'label'   => 'Group Name',
                     'rules'   => 'trim|required'
                  ),
               array(
                     'field'   => 'group_description',
                     'label'   => 'Group Description',
                     'rules'   => 'trim|required'
                  ),
				  array(
                     'field'   => 'group_public',
                     'label'   => 'Allow public signup',
                     'rules'   => 'trim|int|required'
                  )
            );
			
			private $newsletter_rules = array(
               array(
                     'field'   => 'subject',
                     'label'   => 'Subject',
                     'rules'   => 'trim|required'
                  ),
               array(
                     'field'   => 'body',
                     'label'   => 'Body',
                     'rules'   => 'trim|required'
                  )
            );

####################################################################################################

	public function __construct()
	{
		parent::__construct();
		$this->load->model('newsletters_model','newsletters');
		$this->lang->load('newsletters');
		$this->template->set_partial('sidebar','admin/sidebar');
	}
	
####################################################################################################

	//prevent duplicate emails
	function _check_email($str,$id)
	{
		$query = $this->db->get_where('newsletter_recipients', array('email'=>$str));
		if ($query->num_rows() == 0)
		{
			return true;
		}
		elseif($query->row()->id == $id and $query->num_rows() == 1)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

####################################################################################################

	// Admin: Different actions
	function action($table)
	{
		switch($this->input->post('btnAction'))
		{
			case 'trash':
				$this->newsletters->delete($table,$this->input->post('action_to'));
			break;
			case 'restore':
				$this->newsletters->delete($table,$this->input->post('action_to'),true);
			break;
			case 'delete':
				$this->newsletters->delete($table,$this->input->post('action_to')) or die('wwww');
			break;
		}
		$table=='recipients' ? $redirect='recipients' : $redirect='';//get more specific
		redirect('admin/newsletters/'.$redirect);
	}

####################################################################################################

	function index($type='draft')
	{
		$this->data->type=$type;
		$this->data->newsletters=$this->newsletters->get_newsletters($type);	
		$this->template->build('admin/index',$this->data);
	}

####################################################################################################

	function preview($id)
	{
		foreach($this->newsletters->get_newsletters(false,$id) as $mail)
		{//move to views with template header/footer
			echo 'Subject: '.$mail->subject;
			echo '<a href="/admin/newsletters/send_mail/'.$id.'/preview">Send me a preview</a>';
			echo '<hr />';
			echo $mail->body;
		}
	}

####################################################################################################

	function edit_newsletter($id=false)
	{
		if($id) $this->data->newsletter=$this->newsletters->get_newsletters(false,$id);
		$this->load->library('form_validation');
		$this->form_validation->set_rules($this->newsletter_rules);
		if ($this->form_validation->run() === true)
		{
			$id ? $action='edit' : $action='add';
			$this->newsletters->edit_newsletter($id) ? $status='success' : $status='error';
			$message=$this->lang->line('newsletters_'.$action.'_newsletter_'.$status);
			$this->session->set_flashdata($status,sprintf($message,$this->input->post('subject')));
			redirect('/admin/newsletters/'.$id);
		}
		$this->template->append_metadata($this->load->view('fragments/wysiwyg',$this->data,TRUE));		
		$this->template->build('admin/edit_newsletter', $this->data);
	}

####################################################################################################
	
	function recipients($offset=0)
	{
		//needs pagination
		//$this->data->pagination=create_pagination('/admin/newsletters/recipients/index', $this->newsletters->count('recipients'), 0, 5);
		//$this->cache->delete('newsletters');die('s');
		//$this->data->recipients=$this->newsletters->recipients(false,false,0,5);
		
		//create_pagination($uri, $total_rows, $limit = NULL, $uri_segment = 4)
				// Create pagination links
		$total_rows = $this->newsletters->count('recipients');
		$this->data->pagination = create_pagination('admin/newsletters/recipients/', $total_rows);
		
		// Using this data, get the relevant results
		$this->data->recipients = $this->newsletters->recipients(false,false,$this->data->pagination['limit']);
		
		
		$this->template->build('admin/recipients',$this->data);
	}
	
####################################################################################################

	function edit_recipient($id=false)
	{
		if($id)
		{
			$this->data->recipient=$this->newsletters->recipients($id);
			$this->data->user_groups=$this->newsletters->user_groups($id);
		}
		$this->data->groups=$this->newsletters->groups();
		$this->load->library('form_validation');
		$this->form_validation->set_rules($this->recipient_rules);
		if ($this->form_validation->run() === true)
		{
			$message='';
			$email_available=$this->_check_email($this->input->post('email'),$id);
			if($id)
			{
				$action='edit';
				$redirect='/admin/newsletters/recipients/'.$id;
			}
			else
			{
				$action='add';
				$redirect='/admin/newsletters/recipients';
			}
			if($email_available===true)
			{
				$this->newsletters->edit_recipient($id) ? $status='success' : $status='error';
			}
			else//fix these damn messages and redirection
			{
				$status='error';
				$message.='The email <strong>'.$this->input->post('email').'</strong> is already in use';
			}
			$message.=$this->lang->line('newsletters_'.$action.'_recipient_'.$status);
			$this->session->set_flashdata($status,sprintf($message,$this->input->post('email')));
			redirect($redirect);
		}
		$this->template->build('admin/edit_recipient',$this->data);
	}

####################################################################################################

	function delete_recipient($id)
	{
		$this->newsletters->delete_recipient($id) ? $status='success' : $status='error';
		$message=$this->lang->line('newsletters_delete_recipient_'.$status);
		$this->session->set_flashdata($status,$message);
		redirect('admin/newsletters/recipients');
	}

####################################################################################################

	function delete_group($id)
	{
		$this->newsletters->delete_group($id) ? $status='success' : $status='error';
		$message=$this->lang->line('newsletters_delete_group_'.$status);
		$this->session->set_flashdata($status,$message);
		redirect('admin/newsletters/groups');
	}

####################################################################################################
	
	function groups($id=false)
	{
		if(!$id)
		{
			$this->data->groups=$this->newsletters->groups();//show all groups
		}
		else
		{
			$this->data->groups=$this->newsletters->groups($id);
			$this->data->recipients=$this->newsletters->recipients(false,$id);//show only recipients in this group
		}
		$this->template->build('admin/groups',$this->data);
	}
	
####################################################################################################

	function confirm_send($id)
	{
		foreach($this->newsletters->get_newsletters('draft',$id) as $mail)
		{
			$this->data->mail_id=$mail->id;
			$this->data->subject=$mail->subject;
			$this->data->body=$mail->body;
		}
		$this->data->groups=$this->newsletters->groups();
		$this->template->build('admin/confirm_send',$this->data);
	}

####################################################################################################

	function batch_add_recipients()
	{
		$this->data->groups=$this->newsletters->groups();
		$this->template->build('admin/batch_add_recipients',$this->data);
	}

####################################################################################################

	function send_mail($id,$preview=false)
	{
		$preview='preview' ? $preview==true : $preview==false;
		$this->newsletters->send($id,$preview);
	}

####################################################################################################

	function edit_group($id=false)
	{
		if($id) $this->data->groups=$this->newsletters->groups($id);
		$this->load->library('form_validation');
		$this->form_validation->set_rules($this->group_rules);
		if ($this->form_validation->run() === true)
		{
			if($id)
			{
				$action='edit';
				$redirect='admin/newsletters/groups/'.$id;
			}
			else
			{
				$action='add';
				$redirect='admin/newsletters/groups';
			}
			if($this->newsletters->edit_group($id))
				$status='success';
			else
				$status='error';
			$message=$this->lang->line('newsletters_'.$action.'_group_'.$status);
			$this->session->set_flashdata($status,sprintf($message,$this->input->post('group_name')));
			redirect($redirect);
		}
		$this->template->build('admin/edit_group',$this->data);
	}

####################################################################################################
function add_users_from_file(){$this->newsletters->add_users_from_file();}
####################################################################################################
}