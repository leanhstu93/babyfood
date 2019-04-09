<?php 
class Comment_model extends CI_Model {
	public function __construct()
	{
		$this->load->database();
	}
	
	public function list_data($limit,$skip)
	{
		$this->db->select('mn_comment.title,mn_comment.content,mn_comment.date, mn_comment.id,mn_comment.idpro,mn_comment.ticlock, mn_product.alias,mn_product.title_vn,mn_user.username');
		$this->db->join('mn_product', 'mn_product.id = mn_comment.id');
		$this->db->join('mn_user', 'mn_user.id = mn_comment.iduser');
		$this->db->order_by('date DESC');
		$query = $this->db->get('mn_comment',$limit,$skip);
		return $query->result();
	}
	public function count_all()
	{
		return $this->db->count_all('mn_comment');	

	}
	public function get_query($sql)
	{
		$query = $this->db->query($sql);
		return $query->result_array();	
	}
	public function get_where($id)
	{
		$query = $this->db->get_where('mn_comment',$id);
		return $query->row_array();
	}
	public function count_where($where)
	{
		$query = $this->db->get_where('mn_comment',$where);
		$result = $query->num_rows();
		return $result;
	}
	public function add($data){
		
		return $this->db->insert('mn_comment', $data);
	}
	public function delete($id){
		
		return $this->db->delete('mn_comment', array('Id' => $id)); 
	}
	public function update($id,$data,$option = false)
	{
		if($option==true){
			$data['title_vn'] = $this->input->post('title_vn');
			if($alias == ""){
				$data['alias'] = $this->page->strtoseo($this->input->post('title_vn'));
			}else{
				$data['alias'] = $this->input->post('alias');
			}
			$data['link'] = $this->input->post('link');
			$data['urlimage'] = $this->input->post('urlimage');
			$data['sort'] = $this->input->post('sort')?$this->input->post('sort'):0;
			$data['ticlock'] =  $this->input->post('ticlock')?$this->input->post('ticlock'):0;
			$data['date'] = time(); 
			$data['content_vn'] = $this->input->post('content_vn');
		}
		$this->db->where('Id', $id);
		$result = $this->db->update('mn_comment', $data); 
		return $result;
	}
	
}