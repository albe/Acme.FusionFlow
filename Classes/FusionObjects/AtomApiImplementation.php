<?php
namespace Acme\FusionFlow\FusionObjects;

use Neos\Flow\Http\Client\Browser;
use Neos\Flow\Http\Client\CurlEngine;
use Neos\Fusion\FusionObjects\ComponentImplementation;

/**
 * A Fusion object to fetch atom information from an API
 * See https://github.com/neelpatel05/periodic-table-api
 */
class AtomApiImplementation extends ComponentImplementation
{
    /**
     * The requested atom, either the symbol or full english name, e.g. "H" or "Hydrogen"
     */
    public function getAtom(): string
    {
        return $this->fusionValue('atom');
    }

    /**
     * The property to pass down into the children for rendering the content
     */
    public function getDataProp(): string
    {
        return $this->fusionValue('dataProp');
    }

    /**
     * @return string
     */
    public function evaluate()
    {
        $context = $this->runtime->getCurrentContext();

        $browser = new Browser();
        $browser->setRequestEngine(new CurlEngine());
        $atom = $this->getAtom();
        // See https://github.com/neelpatel05/periodic-table-api
        $uri = strlen($atom) <= 2 ? 'https://neelpatel05.pythonanywhere.com/element/symbol?symbol=' : 'https://neelpatel05.pythonanywhere.com/element/atomicname?atomicname=';
        $response = $browser->request($uri . $atom);
        if ($response->getStatusCode() <= 300) {
            $context[$this->getDataProp()] = json_decode($response->getBody()->getContents(), true);
        }

        $renderContext = $this->prepare($context);
        return $this->render($renderContext);
    }
}
