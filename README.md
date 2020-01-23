# yii2-pevnev-domain-helper
<p>
<h2>Install</h2>
<b>composer require "wolverineo250kr/yii2-pevnev-blog":"*"</b>
<br/>
<br/>
main.php
<br/>
<br/>
return [<br/>...<br/> 
    'bootstrap' => ['log', 'assetsAutoCompress', 'blog'],<br/>
	    'modules' => [<br/>
        'blog' => [<br/>
                    'class' => 'wolverineo250kr\blog\modules\frontend\Module',<br/>
        ],<br/>
		],<br/>