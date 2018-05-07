<?php

namespace backend\modules\zadarma;

use yii\web\AssetBundle;

/**
 * Description of ZadarmaAsset
 *
 * @author novak-ol
 */
class ZadarmaAsset extends AssetBundle {
    
    public $sourcePath = '@app/modules/zadarma/assets/';
    public $js = [
        'clipboard.min.js',
    ];
    public $css = [
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
