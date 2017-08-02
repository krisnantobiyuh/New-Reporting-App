<?php

namespace App\Models;

class CommentModel extends BaseModel
{
	protected $table = 'comments';
	protected $column = ['comment', 'creator', 'item_id', 'created_at', 'updated_at'];

	function add(array $data)
	{
		$data = [
			'comment' 	=> 	$data['name'],
			'creator'	=>	$data['creator'],
			'item_id'	=>	$data['item_id'],
		];
		$this->createData($data);

		return $this->db->lastInsertId();
	}

	public function getAllComment()
    {
        $qb = $this->db->createQueryBuilder();
        $this->query = $qb->select('*')
            			  ->from($this->table);

        return $this;
    }

	public function search($val)
    {
        $qb = $this->db->createQueryBuilder();
        $this->query = $qb->select('*')
                 ->from($this->table)
                 ->where('name LIKE :val')
                 ->andWhere('deleted = 0')
                 ->setParameter('val', '%'.$val.'%');

        $result = $this->query->execute();

        return $result->fetchAll();
    }

}
?>
