<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Auth_model','auth');
    }

    public function index()
    {
        // if($this->session->userdata('username')){
        //     redirect('user');
        // }

        $this->form_validation->set_rules('username','Username','trim|required');
        $this->form_validation->set_rules('password','Password','trim|required');
        // die(print_r($this->input->post('username'),1));
        if ($this->form_validation->run() == FALSE) 
        {
            $data['title'] = 'User Login';
            $this->load->view('login');
        } else {
            $this->_login();
        }               
    }

    private function _login()
    {
        $username = $this->input->post('username');
        $password = md5($this->input->post('password'));

        $user = $this->db->get_where('user',['username' => $username,'password' => $password])->row_array();
        // die(print_r($user['admin'],1));
        if($user){
            if($user['admin'] == "Y"){
                $data = [
                    'fullnm' => $user['fullnm'],
                    'id' => $user['Id']
                ];
                $this->session->set_userdata($data);
                $this->session->set_flashdata('message',', Selamat Datang '.$user['fullnm']);
    
                redirect('admin');
            }else{
                $this->session->set_flashdata('messageError','Tidak Memiliki Akses');
                redirect('auth');
            }
        }else{
            $this->session->set_flashdata('messageError','Username / Password Tidak Terdaftar');
            redirect('auth');
        }

    }

    public function registration()
    {
        if($this->session->userdata('username')){
            redirect('user');
        }
        
        $this->form_validation->set_rules('name','Name','required|trim');
        $this->form_validation->set_rules('username','Email','required|trim|valid_username|is_unique[user.username]',[
            'is_unique' => 'This username has been registered!'
        ]);
        $this->form_validation->set_rules('password1','Password','required|trim|min_length[3]|matches[password2]',
        ['matches' => 'Password dont match!',
        'min_length' => 'Password to short!'
        ]);
        $this->form_validation->set_rules('password2','Password','required|trim|matches[password1]');

        if ($this->form_validation->run()== FALSE) {
        $data['title'] = 'User Registration';

        $this->load->view('templates/auth_header',$data);
        $this->load->view('auth/registration');
        $this->load->view('templates/auth_footer');
        } else {
            $data = [
                'name' => htmlspecialchars($this->input->post('name',true)),
                'username' => htmlspecialchars($this->input->post('username',true)),
                'image' => 'default.jpg',
                'password' => password_hash($this->input->post('password1'),PASSWORD_DEFAULT),
                'role_id' => 2,
                'is_active' => 1,
                'date_created' => time()
            ];

            $this->db->insert('user',$data);
            $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">
            Your account has been created!
          </div>');
            redirect('auth');
        }               
    }

    private function _sendEmail($token, $type)
    {
        $config = [
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://mail.yonathanrizky.com',
            'smtp_user' => 'info@yonathanrizky.com',
            'smtp_pass' => '*#info2012',
            'smtp_port' => 465,
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n"
        ];

        $this->load->library('username',$config);
        $this->username->initialize($config);
        $this->username->from('info@yonathanrizky.com','Info Yonathan Rizky');
        $this->username->to($this->input->post('username'));

        if ($type == 'forgot') {
            $this->username->subject('Reset Password');
            $this->username->message('Click this link to reset your password : <a href="'.base_url() . 'auth/resetpassword?username=' . $this->input->post('username') . '&token=' . urlencode($token) . '">Reset Password</a>');    
        }

        if ($this->username->send()) {
            return true;
        } else {
            echo $this->username->print_debugger();
            die;
        }        
    }

    public function forgotpassword()
    {
        $this->form_validation->set_rules('username','Email','trim|required|valid_username');
        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Forgot Password';
            $this->load->view('templates/auth_header',$data);
            $this->load->view('auth/forgot_password');
            $this->load->view('templates/auth_footer');
        } else {
            $username = $this->input->post('username');
            $user = $this->auth->getUser($username);
            
            if ($user) {
                $token = base64_encode(random_bytes(32));
                $user_token = [
                    'username' => $username,
                    'token' => $token,
                    'date_created' => time()
                ];

                $this->db->insert('user_token',$user_token);
                $this->_sendEmail($token,'forgot');
                $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">
                Reset Password Sent!
                </div>');
                redirect('auth');
            } else {
                $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">
                Email is not registered or actived!
                </div>');
                redirect('auth/forgotPassword');
            }            
        }        
    }

    public function resetpassword()
    {
        $username = $this->input->get('username');
        $token = $this->input->get('token');

        $user = $this->auth->getUser($username);

        if ($user) {
            $user_token = $this->auth->getUserToken($token);
            if ($user_token) {
                if (time() - $user_token['date_created'] < (60*60*24)) {
                    $this->session->set_userdata('reset_username',$username);
                    $this->changePassword();
                } else {
                    $this->db->delete('user_token',['username' => $username]);
    
                    $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">
                    Account activation failed! Token Expired
                    </div>');
                    redirect('auth'); 
                }
            } else {
                $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">
                Reset password failed! Wrong token
              </div>');
                redirect('auth');  
            }            
        } else {
            $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">
                Reset Password Failed! Wrong Email!
                </div>');
                redirect('auth');    
        }        
    }

    public function changePassword()
    {
        if (!$this->session->userdata('reset_username')) {
            redirect('auth');
        }

        $this->form_validation->set_rules('password1','Password','trim|required|min_length[3]|matches[password2]');
        $this->form_validation->set_rules('password2','Repeat Password','trim|required|min_length[3]|matches[password1]');
        if($this->form_validation->run() == false)
        {
            $data['title'] = 'Change Password';
            $this->load->view('templates/auth_header',$data);
            $this->load->view('auth/change_password');
            $this->load->view('templates/auth_footer');
        }else{
            $password = password_hash($this->input->post('password1'),PASSWORD_DEFAULT);
            $username = $this->session->userdata('reset_username');
            $this->db->set('password',$password);
            $this->db->where('username',$username);
            $this->db->update('user');

            $this->db->where('username',$username);
            $this->db->delete('user_token');

            $this->session->unset_userdata('reset_username');

            $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">
                Password has been change!
                </div>');
                redirect('auth');
        }
    }

    public function logout()
    {
        // $this->session->sess_destroy();
        $this->session->unset_userdata('id');
        $this->session->unset_userdata('fullnm');
        redirect('auth');
    }

    public function blocked()
    {
        $this->load->view('auth/blocked');
    }
}
?>