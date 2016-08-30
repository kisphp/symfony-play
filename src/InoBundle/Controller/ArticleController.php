<?php

namespace InoBundle\Controller;

use InoBundle\Entity\Product;
use InoBundle\Forms\ProductForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Template()
 */
class ArticleController extends Controller
{
    public function indexAction()
    {
        $articles = $this->get('doctrine.orm.entity_manager')
            ->getRepository('InoBundle:Product')
            ->findAll()
        ;

        return [
            'articles' => $articles,
        ];
    }

    public function editAction(Request $request, $id)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $entity = new Product();

        if ($id > 0) {
            $entity = $em->getRepository('InoBundle:Product')
                ->find($id)
            ;
        }

        $form = $this->createForm(ProductForm::class, $entity);
        $form->handleRequest($request);


        if ($form->isValid()) {
            $em->persist($form->getData());
            $em->flush();

            $this->addFlash('success', 'Product created');

            return $this->redirect(
                $this->generateUrl('articles_edit', [
                    'id' => $entity->getId(),
                ])
            );
        }

        return [
            'form' => $form->createView(),
        ];
    }

    public function deleteAction(Request $request)
    {
        $id = $request->request->getInt('id');

        $em = $this->get('doctrine.orm.entity_manager');

        if ($id > 0) {
            $entity = $em->getRepository('InoBundle:Product')
                ->find($id)
            ;
            $em->remove($entity);
            $em->flush();

            return new JsonResponse([
                'code' => Response::HTTP_OK
            ]);
        }

        return new JsonResponse([
            'code' => Response::HTTP_BAD_REQUEST,
            'message' => 'Product could not be found',
        ]);
    }
}
