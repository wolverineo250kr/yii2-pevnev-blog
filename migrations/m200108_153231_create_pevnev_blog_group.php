<?php

use yii\db\Schema;

class m200108_153231_create_pevnev_blog_group extends yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{pevnev_blog_group}}', [
            'id' => $this->primaryKey()->notNull(),
            'name' => $this->string(1255),
            'is_active' => $this->getDb()->getSchema()->createColumnSchemaBuilder('TINYINT(1) UNSIGNED')->defaultValue('0')->notNull(),
        ]); 
		
				$this->insert('pevnev_blog_group', [
            'name' => 'Demo category 1',
            'is_active' => 1,
        ]);
		
						$this->insert('pevnev_blog_group', [
            'name' => 'Demo category 2',
            'is_active' => 1,
        ]);
		
								$this->insert('pevnev_blog_group', [
            'name' => 'Demo category 3',
            'is_active' => 1,
        ]);
		
        $this->createIndex('is_active', '{{pevnev_blog_group}}', 'is_active', false);
    }

    public function down()
    {
        $this->execute('SET FOREIGN_KEY_CHECKS = 0');
        $this->dropTable('{{pevnev_blog_group}}');
        $this->execute('SET FOREIGN_KEY_CHECKS = 1');
    }
}
