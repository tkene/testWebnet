<?php

namespace App\Tests\Service;

use App\Service\CardService;
use PHPUnit\Framework\TestCase;

class CardServiceTest extends TestCase
{
    private CardService $cardService;

    protected function setUp(): void
    {
        $this->cardService = new CardService();
    }

    const HAND = [
        ['value' => 'Roi', 'color' => 'Piques', 'symbol' => '♠️'],
        ['value' => 'As', 'color' => 'Carreaux', 'symbol' => '♦️'],
        ['value' => 'Dame', 'color' => 'Carreaux', 'symbol' => '♦️'],
        ['value' => 'As', 'color' => 'Piques', 'symbol' => '♠️'],
        ['value' => '2', 'color' => 'Carreaux', 'symbol' => '♦️'],
    ];

    const COLOR_ORDER = [
        ['symbol' => '♦️', 'name' => 'Carreaux'],
        ['symbol' => '♥️', 'name' => 'Cœurs'],
        ['symbol' => '♠️', 'name' => 'Piques'],
        ['symbol' => '♣️', 'name' => 'Trèfles'],
    ];

    const VALUES_ORDER = ['As', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'Valet', 'Dame', 'Roi'];

    public function testSortHand(): void
    {
        $hand = self::HAND;

        $colorOrder = self::COLOR_ORDER;

        $valuesOrder = self::VALUES_ORDER;

        $sortedHand = $this->cardService->sortHand($hand, $colorOrder, $valuesOrder);

        // Assert : Vérifier les résultats
        $this->assertCount(5, $sortedHand, 'La main triée doit contenir 5 cartes');

        // Vérifier que les cartes sont triées par couleur d'abord (Carreaux avant Piques)
        $this->assertEquals('Carreaux', $sortedHand[0]['color'], 'La première carte doit être de couleur Carreaux');
        $this->assertEquals('Carreaux', $sortedHand[1]['color'], 'La deuxième carte doit être de couleur Carreaux');
        $this->assertEquals('Carreaux', $sortedHand[2]['color'], 'La troisième carte doit être de couleur Carreaux');
        $this->assertEquals('Piques', $sortedHand[3]['color'], 'La quatrième carte doit être de couleur Piques');
        $this->assertEquals('Piques', $sortedHand[4]['color'], 'La cinquième carte doit être de couleur Piques');

        // Vérifier que les cartes de même couleur sont triées par valeur
        $this->assertEquals('As', $sortedHand[0]['value'], 'La première carte Carreaux doit être un As');
        $this->assertEquals('2', $sortedHand[1]['value'], 'La deuxième carte Carreaux doit être un 2');
        $this->assertEquals('Dame', $sortedHand[2]['value'], 'La troisième carte Carreaux doit être une Dame');
        $this->assertEquals('As', $sortedHand[3]['value'], 'La première carte Piques doit être un As');
        $this->assertEquals('Roi', $sortedHand[4]['value'], 'La deuxième carte Piques doit être un Roi');
    }
}
