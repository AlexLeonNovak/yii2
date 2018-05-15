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
 * @property string $caller_id
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
            [['pbx_call_id', 'internal', 'destination', 'disposition', 'caller_id'], 'string', 'max' => 50],
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
            'type' => 'Тип звонка',
            'call_start' => 'Соединение',
            'answer_time' => 'Начало разговора',
            'call_end' => 'Конец разговора',
            'pbx_call_id' => 'Pbx Call ID',
            'internal' => 'Внутренний номер',
            'destination' => 'Кому звонили',
            'caller_id' => 'Кто звонил', //при входящем звонке
            'disposition' => 'Состояние',
            'status_code' => 'Status Code',
            'is_recorded' => 'Is Recorded',
            'call_id_with_rec' => 'Call Id With Rec',
            'duration' => 'Длительность',
        ];
    }
}
