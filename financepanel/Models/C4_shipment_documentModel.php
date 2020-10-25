<?php

namespace Financepanel\Models;

use CodeIgniter\Model;

class C4_shipment_documentModel extends Model
{

    //--------------------------------------------------------------------

    protected $table          = 'c4_shipment_document';
    protected $primaryKey     = 'c4_shipment_document_id';
    protected $useSoftDeletes = true;
    protected $allowedFields  = ["c4_shipment_document_id","description","address","inflow","issue_date","shipment_date","procurement_number","created_at","updated_at","deleted_at"];
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
        
        if (function_exists('c4_shipment_document_beforeInsert'))
        {
            return c4_shipment_document_beforeInsert($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------

    protected function afterInsert($data)
    {
        if (function_exists('c4_shipment_document_afterInsert'))
        {
            c4_shipment_document_afterInsert($data);
        }
    }

    //--------------------------------------------------------------------

    protected function beforeUpdate(array $data)
    {
        
        if (function_exists('c4_shipment_document_beforeUpdate'))
        {
            return c4_shipment_document_beforeUpdate($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------

    protected function afterUpdate(array $data)
    {
        if (function_exists('c4_shipment_document_afterUpdate'))
        {
            c4_shipment_document_afterUpdate($data);
        }
    }

    //--------------------------------------------------------------------

    protected function beforeDelete(array $data)
    {
        
        if (function_exists('c4_shipment_document_beforeDelete'))
        {
            return c4_shipment_document_beforeDelete($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------

    protected function afterDelete(array $data)
    {
        if (function_exists('c4_shipment_document_afterDelete'))
        {
            c4_shipment_document_afterDelete($data);
        }
    }

    //--------------------------------------------------------------------

    protected function afterFind(array $data)
    {
        if (function_exists('c4_shipment_document_afterFind'))
        {
            return c4_shipment_document_afterFind($data);
        }

        return $data;
    }

    //--------------------------------------------------------------------
}