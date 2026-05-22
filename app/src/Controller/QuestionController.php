<?php

namespace App\Controller;

use App\Entity\Question;
use App\Repository\QuestionRepository;
use App\Service\QuestionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;

final class QuestionController extends AbstractController {

    public function __construct(
        private readonly QuestionService $questionService
    ) {}


    #[Route(
        '/question',
        name: 'question_list',
        methods: ['GET']
    )]

    /*
     * Index
     */
    public function index(#[MapQueryParameter] int $page = 1): Response {
        $pagination = $this->questionService->getPaginatedList($page);
        return $this->render('question/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * View action.
     *
     * @param Question $question Question entity
     *
     * @return Response HTTP response
     */
    #[Route(
        '/question/{id}',
        name: 'question_view',
        requirements: ['id' => '[1-9]\d*'],
        methods: ['GET']
    )]

    public function view(Question $question): Response {
        return $this->render('question/view.html.twig', ['question' => $question]);
    }

}

