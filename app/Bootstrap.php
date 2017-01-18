<?php
/**
 * @name Bootstrap
 * @author root
 * @desc 所有在Bootstrap类中, 以_init开头的方法, 都会被Yaf调用,
 * @see http://www.php.net/manual/en/class.yaf-bootstrap-abstract.php
 * 这些方法, 都接受一个参数:Yaf_Dispatcher $dispatcher
 * 调用的次序, 和申明的次序相同
 */
use \Yaf\Bootstrap_Abstract;
use Illuminate\View\Engines\EngineResolver;
use Illuminate\View\Engines\PhpEngine;
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\View\Engines\CompilerEngine;
use Illuminate\Database\Capsule\Manager as Capsule;

class Bootstrap extends Bootstrap_Abstract{

    /**
     * 保存配置
     */
    public function _initConfig() {
		$arrConfig = Yaf\Application::app()->getConfig();
		Yaf\Registry::set('config', $arrConfig);
	}

    /**
     * 注册插件
     * @param \Yaf\Dispatcher $dispatcher
     */
	public function _initPlugin(Yaf\Dispatcher $dispatcher) {
		//$objSamplePlugin = new SamplePlugin();
		//$dispatcher->registerPlugin($objSamplePlugin);
	}

    /**
     * 定制路由
     * @param \Yaf\Dispatcher $dispatcher
     */
	public function _initRoute(Yaf\Dispatcher $dispatcher) {
		//在这里注册自己的路由协议,默认使用简单路由
        //$router = $dispatcher->getRouter();
        //$router->addConfig(Yaf\Registry::get('config')->router);
	}

    /**
     * composer自动加载
     */
    public function _initLoad(){
        require APP_PATH . '/vendor/autoload.php';
    }

    /**
     * Eloquent orm 初始化
     */
    public function _initDb()
    {
        $db_config = \Yaf\Registry::get('config')->database->toArray();
        $capsule = new Capsule;
        // 创建链接
        $capsule->addConnection($db_config);
        // 设置全局静态可访问
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }

    /**
     * blade模板初始化
     * @param \Yaf\Dispatcher $dispatcher
     */
	public function _initView(Yaf\Dispatcher $dispatcher){
        $dispatcher->disableView();  //关闭自动渲染

        $view_path = Yaf\Registry::get('config')->application->view;  //获取模板路径
        $finder = new \Illuminate\View\FileViewFinder(new \Illuminate\Filesystem\Filesystem(), [$view_path]);  //finder实例
        $view_factory = new \Tool\View($this->registerEngineResolver(), $finder, new Tool\Dispatcher());  //视图工厂

        $dispatcher->setView($view_factory);  //设置模板引擎
	}

    /**
     * 注册模板引擎
     * @return EngineResolver
     */
    protected function registerEngineResolver()
    {
        $resolver = new EngineResolver;

        foreach (['php', 'blade'] as $engine) {
            $this->{'register'.ucfirst($engine).'Engine'}($resolver);
        }

        return $resolver;
    }

    /**
     * 注册php模板引擎
     * @param  \Illuminate\View\Engines\EngineResolver  $resolver
     * @return void
     */
    protected function registerPhpEngine($resolver)
    {
        $resolver->register('php', function () {
            return new PhpEngine;
        });
    }

    /**
     * 注册blade模板引擎
     * @param  \Illuminate\View\Engines\EngineResolver  $resolver
     * @return void
     */
    protected function registerBladeEngine($resolver)
    {
        $cache = Yaf\Registry::get('config')->application->compile;  //获取编译路径

        $bladeCompiler = new BladeCompiler(new \Illuminate\Filesystem\Filesystem(), $cache); //实例blade模板编译类

        $resolver->register('blade', function () use ($bladeCompiler) {
            return new CompilerEngine($bladeCompiler);
        });
    }
}
