<?php

namespace ApiBundle\Controller;

use ApiBundle\Entity\HappyUser;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\Get;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpKernel\Exception\SymfonyHttpUnprocessableEntity;

class UsersController extends FOSRestController
{
    /**
     * @Get("/users")
     */
    public function getUsersAction()
    {
        $users = $this->getDoctrine()->getRepository('ApiBundle\Entity\User\User')->findAll();

        $view = $this->view($users, 200)
            ->setTemplate("ApiBundle:User:users.html.twig")
            ->setTemplateVar('users');

        return $this->handleView($view);
    }

    /**
     * @Get("/users/{user}, requirements={"user" = "\d+"})
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
                throw new Exception\UnprocessableEntityHttpException($e->getMessage());
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
     * @Put("/users/{user}, requirements={"user" = "\d+"})
     */
    public function putUsersAction(Request $request, User $user)
    {
        // probably handled by paramConverter here above
        if (!$user = $em->getRepository('ApiBundle\Entity\User')->find($id)) {
            throw new SymfonyHttpNotFoundException("User not found");
        }

        $user = $this->get('serializer')->deserialize(
            $request->getContent(),
            'ApiBundle\Entity\HappyUser',
            'json'
        );

        $violations = $this->get('validator')->validate($user);

        if (count($violations)) {
            throw new SymfonyHttpUnprocessableEntity("constant error codes here, along with validation errors");
        }

        $em->getRepository('ApiBundle\Entity\User')->save($user);

        return $user;
    }

    /**
     * @Delete("/users/{user}, requirements={"user" = "\d+"})
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
