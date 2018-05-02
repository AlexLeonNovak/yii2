<?php

namespace backend\modules\zadarma\models;

use Yii;

/**
 * This is the model class for table "zadarma".
 *
 * @property int $id
 * @property int $caller_id
 * @property int $called_did
 * @property int $call_start
 * @property int $pbx_call_id
 * @property int $internal
 * @property int $destination
 */
class Zadarma extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zadarma';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['caller_id', 'called_did', 'call_start', 'pbx_call_id', 'internal', 'destination'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'caller_id' => 'Caller ID',
            'called_did' => 'Called Did',
            'call_start' => 'Call Start',
            'pbx_call_id' => 'Pbx Call ID',
            'internal' => 'Internal',
            'destination' => 'Destination',
        ];
    }
}
