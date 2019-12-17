<?php


namespace App\Initializer;


use Sulu\Bundle\SecurityBundle\UserManager\UserManager;
use Sulu\Component\DocumentManager\DocumentManager;
use Sulu\Component\Webspace\Manager\WebspaceManager;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Process\Process;

class Initializer
{
    /** @var \Sulu\Bundle\DocumentManagerBundle\Initializer\Initializer */
    private $initializer;

    /**
     * Initializer constructor.
     * @param \Sulu\Bundle\DocumentManagerBundle\Initializer\Initializer $initializer
     */
    public function __construct($initializer)
    {
        $this->initializer = $initializer;
    }

    public function initialize($key, $content)
    {
        $fs = new Filesystem();
        $fs->dumpFile(__DIR__.'/../../config/webspaces/'.$key.'.xml', $content);

        $proc = new Process(['bin/adminconsole sulu:document:initialize'], __DIR__.'/../../');
        $proc->run();
    }
}