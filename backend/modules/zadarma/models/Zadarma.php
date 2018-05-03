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
            'event' => 'Событие',
            'duration' => 'Длительность',
            'caller_id' => 'Внутренний номер (кто)',
            'called_did' => 'Внутренний номер (кому)',
            'call_start' => 'Начало звонка',
            'pbx_call_id' => 'ID звонка',
            'internal' => 'Внутренний номер (опциональный)',
            'destination' => 'Куда звонили',
            'disposition' => 'Состояние',
            /*
             * 'answered' – разговор,
             * 'busy' – занято,
             * 'cancel' - отменен,
             * 'no answer' - без ответа,
             * 'failed' - не удался,
             * 'no money' - нет средств, превышен лимит,
             * 'unallocated number' - номер не существует,
             * 'no limit' - превышен лимит,
             * 'no day limit' - превышен дневной лимит,
             * 'line limit' - превышен лимит линий,
             * 'no money, no limit' - превышен лимит;
             */
            'status_code' => 'Q.931',
            'is_recorded' => '1 - есть запись звонка, 0 - нет записи'
        ];
    }
}
