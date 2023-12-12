<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\Type\TaskType;//DateType, TextType, SubmitType ...
use App\Repository\TaskRepository;

use Doctrine\ORM\EntityManagerInterface; //pour la persistance 
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TaskController extends AbstractController
{
    /**
     * @Route("/task", name="add_task")
     */
    public function nouvelleTache(Request $request, EntityManagerInterface $entityManager, TaskRepository $taskRepository): Response 
    {
        // Instancier un objet Task
        $task = new Task();
        // Si tu veux(initialiser les champs)
        $task->setTask('Write a blog post');
        $task->setDueDate(new \DateTime('tomorrow'));// N'importe quoi! tu change la valeur et ça gueule ...
        // createForm() remplace  createFormBuilder() 
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();   
            $entityManager->persist($task);
            $entityManager->flush(); // the INSERT query
        }
        return $this->renderForm('task/new_task.html.twig', [   
            'form' => $form ,
            'tache' => $task,
            'taches' => $taskRepository->findBy([])
        ]);    
    }


    /**
     * @Route("/t/edit/{id}", name="edit_task")
     */
    public function updateTask(Request $request, EntityManagerInterface $entityManager, int $id, TaskRepository $taskRepository): Response
    {
        $task = $entityManager->getRepository(Task::class)->find($id);
        if (!$task) {
            throw $this->createNotFoundException('No task found for id ' . $id);
        }
        if (!$task->getId()) {// pour pas modif la date
            $task->setDueDate(new \DateTime('tomorrow')); 
        }
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();
            $entityManager->persist($task);
            $entityManager->flush(); 
        }
        return $this->renderForm('task/edit_task.html.twig', [
            'form' => $form,
            'mission' => $task,
            'taches' => $taskRepository->findBy([])
        ]);
    }
    /**
     * @Route("/t/remove/{id}", name="remove_task")
     */
    public function removeTask(Request $request, EntityManagerInterface $entityManager, int $id, TaskRepository $taskRepository): Response
    {
        $task = $entityManager->getRepository(Task::class)->find($id);
        if (!$task) {
            throw $this->createNotFoundException('No task found for id ' . $id);
        }
        if (!$task->getId()) { // pour pas modif la date
            $task->setDueDate(new \DateTime('tomorrow'));
        }
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();
            //$entityManager->persist($task);
            $entityManager->remove($task);
            $entityManager->flush();
        }
        return $this->renderForm('task/remove_task.html.twig', [
            'form' => $form,
            'mission' => $task,
            'taches' => $taskRepository->findBy([])
        ]);
    }

    /**
     * @Route("/toustaches", name="show_all_task")
     */
    public function affichetouslestaches(TaskRepository $taskRepository){
        return $this->render('task/show_tasks.html.twig', [
            'taches' => $taskRepository->findBy([])
        ]);

    }
    /**
     * @Route("/workflow", name="workflow")
     */
    public function workflow(){
        return $this->render('task/workflow.html.twig');
    }
 
}
