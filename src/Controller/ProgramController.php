<?php

// src/Controller/ProgramController.php
namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Program;
use App\Entity\Season;
use App\Entity\Episode;

/**
 * @Route("/programs", name="program_")
 */
class ProgramController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @return Response A response instance
     */
    public function index(): Response
    {
        $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findAll();

        return $this->render('program/index.html.twig',
            ['programs' => $programs]
        );
    }

    /**
     * @Route("/show/{id<^[0-9]+$>}", name="show")
     * @return Response
     */
    public function show(int $id): Response
    {
        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findOneBy(['id' => $id]);

        if (!$program) {
            throw $this->createNotFoundException(
                'No program with id : ' . $id . ' found in program\'s table.'
            );
        }

        $seasons = $this->getDoctrine()
            ->getRepository(Season::class)
            ->findBy(['program' => $program]);

        return $this->render('program/show.html.twig', [
            'program' => $program,
            'seasons' => $seasons,
        ]);
    }

    /**
     * @Route("/{programId}/seasons/{seasonId}", name="season_show")
     * @ParamConverter("program", class="App\Entity\Program", options={"mapping": {"programId": "id"}})
     * @ParamConverter("season", class="App\Entity\Season", options={"mapping": {"seasonId": "id"}})
     */
    public function showSeason(Program $program, Season $season): Response
    {
        /*$program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findOneBy(['id' => $program]);

        if (!$program) {
            throw $this->createNotFoundException(
                'No program with id : ' . $program . ' found in program\'s table.'
            );
        }

        $season = $this->getDoctrine()
            ->getRepository(Season::class)
            ->findOneBy(['id' => $season]);

        if (!$season) {
            throw $this->createNotFoundException(
                'No program with id : ' . $season . ' found in program\'s table.'
            );
        }*/

        return $this->render('/program/season_show.html.twig', [
            'program' => $program,
            'season' => $season,
        ]);
    }

    /**
     * @Route("/{programId}/seasons/{seasonId}/episodes/{episodeId}", name="episode_show")
     * @ParamConverter("program", class="App\Entity\Program", options={"mapping": {"programId": "id"}})
     * @ParamConverter("season", class="App\Entity\Season", options={"mapping": {"seasonId": "id"}})
     * @ParamConverter("episode", class="App\Entity\Episode", options={"mapping": {"episodeId": "id"}})
     */
    public function showEpisode(Program $program, Season $season, Episode $episode): Response
    {
        /*$program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findOneBy(['id' => $program]);

        if (!$program) {
            throw $this->createNotFoundException(
                'No program with id : ' . $program . ' found in program\'s table.'
            );
        }

        $season = $this->getDoctrine()
            ->getRepository(Season::class)
            ->findOneBy(['id' => $season]);

        if (!$season) {
            throw $this->createNotFoundException(
                'No program with id : ' . $season . ' found in program\'s table.'
            );
        }

        $episode = $this->getDoctrine()
            ->getRepository(Episode::class)
            ->findOneBy(['id' => $episode]);

        if (!$episode) {
            throw $this->createNotFoundException(
                'No program with id : ' . $episode . ' found in program\'s table.'
            );
        }*/

        return $this->render('/program/episode_show.html.twig', [
            'program' => $program,
            'season' => $season,
            'episode' => $episode,
        ]);
    }
}