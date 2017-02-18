<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use UserBundle\Entity\User;
use UserBundle\Form\Type\UserType;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{

    /**
     * @Route("/user/view", name="user_view")
     */
    public function indexAction()
    {
        $user = $this->container->get('user_profile')->getUser();

        if (is_null($user))
            return $this->redirectToRoute('user_add');

        return $this->render('UserBundle:User:index.html.twig', array(
                    'user' => $user
        ));
    }

    /**
     * @Route("/user/add", name="user_add")
     */
    public function addUserAction(Request $request)
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);

        $user->setSession($this->container->get('user_profile')->getUserSession());

        if ($form->handleRequest($request)->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', 'Votre profil a été créé.');

            return $this->redirectToRoute('home');
        }

        return $this->render('UserBundle:User:add.html.twig', array(
                    'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/user/edit", name="user_edit")
     */
    public function editAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $this->container->get('user_profile')->getUser();

        if (is_null($user))
            return $this->redirectToRoute('user_add');

        $form = $this->createForm(UserType::class, $user);

        if ($form->handleRequest($request)->isValid())
        {
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', 'Votre profil est mis à jour.');

            return $this->redirectToRoute('home');
        }

        return $this->render('UserBundle:User:edit.html.twig', array(
                    'form' => $form->createView(),
        ));
    }

}
