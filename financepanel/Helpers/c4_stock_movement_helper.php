<?php

//--------------------------------------------------------------------
/**
 * c4_stock_movement Helper
 *
 * c4_stock_movement_beforeInsert, c4_stock_movement_afterInsert and others called from Modal  
 * Check https://codeigniter4.github.io/CodeIgniter4/models/model.html#event-parameters
 * 
 */
//--------------------------------------------------------------------

if (!function_exists('c4_stock_movement_beforeInsert'))
{

    function c4_stock_movement_beforeInsert(array $data): array
    {
        return $data;
    }

}


//--------------------------------------------------------------------
            
if (!function_exists('c4_stock_movement_afterInsert'))
{

    function c4_stock_movement_afterInsert(array $data)
    {
        $insert_id = $data['result']->connID->insert_id;
        $saved_data = $data['data'];
    }

}

//--------------------------------------------------------------------

if (!function_exists('c4_stock_movement_beforeUpdate'))
{

    function c4_stock_movement_beforeUpdate(array $data): array
    {
        return $data;
    }

}
    
//--------------------------------------------------------------------
    
if (!function_exists('c4_stock_movement_afterUpdate'))
{

    function c4_stock_movement_afterUpdate(array $data)
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
    
if (!function_exists('c4_stock_movement_beforeDelete'))
{

    function c4_stock_movement_beforeDelete(array $data): array
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
    
if (!function_exists('c4_stock_movement_afterDelete'))
{
    /**
     * afterDelete callback 
     * Usually called from C4_stock_movementModel
     * 
     * @param array $data
     */
    function c4_stock_movement_afterDelete(array $data)
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


if (!function_exists('saveC4_stock_movement'))
{

    function saveC4_stock_movement(array $data)
    {
        $C4_stock_movementModel = new \Financepanel\Models\C4_stock_movementModel();
        

        if ($C4_stock_movementModel->save($data) !== false)
        {
            if (empty($data['c4_stock_movement_id']))
            {
                return $C4_stock_movementModel->getInsertID();
            }
            else
            {
                return $data['c4_stock_movement_id'];
            }
        }

        return false;
    }
}

//--------------------------------------------------------------------
                
if (!function_exists('getAllC4_stock_movement'))
{

    function getAllC4_stock_movement($where = null, $limit=null, $orderBy = 'c4_stock_movement_id')
    {
        $C4_stock_movementModel = new \Financepanel\Models\C4_stock_movementModel();
        
        

        if (!empty($where))
        {
            if(is_array($where))
            {
              $C4_stock_movementModel->where($where);  
            }
            else
            {
              $ids = explode(',', $where);
              $C4_stock_movementModel->whereIn('c4_stock_movement_id', $ids); 
            }
        }
        
        if (!empty($limit))
        {
            $C4_stock_movementModel->limit($limit);
        }
        
        $C4_stock_movementModel->orderBy($orderBy, 'asc');

        return $C4_stock_movementModel->findAll();
    }

}

//--------------------------------------------------------------------
        
if (!function_exists('getC4_stock_movement'))
{

    function getC4_stock_movement($where = null, $order_by=null, $select='*')
    {
        $C4_stock_movementModel = new \Financepanel\Models\C4_stock_movementModel();
        
        

        if (!empty($where))
        {
            if(!is_array($where))
            {
                $where = ['c4_stock_movement_id' => $where];
            }
            
            $C4_stock_movementModel->where($where);
        }

        $C4_stock_movementModel->select($select);

        if (empty($order_by))
        {
            return $C4_stock_movementModel->first();
        }
        else
        {
            return $C4_stock_movementModel->orderBy($order_by, 'desc')->first();
        }
    }

}
//--------------------------------------------------------------------
    
if (!function_exists('getLastC4_stock_movement'))
{
    
    function getLastC4_stock_movement($where = null)
    {
        return getC4_stock_movement($where, 'c4_stock_movement_id');
    } 

}

//--------------------------------------------------------------------

if (!function_exists('updateC4_stock_movement'))
{

    function updateC4_stock_movement(array $data, $where = null)
    {

        $C4_stock_movementModel = new \Financepanel\Models\C4_stock_movementModel();

        if (!empty($where))
        {
            $C4_stock_movementModel->where($where);
        }
        

        $C4_stock_movementModel->set($data);

        return  $C4_stock_movementModel->update();

    }
}

//--------------------------------------------------------------------
  
if (!function_exists('deleteC4_stock_movement'))
{

    function deleteC4_stock_movement($where)
    {
        $C4_stock_movementModel = new \Financepanel\Models\C4_stock_movementModel();
        

        if(is_numeric($where))
        {
            return $C4_stock_movementModel->delete($where);
        }

        if(is_array($where) && count($where))
        {
            $findAll = $C4_stock_movementModel->select('c4_stock_movement_id')->where($where)->findAll();

            if (empty($findAll))
            {
                return false;
            }
            
            foreach ($findAll as $data)
            {
                $C4_stock_movementModel->delete($data['c4_stock_movement_id']);
            }
        }
    }
}
                       
//--------------------------------------------------------------------

if (!function_exists('countC4_stock_movement'))
{

    function countC4_stock_movement($where = null)
    {
        $C4_stock_movementModel = new \Financepanel\Models\C4_stock_movementModel();        
        
        

        if (!empty($where))
        {            
            $C4_stock_movementModel->where($where);
        }

        return $C4_stock_movementModel->countAllResults();
    }

}