<?php
/**
 * @brief
 * Created by PhpStorm.
 * User: zy&cs
 * Date: 17-4-27
 * Time: 上午10:58
 */
namespace App\CliModules\Demo\Tasks;

use Swoolcon;
use App\CliModules\Server\Tasks;
use Swoole\Http\Request as SwooleRequest;
use Swoole\Http\Response as SwooleResponse;
use Swoole\WebSocket\Frame;
use Swoole\WebSocket\Server as SwooleWebsocket;

class MainTask extends Tasks
{
    /**
     * @var \Swoolcon\Application\Web
     */
    private $application = null;

    public function mainAction()
    {
        $host   = '127.0.0.1';
        $port   = '9999';
        $server = new SwooleWebsocket($host, $port);
        $server->set([
            'max_request' => '50'
        ]);
        $server->on('WorkerStart', [$this, 'onWorkerStart']);
        $server->on('Request', [$this, 'onRequest']);
        $server->on('Message', [$this, 'onMessage']);
        $server->on('Open', [$this, 'onOpen']);

        echo sprintf('server started on %s:%s%s', $host, $port, PHP_EOL);
        $server->start();
    }


    public function onWorkerStart(SwooleWebsocket $server, $workerId)
    {
        //router


        //先这么做，以后可能有优化，把 app 放 workerstart 里面，而不是每次请求都new 一个
        $this->application = new \Swoolcon\Application\Web();
        $this->application->setServiceProviderList(require config_path('ProvidersWeb.php'))
            ->setModules([
                'frontend' => [
                    'className' => \App\DemoModules\Frontend\Module::class,
                    'path'      => app_path('App/DemoModules/Frontend/Module.php'),
                    'router'    => app_path('App/DemoModules/Frontend/Config/Routing.php'),
                ],
            ])->setRouter(function () {
                $router = new Swoolcon\Mvc\Router();
                $router->removeExtraSlashes(true);

                $frontend = new \Phalcon\Mvc\Router\Group([
                    'module'     => 'frontend',
                    'namespace'  => \App\DemoModules\Frontend\Controllers::class,
                    'controller' => 'index',
                    'action'     => 'index',
                ]);
                $frontend->setPrefix('');

                $frontend->add('[/]?', [
                    'action' => 'index',
                ]);
                $frontend->add('/:controller[/]?', [
                    'controller' => 1,
                ]);
                $frontend->add('/:controller/:action[/]?', [
                    'controller' => 1,
                    'action'     => 2,
                ]);
                $router->mount($frontend);

                return $router;
            });
    }

    public function onRequest(SwooleRequest $request, SwooleResponse $response)
    {
        //目前不处理静态文件，当成动态文件处理，静态文件建议交给nginx


        //动态脚本处理 request_uri
        $app                  = $this->application;
        $request->get['_url'] = $request->server['request_uri'];


        ob_start();
        $app->setSwooleRequest($request)->setSwooleResponse($response)->register();
        echo $app->run();
        $response->end(ob_get_contents());
        ob_clean();

        //先把超全局unset掉，否则可能串请求
        unset($_SESSION);
        unset($_GET);
        unset($_POST);
        unset($_REQUEST);
        unset($_FILES);
        unset($_ENV);
    }

    public function onOpen(SwooleWebsocket $server, SwooleRequest $request)
    {
        $server->push($request->fd, 'connect ok' . ' :' . $request->server['request_uri']);
    }


    public function onMessage(SwooleWebsocket $server, Frame $frame)
    {
        if ($frame->opcode == WEBSOCKET_OPCODE_BINARY) {

            //$str_info = @unpack("C2chars", substr($frame->data,0,16));
            $str_info = @unpack("C2chars", substr($frame->data, 0, 2));

            $type_code = intval($str_info['chars1'] . $str_info['chars2']);
            var_dump($type_code);
            return;
        }
        $server->push($frame->fd, $frame->data);
    }
}