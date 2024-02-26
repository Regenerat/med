<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $fio
 * @property string $password
 * @property string $date_of_birth
 * @property string $tel
 * @property int $role_id
 *
 * @property Reception[] $receptions
 * @property Role $role
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fio', 'password', 'date_of_birth', 'tel', 'role_id'], 'required'],
            [['date_of_birth'], 'safe'],
            [['role_id'], 'integer'],
            [['fio'], 'string', 'max' => 511],
            [['password', 'tel'], 'string', 'max' => 255],
            [['tel'], 'unique'],
            [['tel'], 'match', 'pattern' => '/^\d{11}$/', 'message' => 'Неверный формат номера телефона'],
            [['role_id'], 'exist', 'skipOnError' => true, 'targetClass' => Role::class, 'targetAttribute' => ['role_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fio' => 'ФИО',
            'password' => 'Пароль',
            'date_of_birth' => 'Дата рождения',
            'tel' => 'Телефон',
            'role_id' => 'Role ID',
            'password_confirmation' => 'Подтвердите пароль',
        ];
    }

    /**
     * Gets query for [[Receptions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReceptions()
    {
        return $this->hasMany(Reception::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Role]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(Role::class, ['id' => 'role_id']);
    }

    /**
     * Функция поиска пользователя по логину и паролю
     * @param string $login Логин пользователя
     * @param string $password Пароль пользователя
     * @return User|null Возвращает пользователя или null, если соответствующего пользователя нет
     */
    public static function login($tel, $password) {
        $user = static::find()->where(['tel' => $tel])->one();
        if ($user && $user->validatePassword($password)) {  
            return $user;
        }
        return null;
    }

     /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return null;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }
}
