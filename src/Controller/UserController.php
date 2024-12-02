<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\UserPasswordType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserController extends AbstractController
{
    /** @var UserRepository $UserRepository */
    private $userRepository;
    private $em;

    public function __construct(UserRepository $userRepository, EntityManagerInterface $em)
    {
        $this->userRepository = $userRepository;
        $this->em = $em;
    }

    #[Route('/account/{login}', name: 'account_info')]
    public function user(string $login)
    {
        $user = $this->userRepository->findBy(
            ['login' => $login],
        );

        return $this->render('user/index.html.twig', [
           'user' => $user[0]
        ]);
    }

    #[Route('/user/update/{id}', name: 'user_update')]
    public function edit(User $user, Request $request, ValidatorInterface $validator)
    {
         $form = $this->createForm(UserType::class, $user);
         $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {
            $errors = $validator->validate($user);
            if (count($errors) > 0) {
                return $this->render('validation.html.twig', [
                    'errors' => $errors,
                ]);
            }
            $this->em->flush();

            return $this->redirectToRoute('account_info', array('login' => $user->getLogin()));
         }

         return $this->render('user/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/user/updatePass/{id}', name: 'user_updatePass')]
    public function editPass(User $user, Request $request, UserPasswordHasherInterface $userPasswordHasher, ValidatorInterface $validator)
    {
         $form = $this->createForm(UserPasswordType::class, $user);
         $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {
            $errors = $validator->validate($user);
            if (count($errors) > 0) {
                return $this->render('validation.html.twig', [
                    'errors' => $errors,
                ]);
            }
            $plainPassword = $form->get('plainPassword')->getData();

            // encode the plain password
            $user->setPassword($userPasswordHasher->hashPassword($user, $plainPassword));

            $this->em->persist($user);
            $this->em->flush();
            $this->em->flush();

            return $this->redirectToRoute('account_info', array('login' => $user->getLogin()));
         }

         return $this->render('user/editPass.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/user/delete/{id}', name: 'user_delete')]
    public function delete(User $user)
    {     
        $this->em->remove($user);
        $this->em->flush();

        return $this->redirectToRoute('home');
    }
}
?>