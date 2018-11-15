<?php
namespace Star\Cli;

use Bee\Cli\Command;
use Curl\Curl;
use Phalcon\Di;

/**
 * 应用部署服务命令
 *
 * @package Ant\Cli\Command
 */
class Deploy extends Command
{
    /**
     * 命令名称
     *
     * @var string
     */
    protected $name = 'deploy';

    /**
     * 命令说明
     *
     * @var string
     */
    protected $desc = '应用部署，根部不同获取运行所需的配置';

    /**
     * 注册帮助显示的信息
     */
    public function initShowHelp()
    {
        // 注册参数信息
        $this
            ->argument('<action>', '')
            ->argument('dist', '拉取正式环境运行配置')
            ->argument('pre', '拉取预发布环境运行配置')
            ->argument('test', '拉取测试环境运行配置')
            ->argument('dev', '拉取开发环境运行配置')
            ->argument('local', '拉取本地环境运行配置')
            ->argument('status', '查看当前使用的配置')
        ;

        // 注册使用示例信息
        $this->usage(
            $this->writer()->colorizer()->colors(''
                . '<bold>pink deploy</end> <line>local</end> '
                . '<comment>拉取本地环境配置文件</end><eol/>'
            )
        );
    }

    /**
     * 命令执行体
     *
     * @param string $action
     */
    public function execute($action = 'dist')
    {
        try {
            if ($action == 'status') {
                $this->status();
                return;
            } else {
                $di     = Di::getDefault();
                $config = $di->getShared('config.deploy');

                file_put_contents(__DIR__ . '/deloy.log', json_encode($config));

                if (!isset($config[$action])) {
                    $this->writer()->warn("不支持[{$action}]配置", true);
                    return;
                }

                $this->build($config[$action]['repo'], $config[$action]['token']);
            }
        } catch (\Throwable $e) {
        }
    }

    /**
     * 获取并构建配置文件
     *  - FIXME: 检测runtime目录可写权限
     *
     * @param $repo
     * @param $token
     * @throws \ErrorException
     */
    private function build($repo, $token)
    {
        // 创建runtime目录
        is_dir(RUNTIME_PATH) or mkdir(RUNTIME_PATH, 0755);

        // 拉取远程配置
        $curl = new Curl;
        $curl->setHeader('token', $token)->get($repo);
        if ($curl->error) {
            throw new \ErrorException('拉取配置失败', $curl->error_code);
        }
        $result = json_decode($curl->response, true);

        if ($result['code'] != 200) {
            throw new \ErrorException($result['msg'], $result['code']);
        }

        // 提取配置并写入runtime
        $mate   = $result['info']['mate'];
        $build  = $result['info']['build'];
        foreach ($mate['map'] as $key => $target) {
            if (isset($build[$key])) {
                $filename = RUNTIME_PATH . "/{$target}.{$mate['ext']}";
                $content  = '<?php return ' . var_export($build[$key], true) . ';';
                file_put_contents($filename, $content);
            }
        }
    }

    protected function status()
    {
        $this->writer()->warn('未完成', true);
    }
}
