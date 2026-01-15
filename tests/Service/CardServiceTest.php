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

    public function testGenerateRandomColorOrder(): void
    {
        $colorOrder = $this->cardService->generateRandomColorOrder();
        
        $this->assertIsArray($colorOrder);
        
        $this->assertCount(4, $colorOrder);
        
        foreach ($colorOrder as $color) {
            $this->assertIsArray($color);
            $this->assertArrayHasKey('symbol', $color);
            $this->assertArrayHasKey('name', $color);
            $this->assertIsString($color['symbol']);
            $this->assertIsString($color['name']);
        }
        
        $colorNames = array_column($colorOrder, 'name');
        $expectedColors = ['Carreaux', 'Cœurs', 'Piques', 'Trèfles'];
        sort($colorNames);
        sort($expectedColors);
        $this->assertEquals($expectedColors, $colorNames);
    }
}
