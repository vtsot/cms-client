<?php

declare(strict_types=1);

namespace App\Controller;

use App\Contract\Dictionary\PageType;
use App\Service\CmsAdmin\PageService;
use App\Service\CmsAdmin\SiteService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use function sprintf;

class DefaultController extends AbstractController
{
    #[Route(
        path: '',
        name: 'web.homepage',
        options: ['expose' => true],
        methods: ['GET'],
    )]
    // todo: move to separate controller
    #[Route(
        path: '/{slug}',
        name: 'web.cms',
        requirements: ['slug' => '[a-zA-Z0-9\-\/]+'],
        methods: ['GET', 'POST'],
    )]
    public function __invoke(
        ?string $slug,
        Request $request,
        SiteService $siteService,
        PageService $pageService,
    ): Response {
        if ((int) $request->query->get('page') === 1) {
            $params = $request->attributes->get('_route_params', []) + $request->query->all();
            unset($params['page']);

            return $this->redirectToRoute($request->attributes->get('_route'), $params);
        }

        if (!$site = $siteService->getSite()) {
            throw $this->createNotFoundException('Site Not Found');
        }

        // redirect from slug homepage to homepage w/o slug
        if ($slug !== null && $site->homepage !== null && $slug === $site->homepage) {
            return $this->redirectToRoute('web.homepage', [], Response::HTTP_MOVED_PERMANENTLY);
        }

        if (!$page = $pageService->getPage($slug ?? $site->homepage)) {
            throw $this->createNotFoundException(sprintf('Page "%s" Not Found', $slug ?? 'homepage'));
        }

        // redirect page except homepage
        if ($page->redirect && !$page->isHomepage) {
            return new RedirectResponse($page->redirect, Response::HTTP_MOVED_PERMANENTLY);
        }

        $view = match ($page->type) {
            PageType::Article => 'web/default/article.html.twig',
            default           => 'web/default/page.html.twig',
        };

        return $this->render($view, [
            'site' => $site,
            'page' => $page,
        ]);
    }
}
