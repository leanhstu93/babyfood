<?php 
class Counter_model extends CI_Model {
	public function __construct()
	{
		$this->load->database();
	}
	public function today()
	{
		 
		 $query = $this->db->query("select * from songuoi WHERE ID = 1");
		 $aRow= $query->result_array();
		 
		 $day=intval(date('d'));
		 $SoNguoiOnline = $this->session->userdata('SoNguoiOnline');
		 if($day != $aRow[0]['DATE'])
			{
				$this->update(array("NUMYES"=>$aRow[0]['NUMBER']));
				$query_date = $this->db->query("select DAYNAME(now()) as ngay ");
				$rowtn= $query_date->result_array();
				
				if($rowtn[0]["ngay"]=="Monday")
				{				
					$this->update(array("NUMWEEK"=>1));
				}
				 $month=intval(date('m'));	 
				 if( $month != $aRow[0]['MONTH'])
					{
						$this->update(array("NUMMONTH"=>1,"MONTH"=>$month));
					}	
				$this->update(array("NUMBER"=>1,"DATE"=>$day));
			}
			else {
				 if (!$SoNguoiOnline)
					{
						$this->db->query("update songuoi set NUMBER=NUMBER + 1,DATE='".$day."'");										
					}	
			}
			
			if (!$SoNguoiOnline)
			{
				$this->db->query("update songuoi set NUMWEEK= NUMWEEK + 1");
				$this->db->query("update songuoi set NUMMONTH=NUMMONTH + 1");
				$_SESSION["SoNguoiOnline"]="11";
			}
			$rs= $this->db->query("select NUMBER from songuoi");
			$row=$rs->result_array();
			return  $row[0]['NUMBER'] ;
	}
	public function monline()
	{
		 $sql= $this->db->query("select NUMMONTH from songuoi");
		 $aRow=$sql->result_array();
		return  $aRow[0]['NUMMONTH'] ;
	}
	public function wonline()
	{
	 	$sql= $this->db->query("select NUMWEEK from songuoi");
		$aRow = $sql->result_array();	
		return  $aRow[0]['NUMWEEK'] ;
	}
	
	public function yonline()
	{
		$sql= $this->db->query("select NUMYES from songuoi");
		$aRow = $sql->result_array();	
		return  $aRow[0]['NUMYES'] ;
	}
	public function getcounter($readorwrite="")
	{
		if($readorwrite="write")
		{
		$hits_session = $this->session->userdata("hit");
		if($hits_session == null) {
			$this->session->set_userdata('hit', 'deiafienvcoewkcdo22');
			$bool = $this->db->query("UPDATE tbl_counter SET hits=hits+1");
			$bool2 = $this->db->query("UPDATE tbl_counter SET realhits=realhits+1");
		}
		$r2= $this->db->query("SELECT hits FROM tbl_counter");
			$row = $r2->result_array();
			$hits=$row[0]['hits'];
		}
		return $hits;
	}
	public function DangOnline()
	{        
		 $s_id = session_id();            
		$time = time();            
		$time_secs = 600;      
		$time_out = $time - $time_secs;       
		
		$this->db->query("DELETE FROM stats WHERE s_time < '$time_out'");                
		$this->db->query("DELETE FROM stats WHERE s_id = '$s_id'");                       
		$this->db->query("INSERT INTO stats (s_id, s_time) VALUES ('$s_id', '$time')");   
		$user_online = $this->db->query("SELECT COUNT(id) AS total FROM stats"); 
		$row = $user_online->result_array();      
		return "".$row[0]['total'].""; 
	
	}
	public function update($data=NULL)
	{
		//$this->db->where('ID', $id);
		$result = $this->db->update('songuoi', $data); 
		return $result;
	}
}