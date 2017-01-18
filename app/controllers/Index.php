<?php
/**
 * @name IndexController
 * @author root
 * @desc 默认控制器
 * @see http://www.php.net/manual/en/class.yaf-controller-abstract.php
 */
use Yaf\Controller_Abstract;

class IndexController extends Controller_Abstract {

	/** 
     * 默认动作
     * Yaf支持直接把Yaf_Request_Abstract::getParam()得到的同名参数作为Action的形参
     * 对于如下的例子, 当访问http://yourhost/Sample/index/index/index/name/root 的时候, 你就会发现不同
     */
	public function indexAction($name = "yaf") {
		//1. fetch query
		//$get = $this->getRequest()->getQuery("get", "default value");

		//2. fetch model
		//$model = new SampleModel();

        $list = [['name'=>'zhangsan', 'age'=>18], ['name'=>'lisi', 'age'=>20]];

		$this->getView()->display("index/index", compact('list', 'name'));
        //$this->getResponse()->setHeader('Content-Type', 'application/json; charset=utf-8');
        //return $this->getResponse()->setBody(json_encode($list));

		//4. render by Yaf, 如果这里返回FALSE, Yaf将不会调用自动视图引擎Render模板
        //return TRUE;
	}

	function dbAction ()
    {
        //$user = new UserModel();

        //$list = $user->where(['user_name'=>'zhangsan'])->first()->toArray();
        $list = UserModel::find(1)->toArray();
        print_r($list);
    }
}
