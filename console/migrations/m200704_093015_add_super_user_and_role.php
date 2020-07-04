<?php

use yii\rbac\Role;
use cando\db\Migration;

/**
 * Class m200704_093015_add_super_user_and_role
 */
class m200704_093015_add_super_user_and_role extends Migration
{

    public $table = '{{%admin_user}}';


    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $hash = Yii::$app->helper->get('hash');
        $this->insert($this->table, [
            'id'            => 1,
            'username'      => 'admin',
            'password_hash' => $hash->generatePasswordHash('admin'),
            'nickname'      => 'admin',
            'auth_key'      => $hash->generateAuthKey(),
            'avatar'        => null,
            'is_active'     => 1,
            'created_at'    => time(),
            'updated_at'    => time(),
        ]);

        $manager = Yii::$app->authManager;
        $admin = $manager->getRole('admin');
        if(is_null($admin)) {
            $admin = new Role([
                'name' => 'admin',
                'data' => [
                    'label' => 'Admin',
                ],
            ]);
            $manager->add($admin);
        }
        $manager->assign($admin, 1);
    }



    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete($this->table, ['id' => 1]);
        $manager = Yii::$app->authManager;
        $admin = $manager->getRole('admin');
        if($admin) {
            $manager->revoke($admin, 1);
        }
    }

}
