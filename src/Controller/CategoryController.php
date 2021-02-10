<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Category;
use App\Entity\User;
use App\Form\CategoryType;
use Symfony\Component\HttpFoundation\Request;


class CategoryController extends AbstractController
{
    //-------------------------- CATEGORY ------------------------------------- 

    /**
     * @Route("/admin/affichage-category", name="affichage-category")
     */
    public function affichageCategory()
    {
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();
        return $this->render('admin/affichagecategory.html.twig', [
            'categories' => $categories
        ]);
    }

    /**
     *@Route("/admin/category/{id}", name="category")
     */
    public function category($id)
    {
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);
        return $this->render('admin/addcategory.html.twig', [
            "id" => $id,
            "category" => $category
        ]);
    }

    /**
     * @Route("/admin/add-category", name="add-category")
     */
    public function addCategory(Request $request)
    {
        $new_category = new Category;
        $form = $this->createForm(CategoryType::class, $new_category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($new_category);
            $entityManager->flush();

            return $this->redirectToRoute('affichage-category');
        }

        return $this->render('admin/addcategory.html.twig', [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/edit-category/{id}", name="edit-category")
     */

    public function editCategory($id, Request $request)
    {
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('affichage-category');
        }

        return $this->render('admin/addcategory.html.twig', [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/delete-category/{id}", name="delete-category")
     */

    public function deleteCategory($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $categories = $entityManager->getRepository(Category::class)->find($id);

        $entityManager->remove($categories);
        $entityManager->flush();

        return $this->redirectToRoute('affichage-category');
    }


    //-------------------------- UTILISATEURS ------------------------------------- 

    /**
     * @Route("/admin/affichage-user", name="affichage-user")
     */
    public function affichageUser()
    {
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();
        return $this->render('admin/affichageuser.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * @Route("/admin/delete-user/{id}", name="delete-user")
     */

    public function deleteUser($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $users = $entityManager->getRepository(User::class)->find($id);

        $entityManager->remove($users);
        $entityManager->flush();

        return $this->redirectToRoute('affichage-user');
    }
}