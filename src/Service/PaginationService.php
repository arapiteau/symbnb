<?php

namespace App\Service;

use Twig\Environment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class PaginationService {
    private $entityClass;
    private $limit = 10;
    private $currentPage = 1;
    private $manager;
    private $twig;
    private $route;
    private $templatePath;

    public function __construct(EntityManagerInterface $manager, Environment $twig, RequestStack $requestStack, $templatePath) {
        $this->route = $requestStack->getCurrentRequest()->attributes->get('_route');
        $this->manager = $manager;
        $this->twig = $twig;
        $this->templatePath = $templatePath;
    }

    public function display() {
        $this->twig->display($this->templatePath, [
            'page' => $this->currentPage,
            'pages' => $this->getPages(),
            'route' => $this->route
        ]);
    }

    public function getPages() {
        if (empty($this->entityClass)) {
            throw new \Exception("Vous n'avez pas spécifié au PaginationService l'entité des objets à paginer !");
        }

        // 1) Connaître le nombre d'enregistrements de la série
        $repo = $this->manager->getRepository($this->entityClass);
        $total = count($repo->findAll());
       
        // 2) Faire la division, l'arrondi et le renvoyer
        $pages = ceil($total / $this->limit);

        return $pages;
    }

    public function getData() {
        if (empty($this->entityClass)) {
            throw new \Exception("Vous n'avez pas spécifié au PaginationService l'entité des objets à paginer !");
        }

        // 1) Calculer l'offset
            $offset = ($this->currentPage  - 1) * $this->limit;

        // 2) Demander au repository de trouver les éléments
            $repo = $this->manager->getRepository($this->entityClass);
            $data = $repo->findBy([], [], $this->limit, $offset);

        // 3) Renvoyer les éléments en question
            return $data;            
    }

    public function setEntityClass($entityClass){
        $this->entityClass = $entityClass;

        return $this;
    }

    public function getEntityClass() {
        return $this->entityClass;
    }

    public function setLimit($limit){
        $this->limit = $limit;

        return $this;
    }

    public function getLimit() {
        return $this->limit;
    }

    public function setCurrentPage($currentPage){
        $this->currentPage = $currentPage;

        return $this;
    }

    public function getCurrentPage() {
        return $this->currentPage;
    }

    public function setRoute($route){
        $this->route = $route;

        return $this;
    }

    public function getRoute() {
        return $this->route;
    }

    public function setTemplatePath($templatePath){
        $this->templatePath = $templatePath;

        return $this;
    }

    public function getTemplatePath() {
        return $this->templatePath;
    }
}