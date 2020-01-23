<?php

namespace wolverineo250kr\modules\blog\models\form;

use wolverineo250kr\modules\blog\models\Blog;

/**
 * Blog form
 */
class BlogForm extends Blog {

	/**
	 * @inheritdoc
	 */

	public function rules() {
		$parentRules = parent::rules();
		return $parentRules;
	}

	public function attributeLabels() {
		$parentlabels = parent::attributeLabels();
		return $parentlabels;
	}

}
