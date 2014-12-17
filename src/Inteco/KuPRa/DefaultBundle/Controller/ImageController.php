<?php
/**
 * @author   Jokūbas Ramanauskas
 * @since    14.11.19
 */

namespace Inteco\KuPRa\DefaultBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ImageController
 * @package Inteco\KuPRa\DefaultBundle\Controller
 */
class ImageController extends Controller
{
    /**
     * @Route("/image/upload/{filters}", name="_admin_image_upload")
     */
    public function uploadAction(Request $request, $filters)
    {
        /** @var \Inteco\KuPRa\DefaultBundle\Manager\ImageManager $imageManager */
        $imageManager = $this->get('manager.common.image');
        $result = $imageManager->prepare($request, $filters);

        return new JsonResponse($result);
    }
}