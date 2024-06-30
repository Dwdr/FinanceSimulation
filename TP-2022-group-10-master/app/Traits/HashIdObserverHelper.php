<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;
use Vinkla\Hashids\Facades\Hashids;

trait HashIdObserverHelper {

    protected static function bootHashIdObserverHelper(){
        self::created(function($model){
//            Log::info($model->id);
            $model->update([
                'hash_id' => Hashids::encode($model->id)
            ]);
        });
    }

}
