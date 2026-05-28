<?php
namespace App\Twig;

use App\Form\SearchType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Routing\RouterInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class SearchFormExtension extends AbstractExtension
{
    public function __construct(
        private FormFactoryInterface $formFactory,
        private RouterInterface $router
    ) {}

    public function getFunctions(): array
    {
        return [
            new TwigFunction('search_form', [$this, 'getSearchForm']),
        ];
    }

    public function getSearchForm(): \Symfony\Component\Form\FormView
    {
        return $this->formFactory
            ->create(SearchType::class, null, [
                'action' => $this->router->generate('app_recherche'),
            ])
            ->createView();
    }
}
