<?phpclass Users extends CI_Controller {    function __construct()    {        parent::__construct();        $this->load->helper(array('language', 'url', 'form', 'ssl', 'pool', 'date'));        $this->load->library(array('authentication'));        $this->load->model(array('account_model'));        $this->load->model(array('account_details_model'));        $this->db->select('language');        $query = $this->db->get_where('account_details', array('account_id' => $this->session->userdata('account_id')));        $lang = $query->row_array();        if (isset($lang['language']))  {$this->config->set_item('language',$lang['language']);}        $this->lang->load(array('general'));    }        function index()    {    }        function viewusers()    {                if ($this->authentication->is_signed_in())        {                   $sql_query = "SELECT *                          FROM `account`                          JOIN `account_details`                          ON `account_details`.`account_id` = `account`.`id`";            $query = $this->db->query($sql_query);            $users = $query->result_array();            $data = array(                        'users'             => $users,                        'account'           => $this->account_model->get_by_id($this->session->userdata('account_id')),                        'account_details'   => $this->account_details_model->get_by_account_id($this->session->userdata('account_id'))                        );            $data['content_main'] = "show_all_users";            $data['title'] = lang('show_all_users');                        $this->load->view('template/template', $data);                    }        else        {            redirect('account/sign_in/?continue='.site_url('users/viewusers'));        }    }}