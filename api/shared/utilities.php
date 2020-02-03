<?php
class Utilities{
    
    public function getPaging($page, $total_rows, $records_per_page, $page_url){
        
        $paging_arrayay = array();
        
        $paging_array["first"] = $page > 1 ? "{$page_url}page=1" : "";
        
        $total_pages = ceil($total_rows / $records_per_page);
        
        $range = 2;
        
        $initial_num = $page - $range;
        $condition_limit_num = ($page + $range)  + 1;
        
        $paging_array['pages'] = array();
        $page_count=0;
        
        for($x = $initial_num; $x < $condition_limit_num; $x++){
            if(($x > 0) && ($x <= $total_pages)){
                $paging_array['pages'][$page_count]["page"]=$x;
                $paging_array['pages'][$page_count]["url"]="{$page_url}page={$x}";
                $paging_array['pages'][$page_count]["current_page"] = $x==$page ? "true" : "false";
                
                $page_count++;
            }
        }
        
        $paging_array["last"] = $page < $total_pages ? "{$page_url}page={$total_pages}" : "";
        
        return $paging_array;
    }  
}
?>