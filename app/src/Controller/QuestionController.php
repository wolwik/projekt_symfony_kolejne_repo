<?php

namespace App\Controller;

use App\Repository\QuestionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;

final class QuestionController extends AbstractController {
    #[Route(
        '/question',
        name: 'question_list'
    )]

    /*
     * IndexT
     */
    public function index(Request $request, QuestionRepository $questionRepository, PaginatorInterface $paginator, #[MapQueryParameter] int $page = 1): Response {
        $pagination = $paginator->paginate(
            $questionRepository->queryAll(),
            $page,
            QuestionRepository::PAGINATOR_ITEMS_PER_PAGE,
            [
                'sortFieldAllowList' => ['question.createdAt', 'question.title', 'question.category'], // lista rzeczy,
                // po ktorych bedzie mozna sortowac
                'defaultSortFieldName' => 'question.createdAt', // domyslne sortowanie
                'defaultSortDirection' => 'desc', // kierunek sortowania, descending
            ]
        );
        return $this->render('question/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }


    /*
     * View
     */
    #[Route(
        '/question/{id}',
        name: 'question_view',
        requirements: ['id' => '[1-9]\d*'],
        methods: ['GET']
    )]

    public function view(QuestionRepository $questionRepository, int $id): Response {
        $question = $questionRepository->find($id);
        if (null === $question) throw $this->createNotFoundException('Question not found');
        return $this->render('question/view.html.twig', ['id' => $id, 'question' => $question]);
    }

}

