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

    public function save(Answer $answer, ?Question $question = null): void
    // par Question jest opcjonalny (ta metoda jest też uzywana do edytowania pytania)
    {
        if (null === $answer->getId()) {
            $answer->setCreatedAt(new \DateTime);
            // to chyba w tym ifie, no bo nie bedzie mozna zmienic wlasciciela
            //odpowiedzi ani pytania, do ktorego sie odnosi xd
            // TEMPORARY HARDCODED
            $answer->setQuestion($question);
            $answer->setGuestNickname('ANDRZEJ');
            $answer->setGuestEmail('sss@gmail.com');
        } else {
            $answer->setUpdatedAt(new \DateTime); // jeżeli nie null to update
        }

        $this->answerRepository->save($answer);
    }

    public function delete(Answer $answer): void
    {
        $this->answerRepository->delete($answer);
    }
}






