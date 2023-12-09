<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\Type\TaskType;
use App\Repository\TaskRepository;
/*  
l 'appel du formulaire ci-dessus(TaskType)dispense les 3 importat° suivantes:

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
*/

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
        return $this->renderForm('task/nouvelleTache.html.twig', [   
            'form' => $form ,
            'tache' => $task,
            'taches' => $taskRepository->findBy([])
        ]);    
    }


    /**
     * @Route("/task_edit/{id}", name="task_edit")
     */
    public function updateTask(Request $request, EntityManagerInterface $entityManager, int $id, TaskRepository $taskRepository): Response
    {
        $task = $entityManager->getRepository(Task::class)->find($id);
        //$task = $entityManager->getRepository(Task::class)->getId(); // !!! c'est là q ça s'passe !!!
        if (!$task) {
            throw $this->createNotFoundException('No task found for id ' . $id);
        }
        $task->setTask('container symfony');
        $task->setDueDate(new \DateTime('tomorrow')); 
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();
            $entityManager->persist($task);
            $entityManager->flush(); // the INSERT query
            // Redirection (suite au clic sur le bouton save)
            //return new Response('Tâche prévue: ' . $task->getTask() .'|Tâche numéro: '.$task->getId() );
            return $this->redirectToRoute('task_updated');
        }
        return $this->renderForm('task/task_update.html.twig', [

            'form' => $form
        ]);
    }
    /**
     *@Route("/task_updated", name="task_updated")
     */
    public function confirmUpdateTask(TaskRepository $taskRepository): Response
    {
        return $this->render('task/confirmUpdateTask.html.twig', [
            // 'taches' => $taskRepository->findBy([], ['taskOrder' => 'asc'])
            'taches' => $taskRepository->findBy([]),

        ]);
    }

    /**
     * @Route("/toustaches", name="show_all_task")
     */
    public function affichetouslestaches(TaskRepository $taskRepository){
        return $this->render('task/affichetousT.html.twig', [
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
