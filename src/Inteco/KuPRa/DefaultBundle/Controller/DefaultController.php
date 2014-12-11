<?php

namespace Inteco\KuPRa\DefaultBundle\Controller;

use Inteco\KuPRa\DefaultBundle\Entity\User;
use Inteco\KuPRa\DefaultBundle\Form\Filter\Model\LoginModel;
use Inteco\KuPRa\DefaultBundle\Form\Filter\Type\LoginType;
use Inteco\KuPRa\DefaultBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authentication\AuthenticationProviderManager;
use Symfony\Component\Security\Core\Authentication\Token;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="_default")
     * @Template()
     */
    public function indexAction()
    {
        $session = $this->get('session');
        $user = $session->get('user');

        if($user == NULL){
            return $this->redirect($this->generateUrl('_title'));
        }
        return [];
    }

    /**
     * @Route("/title", name="_title")
     * @Template("IntecoKuPRaDefaultBundle:Default:title.html.twig")
     */
    public function titlePageAction()
    {
        $session = $this->get('session');
        $user = $session->get('user');

        if($user != NULL){
            return $this->redirect($this->generateUrl('_title'));
        }

        $userEntity = new User();
        $err = 'none';
        $regForm = $this->createForm(new UserType(), $userEntity);
        $logForm = $this->createForm(new LoginType(), new LoginModel());

        if ($this->getRequest()->isMethod('POST')) {
            $logForm->submit($this->getRequest());
            $data = $logForm->getData();
            $user = $this->get('repository.user')->findOneBy(array('loginName' => $data->getLoginName()));
            if (!empty($user)){
                $factory = $this->container->get('security.encoder_factory');
                $encoder = $factory->getEncoder(new User());
                $encodedPassword = $encoder->encodePassword($data->getPassword(), $user->getSalt());
                if($encodedPassword == $user->getPassword()){
                    $session = new Session();
                    $session->set('user', $user->getId());
                    return $this->redirect($this->generateUrl('_default'));
                }
            } else {
                $err = 'login';
            }
            $regForm->submit($this->getRequest());
            if ($regForm->isValid()) {
                $regData = $regForm->getData();
                $user = new User();
                $user->setNickname($regData->getNickName());
                $user->setLoginName($regData->getLoginName());
                $user->setName($regData->getName());
                $user->setSurname($regData->getSurname());
                $user->setLoginName($regData->getLoginName());
                $user->setSalt(md5(uniqid()));
                $user->setRole('ROLE_USER');

                $factory = $this->container->get('security.encoder_factory');
                $encoder = $factory->getEncoder($user);
                $encodedPassword = $encoder->encodePassword($regData->getPassword(), $user->getSalt());
                $user->setPassword($encodedPassword);
                $this->get('manager.user')->register($user);
                $session = new Session();
                $session->set('user', $user->getId());
                return $this->redirect($this->generateUrl('_default'));
            } else {
                $err = 'reg';
            }
        }

        return [
            'regForm' => $regForm->createView(),
            'logForm' => $logForm->createView(),
            'err' => $err
        ];
    }

    /**
     * @Route("/logout", name="_logout")
     * @Template()
     */
    public function logoutAction()
    {
        $session = new Session();
        $session->remove('user');
        return $this->redirect($this->generateUrl('_title'));
    }

    public function registerAction(){

    }
}
