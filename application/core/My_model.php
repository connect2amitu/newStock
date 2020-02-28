<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class My_model extends CI_Model 
{
	/**
	 * Add Record
	 * @param  string $table table name
	 * @param  array $data  New record array
	 * @param  bool $type  true = Multiple insert, false = single insert
	 * @return bool|int        
	 */
	public function insert($table='', $data='', $type='')
	{
		if ($table!='' and $data!='') 
		{
			if ($type!=null) 
			{
				return $this->db->insert_batch($table, $data);
			}
			else
			{
				$this->db->insert($table, $data);
				return $this->db->insert_id();		
			}
		}
		return false;
	}

	/**
	 * Update record
	 * @param  string $table   table name
	 * @param  array $newdata new update record array
	 * @param  int|array $id      array of where condition
	 * @return bool          
	 */
	public function update($table='', $newdata='', $id='')
	{
		if ($table!='' and $newdata!='' and $id!='') 
		{
			if (is_array($id)) 
			{
				$this->db->where($id);
			}
			else
			{
				$this->db->where('id', $id);
			}
			return $this->db->update($table, $newdata);	
		}
		return false;

	}

	/**
	 * Delete record
	 * @param  string $table table name
	 * @param  int|array $id    where condition data 
	 * @return bool        
	 */
	public function delete($table='', $id='')
	{
		if ($table!='' and $id!='') 
		{
			if (is_array($id)) 
			{
				$this->db->where($id);
			}
			else
			{
				$this->db->where('id', $id);
			}
			return $this->db->delete($table);
		}
		return false;
	}

	/**
	 * Multiple delete records
	 * @param  string $table table name
	 * @param  array $id    IDs of Selected Records
	 * @return bool        
	 */
	public function delete_all($table='', $id='')
	{
		if ($table!='' and $id!='') 
		{
			$this->db->where_in('id', $id);	
			return $this->db->delete($table);
		}
	}

	
	/**
	 * Select records
	 * @param  string $table  table name
	 * @param  int|array $id     id of record
	 * @param  int $start  start of record
	 * @param  int $offset offset of record
	 * @return array         array of fetched records
	 */
	public function select($table='', $id='', $start='', $offset='')
	{
		if ($table!='') 
		{
			if ($id!='') 
			{
				if (is_array($id)) 
				{
					$this->db->where($id);	
				}
				else
				{
					$this->db->where('id',$id);						
				}
			}

			if ($start!='' or $offset!='') 
			{
				$this->db->limit($start, $offset);	
			}

			return $this->db->get($table)->result_array();	
		}
		return false;
	}

	/**
	 * count all records
	 * @param  string $table table name
	 * @return int        total number of existed records
	 */
	public function count_all($table='')
	{
		if ($table!='') 
		{
			return $this->db->count_all($table);
		}
		return false;
	}

	/**
	 * get filtred records
	 * @param  string $table table name
	 * @param  array $like  like critearea
	 * @return array        array of records
	 */
	public function filtered($table='', $like='',$start='', $offset='')
	{
		$this->db->select('*');
		$this->db->from($table);
		$this->db->like($like[0][0], $like[0][1], 'after'); 
		$this->db->limit($start, $offset); 
		
		for ($i = 1; $i < count($like); $i++)
		{
			$this->db->or_like($like[$i][0], $like[$i][1], 'after');
		}

		return $this->db->get()->result_array();
	}

	

}

/* End of file My_model.php */
/* Location: ./application/core/My_model.php */