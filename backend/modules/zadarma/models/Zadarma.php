<?php

namespace backend\modules\zadarma\models;

use Yii;

/**
 * This is the model class for table "{{%zadarma}}".
 *
 * @property int $id
 * @property string $type
 * @property int $call_start
 * @property int $answer_time
 * @property int $call_end
 * @property string $pbx_call_id
 * @property string $internal
 * @property string $destination
 * @property string $disposition
 * @property int $status_code
 * @property int $is_recorded
 * @property string $call_id_with_rec
 * @property int $duration
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
            [['call_start', 'answer_time', 'call_end', 'status_code', 'duration'], 'integer'],
            [['type'], 'string', 'max' => 10],
            [['pbx_call_id', 'internal', 'destination', 'disposition'], 'string', 'max' => 50],
            [['is_recorded'], 'string', 'max' => 1],
            [['call_id_with_rec'], 'string', 'max' => 150],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'call_start' => 'Call Start',
            'answer_time' => 'Answer Time',
            'call_end' => 'Call End',
            'pbx_call_id' => 'Pbx Call ID',
            'internal' => 'Internal',
            'destination' => 'Destination',
            'disposition' => 'Disposition',
            'status_code' => 'Status Code',
            'is_recorded' => 'Is Recorded',
            'call_id_with_rec' => 'Call Id With Rec',
            'duration' => 'Duration',
        ];
    }
}
