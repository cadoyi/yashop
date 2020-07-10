<?php

namespace admin\backend\models\user;

use Yii;
use admin\models\User;

/**
 * 编辑用户
 *
 * @author  zhangyang <znangyangcado@qq.com>
 */
class Edit extends User
{

    public $admin_password;

    public $role;

    public $avatar_input;
    public $avatar_delete;



    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge([
            [['admin_password'], 'required'],
            [['admin_password'], 'validateCurrentPassword'],
            [['role'], 'required'],
            [['role'], 'string'],
            [['role'], function($attribute) {
                $authManager = Yii::$app->authManager;
                $role = $authManager->getRole($this->$attribute);
                if(!$role) {
                   $this->addError($attribute, Yii::t('app', 'Role not exist'));
                }
            }],
            [['avatar_input'], 'image', 'extensions' => ['jpg', 'jpeg', 'png']],
            [['avatar_delete'], 'boolean'],
            [['avatar_delete'], 'default', 'value' => 0],
        ], parent::rules());
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'admin_password'    => Yii::t('app', 'Current user\'s password'),
            'role'              => Yii::t('app', 'Role'),
            'avatar'            => Yii::t('app', 'Avatar'),
        ]);
    }


    /**
     * 验证当前用户的密码
     * 
     * @param  string $attribute 属性名
     */
    public function validateCurrentPassword($attribute)
    {
        $user = Yii::$app->user->identity;
        if(!$user || !$user->validatePassword($this->$attribute)) {
            $this->addError($attribute, Yii::t('app', '{attribute} incorrent', [
                'attribute' => $this->getAttributeLabel($attribute),
            ]));            
        }
    }    



    /**
     * 保存用户和角色
     * 
     * @return boolean
     */
    public function saveUser()
    {
        if(!$this->validate()) {
            return false;
        }
        $trans = static::getDb()->beginTransaction();
        try {
            if(false === $this->save()) {
                throw new \Exception('User cannot be saved');
            }
            $this->saveRole();
            $trans->commit();
        } catch(\Throwable $e) {
            $trans->rollBack();
            throw $e;
        }
        return true;
    }



    /**
     * 保存角色
     */
    public function saveRole()
    {
        $manager = Yii::$app->authManager;
        $role = $manager->getRole($this->role);
        $manager->revokeAll($this->id);
        $manager->assign($role, $this->id);
    }



}