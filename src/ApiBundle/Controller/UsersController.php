<?php

namespace ApiBundle\Controller;

use ApiBundle\Entity\User\User;
use ApiBundle\Entity\HappyUser;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\Delete;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class UsersController extends FOSRestController
{
    /**
     * @Get("/users")
     */
    public function getUsersAction()
    {
        $users = $this->getDoctrine()->getRepository('ApiBundle\Entity\HappyUser')->findAll();

        $view = $this->view($users, 200)
            ->setTemplate("ApiBundle:User:users.html.twig")
            ->setTemplateVar('users');

        return $this->handleView($view);
    }

    /**
     * @Get("/users/{user}", requirements={"user" = "\d+"})
     */
    public function getUserAction(User $user)
    {
        $view = $this->view($user, 200)
            ->setTemplate("ApiBundle:User:user.html.twig")
            ->setTemplateVar('user');

        return $this->handleView($view);
    }

    /**
     * Form Post
     *
     * @Post("/users")
     */
    public function postUsersAction(Request $request)
    {
        $form = $this->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();

            $em->getConnection()->beginTransaction();

            try{
                $em->persist($form->getData());
                $em->flush();
                $em->getConnection()->commit();
            } catch (\Exception $e) {
                //or conflictException
                throw new UnprocessableEntityHttpException($e->getMessage());
                $em->getConnection()->rollBack();
                $em->close();
            }

            $view = $this->view($form->getData(), 201);

            return $this->handleView($view);
        }

        return $this->handleView($this->view($form, 400));
    }

    /**
     * Json put
     *
     * @Put("/users/{user}", requirements={"user" = "\d+"})
     */
    public function putUsersAction(Request $request, HappyUser $user)
    {
        $userData = $this->get('serializer')->deserialize(
            $request->getContent(),
            'ApiBundle\Entity\HappyUser',
            'json'
        );

        $violations = $this->get('validator')->validate($userData);

        if (count($violations)) {
            throw new UnprocessableEntityHttpException("constant error codes here, along with validation errors");
        }

        $user->setUsername($userData->getUsername());

        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($user);
        $em->flush();

        $view = $this->view($user, 201);

        return $this->handleView($view);
    }

    /**
     * @Delete("/users/{user}", requirements={"user" = "\d+"})
     */
    public function deleteUsersAction(Request $request, User $user)
    {
        if (!$user = $em->getRepository('ApiBundle\Entity\User')->find($id)) {
            return $this->handleView($this->view($form, 404));
        }

        $em = $this->getDoctrine()->getEntityManager();

        $em->remove($user);
        $em->flush();

        $view = $this->view('', 204);

        return $this->handleView($view);
    }
}
