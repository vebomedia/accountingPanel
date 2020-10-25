<?php

//--------------------------------------------------------------------
/**
 * c4_shipment_document Helper
 *
 * c4_shipment_document_beforeInsert, c4_shipment_document_afterInsert and others called from Modal  
 * Check https://codeigniter4.github.io/CodeIgniter4/models/model.html#event-parameters
 * 
 */
//--------------------------------------------------------------------

if (!function_exists('c4_shipment_document_beforeInsert'))
{

    function c4_shipment_document_beforeInsert(array $data): array
    {
        return $data;
    }

}


//--------------------------------------------------------------------
            
if (!function_exists('c4_shipment_document_afterInsert'))
{

    function c4_shipment_document_afterInsert(array $data)
    {
        $insert_id = $data['result']->connID->insert_id;
        $saved_data = $data['data'];
    }

}

//--------------------------------------------------------------------

if (!function_exists('c4_shipment_document_beforeUpdate'))
{

    function c4_shipment_document_beforeUpdate(array $data): array
    {
        return $data;
    }

}
    
//--------------------------------------------------------------------
    
if (!function_exists('c4_shipment_document_afterUpdate'))
{

    function c4_shipment_document_afterUpdate(array $data)
    {
        $ids   = $data['id'];
        $updatedData = $data['data'];

        if (empty($ids))
        {
            return $data;
        }

    }
}

//--------------------------------------------------------------------
    
if (!function_exists('c4_shipment_document_beforeDelete'))
{

    function c4_shipment_document_beforeDelete(array $data): array
    {
    
        $ids   = $data['id'];
        $purge = $data['purge'];

        if (empty($ids))
        {
            return $data;
        }
            
        return $data;
    }
}

//--------------------------------------------------------------------
    
if (!function_exists('c4_shipment_document_afterDelete'))
{
    /**
     * afterDelete callback 
     * Usually called from C4_shipment_documentModel
     * 
     * @param array $data
     */
    function c4_shipment_document_afterDelete(array $data)
    {
        $ids   = $data['id'];
        $purge = $data['purge'];
    
        if (empty($ids))
        {
            return $data;
        }
    }

}

//--------------------------------------------------------------------


if (!function_exists('saveC4_shipment_document'))
{

    function saveC4_shipment_document(array $data)
    {
        $C4_shipment_documentModel = new \Financepanel\Models\C4_shipment_documentModel();
        

        if ($C4_shipment_documentModel->save($data) !== false)
        {
            if (empty($data['c4_shipment_document_id']))
            {
                return $C4_shipment_documentModel->getInsertID();
            }
            else
            {
                return $data['c4_shipment_document_id'];
            }
        }

        return false;
    }
}

//--------------------------------------------------------------------
                
if (!function_exists('getAllC4_shipment_document'))
{

    function getAllC4_shipment_document($where = null, $limit=null, $orderBy = 'c4_shipment_document_id')
    {
        $C4_shipment_documentModel = new \Financepanel\Models\C4_shipment_documentModel();
        
        

        if (!empty($where))
        {
            if(is_array($where))
            {
              $C4_shipment_documentModel->where($where);  
            }
            else
            {
              $ids = explode(',', $where);
              $C4_shipment_documentModel->whereIn('c4_shipment_document_id', $ids); 
            }
        }
        
        if (!empty($limit))
        {
            $C4_shipment_documentModel->limit($limit);
        }
        
        $C4_shipment_documentModel->orderBy($orderBy, 'asc');

        return $C4_shipment_documentModel->findAll();
    }

}

//--------------------------------------------------------------------
        
if (!function_exists('getC4_shipment_document'))
{

    function getC4_shipment_document($where = null, $order_by=null, $select='*')
    {
        $C4_shipment_documentModel = new \Financepanel\Models\C4_shipment_documentModel();
        
        

        if (!empty($where))
        {
            if(!is_array($where))
            {
                $where = ['c4_shipment_document_id' => $where];
            }
            
            $C4_shipment_documentModel->where($where);
        }

        $C4_shipment_documentModel->select($select);

        if (empty($order_by))
        {
            return $C4_shipment_documentModel->first();
        }
        else
        {
            return $C4_shipment_documentModel->orderBy($order_by, 'desc')->first();
        }
    }

}
//--------------------------------------------------------------------
    
if (!function_exists('getLastC4_shipment_document'))
{
    
    function getLastC4_shipment_document($where = null)
    {
        return getC4_shipment_document($where, 'c4_shipment_document_id');
    } 

}

//--------------------------------------------------------------------

if (!function_exists('updateC4_shipment_document'))
{

    function updateC4_shipment_document(array $data, $where = null)
    {

        $C4_shipment_documentModel = new \Financepanel\Models\C4_shipment_documentModel();

        if (!empty($where))
        {
            $C4_shipment_documentModel->where($where);
        }
        

        $C4_shipment_documentModel->set($data);

        return  $C4_shipment_documentModel->update();

    }
}

//--------------------------------------------------------------------
  
if (!function_exists('deleteC4_shipment_document'))
{

    function deleteC4_shipment_document($where)
    {
        $C4_shipment_documentModel = new \Financepanel\Models\C4_shipment_documentModel();
        

        if(is_numeric($where))
        {
            return $C4_shipment_documentModel->delete($where);
        }

        if(is_array($where) && count($where))
        {
            $findAll = $C4_shipment_documentModel->select('c4_shipment_document_id')->where($where)->findAll();

            if (empty($findAll))
            {
                return false;
            }
            
            foreach ($findAll as $data)
            {
                $C4_shipment_documentModel->delete($data['c4_shipment_document_id']);
            }
        }
    }
}
                       
//--------------------------------------------------------------------

if (!function_exists('countC4_shipment_document'))
{

    function countC4_shipment_document($where = null)
    {
        $C4_shipment_documentModel = new \Financepanel\Models\C4_shipment_documentModel();        
        
        

        if (!empty($where))
        {            
            $C4_shipment_documentModel->where($where);
        }

        return $C4_shipment_documentModel->countAllResults();
    }

}