<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "reception".
 *
 * @property int $id
 * @property string $patient_fio
 * @property string $date_of_reception
 * @property string $description
 * @property int $user_id
 * @property int $status_id
 *
 * @property Status $status
 * @property User $user
 */
class Reception extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reception';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['patient_fio', 'date_of_reception', 'description', 'user_id', 'status_id'], 'required'],
            [['date_of_reception'], 'safe'],
            [['description'], 'string'],
            [['user_id', 'status_id'], 'integer'],
            [['patient_fio'], 'string', 'max' => 511],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => Status::class, 'targetAttribute' => ['status_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'patient_fio' => 'Patient Fio',
            'date_of_reception' => 'Date Of Reception',
            'description' => 'Description',
            'user_id' => 'User ID',
            'status_id' => 'Status ID',
        ];
    }

    /**
     * Gets query for [[Status]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(Status::class, ['id' => 'status_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
