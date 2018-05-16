<?php

namespace backend\modules\users;

use yii\web\AssetBundle;

/**
 * Description of ZadarmaAsset
 *
 * @author novak-ol
 */
class UsersAsset extends AssetBundle {
    
    public $sourcePath = '@app/modules/users/assets/';
    public $js = [
        'common.js',
    ];
    public $css = [
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\jui\JuiAsset',
    ];
}