<?php

declare(strict_types=1);

namespace App\Controller\General;

use App\Controller\AbstractController;
use App\Exception\Security\AccessDeniedException;
use Exception;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class CacheClearController extends AbstractController
{
    /**
     * @throws Exception
     */
    #[Route(path: '/cache-clear', name: 'cache.clear')]
    public function __invoke(
        #[Autowire(env: 'CMS_ADMIN_SITE_TOKEN')]
        string $token,
        TranslatorInterface $translator,
        Request $request,
        KernelInterface $kernel,
    ): Response {
        if (!$request->headers->get('X-API-KEY')
            || $request->headers->get('X-API-KEY') !== $token
        ) {
            throw new AccessDeniedException($translator->trans(id: 'SECURITY.ACCESS_DENIED', domain: 'security'));
        }

        $application = new Application($kernel);
        $application->setAutoExit(false);
        $output = new BufferedOutput();

        $commands   = [];
        $commands[] = ['command' => 'cache:clear', '--env' => 'dev'];
        $commands[] = ['command' => 'cache:clear', '--env' => 'prod'];
        $commands[] = ['command' => 'cache:pool:clear', '--env' => 'prod', 'pools' => ['site.cache', 'site.image.cache', 'site.banner.cache']];
        $commands[] = ['command' => 'cache:pool:clear', '--env' => 'dev', 'pools' => ['site.cache', 'site.image.cache', 'site.banner.cache']];

        // run commands
        foreach ($commands as $arrayInput) {
            $application->run(new ArrayInput($arrayInput), $output);
        }

        return new Response('<pre>' . $output->fetch() . '</pre>');
    }
}
