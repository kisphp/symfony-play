<?php

namespace InoBundle\Controller;

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
        $articles = $this->get('model.product')->getAllProducts();

        return [
            'articles' => $articles,
        ];
    }

    public function editAction(Request $request, $id)
    {
        $productModel = $this->get('model.product');
        $entity = $productModel->getByIdOrEmpty($id);

        $form = $this->createForm(ProductForm::class, $entity);
        $form->handleRequest($request);


        if ($form->isValid()) {
            $entity = $productModel->save($form->getData());
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
        $productModel = $this->get('model.product');

        if ($id > 0) {
            $entity = $productModel->find($id);
            $productModel->delete($entity);

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
