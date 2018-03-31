<?php

namespace frontend\modules\testusers;

use yii\web\AssetBundle;

/**
 * Description of TestAssets
 *
 * @author novak-ol
 */
class TestAsset extends AssetBundle {
    
    public $sourcePath = '@app/modules/testusers/assets/';
    public $js = [
        'common.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
