��ģ�飬ͨ���̳л���use yii\db\ActiveRecord��������չ
�������Ҫ������:���һ����������Ҫͬʱ�洢��ͼ�Ͷ�ͼ�Լ������ӵ����
�ǿ������еĴ���ͻ��ӷ�ף���ģ����ԺܺõĽ�������⡣�������Լ���������
���и���һ����չ

ʹ�÷���:
�Ժ��ARģ��ֻ��Ҫ�̳и�ģ��,Ȼ����ARģ��������
���ӵ�ͼ�Ͷ�ͼ���ֶ�
public $singleImage = [];
public $multiImage = ['identity_card','shop_image'];

Ȼ����beforeSave()�е���uploadImage()��������
���������в���дһ�����ͼƬ�ϴ��Ĵ��룬��ֽ���߿���
��ʹ��Ե����и����ӵ�ͼƬ�ύ���Ҳֻ�����漸�д���ͽ��
