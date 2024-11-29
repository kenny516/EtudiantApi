<?php
namespace App\Service;

use App\Entity\Note;
use App\Entity\Semestre;
use App\Repository\SemestreRepository;
use Doctrine\Common\Collections\Collection;

class SemestreService
{
    private SemestreRepository $semestreRepository;
    // Injection du repository dans le constructeur
    public function __construct(SemestreRepository $semestreRepository)
    {
        $this->$semestreRepository = $semestreRepository;
    }

    /**
     * Calculer les résultats d'un semestre pour un étudiant
     * @param Collection $notes
     * @param Semestre $semestre
     */
    public function calculerResultats(Collection $notes, Semestre $semestre): void
    {
        $notesSemestre = $notes->filter(function (Note $note) use ($semestre) {
            return $semestre->getMatieres()->contains($note->getMatiere());
        });

        $totalNote = 0;
        $totalCoefficient = 0;

        foreach ($notesSemestre as $note) {
            $totalNote += $note->getNote() * $note->getMatiere()->getCoefficient();
            $totalCoefficient += $note->getMatiere()->getCoefficient();
        }

        $moyenneSemestre = $totalCoefficient > 0 ? $totalNote / $totalCoefficient : 0;

        foreach ($notesSemestre as $note) {
            $matiere = $note->getMatiere();

            if ($note->getNote() < 6) {
                $note->setResultat('AJ');
            } elseif ($moyenneSemestre >= 10) {
                if ($note->getNote() < 10) {
                    $note->setResultat('COMP');
                } elseif ($note->getNote() >= 16) {
                    $note->setResultat('TB');
                } elseif ($note->getNote() >= 14) {
                    $note->setResultat('B');
                } else {
                    $note->setResultat('P');
                }
            } else {
                if ($note->getNote() < 10) {
                    $note->setResultat('AJ');
                } elseif ($note->getNote() >= 16) {
                    $note->setResultat('TB');
                } elseif ($note->getNote() >= 14) {
                    $note->setResultat('B');
                } else {
                    $note->setResultat('P');
                }
            }
        }
    }


    public function GetSemestreD($etudiantId, $semestreId)
    {
        $notes = $this->semestreRepository->findEtudiantNotes($etudiantId);
        return $notes;
    }


}