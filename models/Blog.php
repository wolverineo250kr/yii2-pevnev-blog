<?

namespace wolverineo250kr\blog\models;
  
use Yii;
use yii\db\ActiveRecord; 
use yii\web\UploadedFile;
use wolverineo250kr\helpers\DomainHelper; 
use wolverineo250kr\helpers\text\TextHelper;
use wolverineo250kr\blog\models\BlogGroup;

/**
 * News model
 *
 * @property integer $id
 * methods
 */
class Blog extends ActiveRecord
{
    const ACTIVE   = 1;
    const DISABLED = 0;

    public $_imagesPath = '/text/news/';
    public $imageFile;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{pevnev_blog}}';
    }

    public function rules()
    {
        return [
            [['id', 'blog_group_id', 'views','is_group_active'], 'integer'],
            [['name', 'url', 'meta_title', 'meta_keywords', 'meta_description', 'image'], 'trim'],
            [['name', 'blog_group_id','timestamp_start', 'text', 'text_announcement'], 'required'],
            [['name', 'url', 'image'], 'string', 'min' => 1, 'max' => 255],
            [['meta_title', 'meta_keywords', 'meta_description'], 'string', 'min' => 0, 'max' => 255],
            [['is_active'], 'default', 'value' => self::DISABLED],
            [['is_active'], 'in', 'range' => [self::ACTIVE, self::DISABLED]],
            [['timestamp', 'timestamp_update', 'timestamp_start'], 'date', 'format' => 'php:Y-m-d H:i:s'],
            [['text', 'text_announcement'], 'string'],
            [['imageFile'], 'file', 'extensions' => 'jpg, png', 'maxSize' => 4194304, 'tooBig' => 'Максимальный размер изображения 4МБ']
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'image' => 'Изображение',
            'name' => 'Название',
            'url' => 'Ссылка(заполнится автоматически)',
            'is_active' => 'Активность',
            'text_announcement' => 'Текст анонса',
            'text' => 'Содержание',
            'views' => 'Просмотры',
            'is_group_active' => 'Группа активна',
            'meta_title' => 'Заголовок SEO',
            'meta_description' => 'meta description',
            'meta_keywords' => 'meta keywords',
            'timestamp' => 'Дата создания',
            'blog_group_id' => 'id  рублики',
            'timestamp_update' => 'Дата обновления',
            'timestamp_start' => 'Дата начала показа',
            'imageFile' => 'Изображение',
        ];
    }
    
    
    public function countReadTime(string $content){
              // очищаем содержимое от тегов
    // подсчитываем количество слов
    $word_count = $this->strWordCountUtf8(strip_tags($content));
    
    // 200 - средняя скорость чтения слов в минуту
    $words_per_minute = 200;
    
    // время чтения статьи в минутах
    $minutes = floor($word_count / $words_per_minute);
    
    $seconds = floor($word_count % $words_per_minute / ($words_per_minute / 60));

    $str_minutes = ($minutes == 1) ? "мин." : "мин.";
    $str_seconds = ($seconds == 1) ? "сек." : "сек.";

    if ($minutes == 0) {
        return "{$seconds} {$str_seconds}";
    }
    else {
        return "{$minutes} {$str_minutes}, {$seconds} {$str_seconds}";
    }
    } 
    
    public function strWordCountUtf8($str) {
    $a = preg_split('/\W+/u', $str, -1, PREG_SPLIT_NO_EMPTY);
    return count($a);
}

    public function getDirPath(bool $withWebroot = false)
    {
        if ($withWebroot) {
		$file = Yii::getAlias('@webroot').Yii::$app->params["imageDir"].'/dynamic'.$this->_imagesPath.$this->id;
		       $file = str_replace('backend', 'frontend', $file);	// При отсутвии возможности использовать симлинки на сервере.
            return $file;
        }
		
		$file =  Yii::$app->params["imageDir"].'/dynamic'.$this->_imagesPath.$this->id;
		       $file = str_replace('backend', 'frontend', $file);	// При отсутвии возможности использовать симлинки на сервере.
            return $file;
			 
    }

    public function getImagePath(bool $withWebroot = false)
    {
        if ($withWebroot) {
            return $this->getDirPath($withWebroot).'/'.$this->image;
        }
 
        return $this->getDirPath($withWebroot).'/'.$this->image;
    }

    public function getSrc($getNoImage = true)
    {
        if ($this->image && file_exists($this->getImagePath(true))) {

            return $this->getImagePath(false);
        }

        if ($getNoImage) {
            return "data:image/png;base64,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";
        }
        return null;
    }

    public function getBlogGroup()
    {
        return $this->hasOne(BlogGroup::className(), ['id' => 'blog_group_id']);
    }

    /**
     * to console sitemap path
     */
    public function getPath()
    {
        return '/news/'.$this->url;
    }

    private function delImage()
    {
        if (mb_strlen($this->image) > 0) {
            $path  = $this->getDirPath(true);
            $thumb = $path.'/'.$this->image;
            if (file_exists($thumb)) {
                unlink($thumb);
            }
            $originalFileName = explode('-thumb.', $this->image);
            if (isset($originalFileName[0]) && isset($originalFileName[1])) {
                $original = $path.'/'.$originalFileName[0].'.'.$originalFileName[1];
                if (file_exists($original)) {
                    unlink($original);
                }
            }
        }
    }

    private function upload()
    {
        if ($this->imageFile) {
            $this->delImage();
            if ($this->validate()) {
                $modelName = md5($this->imageFile->baseName.time());
                $path      = $this->getDirPath(true).'/';
                if (!file_exists($path)) {
                    mkdir($path, 0755, true);
                }
                $this->imageFile->saveAs($path.$modelName.'.'.$this->imageFile->extension);
                $file        = $path.$modelName.'.'.$this->imageFile->extension;
                $this->image = $modelName.'.'.$this->imageFile->extension;
 
            }
        }
    }

    public function beforeDelete()
    {
        \yii\helpers\FileHelper::removeDirectory($this->getDirPath(true));
        return parent::beforeDelete();
    }

    public function beforeSave($insert)
    {
        $this->imageFile = UploadedFile::getInstance($this, 'imageFile');
        $this->upload();

        if (!$this->meta_description) {
            $this->meta_description = TextHelper::cut($this->name, 150);
        }

        if (mb_strlen($this->url) < 4) {
            $this->url = TextHelper::slug($this->name, '-');
        }
       
        return parent::beforeSave($insert);
    }
}