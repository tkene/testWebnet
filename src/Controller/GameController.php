<?php

namespace App\Controller;

use App\Service\CardService;
use App\Service\GameService;
use App\Service\GameStateService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

class GameController extends AbstractController
{
    private CardService $cardService;
    private GameService $gameService;
    private GameStateService $gameStateService;

    public function __construct(
        GameService $gameService,
        CardService $cardService,
        GameStateService $gameStateService
    ) {
        $this->gameService = $gameService;
        $this->cardService = $cardService;
        $this->gameStateService = $gameStateService;
    }

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('game/index.html.twig');
    }

    #[Route('/choose-colors', name: 'app_choose_colors')]
    public function chooseColors(SessionInterface $session): Response
    {
        $this->gameStateService->initializeGame($session);
        
        $colorOrder = $this->cardService->generateRandomColorOrder();
        $this->gameStateService->setColorOrder($session, $colorOrder);

        return $this->render('game/choose_colors.html.twig', [
            'colorOrder' => $colorOrder,
        ]);
    }

    #[Route('/confirm-colors', name: 'app_confirm_colors')]
    public function confirmColors(SessionInterface $session): Response
    {
        if ($this->gameStateService->getColorOrder($session) === null) {
            return $this->redirectToRoute('app_choose_colors');
        }
        
        $this->gameStateService->confirmColorOrder($session);
        return $this->redirectToRoute('app_choose_values');
    }

    #[Route('/choose-values', name: 'app_choose_values')]
    public function chooseValues(SessionInterface $session): Response
    {
        if (!$this->gameStateService->isColorOrderConfirmed($session)) {
            return $this->redirectToRoute('app_choose_colors');
        }
        
        $valuesOrder = $this->cardService->generateRandomValuesOrder();
        $this->gameStateService->setValuesOrder($session, $valuesOrder);
        
        return $this->render('game/choose_values.html.twig', [
            'valuesOrder' => $valuesOrder,
        ]);
    }

    #[Route('/confirm-values', name: 'app_confirm_values')]
    public function confirmValues(SessionInterface $session): Response
    {
        if ($this->gameStateService->getValuesOrder($session) === null) {
            return $this->redirectToRoute('app_choose_values');
        }
        
        $this->gameStateService->confirmValuesOrder($session);
        return $this->redirectToRoute('app_choose_game_mode');
    }

    #[Route('/choose-game-mode', name: 'app_choose_game_mode')]
    public function chooseGameMode(SessionInterface $session): Response
    {
        if (!$this->gameStateService->isColorOrderConfirmed($session)) {
            return $this->redirectToRoute('app_choose_colors');
        }
        
        if (!$this->gameStateService->isValuesOrderConfirmed($session)) {
            return $this->redirectToRoute('app_choose_values');
        }
        
        return $this->render('game/choose_game_mode.html.twig');
    }

    #[Route('/confirm-cards-number', name: 'app_confirm_cards_number', methods: ['POST'])]
    public function confirmCardsNumber(SessionInterface $session, Request $request): Response
    {     
        $numberOfCardsInput = $request->request->get('numberOfCards');
        
        if ($numberOfCardsInput === null || $numberOfCardsInput === '') {
            $this->addFlash('error', 'Veuillez entrer un nombre de cartes.');
            return $this->redirectToRoute('app_choose_game_mode');
        }
        
        $numberOfCards = (int) $numberOfCardsInput;
        
        $validationResult = $this->gameService->validateCardsNumber($numberOfCards);
        if (isset($validationResult['error'])) {
            $this->addFlash('error', $validationResult['error']);
            return $this->redirectToRoute('app_choose_game_mode');
        }
        
        $this->gameStateService->setNumberOfCards($session, $numberOfCards);
            
        return $this->redirectToRoute('app_show_cards_with_values');
    }

    #[Route('/show-cards-with-values', name: 'app_show_cards_with_values')]
    public function showCardsWithValues(SessionInterface $session): Response
    {
        if (!$this->gameStateService->isGameSetupComplete($session)) {
            return $this->redirectToRoute('app_choose_colors');
        }
        
        if (!$this->gameStateService->hasNumberOfCards($session)) {
            return $this->redirectToRoute('app_choose_game_mode');
        }
        
        if (!$this->gameStateService->hasUnsortedHand($session)) {
            $handData = $this->gameStateService->getHandGenerationData($session);
            
            if ($handData === null) {
                return $this->redirectToRoute('app_choose_game_mode');
            }
            
            $unsortedHand = $this->gameService->generateRandomHand(
                $handData['colorOrder'],
                $handData['valuesOrder'],
                $handData['numberOfCards']
            );
            $this->gameStateService->setUnsortedHand($session, $unsortedHand);
        }
        
        return $this->render('game/show_cards.html.twig', [
            'drawnCards' => $this->gameStateService->getUnsortedHand($session),
        ]);
    }

    #[Route('/show-sorted-cards', name: 'app_show_sorted_cards')]
    public function showSortedCards(SessionInterface $session): Response
    {
        if (!$this->gameStateService->isGameSetupComplete($session)) {
            return $this->redirectToRoute('app_choose_colors');
        }
        
        if (!$this->gameStateService->hasNumberOfCards($session)) {
            return $this->redirectToRoute('app_choose_game_mode');
        }
        
        if (!$this->gameStateService->hasUnsortedHand($session)) {
            return $this->redirectToRoute('app_show_cards_with_values');
        }
        
        $sortingData = $this->gameStateService->getSortingData($session);
        
        if ($sortingData === null) {
            return $this->redirectToRoute('app_show_cards_with_values');
        }
        
        $sortedHand = $this->cardService->sortHand(
            $sortingData['unsortedHand'],
            $sortingData['colorOrder'],
            $sortingData['valuesOrder']
        );
        $this->gameStateService->setSortedHand($session, $sortedHand);
        
        return $this->render('game/show_sorted_cards.html.twig', [
            'sortedCards' => $sortedHand,
            'colorOrder' => $sortingData['colorOrder'],
            'valuesOrder' => $sortingData['valuesOrder'],
        ]);
    }

    #[Route('/reset-game', name: 'app_reset_game')]
    public function resetGame(SessionInterface $session): Response
    {
        $this->gameStateService->clearGame($session);
        return $this->redirectToRoute('app_home');
    }
}
