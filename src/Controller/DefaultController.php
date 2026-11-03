<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\CmsAdmin\SiteService;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DefaultController extends AbstractController
{
    #[Route(
        path: '',
        name: 'web.homepage',
        options: ['expose' => true],
        methods: ['GET'],
    )]
    public function __invoke(
        SiteService $siteService,
        LoggerInterface $logger,
    ): Response {
        dd(
            $siteService->getSite(true)
        );

        return $this->render('web/default/index.html.twig', [
        ]);
    }
}
