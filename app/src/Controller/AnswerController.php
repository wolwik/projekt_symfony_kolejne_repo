<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Entity\Question;
use App\Form\AnswerType;
use App\Service\AnswerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

final class AnswerController extends AbstractController
{

    /**
     * Constructor.
     *
     * @param AnswerServiceInterface $answerService Answer service
     * @param TranslatorInterface      $translator      Translator
     */

    public function __construct(
        private readonly AnswerService $answerService,
        private readonly TranslatorInterface $translator
    ) {}




    #[Route(
        '/answer',
        name: 'app_answer'
    )]

    public function index(): Response
    {
        return $this->render('answer/index.html.twig', [
            'controller_name' => 'AnswerController',
        ]);
    }

    #[Route(
        '/question/{id}/answer',
        name: 'answer_create',
        methods: ['POST']
    )]

    public function create(Question $question, Request $request): Response
    {
        $answer = new Answer();

        $form = $this->createForm(AnswerType::class, $answer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->answerService->save($answer, $question);

            /* to ma być tutaj ??
            $this->addFlash(
                'success',
                $this->translator->trans('message.created_successfully')
            );
            */

        }

        // powrót do PYTANIA
        return $this->redirectToRoute('question_view', ['id' => $question->getId()]);
    }

    // nie renderujemy twiga, bo to jest w twigu renderowanym przez Question

}
