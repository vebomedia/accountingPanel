<?php

namespace Financepanel\Models;

use CodeIgniter\Model;

class C4_fileModel extends Model
{

    //--------------------------------------------------------------------

    protected $table          = 'c4_file';
    protected $primaryKey     = 'c4_file_id';
    protected $useSoftDeletes = true;
    protected $allowedFields  = ["c4_file_id","name","fullPath","isPublic","isImage","originalName","thumb","extension","size","type","path","sort_order","keywords","created_at","updated_at","deleted_at"];
    protected $useTimestamps  = true;
    protected $createdField   = 'created_at';
    protected $updatedField   = 'updated_at';
    protected $deletedField   = 'deleted_at';
    protected $beforeInsert   = ['beforeInsert'];
    protected $afterInsert    = ['afterInsert'];
    protected $beforeUpdate   = ['beforeUpdate'];
    protected $afterUpdate    = ['afterUpdate'];
    protected $beforeDelete   = ['beforeDelete'];
    protected $afterDelete    = ['afterDelete'];
    protected $afterFind      = ['afterFind'];

    //--------------------------------------------------------------------

    /**
     * Return DB fields which ones are allowed
     * @return array
     */
    public function getAllowedFields(): array
    {

        return $this->allowedFields;
    }

    //--------------------------------------------------------------------

    protected function beforeInsert(array $data)
    {
        
        if (function_exists('c4_file_beforeInsert'))
        {
            return c4_file_beforeInsert($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------

    protected function afterInsert($data)
    {
        if (function_exists('c4_file_afterInsert'))
        {
            c4_file_afterInsert($data);
        }
    }

    //--------------------------------------------------------------------

    protected function beforeUpdate(array $data)
    {
        
        if (function_exists('c4_file_beforeUpdate'))
        {
            return c4_file_beforeUpdate($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------

    protected function afterUpdate(array $data)
    {
        if (function_exists('c4_file_afterUpdate'))
        {
            c4_file_afterUpdate($data);
        }
    }

    //--------------------------------------------------------------------

    protected function beforeDelete(array $data)
    {
        
        if (function_exists('c4_file_beforeDelete'))
        {
            return c4_file_beforeDelete($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------

    protected function afterDelete(array $data)
    {
        if (function_exists('c4_file_afterDelete'))
        {
            c4_file_afterDelete($data);
        }
    }

    //--------------------------------------------------------------------

    protected function afterFind(array $data)
    {
        if (function_exists('c4_file_afterFind'))
        {
            return c4_file_afterFind($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------
}