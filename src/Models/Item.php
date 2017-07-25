<?php
namespace App\Models;
class Item extends BaseModel
{
    protected $table = 'items';
    protected $column = ['id', 'name'];
    protected $joinTable = 'groups';

    public function create($data)
    {
        $date = date('Y-m-d H:i:s');
        $data = [
            'name'        => $data['name'],
            'description' => $data['description'],
            'recurrent'   => $data['recurrent'],
            'start_date'  => $data['start_date'],
            'group_id'    => $data['group_id'],
            'user_id'     => $data['user_id'],
            'image'       => $data['image'],
            'creator'     => $data['creator'],
            'public'      => $data['public'],
            'updated_at'  => $date
        ];
        $this->createData($data);
        return $this->db->lastInsertId();
    }

    public function update($data, $id)
    {
        $date = date('Y-m-d H:i:s');
        $data = [
            'name'        => $data['name'],
            'description' => $data['description'],
            'recurrent'   => $data['recurrent'],
            'start_date'  => $data['start_date'],
            'group_id'    => $data['group_id'],
reXm.                   'updated_at'  => $date
        ];
        $this->updateData($data, $id);
    }

    public function getAllItem()
    {
        $qb = $this->db->createQueryBuilder();
        $qb->select('gr.name as groups', 'it.*')
           ->from($this->table, 'it')
           ->join('it', $this->joinTable, 'gr', 'gr.id = it.group_id')
           ->where('it.deleted = 0');
           $result = $qb->execute();
           return $result->fetchAll();
    }

    public function getAllDeleted()
    {
        $qb = $this->db->createQueryBuilder();
        $qb->select('gr.name as groups', 'it.*')
           ->from($this->table, 'it')
           ->join('it', $this->joinTable, 'gr', 'gr.id = it.group_id')
           ->where('it.deleted = 1');
           $result = $qb->execute();
           return $result->fetchAll();
    }

    public function getUserItem($userId, $groupId)
    {
        $qb = $this->db->createQueryBuilder();
        $query1 = $qb->select('item_id')
        ->from('reported_item')
        ->where('user_id =' . $userId)
        ->execute();

        $qb1 = $this->db->createQueryBuilder();
        if ($query1->fetchAll()[0] != NULL) {
            $this->query = $qb1->select('i.*')
            ->from($this->table, 'i')
            ->join('i', 'reported_item', 'r', $qb1->expr()->notIn('i.id', $query1))
            ->where('i.user_id = '. $userId .'&&'. 'i.group_id = '. $groupId)
            ->orWhere('i.group_id = '. $groupId)
            ->andWhere('i.deleted = 0 && i.status = 0')
            ->groupBy('i.id');
        } else {
            $this->query = $qb1->select('*')
            ->from($this->table)
            ->where('user_id = '. $userId .'&&'. 'group_id = '. $groupId)
            ->orWhere('group_id = '. $groupId)
            ->andWhere('deleted = 0 && status = 0');
        }
        return $this->fetchAll();
    }

    public function getItemDone($userId, $groupId)
    {
        $qb = $this->db->createQueryBuilder();
            $this->query = $qb->select('*')
            ->from($this->table)
            ->where('user_id = '. $userId .'&&'. 'group_id = '. $groupId)
            ->orWhere('group_id = '. $groupId)
            ->andWhere('deleted = 0 && status = 1');
        return $this->fetchAll();
    }


    public function getGroupItem($userId)
    {
        $qb = $this->db->createQueryBuilder();
        $query = $qb->select('group_id')
        ->from('user_group')
        ->where('user_id =' . $userId)
        ->execute();
        //    $result = $query1->execute();
        //    $result1 = $result->fetchAll();
        //    var_dump($result1); die()
        $qb1 = $this->db->createQueryBuilder();
        $query1 = $qb1->select('i.*')
            ->from($this->table, 'i')
            ->where('i.status = 0')
            ->join('i', 'user_group', 'ug', $qb1->expr()->in('i.group_id',$query))
            ->execute();


            $result2  = array_map("unserialize", array_unique(array_map("serialize", $query1->fetchAll())));

            return $result2;

    }

    public function getUserItemInGroup($userId)
    {
        $qb = $this->db->createQueryBuilder();
        $query1 = $qb->select('item_id')
        ->from('reported_item', 'ri')
        ->where('ri.user_id =' . $userId)
        ->execute();

        $qb2 = $this->db->createQueryBuilder();
        $query2 = $qb2->select('group_id')
        ->from('user_group', 'ug')
        ->where('ug.user_id =' . $userId)
        ->execute();

        $qb1 = $this->db->createQueryBuilder();
        if ($query1->fetchAll() != NULL) {
            $this->query = $qb1->select('i.*')
            ->from($this->table, 'i')
            ->join('i', 'reported_item', 'r', $qb1->expr()->notIn('i.id', $query1))
            ->where('i.user_id ='.$userId)
            ->andWhere('i.deleted = 0')
            ->groupBy('i.id');
        } else {
            $this->query = $qb1->select('i.*')
            ->from($this->table, 'i')
            ->join('i', 'user_group', 'ug', $qb1->expr()->in('i.group_id', $query2))
            ->where('i.user_id ='.$userId)
            ->andWhere('i.deleted = 0');
        }

        return $this->fetchAll();
    }

    public function userItem($userId)
    {
        $qb = $this->db->createQueryBuilder();
        $qb->select('*')
           ->from($this->table)
           ->where('user_id = '. $userId)
           ->andWhere('status = 0');

           $result = $qb->execute();
           return $result->fetchAll();
    }

    public function getItem($column1, $value1, $column2, $value2)
    {
        $param1 = ':'.$column1;
        $param2 = ':'.$column2;
        $qb = $this->db->createQueryBuilder();
        $qb->select('*')
            ->from($this->table)
            ->setParameter($param1, $value1)
            ->setParameter($param2, $value2)
            ->where($column1 . ' = '. $param1. '&&' . $column2 . ' = '. $param2);
        $result = $qb->execute();
        return $result->fetchAll();
    }


}
