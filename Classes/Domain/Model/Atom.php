<?php
namespace Acme\FusionFlow\Domain\Model;

/*
 * This file is part of the Acme.FusionFlow package.
 */

use Neos\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Flow\Entity
 */
class Atom
{

    /**
     * @var string
     * @Flow\Validate(type="NotEmpty")
     */
    protected $name;


    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }
}
