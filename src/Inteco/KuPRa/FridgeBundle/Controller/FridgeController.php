<?php

namespace Inteco\KuPRa\FridgeBundle\Controller;

use Doctrine\ORM\EntityManager;
use Inteco\KuPRa\DefaultBundle\EntityRepositories\UserRepository;
use Inteco\KuPRa\FridgeBundle\Entity\FridgeItem;
use Inteco\KuPRa\FridgeBundle\Entity\FridgeRepository;
use Inteco\KuPRa\FridgeBundle\Entity\Measurement;
use Inteco\KuPRa\FridgeBundle\Entity\Product;
use Inteco\KuPRa\FridgeBundle\Entity\Recipe;
use Inteco\KuPRa\FridgeBundle\Entity\RecipeItem;
use Inteco\KuPRa\FridgeBundle\Form\FridgeItemType;
use Inteco\KuPRa\FridgeBundle\Form\MeasurementType;
use Inteco\KuPRa\FridgeBundle\Form\ProductType;
use Inteco\KuPRa\FridgeBundle\Form\RecipeItemType;
use Inteco\KuPRa\FridgeBundle\Form\RecipeType;
use Inteco\KuPRa\FridgeBundle\Form\StarType;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Inteco\KuPRa\FridgeBundle\Entity\Fridge;
use Inteco\KuPRa\FridgeBundle\Form\FridgeType;

/**
 * Fridge controller.
 *
 * @Route("/fridge")
 */
class FridgeController extends Controller
{

    /**
     * Lists all Fridge entities.
     *
     * @Route("/", name="_fridge")
     * @Template("IntecoKuPRaFridgeBundle:Fridge:fridge.html.twig")
     */
    public function fridgeAction()
    {
        $role = $this->_getUserRole();
        $fridge = $this->_getFridge();
        if ($fridge == NULL || $role == null){
            return $this->redirect($this->generateUrl('_fridge'));
        }
        $em = $this->getDoctrine()->getManager();
        $err = '';
        $item = new FridgeItem();
        $form = $this->createForm(new FridgeItemType(), $item);
        if ($this->getRequest()->isMethod('POST')) {
            $item->setFridge($fridge);
            $form->submit($this->getRequest());
            $check = $em->getRepository('IntecoKuPRaFridgeBundle:FridgeItem')->findOneBy(array('product' =>$item->getProduct(), 'fridge' => $fridge));
            if ($form->isValid()) {
                if($check != null){
                    $check->setAmount($item->getAmount()+$check->getAmount());
                    $em->persist($check);
                    $em->flush();
                } else {
                    $em->persist($item);
                    $em->flush();
                }
            }
        }
        $entities = $em->getRepository('IntecoKuPRaFridgeBundle:FridgeItem')->findBy(array('fridge' => $fridge));
        return ['form' => $form->createView(), 'entities' => $entities, 'err' => $err, 'role' => $role];
    }

    /**
     * @Route("/{id}/edit", name="_edit_fridge")
     * @Template("IntecoKuPRaFridgeBundle:Fridge:fridge.html.twig")
     */
    public function editFridgeAction($id)
    {
        $role = $this->_getUserRole();
        $fridge = $this->_getFridge();
        if ($fridge == NULL || $role == null){
            return $this->redirect($this->generateUrl('_fridge'));
        }
        $em = $this->getDoctrine()->getEntityManager();
        $item = $em->getRepository('IntecoKuPRaFridgeBundle:FridgeItem')->findOneById($id);
        if (empty($item)){
            return $this->redirect($this->generateUrl('_fridge'));
        } else {
            $form = $this->createForm(new FridgeItemType(), $item)->remove('Įdėti')->add('edit', 'submit');
            if ($this->getRequest()->isMethod('POST')) {
                $form->submit($this->getRequest());
                if ($form->isValid()) {
                    $em->persist($item);
                    $em->flush();
                    return $this->redirect($this->generateUrl('_fridge'));
                }
            }
            $entities = $em->getRepository('IntecoKuPRaFridgeBundle:FridgeItem')->findBy(array('fridge' => $fridge));
            return ['form' => $form->createView(), 'entities' => $entities, 'role' => $role, 'action' => 'edit'];
        }
    }

    /**
     * @Route("/measurement", name="_measurement")
     * @Template("IntecoKuPRaFridgeBundle:Fridge:measurement.html.twig")
     */
    public function measurementAction()
    {
        $role = $this->_getUserRole();
        if($role == null){
            return $this->redirect($this->generateUrl('_default'));
        }
        $em = $this->getDoctrine()->getManager();
        $err = '';
        $measurement = new Measurement();
        $form = $this->createForm(new MeasurementType(), $measurement);

        if ($this->getRequest()->isMethod('POST')) {
            $form->submit($this->getRequest());
            $checkTitle = $em->getRepository('IntecoKuPRaFridgeBundle:Measurement')->findOneBy(array('title'=>$measurement->getTitle()));
            $checkShort = $em->getRepository('IntecoKuPRaFridgeBundle:Measurement')->findOneBy(array('shortTitle'=>$measurement->getShortTitle()));
            if ($form->isValid()) {
                if(empty($checkTitle) && empty($checkShort)){
                $em->persist($measurement);
                $em->flush();
                } else {
                    $err = "Measurement exists";
                }
            }
        }
        $entities = $em->getRepository('IntecoKuPRaFridgeBundle:Measurement')->findAll();
        return ['form' => $form->createView(), 'entities' => $entities, 'err' => $err, 'role' => $role];
    }

    /**
     * @Route("/measurement/{id}/delete", name="_delete_measurement")
     */
    public function deleteMeasurementAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $measurement = $em->getRepository('IntecoKuPRaFridgeBundle:Measurement')->findOneById($id);
        $em->remove($measurement);
        $em->flush();
        return $this->redirect($this->generateUrl('_measurement'));
    }

    /**
     * @Route("/measurement/{id}/edit", name="_edit_measurement")
     * @Template("IntecoKuPRaFridgeBundle:Fridge:measurement.html.twig")
     */
    public function editMeasurementAction($id)
    {
        $role = $this->_getUserRole();
        $em = $this->getDoctrine()->getEntityManager();
        $measurement = $em->getRepository('IntecoKuPRaFridgeBundle:Measurement')->findOneById($id);
        $entities = $em->getRepository('IntecoKuPRaFridgeBundle:Measurement')->findAll();
        if (empty($measurement) || $role != 'ROLE_ADMIN'){
            return $this->redirect($this->generateUrl('_measurement'));
        } else {
            $form = $this->createForm(new MeasurementType(), $measurement)->remove('submit')->add('edit', 'submit');
            if ($this->getRequest()->isMethod('POST')) {
                $form->submit($this->getRequest());
                if ($form->isValid()) {
                    $em->persist($measurement);
                    $em->flush();
                    return $this->redirect($this->generateUrl('_measurement'));
                }
            }
            return ['form' => $form->createView(), 'entities' => $entities, 'role' => $role, 'action' => 'edit'];
        }
    }

    /**
     * @Route("/products", name="_products")
     * @Template("IntecoKuPRaFridgeBundle:Fridge:product.html.twig")
     */
    public function productsAction()
    {
        $role = $this->_getUserRole();
        if($role == null){
            return $this->redirect($this->generateUrl('_default'));
        }
        $em = $this->getDoctrine()->getManager();
        $err = '';
        $product = new Product();
        $form = $this->createForm(new ProductType(), $product);
        if ($this->getRequest()->isMethod('POST')) {
            $form->submit($this->getRequest());
            $checkTitle = $em->getRepository('IntecoKuPRaFridgeBundle:Product')->findOneBy(array('title'=>$product->getTitle()));
            if ($form->isValid()) {
                if(empty($checkTitle)){
                    $product->upload();
                    $em->persist($product);
                    $em->flush();
                } else {
                    $err = "Product exists";
                }
            }
        }
        $entities = $em->getRepository('IntecoKuPRaFridgeBundle:Product')->findAll();
        return ['form' => $form->createView(), 'entities' => $entities, 'err' => $err, 'role' => $role, 'action' => 'index'];
    }

    /**
     * @Route("/product/{id}/delete", name="_delete_product")
     */
    public function deleteProductAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $product = $em->getRepository('IntecoKuPRaFridgeBundle:Product')->findOneById($id);
        $em->remove($product);
        $em->flush();
        return $this->redirect($this->generateUrl('_products'));
    }

    /**
     * @Route("/product/{id}/edit", name="_edit_product")
     * @Template("IntecoKuPRaFridgeBundle:Fridge:product.html.twig")
     */
    public function editProductAction($id)
    {
        $role = $this->_getUserRole();
        $em = $this->getDoctrine()->getEntityManager();
        $product = $em->getRepository('IntecoKuPRaFridgeBundle:Product')->findOneById($id);
        if (empty($product) || $role != 'ROLE_ADMIN'){
            return $this->redirect($this->generateUrl('_product'));
        } else {
            $form = $this->createForm(new ProductType(), $product)->remove('Sukurti')->add('edit', 'submit');
            if ($this->getRequest()->isMethod('POST')) {
                $form->submit($this->getRequest());
                if ($form->isValid()) {
                    $em->persist($product);
                    $em->flush();
                    return $this->redirect($this->generateUrl('_products'));
                }
            }
            $entities = $em->getRepository('IntecoKuPRaFridgeBundle:Product')->findAll();
            return ['form' => $form->createView(), 'entities' => $entities, 'role' => $role, 'action' => 'edit'];
        }
    }

    /**
     * @Route("/recipes", name="_recipes")
     * @Template("IntecoKuPRaFridgeBundle:Fridge:recipes.html.twig")
     */
    public function recipesAction()
    {
        $this->_checkRecipes();
        $em = $this->getDoctrine()->getEntityManager();
        $entities = $em->getRepository('IntecoKuPRaFridgeBundle:Recipe')->findAll();
        $session = $this->get('session');
        $userId = $session->get('user');
        $fridge = $em->getRepository('IntecoKuPRaFridgeBundle:Fridge')->findOneBy(['author' => $userId]);
        return ['entities' => $entities, 'fridge' => $fridge];
    }

    /**
     * @Route("/recipe/view/{id}", name="_view_recipe")
     * @Template("IntecoKuPRaFridgeBundle:Fridge:view.html.twig")
     */
    public function viewRecipeAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $session = $this->get('session');
        $userId = $session->get('user');
        $fridge = $em->getRepository('IntecoKuPRaFridgeBundle:Fridge')->findOneBy(['author' => $userId]);
        $recipe = $em->getRepository('IntecoKuPRaFridgeBundle:Recipe')->findOneById($id);
        $able = $this->_checkIfAble($recipe->getId());
        $form = $this->createForm(new StarType());
        return ['recipe' => $recipe, 'fridge' => $fridge, 'able' => $able, 'form' => $form->createView()];
    }

    /**
     * @Route("/recipe", name="_create_recipe")
     * @Template("IntecoKuPRaFridgeBundle:Fridge:recipe.html.twig")
     */
    public function createRecipeAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        if ($this->getRequest()->isMethod('POST')) {
            $recipe = $em->getRepository('IntecoKuPRaFridgeBundle:Recipe')->findOneById($this->getRequest()->request->get('inteco_kupra_fridgebundle_recipe')['id']);
        } else {
            $recipe = new Recipe();
        }
        $fs = new Filesystem();

        $session = $this->get('session');
        $userId = $session->get('user');
        $userRepository = $this->get('repository.user');
        $user = $userRepository->findOneBy(['id' => $userId]);
        $recipe->setAuthor($user);
        $em->persist($recipe);
        $em->flush();
        $form = $this->createForm(new RecipeType(), $recipe);
        if ($this->getRequest()->isMethod('POST')) {
            $form->submit($this->getRequest());
            $data = $this->getRequest()->request->get('inteco_kupra_fridgebundle_recipeitem_product');
            if(!empty($data)){
                foreach($data as $item){
                    $product = $em->getRepository('IntecoKuPRaFridgeBundle:RecipeItem')->findOneById($item['id']);
                    $product->setProduct($em->getRepository('IntecoKuPRaFridgeBundle:Product')->findOneById($item['product']));
                    $product->setAmount($item['amount']);
                    $em->persist($product);
                    $em->flush();
                }
            $images = $recipe->getFile();
            $recipe->setPaths([]);
            $recipe->setAuthor($user);
            foreach($images as $image){
                if(!$fs->exists('/home/wambo/Projects/psi/src/Inteco/KuPRa/FridgeBundle/Resources/public/images'.$image->getClientOriginalName())){
                    $image->move(
                        '/home/wambo/Projects/psi/src/Inteco/KuPRa/FridgeBundle/Resources/public/images',
                        $image->getClientOriginalName()
                    );
                }
                $recipe->addPaths('bundles/intecokuprafridge/images/'.$image->getClientOriginalName());
            }
            $em->persist($recipe);
            $em->flush();
            return $this->redirect($this->generateUrl('_recipes'));
            }
        }

        return ['form' => $form->createView(), 'id' => $recipe->getId()];
    }

    /**
     * @Route("/recipe/items/{id}", name="_recipe_items")
     * @Template("IntecoKuPRaFridgeBundle:Fridge:recipeItems.html.twig")
     */
    public function getRecipeItemsAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $recipe = $em->getRepository('IntecoKuPRaFridgeBundle:Recipe')->findOneById($id);
        $items = $em->getRepository('IntecoKuPRaFridgeBundle:RecipeItem')->findBy(['recipe' => $recipe]);
        $forms = [];
        foreach($items as $item){
            $form = $this->createForm(new RecipeItemType(), $item);
            $forms[] = $form->createView();
        }

        return ['forms' => $forms];
    }

    /**
     * @Route("/recipe/add/{id}", name="_add_recipe_items")
     * @Template("IntecoKuPRaFridgeBundle:Fridge:recipeAdd.html.twig")
     */
    public function addRecipeItemAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $recipe = $em->getRepository('IntecoKuPRaFridgeBundle:Recipe')->findOneById($id);
        $item = new RecipeItem();
        $item->setRecipe($recipe);
        $em->persist($item);
        $em->flush();
        $form = $this->createForm(new RecipeItemType(), $item);

        return ['form' => $form->createView()];
    }

    /**
     * @Route("/menu", name="_menu")
     * @Template("IntecoKuPRaFridgeBundle:Fridge:menu.html.twig")
     */
    public function menuAction()
    {
        return [];
    }

    private function _getUserRole()
    {
        $session = $this->get('session');
        $userId = $session->get('user');
        if($userId != NULL){
            $userRepository = $this->get('repository.user');
            $user = $userRepository->findOneBy(['id' => $userId]);
            return $user->getRole();
        } else {
            return null;
        }
    }

    private function _checkRecipes()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entities = $em->getRepository('IntecoKuPRaFridgeBundle:Recipe')->findAll();
        foreach($entities as $entity){
            $title = $entity->getTitle();
            if(empty($title)){
                foreach($entity->getProducts() as $product){
                    $em->remove($product);
                    $em->flush();
                }
                $em->remove($entity);
                $em->flush();
            }
        }
    }

    private function _getFridge()
    {
        $session = $this->get('session');
        $userId = $session->get('user');
        if($userId != NULL){
            $userRepository = $this->get('repository.user');
            $user = $userRepository->findOneBy(['id' => $userId]);
            $fridgeRepository = $this->get('repository.fridge');
            $fridge = $fridgeRepository->findOneBy(array('author' => $user));
            if ($fridge == NULL){
                $fridge = new Fridge();
                $fridge->setAuthor($user);
                $em = $this->getDoctrine()->getManager();
                $em->persist($fridge);
                $em->flush();
            }
            return $fridge;
        } else {
            return null;
        }
    }

    private function _checkIfAble($id)
    {
        $able = true;
        $em = $this->getDoctrine()->getEntityManager();
        $session = $this->get('session');
        $userId = $session->get('user');
        $userRepository = $this->get('repository.user');
        $user = $userRepository->findOneBy(['id' => $userId]);
        $fridgeRepository = $this->get('repository.fridge');
        $fridge = $fridgeRepository->findOneBy(array('author' => $user));
        $items = $em->getRepository('IntecoKuPRaFridgeBundle:RecipeItem')->findBy(['recipe' => $id]);
        foreach($items as $item){
            $product = $em->getRepository('IntecoKuPRaFridgeBundle:FridgeItem')->findOneBy(['fridge' => $fridge, 'product' => $item->getProduct()]);
            if(empty($product) || ($product->getAmount() < $item->getAmount())){
                $able = false;
            }
        }
        return $able;
    }
}
