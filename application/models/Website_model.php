<?php 
class Website_model extends CI_Model {
	public $title;
	public $content;
	public $date;

	public function __construct()
	{
		$this->load->database();
		$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
	}


	public function list_data($limit,$skip)
	{
		$query = $this->db->get('mn_website',$limit,$skip);
		return $query->result();
	}
	public function count_all()
	{
		return $this->db->count_all('mn_website');	

	}
	public function get_where($id)
	{
		$query = $this->db->get_where('mn_website',array("Id"=>$id));
		return $query->result_array();
	}
	public function add(){
		$data['username'] = $this->input->post('username');
		$data['password'] = $this->page->gen_pass($this->input->post('password'));
		$data['email'] = $this->input->post('email');
		$data['level'] = $this->input->post('level');
		$data['ticlock'] = $this->input->post('ticlock')?$this->input->post('ticlock'):0;
		$data['time'] = time();
		$data['fullname'] = $this->input->post('fullname');
		$data['address'] = $this->input->post('address');
		$data['note'] = $this->input->post('note');
		return $this->db->insert('mn_website', $data);
	}
	public function delete($id){
		
		return $this->db->delete('mn_website', array('Id' => $id)); 
	}
	public function update($id,$data,$option = false)
	{
		if($option==true){
			$data['title_vn'] = $this->input->post('title_vn');
			$data['googleanalytics'] = $this->input->post('googleanalytics');
			$data['email'] = $this->input->post('email');
			$data['hotline'] = $this->input->post('hotline');
			$data['meta_title'] = $this->input->post('meta_title');
			$data['keyword_vn'] = $this->input->post('keyword_vn');
			$data['description_vn'] = $this->input->post('description_vn');
			$data['enable'] = $this->input->post('enable')?$this->input->post('enable'):0;
			$data['stamp'] = $this->input->post('stamp')?$this->input->post('stamp'):0;
			//var_dump($data);
			
		}
		unset($data['percent_old']);
		unset($data['money_old']);
		$this->db->where('id', $id);
		$result = $this->db->update('mn_website', $data); 
		return $result;
	}
	public function get_payment_month_year($month,$year)
	{
		$query = $this->db->get_where('mn_payment',array("month"=>$month,"year"=>$year));
		return $query->result_array();
	}
	public function payment($month, $year, $rget = 1, $a_c = array()) {
        $cache_id = 'paymentToUser_' . $month . '_' . $year;
        $cached = $this->cache->get($cache_id);
        if (!$cached) {
            $result = $this->get_payment_month_year($month,$year);
            if ($result == array()) {
                if ($rget > 12) {
                    $cached = array('price' => '10000', 'percent' => 1);
                    if ($a_c != array()) 
                        $this->cache->file->save('paymentToUser_' . $a_c[0] . '_' . $a_c[1], $cached, 31104000); 
                    return $cached;
                }
                if ($a_c == array())
                    $a_c = array($month, $year);
                if ($month == 1 AND $rget < 12) {
                    $month = 12;
                    $year = $year - 1;
                } else
                    $month = $month - 1;
                $result = $this->payment($month, $year, $rget + 1, $a_c);
                if ($result)
                    return $result;
                return FALSE;
            }else {
                $this->cache->save($cache_id, $result[0], 31104000);
                return $result[0];
            }
        }
        else
            return $cached;
    }
}