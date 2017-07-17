<?php

function BBgetClassifiers(){
    return \App\Modules\Manage\Models\Classifier::all();
}

function BBgetClassifiersInList(){
    return \App\Modules\Manage\Models\Classifier::pluck('title','id')->toArray();
}

