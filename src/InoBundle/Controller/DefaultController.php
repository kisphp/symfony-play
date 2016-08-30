<?php

namespace InoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Template()
 */
class DefaultController extends Controller
{
    public function indexAction()
    {
        return [];
    }

    public function contactAction()
    {
        return [];
    }
}
