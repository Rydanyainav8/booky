<?php

namespace App\Controller;

use ApiPlatform\Validator\ValidatorInterface;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
    #[Route('/api/user/create', name: 'register-user', methods: ['POST'])]
    public function register(Request $request, EntityManagerInterface $em, ValidatorInterface $validator, UserPasswordHasherInterface $passwordHasher): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        var_dump($data);
    
        // Extracting data with null coalescing operator
        $email = $data['email'] ?? null;
        $password = $data['password'] ?? null;
        $firstname = $data['firstname'] ?? null;
        $lastname = $data['lastname'] ?? null;
        $roles = $data['roles'] ?? ['ROLE_USER']; // Default role if none provided
    
        // Validate input fields
        if (!$email || !$password || !$firstname || !$lastname) {
            return new JsonResponse(['error' => 'All fields are required'], 400);
        }
    
        // Create new User object
        $user = new User();
        $user->setEmail($email);
        $user->setFirstname($firstname);
        $user->setLastname($lastname);
        $user->setRoles($roles); // Set roles
    
        // Hash password
        $hashedPassword = $passwordHasher->hashPassword($user, $password);
        $user->setPassword($hashedPassword);
    
        $errors = $validator->validate($user);

        // Type cast to array if needed and check count
        if (count((array)$errors) > 0) {
            return new JsonResponse(['error' => (string)$errors], 400);
        }
    
        // Persist user to database
        $em->persist($user);
        $em->flush();
    
        return new JsonResponse(['message' => 'User registered successfully'], 201);
    }

    // #[Route(path:'/api/login', name:'login_user')]
    // public function Login():JsonResponse
    // {
    //     return new JsonResponse(['message' => 'Logged successfully!'], 201);
    // }
}