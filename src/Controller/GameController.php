<?php

namespace App\Controller;

use App\Service\CardService;
use App\Service\GameService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

class GameController extends AbstractController
{
    private CardService $cardService;
    private GameService $gameService;

    public function __construct(GameService $gameService, CardService $cardService)
    {
        $this->gameService = $gameService;
        $this->cardService = $cardService;
    }

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('game/index.html.twig');
    }

    #[Route('/choose-colors', name: 'app_choose_colors')]
    public function chooseColors(SessionInterface $session, Request $request): Response
    {
        $new = $request->query->get('new');
        
        if ($new || !$session->has('colorOrder')) {
            // Si on demande un nouvel ordre ou si aucun ordre n'existe, on génère un nouvel ordre aléatoire
            // On ne clear que les données liées aux couleurs pour préserver le reste si nécessaire
            if ($new) {
                // Générer un nouvel ordre aléatoire
                $colorOrder = $this->cardService->generateRandomColorOrder();
                $session->set('colorOrder', $colorOrder);
                $session->set('colorOrderConfirmed', false);
            } else {
                // Première visite : générer un ordre aléatoire
                $colorOrder = $this->cardService->generateRandomColorOrder();
                $session->set('colorOrder', $colorOrder);
                $session->set('colorOrderConfirmed', false);
            }
        } else {
            // Récupérer l'ordre existant (qui peut avoir été modifié)
            $colorOrder = $session->get('colorOrder', []);
            // S'assurer que l'ordre est bien sauvegardé
            $session->set('colorOrder', $colorOrder);
        }

        return $this->render('game/choose_colors.html.twig', [
            'colorOrder' => $colorOrder,
        ]);
    }

    #[Route('/reorder-color', name: 'app_reorder_color', methods: ['POST'])]
    public function reorderColor(SessionInterface $session, Request $request): Response
    {
        $index = (int) $request->request->get('index');
        $direction = $request->request->get('direction'); // 'up' or 'down'
        
        if (!$session->has('colorOrder')) {
            return $this->redirectToRoute('app_choose_colors');
        }
        
        $colorOrder = $session->get('colorOrder');
        
        if ($direction === 'up' && $index > 0) {
            // Échanger avec l'élément précédent
            $temp = $colorOrder[$index];
            $colorOrder[$index] = $colorOrder[$index - 1];
            $colorOrder[$index - 1] = $temp;
        } elseif ($direction === 'down' && $index < count($colorOrder) - 1) {
            // Échanger avec l'élément suivant
            $temp = $colorOrder[$index];
            $colorOrder[$index] = $colorOrder[$index + 1];
            $colorOrder[$index + 1] = $temp;
        }
        
        $session->set('colorOrder', $colorOrder);
        
        return $this->redirectToRoute('app_choose_colors');
    }

    #[Route('/confirm-colors', name: 'app_confirm_colors')]
    public function confirmColors(SessionInterface $session): Response
    {
        if ($session->has('colorOrder')) {
            // Récupérer l'ordre actuel (qui peut avoir été modifié)
            $colorOrder = $session->get('colorOrder');
            
            // Sauvegarder explicitement l'ordre actuel dans la session
            $session->set('colorOrder', $colorOrder);
            $session->set('colorOrderConfirmed', true);
            
            return $this->redirectToRoute('app_choose_values');
        }
        
        return $this->redirectToRoute('app_choose_colors');
    }

    #[Route('/choose-values', name: 'app_choose_values')]
    public function chooseValues(SessionInterface $session, Request $request): Response
    {
        if (!$session->has('colorOrderConfirmed') || !$session->get('colorOrderConfirmed')) {
            return $this->redirectToRoute('app_choose_colors');
        }
        
        $new = $request->query->get('new');
        
        if ($new || !$session->has('valuesOrder')) {
            // Si on demande un nouvel ordre ou si aucun ordre n'existe, on génère un nouvel ordre aléatoire
            $valuesOrder = $this->cardService->generateRandomValuesOrder();
            $session->set('valuesOrder', $valuesOrder);
            $session->set('valuesOrderConfirmed', false);
        } else {
            // Récupérer l'ordre existant (qui peut avoir été modifié)
            $valuesOrder = $session->get('valuesOrder', []);
            // S'assurer que l'ordre est bien sauvegardé
            $session->set('valuesOrder', $valuesOrder);
        }
        
        return $this->render('game/choose_values.html.twig', [
            'valuesOrder' => $valuesOrder,
        ]);
    }

    #[Route('/reorder-value', name: 'app_reorder_value', methods: ['POST'])]
    public function reorderValue(SessionInterface $session, Request $request): Response
    {
        if (!$session->has('colorOrderConfirmed') || !$session->get('colorOrderConfirmed')) {
            return $this->redirectToRoute('app_choose_colors');
        }
        
        $index = (int) $request->request->get('index');
        $direction = $request->request->get('direction'); // 'up' or 'down'
        
        if (!$session->has('valuesOrder')) {
            return $this->redirectToRoute('app_choose_values');
        }
        
        $valuesOrder = $session->get('valuesOrder');
        
        if ($direction === 'up' && $index > 0) {
            // Échanger avec l'élément précédent
            $temp = $valuesOrder[$index];
            $valuesOrder[$index] = $valuesOrder[$index - 1];
            $valuesOrder[$index - 1] = $temp;
        } elseif ($direction === 'down' && $index < count($valuesOrder) - 1) {
            // Échanger avec l'élément suivant
            $temp = $valuesOrder[$index];
            $valuesOrder[$index] = $valuesOrder[$index + 1];
            $valuesOrder[$index + 1] = $temp;
        }
        
        $session->set('valuesOrder', $valuesOrder);
        
        return $this->redirectToRoute('app_choose_values');
    }

    #[Route('/confirm-values', name: 'app_confirm_values')]
    public function confirmValues(SessionInterface $session): Response
    {
        if ($session->has('valuesOrder')) {
            // Récupérer l'ordre actuel (qui peut avoir été modifié)
            $valuesOrder = $session->get('valuesOrder');
            
            // Sauvegarder explicitement l'ordre actuel dans la session
            $session->set('valuesOrder', $valuesOrder);
            $session->set('valuesOrderConfirmed', true);
            
            return $this->redirectToRoute('app_choose_game_mode');
        }
        
        return $this->redirectToRoute('app_choose_values');
    }

    #[Route('/choose-game-mode', name: 'app_choose_game_mode')]
    public function chooseGameMode(SessionInterface $session): Response
    {
        if (!$session->has('colorOrderConfirmed') || !$session->get('colorOrderConfirmed')) {
            return $this->redirectToRoute('app_choose_colors');
        }
        
        if (!$session->has('valuesOrderConfirmed') || !$session->get('valuesOrderConfirmed')) {
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
        
        $session->set('numberOfCards', $numberOfCards);
            
        return $this->redirectToRoute('app_show_cards_with_values');
    }

    #[Route('/show-cards-with-values', name: 'app_show_cards_with_values')]
    public function showCardsWithValues(SessionInterface $session): Response
    {
        if (!$session->has('colorOrderConfirmed') || !$session->get('colorOrderConfirmed')) {
            return $this->redirectToRoute('app_choose_colors');
        }
        
        if (!$session->has('valuesOrderConfirmed') || !$session->get('valuesOrderConfirmed')) {
            return $this->redirectToRoute('app_choose_values');
        }
        
        if (!$session->has('numberOfCards')) {
            return $this->redirectToRoute('app_choose_game_mode');
        }
        
        if (!$session->has('unsortedHand')) {
            $colorOrder = $session->get('colorOrder', []);
            $valuesOrder = $session->get('valuesOrder', []);
            $numberOfCards = $session->get('numberOfCards', 4);
            
            $unsortedHand = $this->gameService->generateRandomHand($colorOrder, $valuesOrder, $numberOfCards);
            
            $session->set('unsortedHand', $unsortedHand);
        }
        
        return $this->render('game/show_cards.html.twig', [
            'drawnCards' => $session->get('unsortedHand'),
        ]);
    }

    #[Route('/show-sorted-cards', name: 'app_show_sorted_cards')]
    public function showSortedCards(SessionInterface $session): Response
    {
        if (!$session->has('colorOrderConfirmed') || !$session->get('colorOrderConfirmed')) {
            return $this->redirectToRoute('app_choose_colors');
        }
        
        if (!$session->has('valuesOrderConfirmed') || !$session->get('valuesOrderConfirmed')) {
            return $this->redirectToRoute('app_choose_values');
        }
        
        if (!$session->has('numberOfCards')) {
            return $this->redirectToRoute('app_choose_game_mode');
        }
        
        if (!$session->has('unsortedHand')) {
            return $this->redirectToRoute('app_show_cards_with_values');
        }
        
        $colorOrder = $session->get('colorOrder', []);
        $valuesOrder = $session->get('valuesOrder', []);
        $unsortedHand = $session->get('unsortedHand', []);
        
        $sortedHand = $this->cardService->sortHand($unsortedHand, $colorOrder, $valuesOrder);
        
        $session->set('sortedHand', $sortedHand);
        
        return $this->render('game/show_sorted_cards.html.twig', [
            'sortedCards' => $sortedHand,
            'colorOrder' => $colorOrder,
            'valuesOrder' => $valuesOrder,
        ]);
    }

    #[Route('/reset-game', name: 'app_reset_game')]
    public function resetGame(SessionInterface $session): Response
    {
        $session->clear();
        return $this->redirectToRoute('app_home');
    }
}
