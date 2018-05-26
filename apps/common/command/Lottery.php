<?php
namespace app\common\command;

use think\console\Command;
use think\console\Input;
use think\console\Output;
use think\console\input\Argument;
use think\console\input\Option;

class Lottery extends Command
{
    protected function configure()
    {
        $this->addArgument('param', Argument::OPTIONAL);//查看状态
        // 设置命令名称
        $this->setName('lottery')->setDescription('this is a super lottery!');
    }

    protected function execute(Input $input, Output $output)
    {
       $output->writeln("lottery start");
	   	
       $lottery = new \app\lottery\controller\Index;
	   //dump($lottery);
       $lottery->index(); 
    }
}