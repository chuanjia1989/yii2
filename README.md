该模块，通过继承基类use yii\db\ActiveRecord来进行扩展
解决的主要问题是:如果一个表单中需要同时存储单图和多图以及更复杂的情况
那控制器中的代码就会很臃肿，该模块可以很好的解决该问题。还可以自己增加属性
进行更进一步扩展

使用方法:
以后的AR模型只需要继承该模块,然后在AR模型中这样
增加单图和多图的字段
public $singleImage = [];
public $multiImage = ['identity_card','shop_image'];

然后在beforeSave()中调用uploadImage()方法就行
这样控制中不用写一点关于图片上传的代码，充分解耦，高可用
即使面对单表中更复杂的图片提交情况也只需上面几行代码就解决

