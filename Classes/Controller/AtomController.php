<?php
namespace Acme\FusionFlow\Controller;

/*
 * This file is part of the Acme.FusionFlow package.
 */

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Mvc\Controller\ActionController;
use Acme\FusionFlow\Domain\Model\Atom;
use Neos\Flow\Mvc\View\ViewInterface;

class AtomController extends ActionController
{

    /**
     * @Flow\Inject
     * @var \Acme\FusionFlow\Domain\Repository\AtomRepository
     */
    protected $atomRepository;

    protected function initializeView(ViewInterface $view)
    {
        $view->assign('page-title', 'We intend to say something about the structure of the atom but lack a language in which we can make ourselves understood.');
    }

    /**
     * @return void
     */
    public function indexAction()
    {
        $this->view->assign('atoms', $this->atomRepository->findAll());
    }

    /**
     * @param \Acme\FusionFlow\Domain\Model\Atom $atom
     * @return void
     */
    public function showAction(Atom $atom)
    {
        $this->view->assign('atom', $atom);
    }

    /**
     * @return void
     */
    public function newAction()
    {
    }

    /**
     * @param \Acme\FusionFlow\Domain\Model\Atom $newAtom
     * @return void
     */
    public function createAction(Atom $newAtom)
    {
        $this->atomRepository->add($newAtom);
        $this->addFlashMessage('Created a new atom.');
        $this->redirect('index');
    }

    /**
     * @param \Acme\FusionFlow\Domain\Model\Atom $atom
     * @return void
     */
    public function editAction(Atom $atom)
    {
        $this->view->assign('atom', $atom);
    }

    /**
     * @param \Acme\FusionFlow\Domain\Model\Atom $atom
     * @return void
     */
    public function updateAction(Atom $atom)
    {
        $this->atomRepository->update($atom);
        $this->addFlashMessage('Updated the atom.');
        $this->redirect('index');
    }

    /**
     * @param \Acme\FusionFlow\Domain\Model\Atom $atom
     * @return void
     */
    public function deleteAction(Atom $atom)
    {
        $this->atomRepository->remove($atom);
        $this->addFlashMessage('Deleted a atom.');
        $this->redirect('index');
    }
}
