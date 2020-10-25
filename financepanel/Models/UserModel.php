<?php

namespace Financepanel\Models;

use CodeIgniter\Model;

class UserModel extends Model
{

    //--------------------------------------------------------------------

    protected $table          = 'user';
    protected $primaryKey     = 'user_id';
    protected $useSoftDeletes = true;
    protected $allowedFields  = ["user_id","company_id","firstname","lastname","email","phone","password","avatar","identityNumber","status","created_at","updated_at","deleted_at"];
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
        
        // staticDBField
        $data['data']['company_id'] = $_SESSION['company_id'];
        
        if (function_exists('user_beforeInsert'))
        {
            return user_beforeInsert($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------

    protected function afterInsert($data)
    {
        if (function_exists('user_afterInsert'))
        {
            user_afterInsert($data);
        }
    }

    //--------------------------------------------------------------------

    protected function beforeUpdate(array $data)
    {
        
        // staticDBField
        $data['data']['company_id'] = $_SESSION['company_id'];
        $this->where('company_id', $_SESSION['company_id']);
        
        if (function_exists('user_beforeUpdate'))
        {
            return user_beforeUpdate($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------

    protected function afterUpdate(array $data)
    {
        if (function_exists('user_afterUpdate'))
        {
            user_afterUpdate($data);
        }
    }

    //--------------------------------------------------------------------

    protected function beforeDelete(array $data)
    {
        
        // staticDBField
        $this->where('company_id', $_SESSION['company_id']);
        
        if (function_exists('user_beforeDelete'))
        {
            return user_beforeDelete($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------

    protected function afterDelete(array $data)
    {
        if (function_exists('user_afterDelete'))
        {
            user_afterDelete($data);
        }
    }

    //--------------------------------------------------------------------

    protected function afterFind(array $data)
    {
        if (function_exists('user_afterFind'))
        {
            return user_afterFind($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------
}