<?php
declare(strict_types=1);

namespace Acme\FusionFlow\Controller;

/*
 * This file is part of the Acme.FusionFlow package.
 */

use Acme\FusionFlow\Domain\Repository\AtomRepository;
use Neos\Flow\Annotations as Flow;
use Neos\Flow\Mvc\Controller\ActionController;
use Acme\FusionFlow\Domain\Model\Atom;
use Neos\Flow\Mvc\View\ViewInterface;
use Neos\Fusion\Core\Cache\ContentCache;
use Neos\Fusion\View\FusionView;

class AtomController extends ActionController
{

    /**
     * @Flow\Inject
     * @var AtomRepository
     */
    protected $atomRepository;

    /**
     * @Flow\Inject
     * @var ContentCache
     */
    protected $contentCache;

    protected function initializeView(ViewInterface $view): void
    {
        /** @var FusionView $view */
        $view->setOption('enableContentCache', true);
        $view->assign('page-title', 'We intend to say something about the structure of the atom but lack a language in which we can make ourselves understood.');
        $flashMessages = $this->controllerContext->getFlashMessageContainer()->getMessagesAndFlush();
        $view->assign('flashMessages', $flashMessages);
    }

    /**
     * @return void
     */
    public function indexAction(): void
    {
        $this->view->assign('atoms', $this->atomRepository->findAll());
    }

    /**
     * @param Atom $atom
     * @return void
     */
    public function showAction(Atom $atom): void
    {
        $this->view->assign('atom', $atom);
    }

    /**
     * @return void
     */
    public function newAction(): void
    {
    }

    /**
     * @param Atom $newAtom
     * @return void
     */
    public function createAction(Atom $newAtom): void
    {
        $this->atomRepository->add($newAtom);
        $this->contentCache->flushByTag('Atoms');
        $this->addFlashMessage('Created a new atom.');
        $this->redirect('index');
    }

    /**
     * @param Atom $atom
     * @return void
     */
    public function editAction(Atom $atom): void
    {
        $this->view->assign('atom', $atom);
    }

    /**
     * @param Atom $atom
     * @return void
     */
    public function updateAction(Atom $atom): void
    {
        $this->atomRepository->update($atom);
        $this->contentCache->flushByTag('Atoms');
        $this->contentCache->flushByTag('Atom_' . $atom->getName());
        $this->addFlashMessage('Updated the atom.');
        $this->redirect('index');
    }

    /**
     * @param Atom $atom
     * @return void
     */
    public function deleteAction(Atom $atom): void
    {
        $this->atomRepository->remove($atom);
        $this->contentCache->flushByTag('Atoms');
        $this->contentCache->flushByTag('Atom_' . $atom->getName());
        $this->addFlashMessage('Deleted a atom.');
        $this->redirect('index');
    }
}
