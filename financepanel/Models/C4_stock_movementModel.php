<?php

namespace Financepanel\Models;

use CodeIgniter\Model;

class C4_stock_movementModel extends Model
{

    //--------------------------------------------------------------------

    protected $table          = 'c4_stock_movement';
    protected $primaryKey     = 'c4_stock_movement_id';
    protected $useSoftDeletes = true;
    protected $allowedFields  = ["c4_stock_movement_id","c4_shipment_document_id","product_id","date","inflow","quantity","created_at","updated_at","deleted_at"];
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
        
        if (function_exists('c4_stock_movement_beforeInsert'))
        {
            return c4_stock_movement_beforeInsert($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------

    protected function afterInsert($data)
    {
        if (function_exists('c4_stock_movement_afterInsert'))
        {
            c4_stock_movement_afterInsert($data);
        }
    }

    //--------------------------------------------------------------------

    protected function beforeUpdate(array $data)
    {
        
        if (function_exists('c4_stock_movement_beforeUpdate'))
        {
            return c4_stock_movement_beforeUpdate($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------

    protected function afterUpdate(array $data)
    {
        if (function_exists('c4_stock_movement_afterUpdate'))
        {
            c4_stock_movement_afterUpdate($data);
        }
    }

    //--------------------------------------------------------------------

    protected function beforeDelete(array $data)
    {
        
        if (function_exists('c4_stock_movement_beforeDelete'))
        {
            return c4_stock_movement_beforeDelete($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------

    protected function afterDelete(array $data)
    {
        if (function_exists('c4_stock_movement_afterDelete'))
        {
            c4_stock_movement_afterDelete($data);
        }
    }

    //--------------------------------------------------------------------

    protected function afterFind(array $data)
    {
        if (function_exists('c4_stock_movement_afterFind'))
        {
            return c4_stock_movement_afterFind($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------
}