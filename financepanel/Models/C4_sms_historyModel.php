<?php

namespace Financepanel\Models;

use CodeIgniter\Model;

class C4_sms_historyModel extends Model
{

    //--------------------------------------------------------------------

    protected $table          = 'c4_sms_history';
    protected $primaryKey     = 'c4_sms_history_id';
    protected $useSoftDeletes = true;
    protected $allowedFields  = ["c4_sms_history_id","smsto","message","is_sended","created_at","updated_at","deleted_at"];
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
        
        if (function_exists('c4_sms_history_beforeInsert'))
        {
            return c4_sms_history_beforeInsert($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------

    protected function afterInsert($data)
    {
        if (function_exists('c4_sms_history_afterInsert'))
        {
            c4_sms_history_afterInsert($data);
        }
    }

    //--------------------------------------------------------------------

    protected function beforeUpdate(array $data)
    {
        
        if (function_exists('c4_sms_history_beforeUpdate'))
        {
            return c4_sms_history_beforeUpdate($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------

    protected function afterUpdate(array $data)
    {
        if (function_exists('c4_sms_history_afterUpdate'))
        {
            c4_sms_history_afterUpdate($data);
        }
    }

    //--------------------------------------------------------------------

    protected function beforeDelete(array $data)
    {
        
        if (function_exists('c4_sms_history_beforeDelete'))
        {
            return c4_sms_history_beforeDelete($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------

    protected function afterDelete(array $data)
    {
        if (function_exists('c4_sms_history_afterDelete'))
        {
            c4_sms_history_afterDelete($data);
        }
    }

    //--------------------------------------------------------------------

    protected function afterFind(array $data)
    {
        if (function_exists('c4_sms_history_afterFind'))
        {
            return c4_sms_history_afterFind($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------
}