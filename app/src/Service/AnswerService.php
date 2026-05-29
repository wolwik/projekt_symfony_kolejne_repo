<?php

/**
 * Answer service
 */

namespace App\Service;

use App\Entity\Answer;
use App\Repository\AnswerRepository;
use App\Entity\Question;

class AnswerService {
    public function __construct(
        private readonly AnswerRepository $answerRepository
    ) {}

    public function save(Answer $answer, Question $question): void
    {
        if (null === $answer->getId()) {
            $answer->setCreatedAt(new \DateTime);
            // to chyba w tym ifie, no bo nie bedzie mozna zmienic wlasciciela
            //odpowiedzi ani pytania, do ktorego sie odnosi xd
            // TEMPORARY HARDCODED
            $answer->setQuestion($question);
            $answer->setGuestNickname('ANDRZEJ');
            $answer->setGuestEmail('sss@gmail.com');
        }
        $this->answerRepository->save($answer);
    }
}






