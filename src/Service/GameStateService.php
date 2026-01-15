<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class GameStateService
{
    private const SESSION_COLOR_ORDER = 'colorOrder';
    private const SESSION_COLOR_ORDER_CONFIRMED = 'colorOrderConfirmed';
    private const SESSION_VALUES_ORDER = 'valuesOrder';
    private const SESSION_VALUES_ORDER_CONFIRMED = 'valuesOrderConfirmed';
    private const SESSION_NUMBER_OF_CARDS = 'numberOfCards';
    private const SESSION_UNSORTED_HAND = 'unsortedHand';
    private const SESSION_SORTED_HAND = 'sortedHand';

    public function initializeGame(SessionInterface $session): void
    {
        $session->clear();
    }

    public function setColorOrder(SessionInterface $session, array $colorOrder): void
    {
        $session->set(self::SESSION_COLOR_ORDER, $colorOrder);
        $session->set(self::SESSION_COLOR_ORDER_CONFIRMED, false);
    }

    public function getColorOrder(SessionInterface $session): ?array
    {
        return $session->get(self::SESSION_COLOR_ORDER);
    }

    public function confirmColorOrder(SessionInterface $session): void
    {
        $session->set(self::SESSION_COLOR_ORDER_CONFIRMED, true);
    }

    public function isColorOrderConfirmed(SessionInterface $session): bool
    {
        return $session->has(self::SESSION_COLOR_ORDER_CONFIRMED) 
            && $session->get(self::SESSION_COLOR_ORDER_CONFIRMED) === true;
    }

    public function setValuesOrder(SessionInterface $session, array $valuesOrder): void
    {
        $session->set(self::SESSION_VALUES_ORDER, $valuesOrder);
        $session->set(self::SESSION_VALUES_ORDER_CONFIRMED, false);
    }

    public function getValuesOrder(SessionInterface $session): ?array
    {
        return $session->get(self::SESSION_VALUES_ORDER);
    }

    public function confirmValuesOrder(SessionInterface $session): void
    {
        $session->set(self::SESSION_VALUES_ORDER_CONFIRMED, true);
    }

    public function isValuesOrderConfirmed(SessionInterface $session): bool
    {
        return $session->has(self::SESSION_VALUES_ORDER_CONFIRMED) 
            && $session->get(self::SESSION_VALUES_ORDER_CONFIRMED) === true;
    }

    public function setNumberOfCards(SessionInterface $session, int $numberOfCards): void
    {
        $session->set(self::SESSION_NUMBER_OF_CARDS, $numberOfCards);
    }

    public function getNumberOfCards(SessionInterface $session): ?int
    {
        return $session->get(self::SESSION_NUMBER_OF_CARDS);
    }

    public function hasNumberOfCards(SessionInterface $session): bool
    {
        return $session->has(self::SESSION_NUMBER_OF_CARDS);
    }

    public function setUnsortedHand(SessionInterface $session, array $hand): void
    {
        $session->set(self::SESSION_UNSORTED_HAND, $hand);
    }

    public function getUnsortedHand(SessionInterface $session): ?array
    {
        return $session->get(self::SESSION_UNSORTED_HAND);
    }

    public function hasUnsortedHand(SessionInterface $session): bool
    {
        return $session->has(self::SESSION_UNSORTED_HAND);
    }

    public function setSortedHand(SessionInterface $session, array $hand): void
    {
        $session->set(self::SESSION_SORTED_HAND, $hand);
    }

    public function getSortedHand(SessionInterface $session): ?array
    {
        return $session->get(self::SESSION_SORTED_HAND);
    }

    public function isGameSetupComplete(SessionInterface $session): bool
    {
        return $this->isColorOrderConfirmed($session) 
            && $this->isValuesOrderConfirmed($session);
    }

    public function getHandGenerationData(SessionInterface $session): ?array
    {
        $colorOrder = $this->getColorOrder($session);
        $valuesOrder = $this->getValuesOrder($session);
        $numberOfCards = $this->getNumberOfCards($session);

        if ($colorOrder === null || $valuesOrder === null || $numberOfCards === null) {
            return null;
        }

        return [
            'colorOrder' => $colorOrder,
            'valuesOrder' => $valuesOrder,
            'numberOfCards' => $numberOfCards,
        ];
    }

    public function getSortingData(SessionInterface $session): ?array
    {
        $colorOrder = $this->getColorOrder($session);
        $valuesOrder = $this->getValuesOrder($session);
        $unsortedHand = $this->getUnsortedHand($session);

        if ($colorOrder === null || $valuesOrder === null || $unsortedHand === null) {
            return null;
        }

        return [
            'colorOrder' => $colorOrder,
            'valuesOrder' => $valuesOrder,
            'unsortedHand' => $unsortedHand,
        ];
    }

    public function clearGame(SessionInterface $session): void
    {
        $session->clear();
    }
}

