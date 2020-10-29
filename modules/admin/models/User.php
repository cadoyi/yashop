<?php

namespace admin\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\web\IdentityInterface;
use cando\db\ActiveRecord;

/**
 * user 类
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class User extends ActiveRecord implements IdentityInterface
{

    const SUPER_ADMIN_ID = 1;

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    public $password;
    public $password_confirm;



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%admin_user}}';
    }




    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'timestamp' => [
                'class' => TimestampBehavior::class,
            ],
        ]);
    }




    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username'], 'required'],
            [['password', 'password_confirm'], 'required', 'on' => static::SCENARIO_CREATE],            
            [['is_active'], 'boolean'],
            [['username', 'nickname'], 'string', 'max' => 32],
            [['avatar'], 'string', 'max' => 255],
            [['password'], 'string', 'max' => 32],
            [['password_confirm'], 'compare', 'compareAttribute' => 'password'],
            [['username'], 'unique', 'when' => function($model, $attribute) {
                return $model->isAttributeChanged($attribute);
            }],
            [['is_active'], 'default', 'value' => static::STATUS_ACTIVE],
            [['nickname'], 'default', 'value' => function($attribute) {
                return $this->username;
            }],
        ];
    }




    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'               => Yii::t('app', 'Id'),
            'username'         => Yii::t('app', 'Username'),
            'nickname'         => Yii::t('app', 'Nickname'),
            'auth_key'         => Yii::t('app', 'Auth key'),
            'password_hash'    => Yii::t('app', 'Password hash'),
            'avatar'           => Yii::t('app', 'Avatar'),
            'is_active'        => Yii::t('app', 'Is active'),
            'last_login_at'    => Yii::t('app', 'Last login at'),
            'last_login_ip'    => Yii::t('app', 'Last login ip'),
            'created_at'       => Yii::t('app', 'Created at'),
            'updated_at'       => Yii::t('app', 'Updated at'),
            'password'         => Yii::t('app', 'Password'),
            'password_confirm' => Yii::t('app', 'Confirm password'),
        ];
    }



    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne([
            'id' => $id,
            'is_active' => static::STATUS_ACTIVE,
        ]);
    }




    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new InvalidCallException('method not allowed');
    }




    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }




    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }



    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }




    /**
     * 获取 hash helper
     * 
     * @return helper
     */
    public function getHashHelper()
    {
        return Yii::$app->helper->get('hash');
    }



    /**
     * 设置密码
     * 
     * @param string $password 
     */
    public function setPassword($password)
    {
        $this->password_hash = $this->hashHelper->generatePasswordHash($password);
    }




    /**
     * 验证密码
     * 
     * @param  string $password 密码
     * @return boolean
     */
    public function validatePassword($password)
    {
        return $this->hashHelper->validatePassword($password, $this->password_hash);
    }



    /**
     * 生成随机密码
     */
    public function generatePassword()
    {
        $this->password_hash = $this->hashHelper->generateRandomPasswordHash();
    }




    /**
     * 生成 auth_key
     */
    public function generateAuthKey()
    {
        $this->auth_key = $this->hashHelper->generateAuthKey();
    }       




    /**
     * 根据用户名查找
     * 
     * @param  string $username 用户名
     * @return static
     */
    public static function findByUsername($username)
    {
        return static::findOne([
            'username' => $username,
        ]);
    }




    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if($insert) {
            $this->generateAuthKey();
        }
        if($this->password) {
            $this->setPassword($this->password);
            $this->password = null;
            $this->password_confirm = null;
        }
        return parent::beforeSave($insert);
    }




    public function getAvatarUrl()
    {
        return null;
    }


    /**
     * 是否可删除
     */
    public function canDelete()
    {
        return $this->id != static::SUPER_ADMIN_ID;
    }


    /**
     * 记录日志.
     *
     * @param  string $description 日志描述
     * @param  array $params 翻译参数
     * @return boolean
     */
    public function log($description, $params = [])
    {
        $config = [
            'user_id'     => $this->id,
            'action'      => Yii::$app->controller->route,
            'description' => $description,
            'params'      => $params,
            'ip'          => Yii::$app->request->getUserIP(),
            'created_at'  => time(),
        ];

        $log = new Log($config);
        $result = $log->save();
        if($result === false) {
            throw new \Exception('User log cannot be saved');
        }
        return true;
    }



    /**
     * @inheritdoc
     */
    public function fields()
    {
        $fields = parent::fields();
        unset($fields['auth_key'], $fields['password_hash']);
        $fields['created_at'] = function() {
            return $this->asDatetime('created_at');
        };
        $fields['updated_at'] = function() {
            return $this->asDatetime('updated_at');
        };
        $fields['is_active'] = function() {
            return $this->isActiveText;
        };
        $fields['avatar'] = function() {
            return (string) Yii::$app->storage->getUrl($this->avatar, 36);
        };
        return $fields;
    }



    /**
     * is active 文本
     * 
     * @return string
     */
    public function getIsActiveText()
    {
        if($this->is_active) {
            return '已启用';
        }
        return '已禁用';
    }

    
}