<?php
    function pusat_url($url="") {
        return "https://taspenpusat.gadaihartadinataabadi.com/$url";
    }
    function images_url($path){
        if(!is_file($path)){
            return base_url('storage/images/default/noimage.jpg');
        }
        return base_url($path);
    }
    function avatar_url($path){
        if(!is_file($path)){
            return base_url('storage/images/default/avatar.png');
        }
        return base_url($path);
    }

    function read_access($segment)
    {
        // if($privileges = session('privileges')){
        //     foreach($privileges as $privilege){
        //         if($privilege->url === $segment){
        //             if($privilege->access === 'DENIED'){
        //                 return false;
        //             }
        //         }
        //     }
        // }
        return true;
    }

    function write_access($segment)
    {
        if($privileges = session('privileges')){
            // foreach($privileges as $privilege){
            //     if($privilege->url === $segment){
            //         if($privilege->access !== 'WRITE'){
            //             return false;
            //         }
            //     }
            // }           
        }
        return true;
    }