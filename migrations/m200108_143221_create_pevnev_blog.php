<?php

use yii\db\Schema;

class m200108_143221_create_pevnev_blog extends yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{pevnev_blog}}', [
            'id' => $this->primaryKey()->notNull(),
            'is_active' => $this->getDb()->getSchema()->createColumnSchemaBuilder('TINYINT(1)')->defaultValue('0')->notNull(),
            'url' => $this->string(255),
            'blog_group_id' => $this->integer()->defaultValue('0')->notNull(),
            'is_group_active' => $this->integer(10)->defaultValue('0')->notNull(),
            'name' => $this->string(255),
            'views' => $this->integer(10)->defaultValue('0')->notNull(),
            'text_announcement' => $this->getDb()->getSchema()->createColumnSchemaBuilder('TEXT'),
            'text' => $this->getDb()->getSchema()->createColumnSchemaBuilder('TEXT'),
            'image' => $this->string(255),
            'meta_title' => $this->string(255),
            'meta_description' => $this->string(255),
            'meta_keywords' => $this->string(255),
            'timestamp' => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'timestamp_update' => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'timestamp_start' => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP',
        ]);

        $this->createIndex('url', '{{pevnev_blog}}', 'url', false);
        $this->createIndex('timestamp_start', '{{pevnev_blog}}', 'timestamp_start', false);
        $this->createIndex('is_active', '{{pevnev_blog}}', 'is_active', false);
        $this->createIndex('views', '{{pevnev_blog}}', 'views', false);
        $this->createIndex('is_group_active', '{{pevnev_blog}}', 'is_group_active', false);
		
		$textAnnouncementDemo = 'Potcany v trenikakh sidya na kortakh v padike Uralmasha reshaut voprosy';
		$textDemo = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.';
		
        Yii::$app->db->createCommand()->batchInsert('pevnev_blog', [
		'name',
		'blog_group_id',
		'is_group_active',
		'is_active',
		'url',
		'text_announcement',
		'text',
		'meta_title'
		], [
            ['Demo post 1', 1, 1, 1, 'demo-post-1', $textAnnouncementDemo, $textDemo, $textAnnouncementDemo],
            ['Demo post 2', 1, 1, 1, 'demo-post-2', $textAnnouncementDemo, $textDemo, $textAnnouncementDemo],
            ['Demo post 3', 1, 1, 1, 'demo-post-3', $textAnnouncementDemo, $textDemo, $textAnnouncementDemo],
            ['Demo post 4', 1, 1, 1, 'demo-post-4', $textAnnouncementDemo, $textDemo, $textAnnouncementDemo],
            ['Demo post 5', 1, 1, 1, 'demo-post-5', $textAnnouncementDemo, $textDemo, $textAnnouncementDemo],
            ['Demo post 6', 2, 1, 1, 'demo-post-6', $textAnnouncementDemo, $textDemo, $textAnnouncementDemo],
            ['Demo post 7', 2, 1, 1, 'demo-post-7', $textAnnouncementDemo, $textDemo, $textAnnouncementDemo],
            ['Demo post 8', 2, 1, 1, 'demo-post-8', $textAnnouncementDemo, $textDemo, $textAnnouncementDemo],			
			['Demo post 9', 3, 1, 1, 'demo-post-9', $textAnnouncementDemo, $textDemo, $textAnnouncementDemo],
            ['Demo post 10', 3, 1, 1, 'demo-post-10', $textAnnouncementDemo, $textDemo, $textAnnouncementDemo],
            ['Demo post 11', 3, 1, 1, 'demo-post-11', $textAnnouncementDemo, $textDemo, $textAnnouncementDemo],
            ['Demo post 12', 3, 1, 1, 'demo-post-12', $textAnnouncementDemo, $textDemo, $textAnnouncementDemo],
        ])->execute();
    }

    public function down()
    {
        $this->execute('SET FOREIGN_KEY_CHECKS = 0');
        $this->dropTable('{{pevnev_blog}}');
        $this->execute('SET FOREIGN_KEY_CHECKS = 1');
    }
}
