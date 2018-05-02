<?php

namespace backend\modules\zadarma\models;

use Yii;

/**
 * This is the model class for table "{{%zadarma}}".
 *
 * @property int $id
 * @property string $event
 * @property int $duration
 * @property int $caller_id
 * @property int $called_did
 * @property string $call_start
 * @property string $pbx_call_id
 * @property int $internal
 * @property string $destination
 * @property string $disposition
 * @property int $status_code
 * @property boolean $is_recorded
 * 
 */
class Zadarma extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%zadarma}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['caller_id', 'called_did', 'internal', 'duration', 'status_code'], 'integer'],
            [['call_start', 'event', 'destination'], 'string', 'max' => 20],
            [['disposition'], 'string', 'max' => 30],
            [['pbx_call_id'], 'string', 'max' => 50],
            [['is_recorded'], 'boolean']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'event' => 'Event',
            'duration' => 'Duration',
            'caller_id' => 'Caller ID',
            'called_did' => 'Called Did',
            'call_start' => 'Call Start',
            'pbx_call_id' => 'Pbx Call ID',
            'internal' => 'Internal',
            'destination' => 'Destination',
            'disposition' => 'Disposition',
            'status_code' => 'Status Code',
            'is_recorded' => 'Is recorded'
        ];
    }
}
