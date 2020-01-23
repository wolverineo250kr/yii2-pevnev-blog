<?php

namespace wolverineo250kr\modules\blog\models\form;

use wolverineo250kr\modules\blog\models\BlogGroup;

/**
 * Blog form
 */
class BlogGroupForm extends BlogGroup {

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
