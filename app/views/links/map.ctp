<?php


        $default = array('type'=>'0','zoom'=>13,'lat'=>$data[0]['Point']['latitude'],'long'=> $data[0]['Point']['longitude']);

        $points = $data;

        $cord = array(array('lat' => 59.492268,'long' => 18.265779), array('lat' => 59.480499,'long' => 18.257376));


        $key = $this->GoogleMap->key;

        echo $javascript->link($this->GoogleMap->url);

        echo $this->GoogleMap->map($default,'width: 1000px; height: 600px');

        echo $this->GoogleMap->addMarkers($points);

        echo $this->GoogleMap->moveMarkerOnClick('StructureLongitudine','StructureLatitudine');

        echo $this->GoogleMap->drawLine($cord);

?>