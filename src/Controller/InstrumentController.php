<?php

namespace App\Controller;

use App\Model\InstrumentManager;
use App\Service\LastFmApi;
class InstrumentController extends AbstractController
{
    public function index(): string
    {
        $instrumentManager = new InstrumentManager();
        $instruments = $instrumentManager->selectAll('id');

        return $this->twig->render('Instrument/list.html.twig', ['instruments' => $instruments]);
    }

    public function result(): string
    {
        $tracks = [];
        $instrumentManager = new InstrumentManager();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $foundIds = array_keys($_POST);
            $tags = $instrumentManager->selectTagFromInstrument(intval($foundIds[0]));
            $tracks = LastFmApi::tagGetTopTracks($tags[0]);
        }

        return $this->twig->render('instrument/results.html.twig', ['tracks' => $tracks]);        
    }
}