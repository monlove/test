<?php
namespace app\common\command;

use think\console\Command;
use think\console\Input;
use think\console\Output;
use think\console\input\Argument;
use think\console\input\Option;

class Cron extends Command
{
    protected function configure()
    {
        $this->addArgument('param', Argument::OPTIONAL);//查看状态
        // 设置命令名称
        $this->setName('cron')->setDescription('this is a supercron!');
    }

    protected function execute(Input $input, Output $output)
    {
        
        //获取参数值
        $args = $input->getArguments();
       
        if ($args['param'] && !in_array($args['param'], ['status', 'worker', 'check', 'stop', 'restart'])) {
            return $output->writeln("error `{$args['param']}` just support ['status', 'worker', 'check', 'stop', 'restart']");
        }

        $manager = new \SuperCronManager\CronManager();
        // 守护进程方式启动
        $manager->daemon = true;
        $manager->argv = $args['param'];

        // crontab格式解析
        $manager->taskInterval('每个小时的1,3,5分钟时运行一次', '1,3,5 * * *', function(){
            echo "每个小时的1,3,5分钟时运行一次\n";
        });

        $manager->taskInterval('每1分钟运行一次', '*/1 * * *', function(){
            echo "每1分钟运行一次\n";
        });

        $manager->taskInterval('每天凌晨运行', '0 0 * *', function(){
            echo "每天凌晨运行\n";
        });

        $manager->taskInterval('每秒运行一次', 's@1', function(){
            echo "每秒运行一次\n";
        });

        $manager->taskInterval('每分钟运行一次', 'i@1', function(){
            echo "每分钟运行一次\n";
        });

        $manager->taskInterval('每小时钟运行一次', 'h@1', function(){
            echo "每小时运行一次\n";
        });

        $manager->taskInterval('指定每天00:00点运行', 'at@00:00', function(){
            echo "指定每天00:00点运行\n";
        });

        $manager->run();
    }
}