<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%order}}".
 *
 * @property int $id
 * @property string|null $created_at
 * @property string|null $hired_at
 * @property string|null $closed_at
 * @property int $equipment_id
 * @property int $client_id
 * @property int $manager_id
 * @property int|null $master
 * @property int|null $status
 * @property int|null $placement
 * @property string|null $problems
 * @property string|null $complect
 * @property float|null $prepayment
 * @property float|null $cost
 * @property string|null $comment
 *
 * @property Client $client
 * @property Equipment $equipment
 * @property User $manager
 */
class Order extends \yii\db\ActiveRecord
{

    const PLACEMENT_OFFICE = 1;
    const PLACEMENT_CLIENT = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%order}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'hired_at', 'closed_at'], 'safe'],
            [['equipment_id', 'client_id', 'manager_id'], 'required'],
            [['equipment_id', 'client_id', 'manager_id', 'master', 'status', 'placement'], 'integer'],
            [['problems', 'comment'], 'string'],
            [['prepayment', 'cost'], 'number'],
            [['complect'], 'string', 'max' => 255],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Client::className(), 'targetAttribute' => ['client_id' => 'id']],
            [['equipment_id'], 'exist', 'skipOnError' => true, 'targetClass' => Equipment::className(), 'targetAttribute' => ['equipment_id' => 'id']],
            [['manager_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['manager_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Created At',
            'hired_at' => 'Hired At',
            'closed_at' => 'Closed At',
            'equipment_id' => 'Equipment ID',
            'client_id' => 'Client ID',
            'manager_id' => 'Manager ID',
            'master' => 'Master',
            'status' => 'Status',
            'placement' => 'Placement',
            'problems' => 'Problems',
            'complect' => 'Complect',
            'prepayment' => 'Prepayment',
            'cost' => 'Cost',
            'comment' => 'Comment',
        ];
    }

    /**
     * Gets query for [[Client]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Client::className(), ['id' => 'client_id']);
    }

    /**
     * Gets query for [[Equipment]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEquipment()
    {
        return $this->hasOne(Equipment::className(), ['id' => 'equipment_id']);
    }

    /**
     * Gets query for [[Manager]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getManager()
    {
        return $this->hasOne(User::className(), ['id' => 'manager_id']);
    }

    public static function listPlacement()
    {
        return [
            self::PLACEMENT_OFFICE => 'В офисе',
            self::PLACEMENT_CLIENT => 'У клиента'
        ];
    }

}