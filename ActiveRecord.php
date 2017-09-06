<?php
/**
 * Class ActiveRecord
 * @package common\components
 * created by yancheng
 * created at 2017/7/8
 * 注释:该模块主要为了剥离控制中对图片的处理，比如一个表同时涉及到单图以及多图上传
 * 这个时候全部放在控制中处理，会比较臃肿，可读性也较差
 * 该模块就能很好的解决该问题，我们只需要在model中增加图片上传的字段，然后beforeSave中调用对应方法就行
 */
namespace common\components;
use Yii;
use yii\helpers\FileHelper;
use yii\validators\ImageValidator;
use yii\db\ActiveRecord as BaseActiveRecord;
use yii\web\UploadedFile;


class ActiveRecord extends BaseActiveRecord
{
    public $singleImage = [];//单图片
    public $multiImage = [];//多图片
    public $extensions = ['jpg', 'png', 'jpeg', 'gif'];//图片扩展
    public $dir = [];
    //上传图片
    public function uploadImage()
    {

        $validator = new ImageValidator([ 'extensions' => $this->extensions]);

        //单图片上传
        if($this->singleImage){
            foreach($this->singleImage as $one){
                $file = UploadedFile::getInstance($this,$one);
                if($file != null){
                    if($validator->validate($file)){
                        $this->$one = $this->createImage($file,$one);
                    }else
                        $this->addError($one, '请上传以'.implode(',',$this->extensions).'结尾的图片');
                }
            }
        }

        //处理多图片上传
        if($this->multiImage){
            foreach($this->multiImage as $one){
                $arr = [];
                $mulFile = UploadedFile::getInstances($this,$one);
                if($mulFile != null){
                    $error = 0;
                    foreach($mulFile as $obj){
                        if($validator->validate($obj)){
                           $arr[] = $this->createImage($obj,$one);
                        }else{
                            $error +=1 ;
                        }
                    }
                    if($error){
                         $this->addError($one, '请上传以'.implode(',',$this->extensions).'结尾的图片');
                    }
                    $this->$one = implode(',',$arr);
                }
            }
        }
    }

    private function createImage($obj,$attribute)
    {
        $className = explode('\\', get_class($this));
        $className = array_pop($className);

        $filename = time () . rand ( 1000, 9999 ) . '.' . $obj->getExtension();
        $dir = '/upload/'.strtolower($className).'/'.$attribute.'/'.date('Ym').'/';
        if(!file_exists(Yii::getAlias('@webroot').$dir))
            FileHelper::createDirectory(Yii::getAlias('@webroot').$dir);

        $filepath = '@webroot' . $dir . $filename;
        $filepath = Yii::getAlias($filepath);
        if ($obj->saveAs ( $filepath )) {
            return   $dir . $filename;
        }
    }

    public function getErs()
    {
        $ers = [];
        foreach($this->errors as $val)
        {
            $ers[] = implode(',', $val);
        }
        return $ers;
    }
}


